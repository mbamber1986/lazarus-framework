<?php

namespace App\System\BaseClasses;

use App\System\Core;
use PDOException;

class Files extends Core
{
    // Global variables
    protected static  $version = "1.0";
    protected static  $filename = __FILE__;

    // Check the File is actually a file and not a directory

    // Generate the file extention
    public static function GetExtention($file)
    {
        return pathinfo($file, PATHINFO_EXTENSION);
    }

    public static function ReturnError($message=null)
    {
        echo $message;
    }

    // Check if a file is an actual file and not a folder;
    public static function VerifyFile($file)
    {
        return (is_file($file)) && (file_exists($file)) ? true : false;
    }

    // Check if file exists
    public static function FileNotFound($file)
    {
        return file_exists($file) ? true : false;
    }
}
