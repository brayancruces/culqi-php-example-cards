<?php
session_start();

/* Configuración de Database */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', '');
define('DB_PASSWORD', '');
define('DB_DATABASE', '');
define("BASE_URL", "http://localhost/demo_culqi_store/"); // Ejemplo: http://misitio.com/demo/

define('CULQI_API_KEY', '');

function getDB()
{

  $dbhost=DB_SERVER;
  $dbuser=DB_USERNAME;
  $dbpass=DB_PASSWORD;
  $dbname=DB_DATABASE;

  // Conexión correcta
  try {
    $dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbConnection->exec("set names utf8");
    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbConnection;
  }
  // Conexión falló
  catch (PDOException $e) {
    //echo 'La conexión falló: ' . $e->getMessage();
    die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
  }


}
