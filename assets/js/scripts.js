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
      $('#configMenu').modal('hide');
    },
    complete : function() {
      setTimeout(() => {
        openWind("setupMenu.php", "contenido");
      }, 3000);
    }
  });
}
$(document).ready(function() {
  $(document).on('click', '#btnNewItem',  function(){
    titleModal("titleModalSetupMenu", "Registrar nuevo item al menú.");
    $("#action").val("create");
    $("#txt_name").val("");
    $("#txt_description").val("");
    $('#configMenu').modal('show');
  });
});