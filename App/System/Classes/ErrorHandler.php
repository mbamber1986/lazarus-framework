<?php
namespace App\System\Classes;

use App\System\Classes\Required\CustomErrorHandler;
use Error;

class ErrorHandler extends CustomErrorHandler
{

    private static $error;
    private static $messages;

    private static $instance;

    private function __construct()
    {
        self::$error = [];
    }

    // Create a Singleton class instance
    public static function Boot()
    {
        if(!isset(static::$instance))
        {
            $c = get_called_class();
            static::$instance = $c;
        }

    return static::$instance;
    }

    public static function newError($value,$key=null)
    {
        return is_null($key) ? self::$error[] = $value : self::$error[$key] = $value;
    }

    public static function showError($name=null)
    {
        return is_null($name) ? self::$error : self::$error[$name];
    }

    public static function hasErrors()
    {
      if(count(self::$error) > 0)
      {
        return true;
      }
      return false;
    }

    public static function DisplayError($file,$linevalue)
    {
        $file = file_get_contents($file);
        // $file = Validation::SafeHtml($file);
        $lines = explode("\n", $file);
        if ($file === false) {
            echo "Failed to read the file: " . $file . "\n";
        } 
        else {
        echo "<pre style='padding:0px; margin:auto;color:white;background-color:#515151; border:solid 1px #000; max-height:300px; width:80%;overflow-y:auto'>";
        foreach ($lines as $lineNumber => $line)
        {
                if ($lineNumber + 1 == $linevalue) {
                    // Highlight the error line
                    echo "<div style='padding:0px;color:white;'>" . ($lineNumber + 1) . " : " . $line . "</div> \n";
                } else {
                    echo "<div style='color:yellow;'>";
                    echo ($lineNumber + 1) . ": " . $line . "\n";
                    echo "</div>";
                    
                }
            }
        }
        echo "</pre>";

        exit();
        }
}