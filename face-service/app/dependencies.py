from functools import lru_cache

from app.config import Settings, get_settings
from app.services.antispoof_service import AntiSpoofService
from app.services.embedding_service import EmbeddingService
from app.services.facenet_service import FaceNetService
from app.services.storage_service import StorageService
from app.utils.image import FaceDetector


@lru_cache
def get_face_detector() -> FaceDetector:
    settings = get_settings()
    return FaceDetector(settings=settings)


@lru_cache
def get_antispoof_service() -> AntiSpoofService:
    return AntiSpoofService(settings=get_settings())


@lru_cache
def get_facenet_service() -> FaceNetService:
    return FaceNetService(settings=get_settings())


@lru_cache
def get_storage_service() -> StorageService:
    settings: Settings = get_settings()
    settings.embedding_path.mkdir(parents=True, exist_ok=True)
    return StorageService(base_path=settings.embedding_path)


def get_embedding_service() -> EmbeddingService:
    return EmbeddingService(
        settings=get_settings(),
        face_detector=get_face_detector(),
        antispoof_service=get_antispoof_service(),
        facenet_service=get_facenet_service(),
        storage_service=get_storage_service(),
    )
