from pydantic import BaseModel, Field


class FaceRequest(BaseModel):
    pegawai_id: str = Field(..., min_length=1, max_length=100)
