<?php
namespace App\System;

use App\System\Classes\Required\Validation;

class System
{


    public $root;
    public function __construct()
    {

        if(is_dir("../public")){
            $explode = explode("/",getcwd());
            array_pop($explode);
            $this->root = implode("/",$explode);
        }
        else
        {
            $this->root = $_SERVER["DOCUMENT_ROOT"];
        }
      
        // Add Boot Structure here
        Validation::Boot();
        // Start Session Manager
        $session= new Sessions();
        if(session_status() == PHP_SESSION_NONE)
        {
           $session->start(); 
        }
        
        // Add Security Class here to Autoload

        
    }

    // Load Defines

    public static function LoadRouter($path = null)
    {
            include self::$rootpath . $path;
    
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

}