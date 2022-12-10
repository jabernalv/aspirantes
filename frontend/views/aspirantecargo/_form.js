var urlopciones='$urlopciones',urlarchivosaspirante='$urlarchivosaspirante',cargosgrid=$('#cargos-grid'),actualizando=$actualizando,cargo_id=$cargo_id,opcion_cargo_id=$opcion_cargo_id;
function requierePin(attribute, value){
  return ($("#requiere_pin-role").val() == 1 && $("#aspirantecargo-pin_proceso_uuid").val() == "") ? false : true;
};
cargosgrid.on('grid.radiochecked', function(ev, key, val){
  cargaOpciones(key);
});
$(document).ready(function(){
  cargaSoportes();
  $(":radio[name=radio-cargo][value="+cargo_id+"]").attr('checked',true);
  if(actualizando==1){
    cargaOpciones(cargo_id);
  }
});
function cargaSoportes(){
  $.ajax({
    url: urlarchivosaspirante,
    type: "get",
    cache: false,
    async: true,
    success: function (response) {
      $(".archivo_aspirante-index").html(response);
    }
  }).done(function(){
    var archivosaspiranteseleccionadosprevios = $("#aspirantecargo-archivo_aspirantes_seleccionados").val().split(",");
    for (var i=0;i<archivosaspiranteseleccionadosprevios.length;i++){ $(":checkbox[value='" + archivosaspiranteseleccionadosprevios[i] + "']").prop("checked","true"); };
  }).fail(function(){}).always(function(){});
}
function cargaOpciones(key){
  $("#aspirantecargo-cargo_id").val( key );
  $("#aspirantecargo-opcion_cargo_id").val( "" );
  $.ajax({
    url: urlopciones + key,
    type: "get",
    cache: false,
    async: true,
    success: function (response) {
      $(".opciones-index").html(response);
    }
  }).done(function(){
    if(actualizando==1){
      $(":radio[name=radio-opcion][value="+opcion_cargo_id+"]").attr('checked',true);
      $("#aspirantecargo-opcion_cargo_id").val(opcion_cargo_id);
      actualizando=0;
    }
  }).fail(function(){}).always(function(){});
}
$('#modaldialog').on('hidden.bs.modal', function (e) {
  cargaSoportes();
});