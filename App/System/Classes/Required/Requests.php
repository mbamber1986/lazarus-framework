<?php
namespace App\System\Classes\Required;

use DateInterval;
use Exception;
use LazarusPhp\DatabaseManager\Database;
use PDOException;

class Requests
{

    public $validate;
    public function  __construct()
    {
        
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
    
    // Do a foeach Loop on all requests


   
    
    public function Post($name)
    {   
        $post = $_POST[$name];
        return ($this->validate == true) ? isset($post) : $post;
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

        if($request == "GET")
        {
          return $this->Get($name);
        }
        elseif($request == "POST")
        {
            return $this->Post($name);
        }

    }

    public function request($name,$validate=false)
    {   
        try
        {
           ( $validate == true && is_bool($validate)) ? $this->validate = true : $this->validate = false;
 
             $request =  $this->GetRequestMethod($name);
             return $this->Sanitize($request);
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }
        // ($validate === true) ? $this->validate = true : $this->validate = false;
    
    }


}