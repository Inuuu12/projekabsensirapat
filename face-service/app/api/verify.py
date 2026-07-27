import logging

from fastapi import APIRouter, Depends, File, Form, UploadFile

from app.dependencies import get_embedding_service
from app.models.response import VerifyResponse
from app.services.embedding_service import EmbeddingService


router = APIRouter(tags=["verification"])
logger = logging.getLogger(__name__)


@router.post("/verify", response_model=VerifyResponse)
async def verify_face(
    pegawai_id: str = Form(..., min_length=1, max_length=100),
    image: UploadFile = File(...),
    service: EmbeddingService = Depends(get_embedding_service),
) -> VerifyResponse:
    result = await service.verify(pegawai_id=pegawai_id, upload=image)
    logger.info(
        "Face verification for pegawai_id=%s verified=%s confidence=%.4f",
        pegawai_id,
        result.verified,
        result.confidence,
    )
    return result
