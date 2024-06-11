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
require(__DIR__ . "/../vendor/autoload.php");


use App\System\Core;


Core::Boot();
$request = new Requests();

     
    $request->Required()->request("username");
    $request->request("email");

    $request->ListErrors();

    if($request->countErrors(1) == true)
    {
        echo "continue";
    } 
    else
    {
        echo '<a href="test.php">Back to Form</a>';
    }

  

?>
<a href="test.php">Back to Form</a>
</body>

</html>