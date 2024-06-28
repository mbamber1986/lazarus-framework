<?php
namespace App\System\Classes\Optional;
use App\System\Classes\Required\Validation;
class Errors
{
    private static $messages;
    public function __construct()
    {

    }
    
    public static function DisplayError($file,$linevalue)
    {


        $file = file_get_contents($file);
        $file = Validation::SafeHtml($file);
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

    
        }

}