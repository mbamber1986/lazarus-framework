<?php
namespace LazarusPhp\AuthManager;

// Work

use Closure;
use Dotenv\Parser\Value;
use lazarusphp\Lazarusdb\Database;

class Auth
{

    public $AuthId;
    public $valid = true;
    public $sql;
    public $name;
    public $password;
    public $email;

    public function __construct()
    {

        // Predifined Values;
        $this->name = $_POST['name'];
        $this->password = $_POST['password'];
        $this->email = $_POST['email'];

        // Do a foreach with the values Create a new Value $this->post[$key];
    }



    public function UserByEmail()
    {
        return DataBase::GenerateQuery("select * from users where email=:email");
    }


    public function UserExist()
    {
        Database::withParams(":email",$this->email);
        $query = $this->UserByEmail();
        return ($query->RowCount() == 1) ? true : false;
    }

    // Register New User
    public function Register_user()
    {
        // Do and if and else here  when Account registered
        if ($this->UserExist() == false) {
            Database::withParams(":name", $_POST['name']);
            Database::withParams(":password", password_hash($_POST['password'], PASSWORD_DEFAULT));
            Database::withParams(":email", $_POST['email']);
            Database::GenerateQuery("insert into users (name,password,email) VALUES(:name,:password,:email)");
        }
    }


    // Login User.
    public function Login($sql=null,$values=null)
    {
        if(is_null($sql))
        {
            Database::withParams(":email",$this->email);
            $query = $this->UserByEmail();
        }
        else
        {
            $query = Database::GenerateQuery($sql,$values=null);
        }
        
        return ($query->RowCount() == 1) ? $query->Fetch() : false;
    }

  
   
}
?>