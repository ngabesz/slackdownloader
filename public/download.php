<?php
require_once '../vendor/autoload.php';

$filesystem = new \Infrastructure\Filesystem\Local();

$zipreader = new \Infrastructure\Reader\ZipReader($filesystem,__DIR__.'/../upload/');
$filereader = new \Infrastructure\Reader\Filereader($filesystem);
$reader = false;

if (!isset($_FILES["fileToUpload"])){
  exit();
}

$e = move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], __DIR__.'/../upload/'.$_FILES["fileToUpload"]["name"]);
$imageFileType = strtolower(pathinfo(__DIR__.'/../upload/'.$_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION));

if ($imageFileType == 'zip'){
  $reader = $zipreader;
}elseif($imageFileType == 'json'){
  $reader = $filereader;
}

if (!$reader){
  echo 'ismeretlen file, csak json vagy zip lehet';
  exit();
}

$urls = $reader->getUrls(__DIR__.'/../upload/'.$_FILES["fileToUpload"]["name"]);
echo '<h1> Az összes képet le tudod tölteni egyben, jobb klikk a fehér részen majd mentés másként:</h1>';

foreach ($urls as $u){
  echo '<img src="'.$u.'"/>';
}

