<?php

declare(strict_types=1);

namespace App\Core;

final class Upload
{
    private const IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp'];
    private const IMAGE_MIMES = ['image/jpeg', 'image/png', 'image/webp'];
    private const PDF_EXTENSIONS = ['pdf'];
    private const PDF_MIMES = ['application/pdf', 'application/x-pdf'];
    private const MAX_SIZE = 8_388_608;

    public static function file(array $file, string $type, string $folder): ?string
    {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
            throw new \RuntimeException('Falha no upload do arquivo.');
        }

        if (($file['size'] ?? 0) > self::MAX_SIZE) {
            throw new \RuntimeException('Arquivo acima do limite de 8 MB.');
        }

        $original = (string) ($file['name'] ?? '');
        $extension = strtolower(pathinfo($original, PATHINFO_EXTENSION));
        $tmp = (string) ($file['tmp_name'] ?? '');
        $mime = mime_content_type($tmp) ?: '';

        $allowedExt = $type === 'pdf' ? self::PDF_EXTENSIONS : self::IMAGE_EXTENSIONS;
        $allowedMime = $type === 'pdf' ? self::PDF_MIMES : self::IMAGE_MIMES;

        if (!in_array($extension, $allowedExt, true) || !in_array($mime, $allowedMime, true)) {
            throw new \RuntimeException('Tipo de arquivo não permitido.');
        }

        if ($type === 'image' && !@getimagesize($tmp)) {
            throw new \RuntimeException('Imagem inválida.');
        }

        $relativeDir = '/uploads/' . trim($folder, '/');
        $targetDir = public_path($relativeDir);
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $name = bin2hex(random_bytes(12)) . '.' . $extension;
        $target = $targetDir . DIRECTORY_SEPARATOR . $name;
        if (!move_uploaded_file($tmp, $target)) {
            throw new \RuntimeException('Não foi possível salvar o arquivo.');
        }

        return $relativeDir . '/' . $name;
    }
}
