from __future__ import annotations

import os
import re
from dataclasses import dataclass
from datetime import datetime, timezone
from pathlib import Path

import numpy as np

from app.exceptions import FaceServiceError


PEGAWAI_ID_PATTERN = re.compile(r"^[A-Za-z0-9_.-]{1,100}$")


@dataclass(frozen=True)
class StoredEmbedding:
    pegawai_id: str
    embedding: np.ndarray
    registered_at: str
    updated_at: str


class StorageService:
    """Local NPZ storage for embeddings and registration metadata."""

    def __init__(self, base_path: Path) -> None:
        self._base_path = base_path
        self._base_path.mkdir(parents=True, exist_ok=True)

    def save(self, pegawai_id: str, embedding: np.ndarray) -> None:
        safe_id = self._validate_pegawai_id(pegawai_id)
        existing = self.load(safe_id)
        now = datetime.now(timezone.utc).isoformat()
        registered_at = existing.registered_at if existing else now

        target = self._file_path(safe_id)
        temp = target.with_suffix(".tmp.npz")
        np.savez_compressed(
            temp,
            pegawai_id=np.array(safe_id),
            embedding=np.asarray(embedding, dtype=np.float32),
            registered_at=np.array(registered_at),
            updated_at=np.array(now),
        )
        os.replace(temp, target)

    def load(self, pegawai_id: str) -> StoredEmbedding | None:
        safe_id = self._validate_pegawai_id(pegawai_id)
        target = self._file_path(safe_id)
        if not target.exists():
            return None

        try:
            with np.load(target, allow_pickle=False) as data:
                return StoredEmbedding(
                    pegawai_id=str(data["pegawai_id"].item()),
                    embedding=np.asarray(data["embedding"], dtype=np.float32),
                    registered_at=str(data["registered_at"].item()),
                    updated_at=str(data["updated_at"].item()),
                )
        except (OSError, ValueError, KeyError) as exc:
            raise FaceServiceError("Stored embedding is corrupted.", status_code=500) from exc

    def delete(self, pegawai_id: str) -> bool:
        safe_id = self._validate_pegawai_id(pegawai_id)
        target = self._file_path(safe_id)
        if not target.exists():
            return False
        target.unlink()
        return True

    def _file_path(self, pegawai_id: str) -> Path:
        return self._base_path / f"{pegawai_id}.npz"

    @staticmethod
    def _validate_pegawai_id(pegawai_id: str) -> str:
        safe_id = pegawai_id.strip()
        if not PEGAWAI_ID_PATTERN.fullmatch(safe_id):
            raise FaceServiceError("Invalid pegawai_id.", status_code=422)
        return safe_id
