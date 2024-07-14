
<html>
<head>
    <title></title>
    <style >

        html,body
        {
            margin:0px;
            padding:0px;
            background-color:#f1f1f1;
        }

        .errors
        {
            width:1024px;
            background-color: #fff;
            text-align: center;
            border:solid 3px #000;
            border-left:12px solid black;
            margin:5px auto;
            padding:5px 0px;
            display: block;
        }

        #form
        {
            width: 1024px;
            border:solid 3px #000;
            padding:5px;
            margin:10px auto;
            min-height: 20px;
        }
    </style>
</head>
<body>
<?php
use App\System\Classes\Optional\Pagination;
use App\System\Classes\Required\Requests;
use App\System\Classes\Required\Validation;
use App\System\App;
use App\System\Classes\Response;
use LazarusPhp\AuthManager\Auth;

require(__DIR__ . "/../vendor/autoload.php");



$app = new App();

$request = new Requests();
$username = "";
$password = "";
if($request->Bind("Post") == true && $request->request("save",true))
{
    $username = $request->request("username");
    $password = $request->request("password");
    $auth = new Auth();
    
    if($auth->Authenticate($username,$password)==true)
    {
        echo "Logged in successfully";
    }
    else
    {
        echo "Login failed";
    }
}
?>
<form id="form" action="test.php" method="post">
<input type="text" name="username" value="<?php echo Validation::SafeHtml($username) ?>">
<input type="password" name="password" value="<?php echo Validation::SafeHtml($password) ?>">

<button name="save">Save</button>
</form>
</body>

</html>