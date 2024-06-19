<?php
require(__DIR__ . "/../vendor/autoload.php");
use App\System\Core;
Core::Boot();
Core::LoadRouter();
