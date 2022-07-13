<?php
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
      "menuPadre" => "",
      "descripcion" => $_POST["txt_description"],
    ];
    $resp = $items->insertNewItem($newData);
    echo $resp;
    break;
  case 'update':
    $resp = $items->updateItem($_POST["id"], "nombre", $_POST["txt_name"]);
    $items->updateItem($_POST["id"], "descripcion", $_POST["txt_description"]);
    echo $resp;
    break;
  case 'delete':
    $action = $items->deleteItem($_POST["id"]);
    $resp = array("flag" => true, "msg" => "Apartado eliminado del menú.");
    echo json_encode($resp);
    break;
  
  default:
    # code...
    break;
}

?>