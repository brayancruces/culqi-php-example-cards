<?php
require('config.php');
require('app/sessions.php');
$userDetails=$userClass->userDetails($session_uid);
?>
<?php
include_once('app/includes/header.php');
?>

<!-- Contenido -->
<div class="container">

    <div class="row">

        <div class="main">

          <?php if (isset($_POST['cardList'])): ?>

          <h3>Proceso de Pago</h3>

          <?php

          // Incluir Culqi-php
          require_once("lib/rmccue/requests/library/Requests.php");
          Requests::register_autoloader();
          include_once("lib/culqi/culqi-php/lib/culqi.php");

          // Configurar tu API Key y autenticación
          $API_KEY = CULQI_API_KEY;
          $culqi = new Culqi\Culqi(array('api_key' => $API_KEY));

          $error = '';
          $success = '';

          try {

            $charge = $culqi->Charges->create(array(
                "amount" => 10000,
                "currency_code" => "PEN",
                "description" => "Polo Culqi Tech",
                "email" => $userDetails->email,
                "source_id" => $_POST['cardList'])
            );


            $success = '<div class="alert alert-success">
            <strong>¡Perfecto!</strong> Tu pago fue exitoso, gracias por comprar en Culqi Store.
            </div>';
          }

          catch (Exception $e) {

            $error_message = json_decode($e->getMessage());

            $error = '<div class="alert alert-danger">
            <strong>¡Error!</strong> '.$error_message->user_message.'
            </div>';

          }
          ?>

          <?= $success ?>
          <?= $error ?>

          <a href="index.php">← Regresar a la tienda</a>

          <?php else: ?>

          <?php
            $url=BASE_URL.'index.php';
            header("Location: $url");
          ?>

          <?php endif; ?>


        </div>


    </div>

</div>
<!-- /.container -->







<?php
include_once('app/includes/footer.php');
