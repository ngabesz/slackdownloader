<?php


namespace Tests\testupload;


use Domain\SlackExportFile;
use PHPUnit\Framework\TestCase;

class SlackExportFileTest extends TestCase
{
  public function testGetName()
  {
    $file = new SlackExportFile(__DIR__ . '/test.json');
    $this->assertEquals('test.json',$file->getName());
  }
}