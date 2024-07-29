<?php

namespace App\System\Classes\Security;

use App\System\Classes\Validation\Validation;

class Security extends Validation
{

    private $request;
    private $token;

    public function __construct()
    {
        // Generate a New Token
        $this->token = bin2hex(random_bytes(32));
    }

    public function getToken()
    {
        return $this->token;
    }

    public function verifyToken($session, $token)
    {
        return (hash_equals($session, $token)) ? true : false;
    }



    public function tokenInput()
    {
        echo '<input type="text" name="csrf_token" value="' . $this->GetToken() . '">';
    }

    public function hash($password, $encryption = PASSWORD_DEFAULT)
    {
        return password_hash($password, $encryption);
    }

    public function VerifyHash($local, $remote)
    {
        return (password_verify($local, $remote) == true) ? true : false;
    }

    public function hasStrongPassword($password, $options)
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

        if (isset($validPw->lowercase)) {
            if ($validPw->lowercase == true) {
                if (!$lowercase) {
                    $this->pwCheck = false;
                    $this->errors[] = "Password Must have at least one lowercase letter";
                }
            }
        }

        if (isset($validPw->number)) {
            if ($validPw->number == true) {
                if (!$number) {
                    $this->pwCheck = false;
                    $this->errors[] = "Password must contain at least one number";
                }
            }
        }

        if (isset($validPw->min)) {
            if ($validPw->min == true) {
                if ($length < 8) {
                    $this->pwCheck = false;
                    $this->errors[] = "Password Must be a minimum of 8 Characters";
                }
            }
        }

        if (isset($validPw->max)) {
            if ($validPw->max == true) {
                if ($length > 20) {
                    $this->pwCheck = false;
                    $this->errors[] = "Password cannit exceed 20 characters";
                }
            }
        }

        if (isset($validPw->specials)) {
            if ($validPw->specials == true) {
                if (!$specialChars) {
                    $this->pwCheck = false;
                    $this->errors[] = "Password Must contain at least one Special Character";
                }
            }
        }


        if ($this->pwCheck == false) {
            return false;
        } else {
            return true;
        }
    }
}
