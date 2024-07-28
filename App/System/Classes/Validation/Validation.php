<?php

namespace App\System\Classes\Validation;

abstract class Validation
{
    public static $token;
    private $pwCheck;
    public $errors = [];
    public $passwordValidate = [];


    public function __construct()
    {
        // Generate a New Token
        self::$token = bin2hex(random_bytes(32));
    }

    public static function getToken()
    {
        return self::$token;
    }

    public static function verifyToken($session, $token)
    {
        return (hash_equals($session, $token)) ? true : false;
    }



    public static function tokenInput()
    {
        echo '<input hidden" name="csrf_token" value="' . self::GetToken() . '">';
    }

    // Manually Checks two factor Authentication
    // Will eventually Add support with linking multiple devices as well as email option
    // Two factor Authentication scripts will be moved to its own class as a later date

    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function passwordVerify($input, $result)
    {
        return password_verify($input, $result) ? true : false;
    }

    // Add Sanitization and Validation

    public function sanitiseEmail($request)
    {
        return filter_var($request, FILTER_SANITIZE_EMAIL);
    }

    public function validateEmail($request)
    {
        return filter_var($request, FILTER_VALIDATE_EMAIL);
    }


    public function hasStrongPassword($password,$options)
    {
        // Options Support upper lower numbers specials minlength maxlength

        $this->pwCheck = true;
        // Check if Uppercase
            $uppercase = preg_match('@[A-Z]@', $password);
            // Check if Lower case
            $lowercase = preg_match('@[a-z]@', $password);
            // Check for numbers
            $number = preg_match('@[0-9]@', $password);
            // Check for String length
            $length = strlen($password);
            $specialChars = preg_match('@[^\w]@', $password);
            
            $explode = explode("|", $options);

            foreach ($explode as $exploded) {
                $this->passwordValidate[$exploded] = true;
            }

            $validPw = (object) $this->passwordValidate;

            if (isset($validPw->uppercase)) {
                if ($validPw->uppercase == true) {
                    if (!$uppercase) {
                        $this->pwCheck = false;
                        $this->errors[] = "Password Must contaoin at least one Uppercase Letter";
                    }
                }
            }

            if(isset($validPw->lowercase))
            {
                if($validPw->lowercase == true)
                {
                    if (!$lowercase) {
                        $this->pwCheck = false;
                        $this->errors[] = "Password Must have at least one lowercase letter";
                    }
                }
            }

            if(isset($validPw->number))
            {
                if($validPw->number == true)
                {
                    if (!$number) {
                        $this->pwCheck = false;
                        $this->errors[] = "Password must contain at least one number";
                    }
                }
            }

            if(isset($validPw->min))
            {
                if($validPw->min == true)
                {
                    if ($length < 8) {
                        $this->pwCheck = false;
                        $this->errors[] = "Password Must be a minimum of 8 Characters";
                    }
                }
            }

            if(isset($validPw->max))
            {
                if($validPw->max == true)
                {
                    if ($length > 20) {
                        $this->pwCheck = false;
                        $this->errors[] = "Password cannit exceed 20 characters";
                    }
                }
            }

            if(isset($validPw->specials))
            {
                if($validPw->specials == true)
                {
                    if (!$specialChars) {
                        $this->pwCheck = false;
                        $this->errors[] = "Password Must contain at least one Special Character";
                    }
                }
            }
    

            if($this->pwCheck == false)
            {
                return false;
            }
            else
            {
                return true;
            }
    }

    public function santiseUrl($request)
    {
        return filter_var($request, FILTER_SANITIZE_URL);
    }

    public function validateUrl($request)
    {
        return filter_var($request, FILTER_VALIDATE_URL);
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
