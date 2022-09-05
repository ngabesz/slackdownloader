<?php

namespace App\Infrastructure\Shared\Filesystem;

class File
{
    private string $name;
    private string $path;

    public function __construct($path)
    {
        $name = explode(DIRECTORY_SEPARATOR, $path);
        $this->name = end($name);
        $this->path = $path;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getExtension(): string
    {
        $re = explode('.', $this->name);
        return end($re);
    }
}
