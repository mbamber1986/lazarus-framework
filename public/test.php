<?php
require(__DIR__ . "/../vendor/autoload.php");
use App\System\Core;
use LazarusPhp\AuthManager\Auth;

Core::Boot();

use App\System\BaseClasses\Performance;
Performance::GenerateId();
echo Performance::DisplayId();
