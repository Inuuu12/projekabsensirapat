from __future__ import annotations

import logging
import sys
from dataclasses import dataclass
from pathlib import Path

import cv2
import numpy as np

from app.config import Settings
from app.exceptions import FaceServiceError
from app.utils.image import FaceBox


logger = logging.getLogger(__name__)


@dataclass(frozen=True)
class LivenessResult:
    is_live: bool
    score: float


class AntiSpoofService:
    """Silent Face Anti Spoofing inference wrapper."""

    def __init__(self, settings: Settings) -> None:
        self._settings = settings
        self._models: dict[Path, object] = {}
        self._torch = None
        self._transform = None
        self._cropper = None
        self._parse_model_name = None
        self._model_mapping = None
        self._device = None

    def check_liveness(self, image_bgr: np.ndarray, face_box: FaceBox) -> LivenessResult:
        self._ensure_runtime_loaded()
        model_paths = sorted(self._settings.anti_spoof_model_dir.glob("*.pth"))
        if not model_paths:
            raise FaceServiceError("Anti spoofing model is not configured.", status_code=503)

        bbox = [face_box.x, face_box.y, face_box.width, face_box.height]
        prediction = np.zeros((1, 3), dtype=np.float32)
        used_models = 0

        for model_path in model_paths:
            h_input, w_input, _, scale = self._parse_model_name(model_path.name)
            crop_config = {
                "org_img": image_bgr,
                "bbox": bbox,
                "scale": scale,
                "out_w": w_input,
                "out_h": h_input,
                "crop": scale is not None,
            }
            cropped = self._cropper.crop(**crop_config)
            model_prediction = self._predict(cropped, model_path)
            if model_prediction.shape[1] > prediction.shape[1]:
                model_prediction = model_prediction[:, : prediction.shape[1]]
            prediction += model_prediction
            used_models += 1

        if used_models == 0:
            raise FaceServiceError("Anti spoofing model is not configured.", status_code=503)

        prediction = prediction / used_models
        label = int(np.argmax(prediction))
        live_score = float(prediction[0][1])
        is_live = label == 1 and live_score >= self._settings.liveness_threshold

        if not is_live:
            logger.warning("Spoof detection failed label=%s live_score=%.4f", label, live_score)

        return LivenessResult(is_live=is_live, score=live_score)

    def _ensure_runtime_loaded(self) -> None:
        if self._torch is not None:
            return

        source_path = self._settings.silent_face_source_path
        src_path = source_path / "src"
        if not source_path.exists() or not src_path.exists():
            raise FaceServiceError("Silent Face Anti Spoofing source is not configured.", status_code=503)

        sys.path.insert(0, str(source_path))
        try:
            import torch
            from src.data_io import transform as trans
            from src.generate_patches import CropImage
            from src.model_lib.MiniFASNet import MiniFASNetV1, MiniFASNetV1SE, MiniFASNetV2, MiniFASNetV2SE
            from src.utility import get_kernel, parse_model_name
        except ImportError as exc:
            logger.exception("Silent Face Anti Spoofing dependency is unavailable.")
            raise FaceServiceError("Anti spoofing dependency is unavailable.", status_code=503) from exc

        self._torch = torch
        self._transform = trans.Compose([trans.ToTensor()])
        self._cropper = CropImage()
        self._parse_model_name = parse_model_name
        self._get_kernel = get_kernel
        self._model_mapping = {
            "MiniFASNetV1": MiniFASNetV1,
            "MiniFASNetV2": MiniFASNetV2,
            "MiniFASNetV1SE": MiniFASNetV1SE,
            "MiniFASNetV2SE": MiniFASNetV2SE,
        }
        self._device = torch.device("cuda:0" if torch.cuda.is_available() else "cpu")

    def _predict(self, image_bgr: np.ndarray, model_path: Path) -> np.ndarray:
        model = self._load_model(model_path)
        image_tensor = self._transform(image_bgr).unsqueeze(0).to(self._device)

        model.eval()
        with self._torch.no_grad():
            result = model.forward(image_tensor)
            result = self._torch.nn.functional.softmax(result, dim=1).cpu().numpy()
        return result

    def _load_model(self, model_path: Path) -> object:
        cached_model = self._models.get(model_path)
        if cached_model is not None:
            return cached_model

        h_input, w_input, model_type, _ = self._parse_model_name(model_path.name)
        model_class = self._model_mapping.get(model_type)
        if model_class is None:
            raise FaceServiceError("Unsupported anti spoofing model type.", status_code=503)

        model = model_class(conv6_kernel=self._get_kernel(h_input, w_input)).to(self._device)
        state_dict = self._torch.load(model_path, map_location=self._device)
        first_layer_name = next(iter(state_dict))

        if first_layer_name.startswith("module."):
            state_dict = {key[7:]: value for key, value in state_dict.items()}

        model.load_state_dict(state_dict)
        self._models[model_path] = model
        return model
