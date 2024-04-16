<?php
namespace Core;

class Config extends Boot
{
    private $Config;
    private $version = 1.0;
    private $name = "Config File";


    function __construct()
    {
        
    }

     // Load the location of a file and 
     public function generateConfig($values,$constant)
     {
        // Check if the files Exisit();
        is_array($values) ? $value = implode("",$values) : $value = $values;
        define($constant,$value);
        
     }
     


    function __destruct()
    {
        $this->config = null;
    }

    public function __clone()
    {

    }
}
?>