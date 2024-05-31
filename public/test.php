<?php
require(__DIR__ . "/../vendor/autoload.php");

use App\System\Classes\Required\Date;
use App\System\Core;
use App\System\Classes\Required\VersionControl;
use LazarusPhp\DatabaseManager\Database;
use LazarusPhp\SessionManager\Sessions;
use App\System\Classes\Required\Csrf;

Core::Boot();
Csrf::GetInput();

var_dump($_SESSION);


