<?php

namespace App\ParserBundle\Infrastructure\FileUploader;

use App\ParserBundle\Domain\Exception\DomainException;

interface FileUploaderInterface
{
    /**
     * @throws DomainException
     */
    public function uploadFile(TempFile $file, $uploadName): UploadedExportFile;
}
