<?php

namespace App\System\Classes\Required;

class Requests extends Validation
{

    private $params = [];
    private $post;
    private $name;
    private $get;
    private $any;

    private $continue;


    // Request Constructor
    public function  __construct()
    {
        $this->continue = true;
    }

    public function hasErrors()
    {
        if(count($this->errors) > 0)
        {
            return false;
        }
        return true;
    }
    /**
     * Post Request Method
     *
     * @param [type] $name
     * @return void
     */


    public function validateParams($name, $params)
    {
        $params = $this->explodeParams($params);

        if (isset($params->required)) {
            if ($params->required == true) {
                if (empty($name)) {
                    $this->continue = false;
                    $this->errors[] = "Required Field: " . $this->name;
                }
            }
        }

        if(isset($params->password))
        {
            if($params->password == true)
            {
                if($this->hasStrongPassword($name,"uppercase|lowercase|number") == false)
                {
                    $this->continue = false;
                    $this->errors[] = "Passowrd Input Does not Follow Requirments";
                }
            }
        }
        // Continue

        if (isset($params->email)) {
            if ($params->email == true) {
                if (!$this->validateEmail($name)) {
                    $this->continue = false;
                    $this->errors[] = "Valid Email Required for " . $this->name;
                }
            }
        }
    }

    public function post($name, $params = null)
    {
        $this->name = $name;
        (isset($_POST[$name])) ? $this->post = $_POST[$name] :  $this->post = null;

        if (!is_null($params)) {
            $this->validateParams($this->post, $params);
        }
        $this->name = null;
        if ($this->continue == true) {
            return $this->post;
        } else {
        }
    }

    /**
     * Get Request Method
     *
     * @param [type] $name
     * @return void
     */
    public function get($name, $params = null)
    {
        (isset($_GET[$name])) ? $this->get = $_GET[$name] :  $this->get = null;

        if (!is_null($params)) {
            $this->validateParams($this->get, $params);
        }

        if ($this->continue == true) {
            return $this->get;
        } else {
            echo "failed";
        }
    }







    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    private function explodeParams($params)
    {
        $explode = explode("|", $params);

        foreach ($explode as $exploded) {
            $this->params[$exploded] = true;
        }

        return (object) $this->params;
    }


    // Call this method at the end to allow the statement to continue.



    public function any($name, $params = null)
    {
        (isset($_REQUEST[$name])) ? $this->any = $_REQUEST[$name] : $this->any = null;


        if (!is_null($params)) {
            $this->validateParams($this->any, $params);
        }

        if ($this->continue == true) {
            return $this->any;
        } else {
            echo "failed";
        }
    }
}
