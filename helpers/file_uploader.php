<?php

function uploadImage(
    array $file,
    string $uploadDir,
    int $maxSize = 500000,
    array $allowedExt = ['jpg', 'jpeg', 'png', 'webp']
) {
    if (empty($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("File upload error: " . $file['error']);
    }

    if (!getimagesize($file['tmp_name'])) {
        throw new Exception("Uploaded file is not an image");
    }

    if ($file['size'] > $maxSize) {
        throw new Exception("File size too large (max {$maxSize} bytes)");
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExt)) {
        throw new Exception("Invalid file type");
    }

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = uniqid('img_', true) . '.' . $ext;

    if (!move_uploaded_file($file['tmp_name'], $uploadDir . $fileName)) {
        throw new Exception("Failed to move uploaded file");
    }

    return $fileName;
}
