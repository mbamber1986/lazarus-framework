<?php
namespace App\System;
use LazarusPhp\LazarusDb\Database;
use App\System\StaticClasses\Date;

class Core
{
    private static $instance;
    private static $paths = [];

    private function __construct()
    {
        self::Defines();
        Date::Boot();
        // Load All Created Define paths
        foreach (self::$paths as $name => $path) {
            define($name,self::GenerateRoot().$path);
        }

       Database::Connect(CONFIG);
        
    }


    // Load Defines

    Public static function Defines()
    {
        self::$paths = [
            "ROOT"=>"",
            "CONFIG"=>"/config.php",
            "ROUTER"=>"/App/System/Router/web.php"
        ];
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


    // Destroy Instance When Finished.
    public function __destruct()
    {
        static::$instance=NULL;
    }
    
    /**
     * Undocumented function
     *
     * Reference of a gets the name of the called class
     * @var $class 
     * @property Private static::$instance this is then Coupled with $class 
     * making a new insta ntiated class of itself 
     * 
     * Return self
     * @return @property Static::$instance;
     * 
     */

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
    public function __toString()
    {
        echo "Not Allowed";
    }
}
?>