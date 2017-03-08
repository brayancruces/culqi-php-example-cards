<?php
require('config.php');
require('app/sessions.php');

$userCards = $cardClass->cardList($session_uid);

?>
<?php
include_once('app/includes/header.php');
?>
<!-- Contenido -->
<div class="container">

    <div class="row">

        <div class="main">

          <h3>Producto "Polo Culqi Tech"</h3>

          <a href="#" class="thumbnail">
            <img src="http://placehold.it/250x250" alt="Imagen Polo Culqi">
          </a>

          <p>
            Para los Culqi Lovers y amantes de la tecnología, el polo oficial de Culqi.
          </p>

          <p><b>Precio:</b> S/ 35.90</p>

          <form name="paymentForm" action="payment.php" method="POST">

            <div class="form-group">

              <?php if (!empty($userCards)): ?>
              <label for="pwd">Selecciona tarjeta</label>
              <select name="cardList"  class="form-control">
                <?php
                foreach ($userCards as $cards) {
                  echo'<option value="'.$cards->culqi_card_id.'">'.$cards->card_mask.' - '.$cards->card_brand.' </option>';
                }
                ?>
              </select>

            <?php else: ?>
            <div class="alert alert-warning">
              <strong>¡Hey!</strong> Aún no puedes hacer compras porque no has añadido tu Tarjeta de Crédito o Débito. <a href="perfil.php#tab-cards">Añade tu tarjeta</a>.
            </div>
            <?php endif; ?>

            </div>


            <center><input class="btn btn-success" type="submit" value="Pagar ahora" <?php if (empty($userCards)): ?> disabled <?php endif; ?> ></center>

          </form>






        </div>


    </div>

</div>
<!-- /.container -->

<?php
include_once('app/includes/footer.php');
