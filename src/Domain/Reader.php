<?php


namespace Domain;


interface Reader
{
  public function getUrls(SlackExportFile $file) : MemeImageCollection;

}