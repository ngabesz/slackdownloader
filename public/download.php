<?php

use Application\GetImagesFromFile\GetImagesFromFileQuery;
use Infrastructure\MemeImageParser\SlackMemeImageParserAdapter;
use Infrastructure\Shared\Filesystem\LocalFilesystem;
use Infrastructure\Shared\FileUploader\LocalFileUploader as UploaderFilesystemAdapter;
use Infrastructure\Shared\Reader\ExtensionAwareReader;
use Infrastructure\Shared\Reader\FilesystemManager;
use Infrastructure\Shared\Reader\JsonReader;
use Infrastructure\Shared\Reader\ZipReader;

require_once '../vendor/autoload.php';

$filesystem = new LocalFilesystem(__DIR__.'/../upload/');

$fileUploader = new UploaderFilesystemAdapter($filesystem);
$fileReader = new FilesystemManager($filesystem);

$zipReader = new ZipReader($fileReader);
$jsonReader = new JsonReader($fileReader);
$reader = new ExtensionAwareReader();
$reader->addReader('zip',$zipReader);
$reader->addReader('json',$jsonReader);

$slackMemeImageParser = new SlackMemeImageParserAdapter($fileUploader, $reader);

$useCase = new Application\GetImagesFromFile\GetImagesFromFileHandler($slackMemeImageParser);
$query = new GetImagesFromFileQuery($_FILES["fileToUpload"]["tmp_name"], $_FILES["fileToUpload"]["name"]);

$urls = $useCase->execute($query);

echo '<h1> Az összes képet le tudod tölteni egyben, jobb klikk a fehér részen majd mentés másként:</h1>';

foreach ($urls as $u){
  echo '<img src="'.$u->getUrl().'"/>';
}

