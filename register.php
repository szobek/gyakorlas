<?php
include_once "load.php";
$alert = false;
if (!empty($_REQUEST["email"]) && !empty($_REQUEST["password"])) {
  $user_class = new User();
 
  if($user_class->registration( $_REQUEST)){
    $alert = true;
  }
  else{
    echo "Hiba";
    die();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <?php include_once "header.php"; ?>
</head>

<body>
  <?php echo  ($alert)?'<div class="alert alert-success text-center">Sikeres regisztráció <a href="login.php"> Bejentkezés</a></div>':""?>
  <section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row justify-content-center align-items-center h-100">
        <div class="col-12 col-lg-9 col-xl-7">
          <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
            <div class="card-body p-4 p-md-5">
              <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 text-center">Regisztráció</h3>

              <form method="post" action="">

                <div class="row">
                  <div class="col-md-6 mb-4">

                    <div class="form-outline">
                      <input type="text" id="firstName" name="firstName" class="form-control form-control-lg" required/>
                      <label class="form-label" for="firstName">Vezetéknév</label>
                    </div>

                  </div>
                  <div class="col-md-6 mb-4">

                    <div class="form-outline">
                      <input type="text" id="lastName" name="lastName" class="form-control form-control-lg" required/>
                      <label class="form-label" for="lastName">Keresztnév</label>
                    </div>

                  </div>
                </div>




                <div class="row">
                  <div class="col-md-6 mb-4 pb-2">

                    <div class="form-outline">
                      <input type="email" id="emailAddress" name="email" class="form-control form-control-lg" required/>
                      <label class="form-label" for="emailAddress">E-mail</label>
                    </div>

                  </div>
                  <div class="col-md-6 mb-4 pb-2">
                    <div class="form-outline">
                      <input type="password" name="password" class="form-control form-control-lg" required/>
                      <label class="form-label" for="emailAddress">Jelszó</label>
                    </div>


                  </div>
                </div>

                <div class="mt-4 pt-2">
                  <input class="btn btn-primary btn-lg" type="submit" value="Submit" />
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>

</html>