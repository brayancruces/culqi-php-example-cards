<?php

class userClass
{
  /* Iniciar sesión */
  public function userLogin($usernameEmail,$password)
  {

    $db = getDB();
    $hash_password= hash('sha256', $password); //Encriptación
    $stmt = $db->prepare("SELECT uid FROM users WHERE (username=:usernameEmail or email=:usernameEmail) AND password=:hash_password");
    $stmt->bindParam("usernameEmail", $usernameEmail,PDO::PARAM_STR) ;
    $stmt->bindParam("hash_password", $hash_password,PDO::PARAM_STR) ;
    $stmt->execute();
    $count=$stmt->rowCount();
    $data=$stmt->fetch(PDO::FETCH_OBJ);
    $db = null;
    if($count)
    {
      $_SESSION['uid']=$data->uid; // Otorgar sesión
      return true;
    }
    else
    {
      return false;
    }


  }


  /* Detalles de usuario */
  public function userDetails($uid)
  {
    try{
      $db = getDB();
      $stmt = $db->prepare("SELECT email,username,first_name,last_name,address, address_city, country, phone_number, culqi_customer_id FROM users WHERE uid=:uid");
      $stmt->bindParam("uid", $uid,PDO::PARAM_INT);
      $stmt->execute();
      $data = $stmt->fetch(PDO::FETCH_OBJ); //data
      return $data;
    }
    catch(PDOException $e) {
      echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
  }


  /* Actualizar Usuario  */
  public function userUpdate($uid, $culqiCustomerId)
  {
    try{
      $db = getDB();
      $stmt = $db->prepare("UPDATE users SET culqi_customer_id=:customer_id WHERE uid=:user_id");

      //Valores
      $stmt->bindParam("user_id", $uid,PDO::PARAM_STR);
      $stmt->bindParam("customer_id", $culqiCustomerId,PDO::PARAM_STR);

      $stmt->execute();
      $db = null;
      return true;


    }
    catch(PDOException $e) {
      echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

  }






}
