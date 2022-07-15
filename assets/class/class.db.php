<?php  
class db {
  private $servername;
  private $username;
  private $password;
  private $dbConect;

  public function __construct() {
    $this->servername = 'localhost';
    $this->username = 'root';
    $this->password = '450420';
  }
  public function dbConect() {
    try {
      $this->dbConect = new PDO("mysql:host=$this->servername;dbname=db_s2Next", $this->username, $this->password);
      // set the PDO error mode to exception
      $this->dbConect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->dbConect->exec("SET CHARACTER SET utf8");
      $msg = "Conectado.";
      $codeError = "";
      $flag = true;
    } catch(PDOException $e) {
      $msg = "No Conectado";
      $codeError = "Connection failed: " . $e->getMessage();
      $flag = false;
    }
    $resp = array("flag" => $flag, "msg" => $msg, "codeError" => $codeError);
    return $resp;
  }
  public function searchItemMenu(){
    $qry = "SELECT t1.*, t2.id_Padre as subMenu FROM db_s2next.cat_menuitem t1
      LEFT JOIN db_s2next.cat_menuitem t2 on t2.id_Padre = t1.id_ItemMenu
      WHERE t1.i_Status = 1 and isnull(t1.id_Padre) 
      GROUP by t1.id_ItemMenu;
    ";
    $eje = $this->dbConect->prepare($qry);
    $eje->execute();
    $salida = '';
    while($registro = $eje->fetch(PDO::FETCH_ASSOC)) {
      $salida .= '<li class="nav-item dropdown" id="item'.$registro["id_ItemMenu"].'" onclick="itemActive(\'item'.$registro["id_ItemMenu"].'\')">';
      $opc1 = '<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="javascript:setupGear(\''.$registro["st_Desc"].'\');"">'.$registro["st_Nombre"].'</a>';
      $opc2 = '<a class="nav-link" href="javascript:setupGear(\''.$registro["st_Desc"].'\');"">'.$registro["st_Nombre"].'</a>';
      if ($registro["subMenu"] > 0) {
        $salida .= $opc1;
        $salida .=  $this->getSubMenu($registro["subMenu"]);
      } else {
        $salida .= $opc2;
      }
      $salida .= '</li>';      
    }
    $eje->closeCursor();
    $this->dbConect = null;
    return $salida;
  }
  private function getSubMenu($itemPath) {
    $qry = "SELECT * FROM db_s2next.cat_menuitem WHERE id_Padre = '".$itemPath."';";
    $eje = $this->dbConect->prepare($qry);
    $eje->execute();
    $salida = '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
    while($registro = $eje->fetch(PDO::FETCH_ASSOC)) {
      $salida .= '<a class="dropdown-item" href="javascript:setupGear(\''.$registro["st_Desc"].'\');">'.$registro["st_Nombre"].'</a>';
    }
    $salida .= '</div>';
    return $salida;
    $eje->closeCursor();
  }
  public function paintTableMenuSetup() {
    $qry = "SELECT t1.*, (SELECT st_Nombre FROM db_s2next.cat_menuitem WHERE id_ItemMenu = t1.id_Padre) as subMenu
      FROM db_s2next.cat_menuitem t1
      WHERE t1.i_Status = 1 
    ";
    $eje = $this->dbConect->prepare($qry);
    $eje->execute();
    $salida = '';
    while($registro = $eje->fetch(PDO::FETCH_ASSOC)) {
      $salida .= '<tr>';
      $salida .= '<td>'.$registro["id_ItemMenu"].'</td>';
      $salida .= '<td>'.$registro["st_Nombre"].'</td>';
      $salida .= '<td>'.$registro["subMenu"].'</td>';
      $salida .= '<td>'.$registro["st_Desc"].'</td>';
      $btnEdit = '<button type="button" class="btn btn-primary btn-sm btnEditItem" value="'.$registro["id_ItemMenu"].'" name="'.$registro["st_Nombre"].'" sub="'.$registro["id_Padre"].'"><i class="fa fa-edit"></i> Editar</button>';
      $btnDelete = '<button type="button" class="btn btn-primary btn-sm btnDeleteItem" value="'.$registro["id_ItemMenu"].'" name="'.$registro["st_Nombre"].'"><i class="fa fa-trash-o"></i> Borrar</button>';
      $salida .= '<td>'.$btnEdit.' '.$btnDelete.'</td>';
      $salida .= '</tr>';
    }
    return $salida;
    $eje->closeCursor();
    $this->dbConect = null;
  }
  public function deleteItem($id) {
    $qry = "UPDATE db_s2next.cat_menuitem set i_status = 2 WHERE id_ItemMenu = ".$id.";";
    $eje = $this->dbConect->prepare($qry);
    $eje->execute();
    $eje->closeCursor();
    $this->dbConect = null;
  }
  public function searchItemData($id) {
    $qry = "SELECT * FROM db_s2next.cat_menuitem WHERE id_ItemMenu = '".$id."';";
    $eje = $this->dbConect->prepare($qry);
    $eje->execute();
    while($registro = $eje->fetch(PDO::FETCH_ASSOC)) {
      $nameItem = $registro["st_Nombre"];
      $descriptionItem = $registro["st_Desc"];
      $id_pathItem = $registro["id_Padre"];
    }
    $resp = array("flag" => true, "nameItem" => $nameItem, "descriptionItem" => $descriptionItem, "id_pathItem" => $id_pathItem);
    return $resp;
  }
  public function updateItem($id, $txt_name, $txt_description, $opt_Path) {
    $qry = "UPDATE db_s2next.cat_menuitem SET st_Nombre = '".$txt_name."', st_Desc = '".$txt_description."', id_Padre = '".$opt_Path."' WHERE id_ItemMenu = '".$id."';";
    $eje = $this->dbConect->prepare($qry);
    $eje->execute();
    $resp = array("flag" => true, "msg" => "Dato actualizado.");
    return $resp;
  }
  public function insertNewItem($txt_name, $txt_description, $opt_Path) {
    $qry = "INSERT INTO db_s2next.cat_menuitem (st_Nombre, st_Desc, id_Padre) VALUES ('".$txt_name."', '".$txt_description."', '".$opt_Path."');";
    $eje = $this->dbConect->prepare($qry);
    $eje->execute();
    $resp = array("flag" => true, "msg" => "Apartado insertado al menú correctamente.");
    return $resp;
  }
  public function optionSelectPathMenu($idPath, $id){
    $qry = "SELECT * FROM db_s2next.cat_menuitem WHERE isnull(id_Padre) AND id_ItemMenu != ".$id;
    $eje = $this->dbConect->prepare($qry);
    $eje->execute();
    $salida = '<option value="">Ninguno</option>';
    while($registro = $eje->fetch(PDO::FETCH_ASSOC)) {
      $optionSelected = ($idPath == $registro["id_ItemMenu"]) ? "selected" : "";
      $salida .= '<option value="'.$registro["id_ItemMenu"].'" '.$optionSelected.'>'.$registro["st_Nombre"].'</option>';
    }
    $resp = array("flag" => true, "html" => $salida);
    return $resp;
  }
}
?>