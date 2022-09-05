<?php

namespace App\Tests\Unit\Infrastructure\Shared\Filesystem;

use App\Infrastructure\Shared\Filesystem\File;
use App\Infrastructure\Shared\Filesystem\LocalFilesystem;
use PHPUnit\Framework\TestCase;

class LocalFilesystemTest extends TestCase
{
  public function testGlobRecursive()
  {

    $expected = array(
        new File(__DIR__ . '/fixture/test.json'),
        new File(__DIR__ . '/fixture/random/asd.json'),
        new File(__DIR__ . '/fixture/random/sub/example/recursive.json'),
    );

    $fileSystem = new LocalFilesystem(__DIR__ . "/fixture");
    $result = $fileSystem->globRecursive(__DIR__ . "/fixture",'*.json');

    $this->assertEquals($expected, $result);

  }
}