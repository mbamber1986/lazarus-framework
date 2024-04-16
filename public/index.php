<?php


require(__DIR__."/../vendor/autoload.php");

use Core\Config;

$config = Config::GetInstance();
$values = [
    "url"=> $config->spliceUrl(0,4),
    "folder"=>"/Core/Ini",
    "File"=>"/index.php",
];
$config->generateConfig($values,"WebIndex");
$config->LoadFile(WebIndex);


