import logging

from fastapi import APIRouter, Depends, File, Form, UploadFile

from app.dependencies import get_embedding_service
from app.models.response import MessageResponse
from app.services.embedding_service import EmbeddingService


router = APIRouter(tags=["registration"])
logger = logging.getLogger(__name__)


@router.post("/register", response_model=MessageResponse)
async def register_face(
    pegawai_id: str = Form(..., min_length=1, max_length=100),
    image: UploadFile = File(...),
    service: EmbeddingService = Depends(get_embedding_service),
) -> MessageResponse:
    await service.register(pegawai_id=pegawai_id, upload=image)
    logger.info("Face registered for pegawai_id=%s", pegawai_id)
    return MessageResponse(success=True, message="Face registered.")
