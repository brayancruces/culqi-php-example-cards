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
          <h3>¡Bienvenido <?php echo $userDetails->first_name; ?>!</h3>
        </div>

        <div class="col-sm-2">
          <nav class="nav-sidebar">
            <ul class="nav tabs">
              <li class="active"><a href="#tab-profile" data-toggle="tab">Perfil</a></li>
              <li class=""><a href="#tab-cards" data-toggle="tab">Tarjetas</a></li>
            </ul>
          </nav>
        </div>

        <div class="col-sm-10">
            <!-- tab content -->
            <div class="tab-content">
                <div class="tab-pane active text-style" id="tab-profile">
                  <h4>Mi perfil</h4>
                  <form class="form-horizontal">
                    <fieldset>

                      <!-- Text input-->
                      <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput">Nombres</label>
                        <div class="col-md-4">
                          <input value="<?php echo $userDetails->first_name; ?>" disabled  name="textinput" placeholder="" class="form-control input-md" type="text">

                        </div>
                      </div>


                      <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput">Apellidos</label>
                        <div class="col-md-4">
                          <input value="<?php echo $userDetails->last_name; ?>" disabled name="textinput" placeholder="" class="form-control input-md"  type="text">

                        </div>
                      </div>


                      <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput">E-mail</label>
                        <div class="col-md-4">
                          <input value="<?php echo $userDetails->email; ?>" disabled name="textinput" placeholder="" class="form-control input-md"  type="text">

                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput">Usuario</label>
                        <div class="col-md-4">
                          <input value="<?php echo $userDetails->username; ?>" disabled name="textinput" placeholder="" class="form-control input-md"  type="text">

                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput">Dirección</label>
                        <div class="col-md-4">
                          <input value="<?php echo $userDetails->address; ?>" disabled name="textinput" placeholder="" class="form-control input-md"  type="text">

                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput">Ciudad</label>
                        <div class="col-md-4">
                          <input value="<?php echo $userDetails->address_city; ?>" disabled name="textinput" placeholder="" class="form-control input-md"  type="text">

                        </div>
                      </div>


                      <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput">Código de País</label>
                        <div class="col-md-4">
                          <input value="<?php echo $userDetails->country; ?>" disabled name="textinput" placeholder="" class="form-control input-md"  type="text">

                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-4 control-label" for="textinput">Teléfono</label>
                        <div class="col-md-4">
                          <input value="<?php echo $userDetails->phone_number; ?>" disabled name="textinput" placeholder="" class="form-control input-md"  type="text">
                        </div>
                      </div>



                    </fieldset>
                  </form>
                </form>
                  <hr>
                </div>
                <div class="tab-pane text-style" id="tab-cards">

                  <h4>Tarjetas asociadas</h4>
                  <p>
                    A tu cuenta puedes asociar una o más tarjetas de crédito o débito. De este modo,
                    al momento de una compra no te volveremos a solicitar los datos de tu tarjeta.
                  </p>

                  <p> <a id="addCardButton" href="#">+ Añadir tarjeta</a></p>

                  <ul>
                  <?php

                  $userCards = $cardClass->cardList($session_uid);


                  foreach ($userCards as $cards) {
                    echo'<li>'.$cards->card_mask.' - '.$cards->card_brand.'</li>';
                  }


                  ?>
                 </ul>

                </div>
            </div>

         </div>




    </div>

</div>
<!-- /.container -->

<!-- Incluyendo .js de Culqi Checkout-->
   <script src="https://checkout.culqi.com/v2"></script>
   <!-- Seteando valores de config-->
   <script>
       Culqi.publicKey = 'pk_test_J0BnI4vcidMGdPkF'; // Llave pública
       Culqi.settings({
           title: 'Culqi Store',
           currency: 'PEN',
           description: 'Agregando tarjeta de <?php echo $userDetails->first_name; ?>',
           amount: ""
       });
   </script>

   <script>
       $('#addCardButton').on('click', function(e) {
           // Abre el formulario con las opciones de Culqi.settings
           Culqi.open();
           e.preventDefault();
       });
       // Recibimos el token desde los servidores de Culqi
       function culqi() {

         if(Culqi.token) { // ¡Token creado exitosamente!
           var token = Culqi.token.id;
           console.log('Se ha creado un token: ' + token);

           $.post(serverRoot+ "app/ajax/addCard.php", // Ruta hacia donde enviaremos el token vía POST
           {token: Culqi.token, user_id: <?php echo $session_uid; ?>},
           function(data, status){
             alert(data);

             location.reload();

           });


         }else{ // ¡Hubo algún problema!
           // Mostramos JSON de objeto error en consola
           console.log(Culqi.error);
           alert(Culqi.error.mensaje);
         }

       };
   </script>

<?php
require_once('app/includes/footer.php');
