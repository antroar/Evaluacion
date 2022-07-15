<?php
require ("./assets/class/class.db.php");
$con = new db();
$con->dbConect();
$tableData = $con->paintTableMenuSetup();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" charset="UTF-8" />
  <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' />
  <title>Setup Menú</title>  
  <script>
    $(document).ready(function() {  
      var id_pathItem;
      $(".btnEditItem").click(function() {
        titleModal("titleModalSetupMenu", "Editar item.");
        var idItem = $(this).val();
        var idPath = $(this).attr("sub");
        var name = $(this).attr("name");
        $("#id").val(idItem);
        $("#action").val("update");
        $("#bd").val("relacional");
        /* Pintaremos el select obteniendo los items padre */  
        ajaxSelectPathBD(idPath,idItem);
        $.ajax({
          url : "actionMenu.php",
          type : 'POST', 
          dataType : 'JSON',
          data: {action:"getData",id:idItem,bd:"relacional"},
          beforeSend : function() {},
          success : function(res) {
            if(res.flag){
              $("#txt_name").val(res.nameItem);
              $("#txt_description").val(res.descriptionItem);
              id_pathItem = res.id_pathItem;
            }else{
              Swal.fire(res.msg, '', 'error')
            }
          },
          complete : function() {
            $('#configMenu').modal('show');
          }
        });
      });

      $(".btnDeleteItem").click(function() {
        var idItem = $(this).val();
        var name = $(this).attr("name");
        
        Swal.fire({
          title: 'Desea borrar el apartado \"'+name+'\"?',
          showDenyButton: true,
          confirmButtonText: 'Confirmar',
          denyButtonText: `Cancelar`,
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            $.ajax({
              url : "actionMenu.php",
              type : 'POST', 
              dataType : 'JSON',
              data: {action:"delete",id:idItem,bd:"relacional"},
              beforeSend : function() {
              },
              success : function(res) {
                if(res.flag){
                  Swal.fire(res.msg, '', 'success')
                }else{
                  Swal.fire(res.msg, '', 'error')
                }
              },
              complete : function() {
                openWind("./menu.php?modelBD=relacional","menu");
                openWind('setupMenuBD.php', 'contenido');
              }
            });            
          } else if (result.isDenied) {
            Swal.fire('Se cancelo la eliminación', '', 'info')
          }
        })
      });
    });
  </script>
</head>
<body>
  <div class="row row-cols-1 mh-100 align-items-end" style="min-height: 50px;">
    <div class="col text-right">
      <button type="button" class="btn btn-outline-primary btn-sm" id="btnNewItem">
        <i class="fa fa-cloud-upload"></i> Nuevo
      </button>
    </div>
  </div>
  <table id="tableMenu" class="table">
    <thead class="thead-dark">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Nombre</th>
        <th scope="col">Menú Padre</th>
        <th scope="col">Descripción</th>
        <th scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody>
      <tr><?=$tableData?></tr>
    </tbody>
  </table>
  <?php include ("./assets/modals.php") ?>
</body>
</html>
