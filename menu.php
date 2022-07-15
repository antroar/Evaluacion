    
<?php
$viewCondition = 'onclick="itemActive(\'itemSetup\')"';
$salida2 = '';
if(isset($_GET["modelBD"]) && $_GET["modelBD"] == "noRelacional") {
  require ("./assets/class/class.dataJson.php");
  $items = new data('./assets/data.json');  
  $data = $items->paintMenu();
  $configMenu = '<a class="nav-link" href="javascript:openWind(\'setupMenu.php\', \'contenido\');">Configurar menú</a>';
} else {
  require ("./assets/class/class.db.php");
  $con = new db();
  $validate = $con->dbConect();
  echo $validate['msg'];
  
  if ($validate['flag']) {    
    $configMenu = '<a class="nav-link" href="javascript:openWind(\'setupMenuBD.php\', \'contenido\');">Configurar menú</a>';
    $data = $con->searchItemMenu();
  }  else {
    $data = '';
    $salida2 = '<input type="hidden" id="estatusBD" name="estatusBD" value="error"/>';
    $salida2 .= '<script>';
    $salida2 .= 'console.log("'.$validate["codeError"].'")';
    $salida2 .= '</script>';
    $configMenu = '<a class="nav-link" href="javascript:setupGear(\'Utiliza el método 2 JSON ó cargue la BD configurando las credenciales en el archivo menu.php\');" style="cursor:not-allowed;">Configurar menú</a>';
    $viewCondition = '';
  }
  
}
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
            $salida .= '<li class="nav-item" id="itemSetup" '.$viewCondition.'>';
              $salida .= $configMenu;
            $salida .= '</li>';
          $salida .= '</ul>';
        $salida .= '</div>';
      $salida .= '</nav>';
    $salida .= '</div>';
  $salida .= '</div> <!-- End Div Menu -->';
  $salida .= $salida2;
  echo $salida;

?>