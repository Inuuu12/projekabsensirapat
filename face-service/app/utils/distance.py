import numpy as np


def cosine_similarity(left: np.ndarray, right: np.ndarray) -> float:
    left_vector = np.asarray(left, dtype=np.float32).reshape(-1)
    right_vector = np.asarray(right, dtype=np.float32).reshape(-1)

    denominator = float(np.linalg.norm(left_vector) * np.linalg.norm(right_vector))
    if denominator <= 0:
        return 0.0

    score = float(np.dot(left_vector, right_vector) / denominator)
    return max(0.0, min(1.0, score))
