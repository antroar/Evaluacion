<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" charset="UTF-8" />
  <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' />
  <title>Practica Técnica</title>

  <?php require ("./assets/headLibs.php"); ?>
</head>
<body>
  <!-- Cuerpo de la página -->
  <div class="container">
    <form action="" method="POST">
      <input type="hidden" id="modelBD" name="modelBD" value="relacional"/>
      <input type="hidden" id="activeElement" name="activeElement" value=""/>
      <!-- Importamos menu -->
      <div id="menu">
        <?php require_once ("./menu.php"); ?>
      </div>
      <!-- Importamos la configuración de la base de datos -->
      <?php require_once ("./setupBD.php"); ?>
    </form>

    <!-- Div Contenido -->
    <div class="row row-cols-1 mh-100">
      <div class="col text-center" id="contenido"></div>
    </div> <!-- End Div Contenido -->
  </div> <!-- End Container -->  
</body>
</html>