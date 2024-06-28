<?php
namespace App\System;

use App\System\Classes\Optional\Errors;
use App\System\Classes\Optional\PathManager;
use App\System\Classes\Required\CustomErrorHandler;
use App\System\Classes\Required\Validation;
use Dotenv\Validator;
use LazarusPhp\SessionManager\Sessions;
use Exception;

class Core
{
    private static $instance;
    private static $directory;

    public static $rootOverride = false;
    public static $folder;

    private static $includes = [
        "Router"=>"/App/System/Router/testrouter.php"
    ];

    private function __construct()
    {
      
        // Add Boot Structure here
        Validation::Boot();
        PathManager::Boot();
        CustomErrorHandler::Boot();
        // Structure::Boot();
        self::$directory = self::GenerateRoot();

        foreach(self::$includes as $key => $file)
        {

        }

        // Start Session Manager
        $session= new Sessions();

        if(session_status() == PHP_SESSION_NONE)
        {
           $session->start(); 
        //    session_regenerate_id(true);
        }
        
        // Add Security Class here to Autoload
        
    }

    public static function GenerateRoot()
    {
        if(is_dir("../public")){
        $explode = explode("/",getcwd());
        array_pop($explode);
        $root = implode("/",$explode);
    }
    else
    {
        $root = $_SERVER["DOCUMENT_ROOT"];
    }
        return $root;
    }


    public static function LoopIncludes()
    {
        foreach(self::$includes as $key => $value)
        {
            self::$includes[$key] = $value;
        }
    }


    public static function RequireFile($name)
    {
        $path = self::$directory.self::$includes[$name];
        if(is_file($path))
        {
            return $path;
        }
        else
        {
            echo "NO File Found";
        }
    } 

    // Destroy Instance When Finished.
    public function __destruct()
    {
        static::$instance=NULL;
    }

     public static function Boot()
    {
   
        if(!isset(static::$instance))
        {
            // Call the currently Called class;
            $class = get_called_class();
            // Set the Static Instance.
            static::$instance = new $class;
        }
        return static::$instance;
    }

    // Prevent the CLass from being cloned
     private function __clone()
    {
        // Prevent Cloning
    }

    // Dont Allow this class to be converted to string
    // public function __toString()
    // {
    //     // echo "Not Allowed";
    // }
}