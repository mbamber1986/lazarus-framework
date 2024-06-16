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
        return (hash_equals($session,$token)) ? true : false;
    }

    public static function GenerateTfa():int
    {
        return random_int(100000,999999);
    }

    public static function TokenInput()
    {
        echo '<input hidden" name="csrf_token" value="'.self::GetToken().'">';
    }

    // Manually Checks two factor Authentication
    // Will eventually Add support with linking multiple devices as well as email option
    // Two factor Authentication scripts will be moved to its own class as a later date
    public static function VerifyTfa($input,$code) :int
    {
        return ($input === $code) ? true : false;   
    }

    public static function TfaInput()
    {
        for($i=0;$i<6;$i++)
        {
            echo "<input name='code[]' type='textbox' maxlength='1' size='1'>";
        }
    }

    public static function HashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function PasswordVerify($input,$result)
    {
        return password_verify($input,$result) ? true : false;
    }



    public static function ValidateEmail($email)
    {
        return (filter_var($email, FILTER_VALIDATE_EMAIL) !== false);
    }



    // Valdate Data and forms.
    public static function SafeHtml($name)
    {#
        $data = stripslashes($name);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }
}