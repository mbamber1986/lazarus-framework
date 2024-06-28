<?php
namespace App\System\Classes\Optional;

use App\System\Classes\Required\CustomErrorHandler;
use App\System\Core;
use Exception;
class PathManager extends Core
{

    private static $instance;
    private static $version_no = "1.0";
    private static $filename = __FILE__;
    private function __construct()
    {
        
    }

    public static function LoadFile($file,$action=false)
    {

        $file = self::GenerateRoot().$file;
            if(!is_file($file) || !file_exists($file))
            {
                trigger_error("File Doesnt exist",E_USER_NOTICE);
                return false;
            }
    }

    public static function LoadFolder($folder)
    {

    }

    public static function Boot()
    {
        if(!isset(static::$instance))
        {
            $c = get_called_class();
            static::$instance = $c;
        }

        return static::$instance;
    }

}