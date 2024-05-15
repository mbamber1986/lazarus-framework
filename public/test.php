<?php
require(__DIR__ . "/../vendor/autoload.php");
use App\System\Core;
use App\System\StaticClasses\Date;
use lazarusphp\lazarusdb\Database;
Core::Boot();
$date = Date::AddDate("now","London");;
$date2 = Date::AddDate("22-03-1972","London");
echo Date::Informat($date,"d/m/y H:i:s a");
echo "<br> Years since : ";
echo Date::GetDifference($date,$date2,"%Y Years %M Months and %D Days ");