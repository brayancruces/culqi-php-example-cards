<?php
include_once("../../config.php");
include('../sessions.php');

// Incluir Culqi-php
require_once("../../lib/rmccue/requests/library/Requests.php");
Requests::register_autoloader();
include_once("../../lib/culqi/culqi-php/lib/culqi.php");

if (isset($_POST['token'])) {

  $tokenJson = $_POST['token'];
  $userId = $_POST['user_id'];

  // Obtener Detalles de usuario (DB)
  $userDetails=$userClass->userDetails($userId);

  // Obtener Customer ID (DB)
  $culqiCustomerId = $userDetails->culqi_customer_id;

  /****** CULQI Magic ******/

  // Configurar tu API Key y autenticación
  $API_KEY = CULQI_API_KEY;
  $culqi = new Culqi\Culqi(array('api_key' => $API_KEY));

  try {

    if (empty($userDetails->culqi_customer_id)) {

      /* Crear Customer (Con culqi-php) */

      $customer = $culqi->Customers->create(
        array(
          "address" => $userDetails->address,
          "address_city" => $userDetails->address_city,
          "country_code" => $userDetails->country,
          "email" => $userDetails->email,
          "first_name" => $userDetails->first_name,
          "last_name" => $userDetails->last_name,
          "phone_number" => $userDetails->phone_number
        )
      );

      // Almacenar en DB Customer ID
      $userClass->userUpdate($userId,$customer->id);

      // Nuevo Customer ID
      $culqiCustomerId = $customer->id;

    }

    /* Crear Card (Con culqi-php) */
    $card = $culqi->Cards->create(
      array(
        "customer_id" => $culqiCustomerId,
        "token_id" => $tokenJson['id']
      )
    );

    // Consultar si el card id ya esta en la db con $card->id (y evitar duplicados)
    $checkCard = $cardClass->cardCheck($userId, $card->id);

    // Almacenar en DB Card ID
    if (!$checkCard) {
      $cardClass->cardSave($userId, $card->id, $card->source->card_number, $card->source->iin->card_brand);
      echo '¡Listo! :D Tarjeta de crédito/débito asociada correctamente a tu cuenta. ';
    }
    else{
      echo '¡Uh! Esta tarjeta ya ha sido registrada en tu cuenta.';
    }


  } catch (Exception $e) {

    $error_message = json_decode($e->getMessage());
    error_log('[CULQI API] Error causado: '.$e->getMessage());

    if (isset($error_message->user_message)) {
      echo $error_message->user_message;
    }
    else {
      echo 'Hubo un problema al asociar tu tarjeta, intenta nuevamente.';
    }

  }


}

else{
  echo' Acceso restringido ¡Despedite de tu cuenta papu!';
}
