<?php
namespace SnorkelWeb\DBManager;

use Lazarus\LazarusDb\Traits\Credentials as TraitsCredentials;
use PDO;
class Credentials
{
   

    private $hostname;
    private $username;
    private $password;
    private $dbname;
    private $type;
    public $key;
    private $config;
    
    public function __construct()
    {

        use Traits\Credentials;
        // Check if the Config Exists;
        file_exists($this->config) ? $this->fetchini() : exit("Could Not Find Config File located at " . $this->config);

    }

    Public function LoadConfig($config)
    {
        $this->config = $config;
        return $this->config;
    }

    public function Setter($type,$hostname,$username,$password,$dbname)
    {
        $this->type = $type;
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
    }
    

    public function OpenConnection()
    {
        // echo $this->Hostname();
        return new PDO($this->dsn(),$this->Username(),$this->Password(),$this->Options());
    }


    public function Options()
    {
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_BOTH,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        return $options;
    }




    private function fetchini()
    {
        $this->key = [];
        // Get Ini File using Constant
        $file = parse_ini_file($this->config);

        foreach($file as $key => $ini)
        {
             $this->key[$key] = $ini;
        }
        
       //  Set individual Values
       return $this->key;
   
    }

}
