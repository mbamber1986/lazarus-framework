<?php
namespace App\System\Classes\Required;

abstract class Validation
{
    public static $token;
    public $errors = [];


    public function __construct()
    {
        // Generate a New Token
        self::$token = bin2hex(random_bytes(32));
    }

    public static function getToken()
    {
        return self::$token;   
    }

    public static function verifyToken($session,$token)
    {
        return (hash_equals($session,$token)) ? true : false;
    }

 

    public static function tokenInput()
    {
        echo '<input hidden" name="csrf_token" value="'.self::GetToken().'">';
    }

    // Manually Checks two factor Authentication
    // Will eventually Add support with linking multiple devices as well as email option
    // Two factor Authentication scripts will be moved to its own class as a later date

    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function passwordVerify($input,$result)
    {
        return password_verify($input,$result) ? true : false;
    }

// Add Sanitization and Validation

    public function sanitiseEmail($request)
    {
        return filter_var($request,FILTER_SANITIZE_EMAIL);
    }

    public function validateEmail($request)
    {
        return filter_var($request,FILTER_VALIDATE_EMAIL);
    }

    public function hasStrongPassword($password)
    {
        
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
    //    $specialChars = preg_match('@[^\w]@', $password);

        if (!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
            return false;
        } else {
            return true;
        }
    }

    public function santiseUrl($request)
    {
        return filter_var($request,FILTER_SANITIZE_URL);
    }

    public function validateUrl($request)
    {
        return filter_var($request,FILTER_VALIDATE_URL);
    }

    // Check if a field is empty
    public function required($value, $name)
    {
        if (empty($value) || ($value = "") || is_null($value)) {
            return true;
        }
    }



    // Valdate Data and forms.
    public static function safeHtml($name)
    {
        $data = stripslashes($name);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }
}