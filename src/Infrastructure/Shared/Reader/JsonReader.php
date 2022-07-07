<?php


namespace App\Infrastructure\Shared\Reader;

use App\Domain\MemeImageCollection;
use App\Infrastructure\Shared\FileUploader\UploadedExportFile;


class JsonReader implements Reader
{
    protected FilesystemManager $filesystem;

    public function __construct( FilesystemManager $filesystem)
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