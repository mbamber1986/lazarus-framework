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


    // Request Constructor
    public function  __construct()
    {
        $this->required = false;
        $this->bind = true;
    }

/**
 * Post Request Method
 *
 * @param [type] $name
 * @return void
 */
    public function Post($name)
    {
        (isset($_POST[$name])) ? $this->post = $_POST[$name] :  $this->post = null;
        ($this->required == true) ? $this->CheckEmpty($this->post, $name) : false;
        return ($this->set == true) ? isset($this->post) : $this->post;
    }

/**
 * Get Request Method
 *
 * @param [type] $name
 * @return void
 */
    public function Get($name)
    {
        (isset($_GET[$name])) ? $this->get = $_GET[$name] :  $this->get = null;
        ($this->required == true) ? $this->CheckEmpty($this->get, $name) : false;
        return ($this->set == true) ? isset($this->get) : $this->get;
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

    public function Bind($requestype)
    {
        $request = strtoupper($requestype);
        if ($_SERVER['REQUEST_METHOD'] === $request) {
            $this->bind = true;
        } else {
            $this->bind = false;
        }
        return $this->bind;
    }

    public function request($name, $set = false)
    {
        $this->set = $set;
        $request = $_SERVER['REQUEST_METHOD'];
        if ($request === "POST") {
            $request = $this->Post($name);
        } elseif ($request === "GET") {
            return $this->Get($name);
        }
        
        $this->required = false;
        return $request;
    
        // Return Value
    }
}
