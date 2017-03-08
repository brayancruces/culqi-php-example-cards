<?php

class cardClass
{

  /* Guardar Tarjeta */
  public function cardSave($uidUser, $culqiCardId, $cardMask, $cardBrand)
  {
    try{
      $db = getDB();
      $stmt = $db->prepare("INSERT INTO users_cards(user_id,culqi_card_id,card_mask,card_brand) VALUES (:user_id,:card_id,:card_mask,:card_brand)");

      //Valores
      $stmt->bindParam("user_id", $uidUser,PDO::PARAM_STR);
      $stmt->bindParam("card_id", $culqiCardId,PDO::PARAM_STR);
      $stmt->bindParam("card_mask", $cardMask,PDO::PARAM_STR);
      $stmt->bindParam("card_brand", $cardBrand,PDO::PARAM_STR);

      $stmt->execute();
      $db = null;
      return true;



    }
    catch(PDOException $e) {
      echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
  }


  /* Listado de Tarjetas */
  public function cardList($uidUser)
  {
    try{
      $db = getDB();
      $stmt = $db->prepare("SELECT * FROM users_cards WHERE user_id=:uid");
      $stmt->bindParam("uid", $uidUser,PDO::PARAM_INT);
      $stmt->execute();
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
      return $data;
    }
    catch(PDOException $e) {
      echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
  }

  /* Consultar Tarjeta */
  public function cardCheck($uidUser, $culqiCardId)
  {
    try{
      $db = getDB();
      $stmt = $db->prepare("SELECT * FROM users_cards WHERE (user_id=:uid AND culqi_card_id=:culqi_card_id)");
      $stmt->bindParam("uid", $uidUser,PDO::PARAM_INT);
      $stmt->bindParam("culqi_card_id", $culqiCardId,PDO::PARAM_INT);
      $stmt->execute();
      $data = $stmt->fetch(PDO::FETCH_OBJ);
      return $data;
    }
    catch(PDOException $e) {
      echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
  }




}
