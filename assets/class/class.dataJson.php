<?php
class data {
  private $json_file;
  private $stored_data;
  private $numberData;
  private $ids = [];
  private $itemNames = [];
  private $itemsMenu = [];

  public function __construct($file_path) {
    $this->json_file = $file_path;
    $this->stored_data = json_decode(file_get_contents($this->json_file), true);
    $this->numberData = count($this->stored_data);
    if ($this->numberData != 0) :
      $i = 0;
      foreach ($this->stored_data as $key) {
        array_push($this->ids, $key['id']);
        array_push($this->itemNames, $key['nombre']);
        $this->itemsMenu[$i]['id'] = $key['id'];
        $this->itemsMenu[$i]['name'] = $key['nombre'];
        $this->itemsMenu[$i]['pathMenu'] = $key['menuPadre'];
        $this->itemsMenu[$i]['description'] = $key['descripcion'];
        $i++;
      }
    endif;
  }

  private function setId($item) {
    $item['id'] = ($this->numberData == 0) ? 1 : max($this->ids)+1;
    return $item;
  }
  
  private function storeData() {
    file_put_contents(
      $this->json_file, json_encode($this->stored_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX
    );
  }

  private function searchJsonPath ($nombre) {
    $resultado = false;
    foreach ($this->itemsMenu as $key => $value) {
      if ($value["pathMenu"] == $nombre) :
        $resultado = true;
      endif;
    }
    return $resultado;
  }
  private function getSubMenu($pathName) {
    $salida = '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
    foreach ($this->itemsMenu as $key => $value) {
      if ($value["pathMenu"] == $pathName) :
        $salida .= '<a class="dropdown-item" href="javascript:setupGear(\''.$value["description"].'\');">'.$value["name"].'</a>';
      endif;
    }
    $salida .= '</div>';
    return $salida;
  }

  public function paintMenu () {
    $data = $this->itemsMenu;
    $itemMain = '';
    foreach ($data as $key => $value) {
      $itemMain .= '<li class="nav-item" id="item'.$value["id"].'" onclick="itemActive(\'item'.$value["id"].'\')">';
      if (trim($value["pathMenu"]) == '' ) :
        $search = $this->searchJsonPath($value["name"]);
        $opc1 = '<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="javascript:setupGear(\''.$value["description"].'\');"">'.$value["name"].'</a>';
        $opc2 = '<a class="nav-link" href="javascript:setupGear(\''.$value["description"].'\');"">'.$value["name"].'</a>';
        $itemMain .= ($search) ? $opc1 : $opc2;
        // Obtenemos submenus en caso de haber encontrado.
        $itemMain .= ($search) ? $this->getSubMenu($value["name"]) : '';
      endif;
      $itemMain .= '</li>';
    }
    $salida =$itemMain;
    return $salida;
  }
  public function paintTableMenuSetup () {
    $data = $this->itemsMenu;
    $tableData = '';
    foreach ($data as $key => $value) {
      $tableData .= '<tr>';
      $tableData .= '<td>'.$value["id"].'</td>';
      $tableData .= '<td>'.$value["name"].'</td>';
      $tableData .= '<td>'.$value["pathMenu"].'</td>';
      $tableData .= '<td>'.$value["description"].'</td>';
      $btnEdit = '<button type="button" class="btn btn-primary btn-sm btnEditItem" value="'.$value["id"].'" name="'.$value["name"].'"><i class="fa fa-edit"></i> Editar</button>';
      $btnDelete = '<button type="button" class="btn btn-primary btn-sm btnDeleteItem" value="'.$value["id"].'" name="'.$value["name"].'"><i class="fa fa-trash-o"></i> Borrar</button>';
      $tableData .= '<td>'.$btnEdit.' '.$btnDelete.'</td>';
      $tableData .= '</tr>';
    }
    return $tableData;
  }

  public function insertNewItem($item) {
    $itemField = $this->setId($item);
    $updateCheck = false;
    $msg = "Dato no insertado.";
    array_push($this->stored_data, $itemField);    
    if (!in_array($item['nombre'], $this->itemNames)) :
      $this->storeData();
      $updateCheck = true;
      $msg = "Apartado insertado al menú correctamente";
    endif;

    $resp = array("flag" => $updateCheck, "msg" => $msg);
    return json_encode($resp);    
  }  
  public function updateItem($id, $field, $value) {
    $updateCheck = false;
    $msg = "Dato no encontrado.";
    foreach($this->stored_data as $key => $store_item) {
      if ($store_item['id'] == $id) :
        $this->stored_data[$key][$field] = $value;
        $updateCheck = true;
        $msg = "Dato actualizado.";
      endif;      
    }
    $this->storeData();
    $resp = array("flag" => $updateCheck, "msg" => $msg);
    return json_encode($resp);
  }
  public function deleteItem($id) {
    foreach ($this->stored_data as $key => $value) {
      if ($value['id'] == $id) :
        unset($this->stored_data[$key]);
      endif;
    }
    $this->storeData();
  }
}
?>