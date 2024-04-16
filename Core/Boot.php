<?php
namespace Core;

class Boot
{

    private static $instance;

    private function __construct()
    {
        // this function does nothing
    }
    
    // Destroy Instance
    public function __destruct()
    {
        static::$instance=NULL;
    }

    public static function GetInstance()
    {
        if(!isset(static::$instance))
        {
            // Call the currently Called class;
            $c = get_called_class();
            // Set the Static Instance.
            static::$instance = new $c;
        }

        return static::$instance;
    }
    // Get Version Number of item
    // Idea Passed thanks for Robert Ireland
     public function GetVersion()
    {
        return static::$version;
    }

    public Function GetCwd()
    {
        return getcwd();
    }

    public function LoadFile($constant)
    {
        echo $constant;
    }
    public function spliceUrl($start,$end)
    {
        $workingdir = explode("/",$this->GetCwd());
        $slice = array_slice($workingdir,$start,$end);
        $root = implode("/",$slice);
        // Is Callable Via the Define;
        define("ROOT",$root);
        // Can Be Echoed Out With Generate Config
        return $root;
    }

    public function __clone()
    {
        
    }

    public function __toString()
    {
        echo "Not Allowed";
    }
}
?>