<?php
namespace App\System\StaticClasses;

use Countable;
use DateInterval;
use DateTime;
use DateTimeInterface;
use DateTimeZone;
use Exception;

class Date
{

    /**
     * 
     * @property mixed $timezone;
     * @property mixed $date
     * @property mixed $instance static
     */

    //  Create the instance
    private static $instance;
    // Generate the properties
    private static $date = [];
    private static $timezone = [];

//  Set Default timezone;
 

    // Create private Constructor
    private function __construct()
    {

    }

 

    public static function Boot()
    {

        foreach(self::ListTz() as $key => $value)
        {
            self::PushTimeZone($key,$value);
        }

        if(!isset(static::$instance))
        {
            $c = get_called_class();
            static::$instance = new $c;
        }
        return static::$instance;
    }

    // Create Custom functions for Date and timeZone;

    public static function AddDate($date,$timeZone=null)
    {
        // Create a Default TimeZone if one is not assigned
        is_null($timeZone) ? $timeZone = self::PullTimeZone("London")  : $timeZone = $timeZone;

        // Return The DateTime Method
        return new DateTime($date,self::SetTimeZone($timeZone));

    }

    
    // Push New TimeZone by name
    public static function PushTimeZone($name,$value)
    {
      return  self::$timezone[$name] = $value;
    
    }

    // Pull the TimeZone Value By Name
    public static  function PullTimezone($name)
    {
        return self::$timezone[$name];
    }

    // Set New TimeZone FUnction
    public static function SetTimeZone($timezone)
    {
        return new DateTimeZone($timezone);
    }

// Array Of PreCreated Timezones 
    public static function ListTz()
    {
        
            $tz = [
                "London"=>"Europe/London",
                "Sydney"=>"Australia/Sydney"
            ];

            return $tz;
    }
 
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
    public function AddInterval($date,$value,$command=null)
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