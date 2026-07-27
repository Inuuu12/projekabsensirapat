from functools import lru_cache
from pathlib import Path

from pydantic import Field, field_validator
from pydantic_settings import BaseSettings, SettingsConfigDict


BASE_DIR = Path(__file__).resolve().parents[1]
SILENT_FACE_DIR = BASE_DIR / "Silent-Face-Anti-Spoofing"


class Settings(BaseSettings):
    app_name: str = "face-service"
    app_host: str = "127.0.0.1"
    app_port: int = 8001
    app_reload: bool = False
    docs_enabled: bool = True
    log_level: str = "INFO"

    cors_origins_csv: str = Field(
        default="http://127.0.0.1:8000,http://localhost:8000",
        validation_alias="CORS_ORIGINS",
    )

    max_image_size_bytes: int = 3 * 1024 * 1024
    allowed_image_content_types_csv: str = Field(
        default="image/jpeg,image/png,image/webp",
        validation_alias="ALLOWED_IMAGE_CONTENT_TYPES",
    )

    recognition_threshold: float = 0.72
    liveness_threshold: float = 0.80
    face_detector_confidence: float = 0.70

    facenet_model_path: Path | None = None
    facenet_model_key: str = "20180402-114759"
    facenet_cache_path: Path = BASE_DIR / "weights" / "facenet"
    allow_model_download: bool = False
    embedding_path: Path = BASE_DIR / "embeddings"
    upload_path: Path = BASE_DIR / "uploads"

    anti_spoof_model_dir: Path = SILENT_FACE_DIR / "resources" / "anti_spoof_models"
    face_detector_proto_path: Path = SILENT_FACE_DIR / "resources" / "detection_model" / "deploy.prototxt"
    face_detector_model_path: Path = SILENT_FACE_DIR / "resources" / "detection_model" / "Widerface-RetinaFace.caffemodel"
    silent_face_source_path: Path = SILENT_FACE_DIR

    model_config = SettingsConfigDict(
        env_file=BASE_DIR / ".env",
        env_file_encoding="utf-8",
        extra="ignore",
    )

    @property
    def cors_origins(self) -> list[str]:
        return self._parse_csv(self.cors_origins_csv)

    @property
    def allowed_image_content_types(self) -> list[str]:
        return self._parse_csv(self.allowed_image_content_types_csv)

    @staticmethod
    def _parse_csv(value: str) -> list[str]:
        return [item.strip() for item in value.split(",") if item.strip()]

    @field_validator("facenet_model_path", mode="before")
    @classmethod
    def empty_path_to_none(cls, value: str | Path | None) -> Path | None:
        if value is None or str(value).strip() == "":
            return None
        path = Path(value)
        if not path.is_absolute():
            return BASE_DIR / path
        return path

    @field_validator(
        "embedding_path",
        "facenet_cache_path",
        "upload_path",
        "anti_spoof_model_dir",
        "face_detector_proto_path",
        "face_detector_model_path",
        "silent_face_source_path",
        mode="before",
    )
    @classmethod
    def resolve_path(cls, value: str | Path) -> Path:
        path = Path(value)
        if not path.is_absolute():
            return BASE_DIR / path
        return path


@lru_cache
def get_settings() -> Settings:
    return Settings()
