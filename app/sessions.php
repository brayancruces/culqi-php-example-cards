<?php

// Logueado
if(!empty($_SESSION['uid']))
{
  $session_uid=$_SESSION['uid'];
  include('classes/userClass.php');

  $userClass = new userClass();

  include('classes/cardClass.php');

  $cardClass = new cardClass();

}

// Invitado
if(empty($session_uid))
{
  $url=BASE_URL.'login.php';
  header("Location: $url");
}

?>
