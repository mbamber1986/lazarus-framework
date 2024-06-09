<?php
use App\System\Classes\Required\Requests;
require(__DIR__ . "/../vendor/autoload.php");


use App\System\Core;

Core::Boot();
$request = new Requests();
if($request->OnGet("username") && $request->OnGet("email"))
{
    echo $request->request("username");
    echo $request->request("email");
}


?>
<form method="post">
<input type="text" name="username" value="">
<button name="save">Save</button>
</form>
