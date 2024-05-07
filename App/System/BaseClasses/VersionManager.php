<?php
namespace App\System\BaseClasses;

class VersionManager
{

    // A Basic Version Management Script
    private static string $version = "1.0" ;
    private static string $filename = __FILE__;
    

    // Get the Version Number
    public static function GetVersion(string $version=null)
    {
        return is_null(self::$version) ? self::$version : $version;
    }

    // Get the Version Filename;
    public static function GetFilename(string $filename=null)
    {
        return is_null(self::$filename) ? self::$filename : $filename;
    }
}