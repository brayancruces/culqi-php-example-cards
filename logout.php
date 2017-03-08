<?php
include('config.php');

// Limpiar sesiones
$session_uid='';
$_SESSION['uid']='';


if(empty($session_uid) && empty($_SESSION['id'])) {
  $url = BASE_URL.'index.php';
  header("Location: $url");
}
