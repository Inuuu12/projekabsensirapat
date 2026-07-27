# Face Recognition Service

FastAPI service terpisah untuk Face Registration, Face Verification, FaceNet embedding, Silent Face Anti Spoofing, dan face detection. Service ini tidak berisi logika Laravel, meeting, pegawai, QR code, atau attendance.

## Architecture

```text
app/main.py              FastAPI app, router registration, error handlers
app/api/                 Thin REST routers
app/services/            AI and storage use cases
app/models/              Pydantic request/response contracts
app/utils/               Image validation, face detection, distance helpers
app/config.py            Environment-driven settings
embeddings/              Local embedding storage as .npz files
weights/                 Optional custom FaceNet model files
uploads/                 Temporary upload directory, ignored by git
```

Flow registration:

```text
multipart image -> validate image -> detect exactly one face -> anti spoofing -> FaceNet embedding -> save .npz
```

Flow verification:

```text
multipart image -> validate image -> load registered embedding -> detect exactly one face -> anti spoofing -> FaceNet embedding -> cosine similarity
```

Liveness always runs before FaceNet. If anti spoofing fails or is not configured, the request fails closed.

## Setup

```powershell
cd face-service
py -3.11 -m venv venv
.\venv\Scripts\Activate.ps1
python -m pip install --upgrade pip
pip install -r requirements.txt
Copy-Item .env.example .env
```

The bundled Silent Face Anti Spoofing resources are used by default:

```text
Silent-Face-Anti-Spoofing/resources/anti_spoof_models
Silent-Face-Anti-Spoofing/resources/detection_model
```

Set `FACENET_MODEL_PATH` to a local TensorFlow/Keras SavedModel or `.h5` if your deployment provides a vetted FaceNet model artifact. When `FACENET_MODEL_PATH` is empty, the service uses `keras-facenet` with cache path `weights/facenet`; keep `ALLOW_MODEL_DOWNLOAD=false` in production and pre-provision the cached weights.

## Run

```powershell
python run.py
```

Default URL:

```text
http://127.0.0.1:8001
```

## API

Health:

```http
GET /health
```

```json
{
  "status": "ok"
}
```

Register:

```bash
curl -X POST http://127.0.0.1:8001/register \
  -F "pegawai_id=EMP001" \
  -F "image=@face.jpg"
```

```json
{
  "success": true,
  "message": "Face registered."
}
```

Verify:

```bash
curl -X POST http://127.0.0.1:8001/verify \
  -F "pegawai_id=EMP001" \
  -F "image=@face.jpg"
```

```json
{
  "verified": true,
  "confidence": 0.97
}
```

Delete registration:

```bash
curl -X DELETE http://127.0.0.1:8001/register/EMP001
```

```json
{
  "success": true,
  "message": "Face registration deleted."
}
```

Error responses are sanitized and consistent:

```json
{
  "success": false,
  "message": "Multiple faces detected."
}
```

## Configuration

```text
RECOGNITION_THRESHOLD=0.72
LIVENESS_THRESHOLD=0.80
MAX_IMAGE_SIZE_BYTES=3145728
FACENET_MODEL_PATH=
FACENET_CACHE_PATH=weights/facenet
ALLOW_MODEL_DOWNLOAD=false
EMBEDDING_PATH=embeddings
UPLOAD_PATH=uploads
ANTI_SPOOF_MODEL_DIR=Silent-Face-Anti-Spoofing/resources/anti_spoof_models
FACE_DETECTOR_PROTO_PATH=Silent-Face-Anti-Spoofing/resources/detection_model/deploy.prototxt
FACE_DETECTOR_MODEL_PATH=Silent-Face-Anti-Spoofing/resources/detection_model/Widerface-RetinaFace.caffemodel
```

## Test

```powershell
pytest
```

The API tests use dependency overrides so they validate routing and response contracts without loading TensorFlow or Torch model weights.
