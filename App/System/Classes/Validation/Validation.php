<?php

namespace App\System\Classes\Validation;

abstract class Validation
{
    private $pwCheck;
    public $errors = [];
    public $passwordValidate = [];


    // Manually Checks two factor Authentication
    // Will eventually Add support with linking multiple devices as well as email option
    // Two factor Authentication scripts will be moved to its own class as a later date


    // Add Sanitization and Validation

    public function sanitiseEmail($request)
    {
        return filter_var($request, FILTER_SANITIZE_EMAIL);
    }

    public function validateEmail($request)
    {
        return filter_var($request, FILTER_VALIDATE_EMAIL);
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
