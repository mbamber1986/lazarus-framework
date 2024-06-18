<?php
namespace App\System;

use App\System\Classes\Required\Validation;
use LazarusPhp\SessionManager\Sessions;

class Core
{
    private static $instance;
    private function __construct()
    {
        $session= new Sessions();
        $session->Start();
        // Add Security Class here to Autoload
        
    }


    // Load Defines


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