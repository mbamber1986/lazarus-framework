<?php
namespace App\System;

use App\System\Classes\Required\Validation;
use LazarusPhp\SessionManager\Sessions;
use App\System\Classes\Required\CustomErrorHandler;
use LazarusPhp\DatabaseManager\CredentialsManager;
use Generator;

class App
{
    public $root;
    public $paths;
    public $path;
    public $config = "/Config.php";

    public function __construct()
    {   
        $this->root = $this->GenerateRoot();
        // Set the Array
        $this->AutoPath();
        // Pass Config File to Database;
        CredentialsManager::SetConfig($this->path["Config"]);
        include_once($this->path["Router"]);

        $this->boot();
        
    }

    public function AutoPath($include=false)
    {
        $this->paths = [
            "Config"=>$this->root.$this->config,
            "Router"=>$this->root."/App/System/Router/router.php"
        ];

        if(count($this->paths) == 0)
        {
            echo "Empty Array";
        }
        else
        {
            foreach($this->paths as $key => $value)
            {
                $this->path[$key] = $value;
            }
        }
    }

    public function AddPath($name,$path)
    {
        $this->path[$name] = $path;
    }


    public function boot($name=null)
    {
        Validation::Boot();
        CustomErrorHandler::Boot();
        $session = new Sessions();
        if(session_status() == PHP_SESSION_NONE)
        {
           $session->start(); 
        }
        // include($this->root."/App/System/Router/router.php");
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