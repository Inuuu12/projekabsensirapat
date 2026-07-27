from pydantic import BaseModel, Field


class HealthResponse(BaseModel):
    status: str


class MessageResponse(BaseModel):
    success: bool
    message: str


class VerifyResponse(BaseModel):
    verified: bool
    confidence: float = Field(..., ge=0.0, le=1.0)
