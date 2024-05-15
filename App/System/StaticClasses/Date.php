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


    // Generate the properties
    public $date;
    public static $utz;
//  Set Default timezone;
    private static $instance;
    // Default Timezone
    private static $timezone = "London";

    // Create private Constructor
    private function __construct()
    {
    }

 

    public static function Boot()
    {

        foreach(self::ListTz() as $key => $value)
        {
            self::GenerateTimeZone($key,$value);
        }

        

        if(!isset(static::$instance))
        {
            $c = get_called_class();
            static::$instance = new $c;
        }
        return static::$instance;
    }

    // Create Custom functions for Date and timeZone;

    public static function AddDate($date=null,$timeZone=null)
    {
        if(!empty($date))
      {  
        !is_null($timeZone) ? $timeZone = $timeZone : $timeZone = self::$timezone;
        return new DateTime($date,self::SetTimeZone($timeZone));
    }
    else
        {
            echo "Error Date Format Must Not be Empty Please";
        }
    }

    
    public static function GenerateTimeZone($name,$value)
    {
      return  self::$utz[$name] = $value;
    }

    public static function GetTimezone($name)
    {
        return self::$utz[$name];
    }

    public static function SetTimeZone($timeZone)
    {
        return new DateTimeZone(self::GetTimezone($timeZone));
    }

    
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
        return $s->diff($t)->format($format);

    }


    public static function ReturnInterval($format)
    {
        return new DateInterval($format);
    }

    public function AddInterval($date,$value,$command=null)
    {

        is_null($command) ? $c="" : $c="T";
         return $date->add(self::ReturnInterval("P".$c.$value));
        
    }
    
    public static function SubInterval($date,$value,$command=null)
    {

        is_null($command) ? $c="" : $c="T";
         return $date->sub(self::ReturnInterval("P".$c.$value));
        
    }



    public static function InFormat($date,$format)
    {
         return $date->format($format);
         
    }

}