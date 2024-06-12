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

    private $required = false;

    public function  __construct()
    {
        $this->required = false;
    }

    public function Sanitize($name)
    {
        $data = trim($name);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data,ENT_QUOTES,'UTF-8');
        return $data;
    }

    public function SafeHtml($data)
    {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlentities($data,ENT_QUOTES);
        return $data;
    }


    public function displayPost($name)
    {
        echo (isset($_POST[$name])) ? $this->SafeHtml($_POST[$name]) : "" ;
    }




    public function Post($name)
    {
        $this->post = $_POST[$name];
        return ($this->set == true) ? isset($this->post) : $this->post;
    }


    public function countErrors()
    {
        // This works 
        return count($this->formerror);
    }

    public function ListErrors($class = null)
    {

        if ($this->countErrors() > 0){
            foreach ($this->formerror as $error) {
                echo "<div class='errors'>" . $error . "</div>";
            }
        }
        else
        {
            echo "No Errors Found";
        }
    }

    

    public function Get($name)
    {   
        $get = $_GET[$name];
        return ($this->validate == true) ? isset($get) : $get;
    }

    public function OnSubmit($name)
    {
        return isset($_POST[$name]) ? $this->validate = true:  $this->validate = false;
    }

    public function OnGet($name)
    {
        $get = $_GET[$name];
        return isset( $get) ? $this->validate = true : $this->validate = false;
    }

    public function CheckEmpty($post,$name)
    {
        if(empty($post))
        {
            $this->formerror[] = "An Error Occurred : Empty Value for input $name";
        }
    }

    public function Required()
    {
        $this->required =  true;

        return $this;
    }

// Call this method at the end to allow the statement to continue.
    public function OnComplete( int $count=0) : int
    {
        return ($this->countErrors() == $count) ? true : false;
    }


    public function request($name,$set=false)
    { 
        // Get the Request Method

        $request = $_SERVER['REQUEST_METHOD'];
        $this->set = $set;
        if($request === "POST")
        {
         $request = $this->Post($name);

        }
        elseif($request === "GET")
        {
            echo "get Request coming soon";
        }
// Return Value
        return  $this->Sanitize($request);
    }


}