<?php

namespace App\Infrastructure\FileUploader;

use App\Domain\Exception\DomainException;

interface FileUploaderInterface
{
    /**
     * @throws DomainException
     */
    public function uploadFile(TempFile $file, $uploadName): UploadedExportFile;
}
