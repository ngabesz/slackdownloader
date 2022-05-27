<?php


namespace Tests;


use Infrastructure\Filesystem\File;
use Infrastructure\Service\Filesystem\Local;
use Infrastructure\Service\Reader\Filereader;
use PHPUnit\Framework\TestCase;

class LocalFilesystemTest extends TestCase
{
  public function testGlobRecursive()
  {

    $expected = array(
        new File(__DIR__.'/testupload/test.json'),
        new File(__DIR__.'/testupload/random/asd.json'),
        new File(__DIR__.'/testupload/random/sub/example/recursive.json'),
    );

    $fileSystem = new \Infrastructure\Filesystem\Local(__DIR__."/testupload");
    $result = $fileSystem->globRecursive(__DIR__."/testupload",'*.json');

    $this->assertEquals($expected,$result);

  }
}