<?php
namespace App\System\Classes\Required;
use LazarusPhp\DatabaseManager\Database;
class Csrf
{

    private static $instance;
    private static $token;
    public static $db;
    public static function Boot()
    {
        self::$db = new Database();
        self::GenerateCsrf();
        if(!isset($instance))
        {
            $c = get_called_class();
            static::$instance = $c;
        }
        return self::$instance;
    }

    private static function GenerateCsrf()
    {
        // Create csrf token
        self::$token =  bin2hex(random_bytes(32));
        $_SESSION['token'] = self::$token;
    }
    
    public static function DisplayToken()
    {
        return self::$token;
    }
    public static function GetInput()
    {
        echo '<input type="Hidden" name="csrf_token" value="'.self::DisplayToken().'">';
    }
}