var url_insert  = "pedidos/register";
var url_update   = "pedidos/update";
var url_edit     = "pedidos/edit";
var url_destroy  = "pedidos/destroy";
var url_all      = "pedidos/all";
var redireccion  = "configuracion/pedidos";
var url_edit_clientes  = "clientes/edit";
var url_edit_contactos  = "contactos/edit";
var url_edit_productos  = "productos/edit";
var url_edit_planes     = "planes/edit";

new Vue({
  el: "#vue-pedidos",
  created: function () {
    this.consulta_general();
  },
  data: {
    datos: [],
    insert: {},
    update: {},
    edit: {},
    fields: {},

  },
  mixins : [mixins],
  methods:{
    consulta_general(){
        var url = domain( url_all );
        var fields = {};
        var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
          
              
          }).catch( error => {
              if( isset(error.response) && error.response.status == 419 ){
                toastr.error( session_expired ); 
                redirect(domain("/"));
                return;
              }
                toastr.error( error.result , expired );  
          });
    }
    ,insert_register(){
        var url = domain( url_insert );
        var fields = {};
        var promise = MasterController.method_master(url,fields,"post");
          promise.then( response => {
          
              toastr.success( response.data.message , title );
              
          }).catch( error => {
              if( isset(error.response) && error.response.status == 419 ){
                toastr.error( session_expired ); 
                redirect(domain("/"));
                return;
              }
                toastr.error( error.result , expired );  
          });
    }
    ,update_register(){
        var url = domain( url_update );
        var fields = {};
        var promise = MasterController.method_master(url,fields,"put");
          promise.then( response => {
          
              toastr.success( response.data.message , title );
              
          }).catch( error => {
              if( isset(error.response) && error.response.status == 419 ){
                toastr.error( session_expired ); 
                redirect(domain("/"));
                return;
              }
                toastr.error( error.result , expired );  
          });
    }
    ,edit_register( id ){
        var url = domain( url_edit );
        var fields = {id : id };
        var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
          
              toastr.success( response.data.message , title );
              
          }).catch( error => {
              if( isset(error.response) && error.response.status == 419 ){
                toastr.error( session_expired ); 
                redirect(domain("/"));
                return;
              }
                toastr.error( error.result , expired );  
          });
        
    }
    ,destroy_register( id ){
        var url = domain( url_destroy );
        var fields = {id : id };
         buildSweetAlertOptions("¿Borrar Registro?","¿Realmente desea eliminar el registro?",function(){
          var promise = MasterController.method_master(url,fields,"delete");
          promise.then( response => {
              toastr.success( response.data.message , title );
          }).catch( error => {
              if( isset(error.response) && error.response.status == 419 ){
                toastr.error( session_expired ); 
                redirect(domain("/"));
                return;
              }
                toastr.error( error.result , expired );  
          });
      },"warning",true,["SI","NO"]);   
    }
    
    
  }


});


function display_contactos(){
    
    var url = domain( url_edit_clientes );
    var fields = {id_cliente : jQuery('#cmb_clientes').val() };
    jQuery('#correo_contacto').val('');
    jQuery('#telefono_contacto').val('');
    var promise = MasterController.method_master(url,fields,"get");
      promise.then( response => {
          console.log(response.data.result);
          jQuery('#rfc_receptor').val(response.data.result.rfc_receptor);
          jQuery('#nombre_comercial').val(response.data.result.nombre_comercial);
          jQuery('#telefono_cliente').val(response.data.result.telefono);
          var contactos = {
             'data'    : response.data.result.contactos
             ,'text'   : "nombre_completo"
             ,'value'  : "id"
             ,'name'   : 'cmb_contactos'
             ,'class'  : 'form-control input-sm'
             ,'leyenda': 'Seleccione Opcion'
             ,'event'  : 'change_contactos()'
            ,'attr'    : 'data-live-search="true"'     
         };
          
         jQuery('#div_contacto').html('');
         jQuery('#div_contacto').html( select_general(contactos) );
         jQuery('#cmb_contactos').selectpicker();
          //toastr.success( response.data.message , title );
      }).catch( error => {
          if( isset(error.response) && error.response.status == 419 ){
                toastr.error( session_expired ); 
                redirect(domain("/"));
                return;
              }
            toastr.error( error.result , expired );  
      });

    
}

function change_contactos(){
    
    var url = domain( url_edit_contactos );
    var fields = {id : jQuery('#cmb_contactos').val() };
    var promise = MasterController.method_master(url,fields,"get");
      promise.then( response => {
          console.log(response.data.result);
          jQuery('#correo_contacto').val(response.data.result.correo);
          jQuery('#telefono_contacto').val(response.data.result.telefono);
      }).catch( error => {
          if( isset(error.response) && error.response.status == 419 ){
                toastr.error( session_expired ); 
                redirect(domain("/"));
                return;
              }
            toastr.error( error.result , expired );  
      });
    
}

function display_productos(){
    var url = domain( url_edit_productos );
    var fields = {id : jQuery('#cmb_productos').val() };
    jQuery('#cmb_planes').selectpicker('val',[0]);
    jQuery('#cantidad_concepto').val(0);
    jQuery('#total_concepto').val(0);
    var promise = MasterController.method_master(url,fields,"get");
      promise.then( response => {
          console.log(response.data.result);
          jQuery('#precio_concepto').val(response.data.result.total);
          jQuery('#descripcion').val(response.data.result.descripcion);
      }).catch( error => {
          if( isset(error.response) && error.response.status == 419 ){
                toastr.error( session_expired ); 
                redirect(domain("/"));
                return;
              }
            toastr.error( error.result , expired );  
      });
}

function display_planes(){
    var url = domain( url_edit_planes );
    var fields = {id : jQuery('#cmb_planes').val() };
    jQuery('#cmb_productos').selectpicker('val',[0]);
    jQuery('#cantidad_concepto').val(0);
    jQuery('#total_concepto').val(0);
    var promise = MasterController.method_master(url,fields,"get");
      promise.then( response => {
          console.log(response.data.result);
          jQuery('#precio_concepto').val(response.data.result.total);
          jQuery('#descripcion').val(response.data.result.descripcion);
      }).catch( error => {
          if( isset(error.response) && error.response.status == 419 ){
                toastr.error( session_expired ); 
                redirect(domain("/"));
                return;
              }
            toastr.error( error.result , expired );  
      });
}

function calcular_suma(){
    var precio = (jQuery('#precio_concepto').val() != "") ? jQuery('#precio_concepto').val(): 0;
    var cantidad = (jQuery('#cantidad_concepto').val() != "") ? jQuery('#cantidad_concepto').val(): 0;
    var total  = parseFloat(precio * cantidad);
    jQuery('#total_concepto').val(total.toFixed(2));
}

jQuery('.add').fancybox();
jQuery('#cmb_estatus').selectpicker();
jQuery('#cmb_clientes').selectpicker();
jQuery('#cmb_estatus_form').selectpicker();
jQuery('#cmb_monedas').selectpicker();
jQuery('#cmb_formas_pagos').selectpicker();
jQuery('#cmb_metodos_pagos').selectpicker();
jQuery('#cmb_productos').selectpicker();
jQuery('#cmb_productos_edit').selectpicker();
jQuery('#cmb_planes').selectpicker();
jQuery('#cmb_planes_edit').selectpicker();




