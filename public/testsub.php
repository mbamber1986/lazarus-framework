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
use App\System\Classes\Required\Requests;
use App\System\Classes\Required\Security;

require(__DIR__ . "/../vendor/autoload.php");




use App\System\Core;
use LazarusPhp\SessionManager\Sessions;
use App\System\Classes\Required\Validation;


Core::Boot();
$request = new Requests();
if($request->ExplicitBind("get")->request("save",true)){
$request->Required()->request("username");
$request->Required()->request("email");
if($request->OnComplete() == true){
if(Validation::VerifyToken($_SESSION['token'],$request->request("csrf_token")) == true)
{
    echo "it works";
    $_SESSION['token'] = Validation::GetToken();
}
else
{
    echo "token is not a match";
}
}
else
{
    $request->ListErrors();
}
}
?>
</body>

</html>