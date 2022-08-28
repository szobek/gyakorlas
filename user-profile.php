<?php
session_start();
$alert=false;
if (!isset($_SESSION["user"])) {
    die("Nincs ilyen user");
}
include_once "classes/class_user.php";
$user_class = new User();
if(isset($_REQUEST["submit"])){

   if( $user_class->modify_logged_user($_SESSION, $_REQUEST)){
    $alert=true;
   }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <?php include_once "header.php";    ?>
</head>

<body>
    <?php include_once "menu.php"; ?>
    <?php echo  ($alert)?'<div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Sikeres módosítás</div>':""?>
    <div class="container">
        <div class="row">
            <div class="col">
                <div id="profile-container">
                    <p>Név: <?php 
                    $user = $_SESSION["user"];
                    
                    echo $user->firstName . " ".$user->lastName;
                    ?></p>
                <p>E-mail: <?php echo $user->email; ?></p></p>
                </div>
                <button class="btn btn-success m-4" id="btn-modify-profile">Módosít</button>
                <button class="btn btn-danger m-4" id="btn-modify-profile-cancel" style="display: none;">Mégsem</button>
                <form id="profile-form" method="post" action="" style="display: none;">

                    <div class="row">
                        <div class="col-md-6 mb-4">

                            <div class="form-outline">
                                <input type="text" id="firstName" name="firstName" class="form-control form-control-lg" required value="<?php echo $_SESSION["user"]->firstName; ?>" />
                                <label class="form-label" for="firstName">Vezetéknév</label>
                            </div>

                        </div>
                        <div class="col-md-6 mb-4">

                            <div class="form-outline">
                                <input type="text" id="lastName" name="lastName" class="form-control form-control-lg" required value="<?php echo $_SESSION["user"]->lastName; ?>" />
                                <label class="form-label" for="lastName">Keresztnév</label>
                            </div>

                        </div>
                    </div>




                    <div class="row">
                        <div class="col-md-6 mb-4 pb-2">
                        <div class="form-outline">
                                <input type="password" name="passwordNew" class="form-control form-control-lg"  />
                                <label class="form-label" for="emailAddress">Új jelszó</label>
                            </div>

                        </div>
                        <div class="col-md-6 mb-4 pb-2">
                            <div class="form-outline">
                                <input type="password" name="passwordNew2" class="form-control form-control-lg"  />
                                <label class="form-label" for="emailAddress">Új jelszó újra</label>
                            </div>


                        </div>
                    </div>

                    <div class="mt-4 pt-2">
                        <input class="btn btn-primary btn-lg" type="submit" value="Submit" name="submit" />
                    </div>

                </form>
                

            </div>
        </div>
    </div>
<?php
include_once "footer.php";
?>