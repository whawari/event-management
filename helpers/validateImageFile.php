<?php

function validateImageFile($file)
{
    $fileName = $file["name"];
    $fileTmpName = $file["tmp_name"];
    $fileSize = $file["size"];

    $targetDir = "../public/images/uploads/";
    $targetFile = $targetDir . basename($fileName);
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if (empty($fileTmpName) || !file_exists($fileTmpName)) {
        return "Required";
    }

    // Allow certain file formats
    $allowedFileMimes = ["jpg", "jpeg", "png", "webp"];

    if (!in_array($fileType, $allowedFileMimes)) {
        return "Only JPG, JPEG, PNG & WEBP files are allowed";
    }

    // Check if file is an actual image
    if (!getimagesize($fileTmpName)) {
        return "File is not an image";
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        return "File already exists";
    }

    // Check file size
    $maxUploadSize = 2 * 1024 * 1024; // 2097152 Bytes -> 2 MB

    if ($fileSize > $maxUploadSize) {
        return "Maximum upload size is: " . $maxUploadSize / (1024 * 1024) . " MB";
    }

    return "valid";
}
