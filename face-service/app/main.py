import logging

from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from fastapi.responses import JSONResponse

from app.api import delete, health, register, verify
from app.config import get_settings
from app.exceptions import FaceServiceError
from app.logging_config import configure_logging


settings = get_settings()
configure_logging(settings.log_level)
logger = logging.getLogger(__name__)

app = FastAPI(
    title=settings.app_name,
    version="1.0.0",
    docs_url="/docs" if settings.docs_enabled else None,
    redoc_url="/redoc" if settings.docs_enabled else None,
)

app.add_middleware(
    CORSMiddleware,
    allow_origins=settings.cors_origins,
    allow_credentials=False,
    allow_methods=["GET", "POST", "DELETE"],
    allow_headers=["Authorization", "Content-Type"],
)

app.include_router(health.router)
app.include_router(register.router)
app.include_router(verify.router)
app.include_router(delete.router)


@app.exception_handler(FaceServiceError)
async def face_service_error_handler(_, exc: FaceServiceError) -> JSONResponse:
    return JSONResponse(
        status_code=exc.status_code,
        content={"success": False, "message": exc.message},
    )


@app.exception_handler(Exception)
async def unhandled_error_handler(_, exc: Exception) -> JSONResponse:
    logger.exception("Unhandled face-service error: %s", exc)
    return JSONResponse(
        status_code=500,
        content={"success": False, "message": "Internal service error."},
    )
