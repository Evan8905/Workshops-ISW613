<?php

namespace App\Services;

use finfo;

final class UploadService
{
    private const TYPES = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp'];

    public static function store(?array $file): array
    {
        if ($file === null || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return ['filename' => null];
        }
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_INI_SIZE || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_FORM_SIZE || ($file['size'] ?? 0) > 2 * 1024 * 1024) {
            return ['error' => 'picture_too_large'];
        }
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK || !is_uploaded_file($file['tmp_name'])) {
            return ['error' => 'upload_failed'];
        }
        $type = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
        if (!isset(self::TYPES[$type]) || getimagesize($file['tmp_name']) === false) {
            return ['error' => 'invalid_picture'];
        }
        $filename = bin2hex(random_bytes(16)) . '.' . self::TYPES[$type];
        if (!move_uploaded_file($file['tmp_name'], APP_ROOT . '/public/uploads/profile_pictures/' . $filename)) {
            return ['error' => 'upload_failed'];
        }
        return ['filename' => $filename];
    }

    public static function delete(?string $filename): void
    {
        $path = APP_ROOT . '/public/uploads/profile_pictures/' . basename((string) $filename);
        if ($filename !== null && is_file($path)) {
            unlink($path);
        }
    }
}
