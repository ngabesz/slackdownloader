<?php

require_once '../vendor/autoload.php';

$filesystem = new \Infrastructure\Filesystem\Local(__DIR__.'/../upload/');

$fileUploader = new \Infrastructure\Service\FileUploader\FilesystemAdapter($filesystem);
$fileReader = new \Infrastructure\Service\Reader\FilesystemAdapter($filesystem);

$zipReader = new \Infrastructure\Service\Reader\ZipReader($fileReader);
$jsonReader = new \Infrastructure\Service\Reader\JsonReader($fileReader);
$reader = new \Infrastructure\Service\Reader\ExtensionAwareReader();
$reader->addReader('zip',$zipReader);
$reader->addReader('json',$jsonReader);

$useCase = new \Application\UseCase\ReadImageUrlsFromUploadedFile($fileUploader,$reader);
$file = new \Application\UseCase\UploadFileRequest($_FILES["fileToUpload"]["tmp_name"],$_FILES["fileToUpload"]["name"]);

$urls = $useCase->execute($file);

echo '<h1> Az összes képet le tudod tölteni egyben, jobb klikk a fehér részen majd mentés másként:</h1>';

foreach ($urls as $u){
  echo '<img src="'.$u->getUrl().'"/>';
}

