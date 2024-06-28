<?php
namespace App\System\Classes\Required;
use App\System\Classes\Required\Validation;

class CustomErrorHandler {

    private static $instance;
    private function __construct()
    {
        
    }

    public static function Boot()
    {
        set_error_handler([__CLASS__, 'handleError']);
        if(!isset(static::$instance))
        {
            $c = get_called_class();
            static::$instance = $c;
        }
        return static::$instance;
    }
    
    private function __destruct()
    {
        restore_error_handler();
    }

    private static $errorTypes = [
        E_ERROR => 'Error',
        E_WARNING => 'Warning',
        E_PARSE => 'Parse Error',
        E_NOTICE => 'Error Notice',
        E_CORE_ERROR => 'Core Error',
        E_CORE_WARNING => 'Core Warning',
        E_COMPILE_ERROR => 'Compile Error',
        E_COMPILE_WARNING => 'Compile Warning',
        E_USER_ERROR => 'User Error',
        E_USER_WARNING => 'User Warning',
        E_USER_NOTICE => 'User Notice',
        E_STRICT => 'Strict',
        E_RECOVERABLE_ERROR => 'Recoverable Error',
        E_DEPRECATED => 'Deprecated',
        E_USER_DEPRECATED => 'User Deprecated'
    ];
    
    public static function DisplayError($file,$linevalue)
    {
        $file = file_get_contents($file);
        $file = Validation::SafeHtml($file);
        $lines = explode("\n", $file);
        if ($file === false) {
            echo "Failed to read the file: " . $file . " <br>";
        } 
        else {
        echo "<pre style='padding:0px; margin:auto;color:white;background-color:#515151; border:solid 1px #000; max-height:300px; width:80%;overflow-y:auto;'>";
        foreach ($lines as $lineNumber => $line)
        {
                if ($lineNumber + 1 == $linevalue) {
                    // Highlight the error line
                    echo "<div style='padding:0px; color:white;'>" . ($lineNumber + 1) . " : " . $line . "</div>  <br>";
                } else {
                    echo "<div style=''>";
                    echo ($lineNumber + 1) . ": " . $line . " <br>";
                    echo "</div>";
                    
                }
            }
        }
        echo "</pre>";
        exit();
        }
    public static function handleError($errno, $errstr, $errfile, $errline) {
        $errorType = isset(self::$errorTypes[$errno]) ? self::$errorTypes[$errno] : 'Unknown Error';
        echo "Error Type: $errorType <br>";
        echo "Error Message: $errstr <br>";
        echo "File: $errfile <br>";
        echo "Line: $errline <br>";
        self::DisplayError($errfile,$errline);
        // Link this to the Database
        $backtrace =var_dump(debug_backtrace());
        echo "Backtrace: <br>$backtrace <br>";
        // Prevent the PHP error handler from executing
        return true;
    }

    private static function formatBacktrace($backtrace) {
        $formattedBacktrace = '';
        foreach ($backtrace as $index => $trace) {
            $file = isset($trace['file']) ? $trace['file'] : '[internal function]';
            $line = isset($trace['line']) ? $trace['line'] : '';
            $function = isset($trace['function']) ? $trace['function'] : '';
            $formattedBacktrace .= "#$index $file($line): $function() <br>";
        }
        return $formattedBacktrace;
    }

}