<?php
namespace App\System\BaseClasses;

use DateInterval;
use DateTime;
use DateTimeZone;

class Performance
{

    /**
     * 
     * @property string $instance;
     * @property mixed $uid;
     * @property mixed $date;
     * @property mixed $str;
     */

     private static $instance;
     private static $uid;
     private static $str;
     private $date;


    //  Private Constructor

    private function __construct()
    {

    }

    // Instantiate a SingleTon Class

       public static function Boot()
    {
   
        if(!isset(static::$instance))
        {
            // Call the currently Called class;
            $class = get_called_class();
            // Set the Static Instance.
            static::$instance = new $class;
        }
        return static::$instance;
    }

    // Generate the id;

    public static function GenerateId()
    {
        self::$uid = serialize(uniqid());
    
    }


    // Insert the Id into the Database

    // Update the Results With end time

    // Disply the Performace

    public static function DisplayId()
    {
        $date = new Date();
        $d1 = $date->UseFormat("Y-m-d");
        $d2 = $date->AddTime("P1Y3M2D")->UseFormat("Y-m-d");
        echo Date::GetDifference($d2,$d1,"%Y Years %m Months %d Days");

    }
}