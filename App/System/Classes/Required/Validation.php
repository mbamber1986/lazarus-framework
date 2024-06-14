<?php
namespace App\System\Classes\Required;

class Validation
{

    public static $instance;
    public static $token;


    public function __construct()
    {
        // Generate a New Token
        self::$token = bin2hex(random_bytes(32));
        
    }

    public static function Boot()
    {
        if (!isset(static::$instance)) {
            $c = get_called_class();
            static::$instance = new $c();
        }
        return static::$instance;
    }

    public static function GetToken()
    {
        return self::$token;   
    }

    public static function VerifyToken($session,$token)
    {
        return (hash_equals($session,$token) : true : false;
    }

    public static function TokenInput()
    {
        echo '<input hidden" name="csrf_token" value="'.self::GetToken().'">';
    }

    // Valdate Data and forms.
    public static function SafeHtml($name)
    {
        $data = trim($name);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }
}