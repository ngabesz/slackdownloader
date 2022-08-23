<?php

namespace App\Infrastructure\Shared\FileUploader;

use App\Domain\Exception\DomainException;

interface FileUploaderInterface
{
    /**
     * @throws DomainException
     */
    public function uploadFile(ExportFile $file, $uploadName): UploadedExportFile;
}
