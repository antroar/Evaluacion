<?php
require ("./assets/class/class.dataJson.php");
$items = new data('./assets/data.json');
$tableData = $items->paintTableMenuSetup();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" charset="UTF-8" />
  <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' />
  <title>Setup Menú</title>  
  <script>
    $(document).ready(function() {  
      $(".btnEditItem").click(function() {
        titleModal("titleModalSetupMenu", "Editar item.");
        var idItem = $(this).val();
        var name = $(this).attr("name");
        $("#id").val(idItem);
        const xhttp = new XMLHttpRequest();
        xhttp.open('GET', './assets/data.json', true);
        xhttp.send();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var datos = JSON.parse(this.responseText);
            var nameItem = datos[idItem]['nombre'];
            var descriptionItem = datos[idItem]['descripcion'];
            $("#txt_name").val(nameItem);
            $("#txt_description").val(descriptionItem);
          }
        }
        $("#action").val("update");
        $('#configMenu').modal('show');
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
              data: {action:"delete",id:idItem},
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
                if ($("#modelBD").val() == 'relacional') {
                  openWind("./menu.php?modelBD=relacional","menu");
                } else {
                  openWind("./menu.php?modelBD=noRelacional","menu");
                }
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
