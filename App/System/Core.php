<?php
namespace App\System;


class Core
{
    private static $instance;
    private static $path = [];
 
    private function __construct()
    {
        static::Map("Root");
        static::Map("Database","/App/System/Configs/config.ini");

    }

    /**
     * Map()
     * 
     * this Method will Create and Assign values to a define Script
     * 
     * @param [string] $name
     * @param [string] $path
     * @param [booleon] $removeroot
     * @return void
     */
    Public static function Map($name,$path=null,$removeRoot=null)
    {   
        $root = self::GenerateRoot();
        if(is_null($path))
        {
            $path = $root;
        }
        elseif(!isset(self::$path[$name])){
            if(!is_null($removeRoot) && ($removeRoot == true))
            {
                
                $path = self::$path["$name"] = $path;
            }
            else
            {
                $root = self::GenerateRoot();
                $path = self::$path[$name] = $root.$path;
            }
          }
        define($name,$path);
      
    }
 
    /**
     * Attach
     * Used to Pull the Created Aliase created by map
     * @param [string] $name
     * @return self::$path[$name];
     */
    public static function Attach($name)
    {
        return self::$path[$name];
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


    // Get the Class Version Number When Passed Over.
    final public static function GetVersion($version=null)
    {
        return is_null($version) ? static::$version : $version;
    }

    final public static function Filename($filename=null)
    {
        return is_null($filename) ? static::$filename : $filename;
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