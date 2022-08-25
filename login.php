<?php
session_start();
 include_once "classes/class_user.php";
if(!empty($_REQUEST["email"]) && !empty($_REQUEST["password"]) ){
    $user_class = new User();
    $fn = $user_class->login();
    $logged = $fn["logged"];
    if($logged){
        $user = $fn["user"];
$_SESSION["logged"] = true;
$_SESSION["user"] = $user;

header("Location:/");
    } else{
        echo "Hibás adatok!";
    }
}
if(array_key_exists("logged",$_SESSION)){
    if($_SESSION["logged"]){

        header("Location:/");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <?php include_once "header.php"; ?>
</head>
<body>
<div id="login">
        <h3 class="text-center text-white pt-5">Login form</h3>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="" method="post">
                            <h3 class="text-center text-info">Login</h3>
                            <div class="form-group">
                                <label for="username" class="text-info">E-mail:</label><br>
                                <input type="text" name="email"  class="form-control" value="kunszt.norbert@gmail.com">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="password" name="password" class="form-control" value="123456">
                            </div>
                            <div class="form-group">
                            
                                <input type="submit"  class="btn btn-info btn-md" value="submit">
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>