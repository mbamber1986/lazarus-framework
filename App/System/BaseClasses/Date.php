<?php
namespace App\System\BaseClasses;

use DateInterval;
use DateTime;
use DateTimeInterface;
use DateTimeZone;

class Date 
{

    // Generate the properties
    public $date;
    private $tz;
//  Set Default timezone;
    private $timezone = "Europe/London";

    // Create private Constructor
    public function __construct()
    {
        $this->date = new DateTime();
        $this->SetTimeZone($this->timezone);
    }

    public function SetTimeZone($timeZone)
    {
        $this->tz = $timeZone;
        $tz = new DateTimeZone($this->tz);
        return $this->date->setTimezone($tz);
    }

    public function GetTimeZone()
    {
        return $this->tz;
    }
    
    public function AddTime(string $time)
    {
         $this->date->add(new DateInterval($time));
         return $this;
    }

 
    // Display the Format
    public function UseFormat($format)
    {
         return $this->date->format($format);
        
    }

    public static function GetDifference($start,$target,$format)
    {   
        $s = new DateTime($start);
        $t = new DateTime($target);
        return $s->diff($t)->format($format);
    }

}