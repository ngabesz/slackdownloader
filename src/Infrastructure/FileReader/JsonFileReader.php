<?php

namespace App\Infrastructure\FileReader;

use App\Domain\MemeImageCollection;
use App\Infrastructure\FileUploader\UploadedExportFile;
use App\Infrastructure\Shared\Filesystem\FilesystemManager;

class JsonFileReader implements FileReaderInterface
{
    protected FilesystemManager $filesystem;

    public function __construct(FilesystemManager $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function getUrls(UploadedExportFile $file) : MemeImageCollection
    {
        $json = $this->filesystem->getContents($file);
        $posts = json_decode($json, true);

        return MemeImageCollection::createFromArray($posts);
    }
}
