<?php
namespace App\System\Classes\Required;

class Validation
{

    public static function Boot()
    {

    }
    public static $token;
    public $errors;


    public function __construct()
    {
        // Generate a New Token
        self::$token = bin2hex(random_bytes(32));
        
    }

    public static function GetToken()
    {
        return self::$token;   
    }

    public static function VerifyToken($session,$token)
    {
        return (hash_equals($session,$token)) ? true : false;
    }

 

    public static function TokenInput()
    {
        echo '<input hidden" name="csrf_token" value="'.self::GetToken().'">';
    }

    // Manually Checks two factor Authentication
    // Will eventually Add support with linking multiple devices as well as email option
    // Two factor Authentication scripts will be moved to its own class as a later date

    public static function HashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function PasswordVerify($input,$result)
    {
        return password_verify($input,$result) ? true : false;
    }

// Add Sanitization and Validation

    public function SanitiseEmail($request)
    {
        return filter_var($request,FILTER_SANITIZE_EMAIL);
    }

    public function ValidateEmail($request)
    {
        return filter_var($request,FILTER_VALIDATE_EMAIL);
    }

    public function SantiseUrl($request)
    {
        return filter_var($request,FILTER_SANITIZE_URL);
    }

    public function ValidateUrl($request)
    {
        return filter_var($request,FILTER_VALIDATE_URL);
    }

    // Check if a field is empty
    public function required($value, $name)
    {
        if (empty($value) || ($value = "") || is_null($value)) {
            // Add Error Code Later
        }
    }



    // Valdate Data and forms.
    public static function SafeHtml($name)
    {
        $data = stripslashes($name);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }
}