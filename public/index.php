<?php
require(__DIR__ . "/../vendor/autoload.php");
use App\System\Core;
use LazarusPhp\AuthManager\Auth;

Core::Boot();

if(isset($_POST['register']))
{
    $auth = new Auth;
    $auth->Register_user();
}
elseif(isset($_POST['login']))
{
    $auth = new Auth;
    $user = $auth->Login();
    echo $user->name;
}

?>

<form method="post">
<input type="text" name="name" placeholder="Name"> <br>
<input type="password" name="password" placeholder="password"> <br>
<input type="email" name="email" placeholder="Email"> <br>
<button name="register">Register user</button> | <button name="login">Login</button>
</form>