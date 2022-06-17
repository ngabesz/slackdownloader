<?php

namespace Infrastructure\Shared\FileUploader;

use Domain\Exception\DomainException;

interface FileUploaderInterface
{
    /**
     * @throws DomainException
     */
    public function uploadFile(ExportFile $file, $uploadName): UploadedExportFile;
}
