<?php
namespace App\System\Classes\Required;
use App\System\Classes\Required\Validation;
use LazarusPhp\DatabaseManager\Database;

class CustomErrorHandler extends Database {

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
    
    public function __destruct()
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

    public function GenerateErrorLog()
    {
        
    }

    
    public static function DisplayError($file,$linevalue)
    {
        $file = file_get_contents($file);
        $file = htmlspecialchars($file);
        $lines = explode("\n", $file);
       
        echo "<pre style='padding:0px; margin:auto;color:white;background-color:#515151; border:solid 1px #000; max-height:300px; width:80%; overflow-y:auto;'>";
        foreach ($lines as $lineNumber => $line)
        {
                if ($lineNumber + 1 == $linevalue) {
                    // Highlight the error line
                    echo "<div style='padding:0px; color:yellow;'>" . ($lineNumber + 1) . " : " . $line . "</div>  <br>";
                } else {
                    echo "<div style='color:white;'>";
                    echo ($lineNumber + 1) . ": " . $line . " <br>";
                    echo "</div>";
                    
                }
        }
                 echo "</pre>";
        }


    public static function handleError($errno, $errstr, $errfile, $errline) {
        $errorType = isset(self::$errorTypes[$errno]) ? self::$errorTypes[$errno] : 'Unknown Error';
        echo "Error Type: $errorType <br>";
        echo "Error Message: $errstr <br>";
        echo "File: $errfile <br>";
        echo "Line: $errline <br>"; 
        self::DisplayError($errfile,$errline);
        // Link this to the Database
        // Logs need adding
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