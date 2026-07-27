from __future__ import annotations

from io import BytesIO
from dataclasses import dataclass

import cv2
import numpy as np
from fastapi import UploadFile
from PIL import Image, ImageOps, UnidentifiedImageError

from app.config import Settings
from app.exceptions import FaceServiceError


@dataclass(frozen=True)
class FaceBox:
    x: int
    y: int
    width: int
    height: int
    confidence: float


class ImageDecoder:
    def __init__(self, settings: Settings) -> None:
        self._settings = settings

    async def decode_upload(self, upload: UploadFile) -> np.ndarray:
        content_type = upload.content_type or ""
        if content_type not in self._settings.allowed_image_content_types:
            raise FaceServiceError("Unsupported image type.", status_code=415)

        image_bytes = await upload.read()
        if not image_bytes:
            raise FaceServiceError("Image file is empty.", status_code=422)
        if len(image_bytes) > self._settings.max_image_size_bytes:
            raise FaceServiceError("Image file is too large.", status_code=413)

        try:
            buffer = BytesIO(image_bytes)
            image = Image.open(buffer)
            image.verify()
            buffer.seek(0)
            image = Image.open(buffer)
            image = ImageOps.exif_transpose(image).convert("RGB")
        except (UnidentifiedImageError, OSError) as exc:
            raise FaceServiceError("Corrupted image.", status_code=422) from exc

        rgb = np.asarray(image, dtype=np.uint8)
        if rgb.ndim != 3 or rgb.shape[2] != 3:
            raise FaceServiceError("Invalid image format.", status_code=422)
        return cv2.cvtColor(rgb, cv2.COLOR_RGB2BGR)


class FaceDetector:
    """RetinaFace detector using Silent Face Anti Spoofing Caffe resources."""

    def __init__(self, settings: Settings) -> None:
        self._settings = settings
        self._net = None

    def detect(self, image_bgr: np.ndarray) -> list[FaceBox]:
        self._load()
        height, width = image_bgr.shape[:2]
        blob = cv2.dnn.blobFromImage(image_bgr, 1.0, (width, height), (104, 117, 123))
        self._net.setInput(blob, "data")
        detections = self._net.forward("detection_out")

        face_boxes: list[FaceBox] = []
        for detection in detections.reshape(-1, 7):
            confidence = float(detection[2])
            if confidence < self._settings.face_detector_confidence:
                continue

            x1 = int(max(0, detection[3] * width))
            y1 = int(max(0, detection[4] * height))
            x2 = int(min(width - 1, detection[5] * width))
            y2 = int(min(height - 1, detection[6] * height))
            box_width = x2 - x1
            box_height = y2 - y1
            if box_width <= 0 or box_height <= 0:
                continue

            face_boxes.append(
                FaceBox(
                    x=x1,
                    y=y1,
                    width=box_width,
                    height=box_height,
                    confidence=confidence,
                )
            )

        return face_boxes

    def _load(self) -> None:
        if self._net is not None:
            return

        proto_path = self._settings.face_detector_proto_path
        model_path = self._settings.face_detector_model_path
        if not proto_path.exists() or not model_path.exists():
            raise FaceServiceError("Face detector model is not configured.", status_code=503)

        self._net = cv2.dnn.readNetFromCaffe(str(proto_path), str(model_path))


def crop_face(image_bgr: np.ndarray, face_box: FaceBox, padding_ratio: float = 0.20) -> np.ndarray:
    height, width = image_bgr.shape[:2]
    padding_x = int(face_box.width * padding_ratio)
    padding_y = int(face_box.height * padding_ratio)

    x1 = max(0, face_box.x - padding_x)
    y1 = max(0, face_box.y - padding_y)
    x2 = min(width, face_box.x + face_box.width + padding_x)
    y2 = min(height, face_box.y + face_box.height + padding_y)

    crop = image_bgr[y1:y2, x1:x2]
    if crop.size == 0:
        raise FaceServiceError("Face crop is invalid.", status_code=422)
    return crop
