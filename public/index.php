<?php
require(__DIR__."/../vendor/autoload.php");
use App\System\Core;
use Lazarus\LazarusDb\Database;
Core::Boot();

// Added to prevent Permission Error Sesion directory if needed.
Core::Map("sessions","/var/www/sessions",true);
session_save_path(sessions);
// Start Session
session_start();
$database = new Database();
