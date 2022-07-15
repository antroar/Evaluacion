<?php
/* En caso de hacer los procesos en el modelo relacional */
if(isset($_POST["bd"]) && $_POST["bd"] == 'relacional') :
  require ("./assets/class/class.db.php");
  $con = new db();
  $con->dbConect();
  if (isset($_POST["action"])) {
    $opc = $_POST["action"];
  } else {
    $resp = array("flag" => false, "msg" => "Parametros invalidos");
    echo json_encode($resp);
  }
  switch ($opc) {
    case 'create':
      $resp = $con->insertNewItem($_POST["txt_name"], $_POST["txt_description"], $_POST["opt_Path"]);
      echo json_encode($resp);
      break;
    case 'update':
      $resp = $con->updateItem($_POST["id"], $_POST["txt_name"], $_POST["txt_description"], $_POST["opt_Path"]) ;
      echo json_encode($resp);
      break;
    case 'delete':
      $action = $con->deleteItem($_POST["id"]);
      $resp = array("flag" => true, "msg" => "Apartado eliminado del menú.");
      echo json_encode($resp);
      break;
    case 'getData':
      $resp = $con->searchItemData($_POST["id"]);
      echo json_encode($resp);
      break;
    case 'getDataSelectPath':
      $resp = $con->optionSelectPathMenu($_POST["id_Path"], $_POST["id_Item"]);
      echo json_encode($resp);
      break;
    default:
      # code...
      break;
  }

  exit;
endif;
/* En caso de no ser del modelo relacional se continua con el proceso JSON */
require ("./assets/class/class.dataJson.php");
$items = new data('./assets/data.json');
if (isset($_POST["action"])) {
  $opc = $_POST["action"];
} else {
  $resp = array("flag" => false, "msg" => "Parametros invalidos");
  echo json_encode($resp);
}
switch ($opc) {
  case 'create':
    $newData = [
      "nombre" => $_POST["txt_name"],
      "menuPadre" => $_POST["opt_Path"],
      "descripcion" => $_POST["txt_description"],
    ];
    $resp = $items->insertNewItem($newData);
    echo $resp;
    break;
  case 'update':
    $resp = $items->updateItem($_POST["id"], "nombre", $_POST["txt_name"]);
    $items->updateItem($_POST["id"], "descripcion", $_POST["txt_description"]);
    $items->updateItem($_POST["id"], "menuPadre", $_POST["opt_Path"]);
    echo $resp;
    break;
  case 'delete':
    $action = $items->deleteItem($_POST["id"]);
    $resp = array("flag" => true, "msg" => "Apartado eliminado del menú.");
    echo json_encode($resp);
    break;
  case 'getDataSelectPath':
    $resp = $items->getDataSelectPath($_POST["id_Path"], $_POST["id_Item"]);
    echo json_encode($resp);
    break;
  default:
    # code...
    break;
}

?>