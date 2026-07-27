from __future__ import annotations

import logging
from pathlib import Path

import cv2
import numpy as np

from app.config import Settings
from app.exceptions import FaceServiceError


logger = logging.getLogger(__name__)


class FaceNetService:
    """Generates normalized FaceNet embeddings without model training."""

    def __init__(self, settings: Settings) -> None:
        self._settings = settings
        self._keras_facenet_model = None
        self._tensorflow_model = None

    def generate_embedding(self, face_bgr: np.ndarray) -> np.ndarray:
        face_rgb = cv2.cvtColor(face_bgr, cv2.COLOR_BGR2RGB)
        face_rgb = cv2.resize(face_rgb, (160, 160), interpolation=cv2.INTER_AREA)

        if self._settings.facenet_model_path:
            embedding = self._generate_with_tensorflow(face_rgb, self._settings.facenet_model_path)
        else:
            embedding = self._generate_with_keras_facenet(face_rgb)

        embedding = np.asarray(embedding, dtype=np.float32).reshape(-1)
        norm = np.linalg.norm(embedding)
        if norm <= 0:
            raise FaceServiceError("Face embedding could not be generated.", status_code=422)
        return embedding / norm

    def _generate_with_keras_facenet(self, face_rgb: np.ndarray) -> np.ndarray:
        if self._keras_facenet_model is None:
            try:
                from keras_facenet import FaceNet
            except ImportError as exc:
                logger.exception("keras-facenet is not installed.")
                raise FaceServiceError("FaceNet model dependency is unavailable.", status_code=503) from exc
            cache_folder = self._settings.facenet_cache_path
            self._ensure_cached_facenet_weights(cache_folder)
            self._keras_facenet_model = FaceNet(
                key=self._settings.facenet_model_key,
                cache_folder=str(cache_folder),
            )

        return self._keras_facenet_model.embeddings([face_rgb])[0]

    def _ensure_cached_facenet_weights(self, cache_folder: Path) -> None:
        if self._settings.allow_model_download:
            cache_folder.mkdir(parents=True, exist_ok=True)
            return

        weights_file = (
            cache_folder
            / self._settings.facenet_model_key
            / f"{self._settings.facenet_model_key}-weights.h5"
        )
        if not weights_file.exists():
            raise FaceServiceError(
                "FaceNet model weights are not available locally.",
                status_code=503,
            )

    def _generate_with_tensorflow(self, face_rgb: np.ndarray, model_path: Path) -> np.ndarray:
        if not model_path.exists():
            raise FaceServiceError("FaceNet model file is not configured correctly.", status_code=503)

        if self._tensorflow_model is None:
            try:
                import tensorflow as tf
            except ImportError as exc:
                logger.exception("TensorFlow is not installed.")
                raise FaceServiceError("TensorFlow dependency is unavailable.", status_code=503) from exc
            self._tensorflow_model = tf.keras.models.load_model(model_path)

        preprocessed = self._prewhiten(face_rgb)
        batched = np.expand_dims(preprocessed, axis=0)
        embedding = self._tensorflow_model.predict(batched, verbose=0)[0]
        return np.asarray(embedding, dtype=np.float32)

    @staticmethod
    def _prewhiten(face_rgb: np.ndarray) -> np.ndarray:
        face = face_rgb.astype(np.float32)
        mean = np.mean(face)
        std = np.std(face)
        std_adj = np.maximum(std, 1.0 / np.sqrt(face.size))
        return (face - mean) / std_adj
