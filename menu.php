    
<?php
if(isset($_GET["modelBD"]) && $_GET["modelBD"] == "noRelacional") {
  require ("./assets/class/class.dataJson.php");
  $items = new data('./assets/data.json');  
  $data = $items->paintMenu();


  $salida = '<!-- Div Menu -->';
  $salida .= '<div class="row row-cols-1 align-items-start">';
    $salida .= '<div class="col align-self-center">';
      $salida .= '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">';
        $salida .= '<a class="navbar-brand" >MENÚ</a>';
        $salida .= '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">';
          $salida .= '<span class="navbar-toggler-icon"></span>';
        $salida .= '</button>';
        $salida .= '<div class="collapse navbar-collapse" id="navbarNav">';
          $salida .= '<ul class="navbar-nav">';
            $salida .= $data;
            $salida .= '<div class="dropdown-divider"></div>';
            $salida .= '<li class="nav-item" id="itemSetup" onclick="itemActive(\'itemSetup\')">';
              $salida .= '<a class="nav-link" href="javascript:openWind(\'setupMenu.php\', \'contenido\');">Configurar menú</a>';
            $salida .= '</li>';

          $salida .= '</ul>';
        $salida .= '</div>';
      $salida .= '</nav>';
    $salida .= '</div>';
  $salida .= '</div> <!-- End Div Menu -->';
  echo $salida;

} else {
?>
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
                <a class="dropdown-item" href="javascript:setupGear();">-</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="javascript:openWind('setupMenu.php', 'contenido');">Configurar menú</a>
              </div>
            </li>
            <li class="nav-item" >
              <a class="nav-link" href="javascript:setupGear();">-</a>
            </li>              
          </ul>
        </div>
      </nav>
    </div>
  </div> <!-- End Div Menu -->  
<?php } ?>