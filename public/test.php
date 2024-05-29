<?php
require(__DIR__ . "/../vendor/autoload.php");

use App\System\Classes\Required\Date;
use App\System\Core;
use LazarusPhp\DatabaseManager\Database;
use LazarusPhp\SessionManager\Sessions;

Core::Boot();
$db = new Database();
$user = $db->AddParams("id",1)->One("select * from users where id=:id");
echo $user->username;

$date = new Date();
$expiry = $date->AddDate("now")->Format("Y-m-d");