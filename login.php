<?php
include('config.php');
include('app/classes/userClass.php');

/* Login */

$userClass = new userClass();

$errorMsgLogin='';

/*  Form */
if (!empty($_POST['loginSubmit']))
{
  $usernameEmail=$_POST['usernameEmail'];
  $password=$_POST['password'];
  if(strlen(trim($usernameEmail))>1 && strlen(trim($password))>1 )
  {
    $uid=$userClass->userLogin($usernameEmail,$password);
    if($uid)
    {
      $url=BASE_URL.'perfil.php';
      header("Location: $url");
    }
    else
    {
      $errorMsgLogin="¡Uh! Por favor verificar el usuario y/o contraseña.";
    }
  }
}


?>

<?php include_once('app/includes/header.php'); ?>
<!-- Contenido -->
<div class="container">

    <div class="row">

        <div class="main">

          <h3>Entrar en Culqi Store <i class="em em-full_moon_with_face"></i></h3>
          <form role="form" method="post" action="" name="login">

            <?php if(!empty($errorMsgLogin)){ ?>
            <div class="alert alert-danger">
              <?php echo $errorMsgLogin; ?>
            </div>
            <?php } ?>

            <div class="form-group">
              <label for="inputEmail">Email</label>
              <input required type="email" class="form-control" placeholder="walter.white@gmail.com" name="usernameEmail" autocomplete="on">
            </div>
            <div class="form-group">
              <label for="inputPassword">Contraseña</label>
              <input required type="password" class="form-control"  placeholder="Ingresa tu contraseña" name="password">
            </div>

            <input type="submit" class="btn btn-info" name="loginSubmit" value="Entrar">

          </form>

        </div>


    </div>

</div>
<!-- /.container -->

<?php
require_once('app/includes/footer.php');
