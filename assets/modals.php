    <?php

    ?>
    <!-- Modal Update / Create Item Menu -->
    <div class="modal fade .modal-lg" data-backdrop="static" id="configMenu" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title" id="titleModalSetupMenu"></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="container-fluid">
              <form action="" method="POST" id="formMenuItem">
                <input type="hidden" name="action" id="action" value=""/>
                <input type="hidden" name="id" id="id" value=""/>
                <div class="form-group row">
                  <label for="txt_name" class="col col-form-label">Nombre:</label>
                  <div class="col col-8">
                    <input type="text" class="form-control form-control-sm" id="txt_name" name="txt_name" placeholder="Nombre del nuevo apartado del menú">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="txt_description" class="col col-form-label">Descripción: </label>
                  <div class="col col-8">
                    <input type="text" class="form-control form-control-sm" id="txt_description" name="txt_description" placeholder="Agregue una descripción del apartado del menú">
                  </div>
                </div>
              </form>
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" onclick="ajaxForm('formMenuItem', '', 'actionMenu.php')"><i class="fa fa-thumbs-up"></i> Guardar</button>
          </div>
        </div>
      </div>
    </div>   