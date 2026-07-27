import io

import numpy as np
from fastapi.testclient import TestClient
from PIL import Image

from app.dependencies import get_embedding_service, get_storage_service
from app.main import app
from app.models.response import VerifyResponse


class FakeEmbeddingService:
    async def register(self, pegawai_id, upload):
        return None

    async def verify(self, pegawai_id, upload):
        return VerifyResponse(verified=True, confidence=0.97)


class FakeStorageService:
    def delete(self, pegawai_id):
        return True


def make_image() -> bytes:
    image = Image.fromarray(np.full((240, 240, 3), 180, dtype=np.uint8))
    buffer = io.BytesIO()
    image.save(buffer, format="JPEG")
    return buffer.getvalue()


def test_health():
    client = TestClient(app)
    response = client.get("/health")
    assert response.status_code == 200
    assert response.json() == {"status": "ok"}


def test_register():
    app.dependency_overrides[get_embedding_service] = lambda: FakeEmbeddingService()
    client = TestClient(app)
    response = client.post(
        "/register",
        data={"pegawai_id": "EMP001"},
        files={"image": ("face.jpg", make_image(), "image/jpeg")},
    )
    app.dependency_overrides.clear()

    assert response.status_code == 200
    assert response.json() == {"success": True, "message": "Face registered."}


def test_verify():
    app.dependency_overrides[get_embedding_service] = lambda: FakeEmbeddingService()
    client = TestClient(app)
    response = client.post(
        "/verify",
        data={"pegawai_id": "EMP001"},
        files={"image": ("face.jpg", make_image(), "image/jpeg")},
    )
    app.dependency_overrides.clear()

    assert response.status_code == 200
    assert response.json() == {"verified": True, "confidence": 0.97}


def test_delete_registration():
    app.dependency_overrides[get_storage_service] = lambda: FakeStorageService()
    client = TestClient(app)
    response = client.delete("/register/EMP001")
    app.dependency_overrides.clear()

    assert response.status_code == 200
    assert response.json() == {"success": True, "message": "Face registration deleted."}
