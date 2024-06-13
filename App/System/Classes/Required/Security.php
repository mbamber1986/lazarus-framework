<?php
namespace App\System\Classes\Required;

class Security
{

    public static $instance;
    public static $token;


    public function __construct()
    {
        self::$token = bin2hex(random_bytes(32));
        
    }

    public static function Boot()
    {
        if(!isset(static::$instance))
        {
            $c = get_called_class();
            static::$instance = new $c();   
        }
        return static::$instance;
    }

    public static function GetToken()
    {
        return self::$token;
    }


    public static function HashPw($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function VerifyPw()
    {
        return password_verify($password);
    }
}