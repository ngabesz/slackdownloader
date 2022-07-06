<?php


namespace Infrastructure\Shared\Reader;

use Domain\MemeImageCollection;
use Infrastructure\Shared\FileUploader\UploadedExportFile;


class JsonReader implements Reader
{
    private FilesystemManager $filesystem;

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