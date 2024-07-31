<?php

namespace   App\System\Classes;
use App\System\Classes\Required\CustomErrorHandler;

use App\System\App;

class Views
{

    private $views;
    private $cache;
    private $requirements;


    public function __construct()
    {
        $app = new App();
        $this->views = $app->GenerateRoot() . "/Views/";
        $this->cache = $app->GenerateRoot() . "/cache/";
        // Create the folders
        
    }
    
    public function render($file, array $data = [])
    {

        if(is_file($this->views.$file))
        {
if (file_exists($this->views.$file)) {
            if (is_array($data)) {
                extract($data);
            }
            ob_start();
            $include = include_once($this->views . $file);
            $include;
            $template = ob_get_clean();
            echo $template;
        }
        else
        {
            trigger_error(E_USER_WARNING,"File Not Found");
        }
        }
        
    }


    private function ValidFolder($property)
    {
        return is_dir($property) ? true : false;
    }
}
