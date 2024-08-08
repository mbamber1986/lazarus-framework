<?php

namespace App\System\Classes\Structure;

class Structure
{
 

    private static $instance;
    
    private function __construct()
    {

    }
    public function Boot()
    {
        if(!isset(static::$instance))
        {
            $c = get_called_class();
            static::$instance = $c;
        }

        return static::$instance;
    }

    public function GenerateRoot()
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
        return $this->root;
    }

}
