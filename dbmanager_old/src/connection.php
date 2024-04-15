<?php

namespace engurn\dbManager;

use engurn\dbmanager\credentials;


class Connection
{
    private $hostname;
    private $username;
    private $password;
    private $dbname;
    private $type;
    public $credentials;

    private $connection;
    private $bool;

    private $stmt;
    private $sql;


    /**
     * Constructor Database COnnections
     *
     * @param [type] $type Database Driver
     * @param [type] $hostname ie: localhost, host.domain.com
     * @param [type] $username : Your database username.
     * @param [type] $password : Your Database Password.
     * @param [type] $dbname : Name of your Database Table.
     * 
     * Leaving any of these values empty will cause the Script to give off a connection error.
     */

    public function __construct($type = null, $hostname = null, $username = null, $password = null, $dbname = null)
    {
        // Instantiate a new Class;
        $this->credentials = new Credentials();
        

        if (file_exists($this->config)) {
            // Allow to connect with ini file with the Ability of Database Override.
            is_null($type) ? $this->type = $this->credentials->key["type"] : $this->type = $type;
            is_null($username) ? $this->username = $this->credentials->key["username"] : $this->username = $username;
            is_null($hostname) ? $this->hostname = $this->credentials->key["hostname"] : $this->hostname = $hostname;
            is_null($dbname) ? $this->dbname = $this->credentials->key['dbname'] : $this->dbname = $dbname;
            is_null($password) ? $this->password = $this->credentials->key['password'] : $this->password = $password;
            $this->bool = true;
        } else {
            //Allow users to enter details manaually  if they dont want to use a ini file.
            $credential_vars = ["type" => $type, "Hostname" => $hostname, "Username" => $username, "Password" => $password, "Database name" => $dbname];
            foreach ($credential_vars as $key => $variables) {
                if (empty($variables) ||  is_null($variables)) {
                    echo $key . " has Been left Empty or null <br>";
                    $this->bool = false;
                } else {
                    $this->bool = true;
                }
            }
            $this->type = $type;
            $this->hostname = $hostname;
            $this->username = $username;
            $this->password = $password;
            $this->dbname = $dbname;
        }

        if ($this->bool == true) { // Create Setter
            $this->credentials->Setter($this->type, $this->hostname, $this->username, $this->password, $this->dbname);

            try {
                $this->connection = $this->credentials->OpenConnection();
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
            return $this;
        } else {
            exit("failed to connect");
        }
    }


    public function GenerateQuery(string $sql, array $array = null)
    {
        $this->sql = $sql;
        $this->stmt = $this->connection->prepare($this->sql);
        !is_null($array) ? $this->BindValues($array) : false;
        $this->stmt->execute();
        return $this;
    }

    public function BindValues($array)
    {
        // !is_null($array) ? $this->param = $array :  $this->param = array_combine($this->paramkey, $this->paramvalue);
        if (!empty($array)) {       // Prepare code
            foreach ($array as $key => $value) {
                //    Execute the loop and bind the parameters
                 $this->stmt->bindValue($key, $value);
            }
        }
    }


    //QUery Managemenent


    /**
     * Count Affected Rows for the database.
     *
     * @return void
     */


    public function RowCount()
    {
        return $this->stmt->rowCount();
    }



    // Fetch one result
    public function Fetch($type = null)
    {
        return $this->stmt->fetch($type);
    }

    // Fetch ALl Result
    public function Fetch_All($type = null)
    {
        return $this->stmt->fetchAll($type);
    }

    public function GetLastId()
    {
        return $this->connection->lastInsertId();
    }

    public function TestConnection()
    {
        $this->bool == true ? $value = "connected" : $value = "not connected";
        return "<hr>" . $value . "<hr>";
    }
}
