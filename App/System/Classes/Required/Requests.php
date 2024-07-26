<?php

namespace App\System\Classes\Required;

use DateInterval;
use Exception;
use LazarusPhp\DatabaseManager\Database;
use PDOException;

use function PHPSTORM_META\elementType;

class Requests extends Validation
{

    private $params = [];
    private $post;
    private $get;
    private $any;

    private $set;

    private $continue;


    // Request Constructor
    public function  __construct()
    {
        $this->continue = true;
    }

    /**
     * Post Request Method
     *
     * @param [type] $name
     * @return void
     */

     public function DisplayErrors()
     {
        // Loop Errors
     }

    public function ValidateParams($name, $params)
    {
        $params = $this->ExplodeParams($params);

            if (isset($params->required)) {
                if ($params->required == true) {
                    if (empty($name)) {
                        $this->continue = false;
                        echo "Empty Value";
                    }
                }
            }
            // Continue
    
             if (isset($params->email)) {
                if ($params->email == true) {
                    if($this->ValidateEmail($name) == false)
                    {
                        $this->continue = false;
                        echo "Valid Email Required";
                    }
                }
            }
        
    }

    public function Post($name, $params = null)
    {
        (isset($_POST[$name])) ? $this->post = $_POST[$name] :  $this->post = null;

        if (!is_null($params)) {
            $this->ValidateParams($this->post, $params);
        }

        if ($this->continue == true) {
            return $this->post;
        } else {
            echo "failed";
        }
    }

    /**
     * Get Request Method
     *
     * @param [type] $name
     * @return void
     */
    public function Get($name,$params=null)
    {
        (isset($_GET[$name])) ? $this->get = $_GET[$name] :  $this->get = null;
        
        if(!is_null($params))
        {
            $this->ValidateParams($this->get, $params);
        }

        if ($this->continue == true) {
            return $this->get;
        } else {
            echo "failed";
        }
    }





   

    public function GetMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    private function ExplodeParams($params)
    {
        $explode = explode("|", $params);

        foreach ($explode as $exploded) {
            $this->params[$exploded] = true;
        }

        return (object) $this->params;
    }


    // Call this method at the end to allow the statement to continue.



    public function any($name, $params=null)
    {
        (isset($_REQUEST[$name])) ? $this->any = $_REQUEST[$name] : $this->any = null;

        
        if(!is_null($params))
        {
            $this->ValidateParams($this->any, $params);
        }

        if ($this->continue == true) {
            return $this->any;
        } else {
            echo "failed";
        }
    }
}
