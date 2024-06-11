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
        if($this->required == true)
        {
            $this->CheckEmpty($this->post,$name);
        }
        else
        {
            return ($this->validate == true) ? isset($this->post) : $this->post;
        }
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


    public function GetRequestMethod($name)
    {

        $request = $_SERVER['REQUEST_METHOD'];
        switch($request)
        {
            case 'GET': $request = $this->Get($name);
            break;
            case 'POST': $request = $this->Post($name);
            break;
            default;
            return $request;
        }

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


    public function request($name)
    {   
        try
        { 
            // $required == true ? $this->required = true : $this->required = false;
             $request =  $this->GetRequestMethod($name);
             $this->required = false;
             return $this->Sanitize($request);
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }
        // ($validate === true) ? $this->validate = true : $this->validate = false;
    
    }


}