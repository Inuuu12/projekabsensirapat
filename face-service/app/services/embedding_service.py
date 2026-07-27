from __future__ import annotations

import logging

from fastapi import UploadFile

from app.config import Settings
from app.exceptions import FaceServiceError
from app.models.response import VerifyResponse
from app.services.antispoof_service import AntiSpoofService
from app.services.facenet_service import FaceNetService
from app.services.storage_service import StorageService
from app.utils.distance import cosine_similarity
from app.utils.image import FaceDetector, ImageDecoder, crop_face


logger = logging.getLogger(__name__)


class EmbeddingService:
    """Application workflow for register and verify operations."""

    def __init__(
        self,
        settings: Settings,
        face_detector: FaceDetector,
        antispoof_service: AntiSpoofService,
        facenet_service: FaceNetService,
        storage_service: StorageService,
    ) -> None:
        self._settings = settings
        self._decoder = ImageDecoder(settings=settings)
        self._face_detector = face_detector
        self._antispoof_service = antispoof_service
        self._facenet_service = facenet_service
        self._storage_service = storage_service

    async def register(self, pegawai_id: str, upload: UploadFile) -> None:
        image_bgr = await self._validated_live_face(upload)
        embedding = self._facenet_service.generate_embedding(image_bgr)
        self._storage_service.save(pegawai_id=pegawai_id, embedding=embedding)

    async def verify(self, pegawai_id: str, upload: UploadFile) -> VerifyResponse:
        registered_embedding = self._storage_service.load(pegawai_id)
        if registered_embedding is None:
            raise FaceServiceError("Registered face not found.", status_code=404)

        image_bgr = await self._validated_live_face(upload)
        embedding = self._facenet_service.generate_embedding(image_bgr)
        confidence = cosine_similarity(registered_embedding.embedding, embedding)
        verified = confidence >= self._settings.recognition_threshold

        return VerifyResponse(verified=verified, confidence=round(float(confidence), 4))

    async def _validated_live_face(self, upload: UploadFile):
        image_bgr = await self._decoder.decode_upload(upload)
        face_boxes = self._face_detector.detect(image_bgr)

        if not face_boxes:
            raise FaceServiceError("No face detected.", status_code=422)
        if len(face_boxes) > 1:
            raise FaceServiceError("Multiple faces detected.", status_code=422)

        face_box = face_boxes[0]
        liveness = self._antispoof_service.check_liveness(image_bgr=image_bgr, face_box=face_box)
        if not liveness.is_live:
            logger.warning("Spoof face rejected with score=%.4f", liveness.score)
            raise FaceServiceError("Spoof face detected.", status_code=422)

        return crop_face(image_bgr=image_bgr, face_box=face_box)
