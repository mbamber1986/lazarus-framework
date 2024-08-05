<?php

namespace   App\System\Classes;
use App\System\Classes\ErrorHandler;
use App\System\App;
class Views
{

    private $data = [];
    private $views;
    private $cache;

    public function __construct()
    {
    
        $app = new App();
        $this->views = $app->GenerateRoot() . "/Views";
        $this->cache = $app->GenerateRoot() . "/cache";
        // Create the folders
        
    }

    public function __call($name, $arguments) {
        // Check if there is at least one argument
        if (count($arguments) > 0) {
            // Store the first argument with the name as the key
            $this->data[$name] = $arguments[0];
        }
        return $this;
    }


    public function __set($name, $value)
    {
        return $this->data[$name]=$value;
    }

    public function __get($name)
    {
        if(array_key_exists($name,$this->data))
        {
            return $this->data[$name];
        }
    }
    
    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    public function __unset($name)
    {
        unset($this->data[$name]);
    }




    private function ViewExists($file)
    {
        return file_exists($file) ? true : false;
    }

    public function render($file, array $data = [])
    {
        echo count($this->data);
        $path = $this->views . $file;
        // Check if $data is not empty
        if(count($data) > 0)
        {
            // Change $this->data to a non Variable;
            $this->data = $data;
        }

        if(is_array($this->data))
        {
            extract($this->data);
        }
    

        if($this->ViewExists($path) == true){
        ob_start();
        ob_get_contents();
        require_once($path);
        ob_end_flush();
        }        
        else
        {
            trigger_error("The File $path cannot be found:");
        }

        return $this;
    }


    private function ValidFolder($property)
    {
        return is_dir($property) ? true : false;
    }
}
