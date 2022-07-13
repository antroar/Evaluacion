<?php
require ("./assets/class/class.dataJson.php");
$new_item = [
  "id" => 1,
  "nombre" => "test",
  "menuPadre" => "",
  "descripcion" => "des test1"
];
$items = new data('./assets/data.json');
// $items->insertNewItem($new_item);
// $items->updateItem(2, 'descripcion', 'test de update');
//$data = $items->readJson();

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" charset="UTF-8" />
  <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' />
  <title>Practica Técnica por metodo Json</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css" /> -->
  <link rel="stylesheet" href="./assets/css/style.css">


  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script>

  <script>
    function setupMenu(url) {
      $("#contenido").load(url);
    }
    function readJson() {
      const fs = require('fs');
      let data = fs.readFileSync('./assets/data.json');
      let itemMenu = JSON.parse(data);
      console.log(typeof (itemMenu))
    }
    function setupGear() {
      console.log("test");
      $("#contenido").html("test");
    }
    $(document).ready(function() {

    });
  </script>

</head>

<body>
  <!-- Cuerpo de la página -->
  <div class="container">

    <!-- Div Menu -->
    <div class="row row-cols-1 align-items-start">
      <div class="col align-self-center">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
          <a class="navbar-brand" >MENÚ</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item active">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Catálogo</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <!-- Insertamos menu desde class json -->
                  <a class="dropdown-item" href="javascript:setupGear();">-</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="javascript:open('setupMenu.php');">Configurar menú</a>
                </div>
              </li>
              <li class="nav-item">
                <!-- Insertamos menu desde class json -->
                <a class="nav-link" href="javascript:setupGear();">-</a>
              </li>              
            </ul>
          </div>
        </nav>
      </div>
    </div> <!-- End Div Menu -->

    <!-- Div Config Database -->
    <div class="fixed-plugin">
      <div class="dropdown">
        <!-- Icon Config Data Conection -->
        <a href="#" data-toggle="dropdown"><i class="fa fa-cog fa-2x"> </i></a>
        <!-- List Menu -->
        <div class="dropdown-menu">
          <p class="header-title">Modelo de BD</p>
          <a class="dropdown-item" href="index.php">BD MySQL</a>
          <a class="dropdown-item active">JSON</a>
        </div>
      </div>
    </div> <!-- End Config Menu Data Base -->
    <br>
    <!-- Div Contenido -->
    <div class="row row-cols-1 min-vh-80">
      <div class="col text-center" id="contenido"></div>
    </div> <!-- End Div Contenido -->

  </div> <!-- End Container -->

  <!-- data-toggle="modal" data-target="#copnfigMenu" -->
  <!-- The Modal -->
  <div class="modal" id="copnfigMenu">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Configuración del menú</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>
</body>

</html>