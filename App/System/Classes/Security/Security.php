<?php
namespace App\System\Classes\Security;
use App\System\Classes\Requests\Requests;
use App\System\Classes\Validation\Validation;

class Security
{

    private $request;
    public function __construct()
    {
    
    }

    public function hash($password,$encryption=PASSWORD_DEFAULT)
    {
        return password_hash($password,$encryption);
    }

    public function VerifyHash($local,$remote)
    {
        if(password_verify($local,$remote))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}