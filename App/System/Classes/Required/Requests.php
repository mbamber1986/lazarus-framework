<?php

namespace App\System\Classes\Required;

use DateInterval;
use Exception;
use LazarusPhp\DatabaseManager\Database;
use PDOException;

class Requests
{

    public $validate;
    public $formerror = [];
    private $post;
    private $get;
    private $set;
    private $required;
    private $bind;


    public function  __construct()
    {
        $this->required = false;
    }



    public function Post($name)
    {
        (isset($_POST[$name])) ? $this->post = $_POST[$name] :  $this->post = null;
        ($this->required == true) ? $this->CheckEmpty($this->post, $name) : false;
        return ($this->set == true) ? isset($this->post) : $this->post;
    }


    public function countErrors()
    {
        // This works 
        return count($this->formerror);
    }

    public function ListErrors($class = null)
    {
        foreach ($this->formerror as $error) {
            echo "<div class='errors'>" . $error . "</div>";
        }
    }


    public function Get($name)
    {
        (isset($_GET[$name])) ? $this->get = $_GET[$name] :  $this->get = null;
        return ($this->set == true) ? isset($this->get) : $this->get;
    }

    public function CheckEmpty($value, $name)
    {
        if (empty($value) || ($value = "") || is_null($value)) {
            $this->formerror[] = "An Error Occurred : Empty Value for input $name";
        }
    }

    public function Required()
    {
        $this->required = true;
        return $this;
    }

    // Call this method at the end to allow the statement to continue.
    public function OnComplete(int $count = 0): int
    {
        return ($this->countErrors() == $count) ? true : false;
    }

    public function ExplicitBind($requestype)
    {
        $this->bind = $requestype;
        return $this;
    }

    public function request($name, $set = false)
    {
        // Get the Request Method
        if($_SERVER['REQUEST_METHOD'] !== strtoupper($this->bind))
        {
            echo "Failed";
        }
        else
        {
        $request = $_SERVER['REQUEST_METHOD'];
        $this->set = $set;

        if ($request === "POST") {
            $request = $this->Post($name);
        } elseif ($request === "GET") {
            return $this->Get($name);
        }
        // Return Value
        // $this->required = false;
        return $request;
        }
        
    }
}
