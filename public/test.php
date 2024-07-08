
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
require(__DIR__ . "/../vendor/autoload.php");



$app = new App();
$request = new Requests();
$_SESSION['token'] = Validation::GetToken();
echo "<a href='testsub.php?username=test&email=mbamber1986&csrf_token=".Validation::GetToken()."&save'>Verify token</a>";
?>
<form id="form" action="testsub.php" method="post">
    <label for="username">Username :</label>
<input type="text" name="username" value="">
<br>
<label for="email">Email : </label>
<input type="text" name="email" value="">
<?php Validation::TokenInput(); ?>
<br>
<button name="save">Save</button>
</form>
</body>

</html>