function openWind(url, elemento) {
  $("#"+elemento).load(url);
}
function changeDB(validate) {
  $("#modelBD").val(validate);
  if (validate == 'relacional'){
    $("#optionBDMysql").addClass("active");
    $("#optionJson").removeClass("active");
    openWind("./menu.php?modelBD=relacional","menu");
    $("#contenido").html('');
  } else {
    $("#optionJson").addClass("active");
    $("#optionBDMysql").removeClass("active");
    openWind("./menu.php?modelBD=noRelacional","menu");
    $("#contenido").html('');
  }
}
function setupGear(description) {
  $("#contenido").html(description);
}
function itemActive(elemento) {
  previousElement = $("#activeElement").val();
  $("#activeElement").val(elemento);
  if (previousElement != '') {
    $("#"+previousElement).removeClass("active");
  } 
  $("#"+elemento).addClass("active");
}
function titleModal(elemento, title) {
  $("#"+elemento).html(title);
}
function ajaxSelectPathBD(idPath, idItem) {
  $.ajax({
    url : "actionMenu.php",
    type : 'POST', 
    data: {action:"getDataSelectPath",bd:"relacional", id_Path:idPath, id_Item:idItem},
    dataType : 'JSON',
    beforeSend : function() {},
    success : function(res) {
      $("#opt_Path").html(res.html);
    },
    complete : function() {}
  });
}
function ajaxSelectPath(idPath, idItem) {
  $.ajax({
    url : "actionMenu.php",
    type : 'POST', 
    data: {action:"getDataSelectPath", id_Path:idPath, id_Item:idItem},
    dataType : 'JSON',
    beforeSend : function() {},
    success : function(res) {
      $("#opt_Path").html(res.html);
    },
    complete : function() {}
  });
}
function ajaxForm(formElement, contentElement, link) {
  var formData = $("#"+formElement).serialize();
  $.ajax({
    url : link,
    type : 'POST', 
    data: formData,
    dataType : 'JSON',
    beforeSend : function() {},
    success : function(res) {
      (res.flag) ? Swal.fire(res.msg, '', 'success') : Swal.fire(res.msg, '', 'error');
      if ($("#modelBD").val() == 'relacional') {
        openWind("./menu.php?modelBD=relacional","menu");
      } else {
        openWind("./menu.php?modelBD=noRelacional","menu");
      }
    },
    complete : function() {
      $('#configMenu').modal('hide');
      if ($("#modelBD").val() == 'relacional') {
        setTimeout(() => {
          openWind("setupMenuBD.php", "contenido");
        }, 500);
      } else {
        setTimeout(() => {
          openWind("setupMenu.php", "contenido");
        }, 500);
      }
    }
  });
}
$(document).ready(function() {
  $(document).on('click', '#btnNewItem',  function(){
    titleModal("titleModalSetupMenu", "Registrar nuevo item al menú.");
    var modelo = $("#modelBD").val();
    $("#action").val("create");
    $("#bd").val(modelo);
    $("#txt_name").val("");
    $("#txt_description").val("");
    if ($("#modelBD").val() == 'relacional') {
      ajaxSelectPathBD('',0);
    } else {
      ajaxSelectPath('','');
    }
    $('#configMenu').modal('show');
  });
});