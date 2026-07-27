import logging

from fastapi import APIRouter, Depends

from app.dependencies import get_storage_service
from app.exceptions import FaceServiceError
from app.models.response import MessageResponse
from app.services.storage_service import StorageService


router = APIRouter(tags=["registration"])
logger = logging.getLogger(__name__)


@router.delete("/register/{pegawai_id}", response_model=MessageResponse)
async def delete_registration(
    pegawai_id: str,
    storage: StorageService = Depends(get_storage_service),
) -> MessageResponse:
    deleted = storage.delete(pegawai_id)
    if not deleted:
        raise FaceServiceError("Registered face not found.", status_code=404)

    logger.info("Face registration deleted for pegawai_id=%s", pegawai_id)
    return MessageResponse(success=True, message="Face registration deleted.")
