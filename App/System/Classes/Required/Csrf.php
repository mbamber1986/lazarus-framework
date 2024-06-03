<?php
namespace App\System\Classes\Required;

use DateInterval;
use LazarusPhp\DatabaseManager\Database;
use PDOException;

class Csrf
{

    private static $instance;
    private static $db;
    private static $table = "csrf_tokens";
    private static $date;
    private static $token;
    public static function Boot()
    {
        self::$db = new Database();
        self::$date = new Date();
        self::CheckActiveToken();
        if(!isset($instance))
        {
            $c = get_called_class();
            static::$instance = $c;
        }
        return self::$instance;
    }

    public static function CheckActiveToken()
    {
        $id = session_id();
        $date = self::$date->AddDate("now")->format("Y-m-d H:i:s");
        $sql = "select * from " .self::$table." WHERE session_id=:id AND expires_at < :expires";
        self::$db->AddParams(":id",$id);
        self::$db->AddParams(":expires",$date);
      if(self::$db->RowCount($sql) == 1)
        {
            echo "Results found";
        }
        else
        {
            self::GenerateToken();
        }
    
    }
    
    public static function GenerateToken()
    {
      
        $date = self::$date->AddDate("now")->add(new DateInterval("PT2M"))->format("Y-m-d H:i:s");
        // Check if there is a session Set
        if(!isset($_SESSION['csrf_token'])){
        self::$token = $_SESSION['csrf_token'];
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        self::$token = $_SESSION['csrf_token'];
        $sql = "INSERT INTO csrf_tokens (session_id token expires_at) VALUES(:session_id,:token,:expiry)";
        self::$db->AddParams(":session_id",session_id())
        ->AddParams(":token",self::$token)
        ->AddParams(":expiry",$date)
        ->GenerateQuery($sql);
    }
    // End Session check

    }

}