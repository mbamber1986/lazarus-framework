<?php
require(__DIR__ . "/../vendor/autoload.php");
use App\System\Core;
use App\System\StaticClasses\Date;
use LazarusPhp\AuthManager\Auth;
use lazarusphp\lazarusdb\Database;
Core::Boot();

Date::PushTimeZone("Germany","Germany/Berlin");
echo Date::PullTimezone("Germany");
echo "<br>";
echo Date::AddDate("now")->format("D/M/Y");
