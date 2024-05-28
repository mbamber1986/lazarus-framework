<?php
namespace App\System\Classes\Required;

use App\System\Core;
use DateInterval;
use DateTime;
use DateTimeInterface;
use DateTimeZone;
use Exception;

class Date
{
    public static $version = "1.0";
    public static $filename = __FILE__;

    /**
     * 
     * @property mixed $timezone;
     * @property mixed $date
     * @property mixed $instance static
     */

    //  Create the instance
    private static $instance;
    // Generate the properties
    private static $date;
    private static $settimezone;
    private static $dtz;


//  Set Default timezone;
 

    // Create private Constructor
    private function __construct()
    {
        self::$dtz = "Europe/London";
    }

    // Add Setter for Date time;
    // Use to change the timezone Mid Code

    private static function LoadTimeZone($timezone)
    {
        try{
        return new DateTimeZone($timezone);
    }
    catch(Exception $e)
    {
        throw new Exception($e->getMessage());
    }
    }

    public static function Boot()
    {

        if(!isset(static::$instance))
        {
            $c = get_called_class();
            static::$instance = new $c;
        }
        return static::$instance;
    }

    // Create Custom functions for Date and timeZone;

    public static function AddDate($date,$tz=null)
    {
        is_null($tz) ? $timezone = self::$dtz : $timezone = $tz;
        // Return The DateTime Method
        return new DateTime($date,self::LoadTimeZone($timezone));                                                                                          
    }

// Command Based Functions;

    // get Difference between two times.
    public static function GetDifference( $start,  $target,  $format)
    {       
        $s = $start;
        $t = $target;
        return $s->diff($t);

    }

// Return Date time Interval
    public static function ReturnInterval($format)
    {
        return new DateInterval($format);
    }

    // Create New Interval !Needs works still
    public static function AddInterval($date,$value,$command=null)
    {

        is_null($command) ? $c="" : $c="T";
         return $date->add(self::ReturnInterval("P".$c.$value));
        
    }
    
    // Reverse of the Above Subtract intervals !Needs works
    public static function SubInterval($date,$value,$command=null)
    {

        is_null($command) ? $c="" : $c="T";
         return $date->sub(self::ReturnInterval("P".$c.$value));
    }
// 


}