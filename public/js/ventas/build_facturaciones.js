var url_insert  = "facturaciones/register";
var url_update   = "facturaciones/update";
var url_edit     = "facturaciones/edit";
var url_destroy  = "facturaciones/destroy";
var url_all      = "facturaciones/all";
var redireccion  = "ventas/facturaciones";

new Vue({
  el: "#vue-facturaciones",
  created: function () {
    this.consulta_general();
  },
  data: {
    datos: [],
    insert: {},
    update: {},
    edit: {},
    fields: {},
    conceptos: {},
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
                toastr.error( error.result  , expired );
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
                toastr.error( error.result  , expired );
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
                toastr.error( error.result  , expired );           
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
                toastr.error( error.result  , expired );
          });
      },"warning",true,["SI","NO"]);   
    }
    
    
  }


});

jQuery(".add").fancybox({ modal: true });
jQuery('#cmb_estatus').selectpicker();
jQuery('#cmb_clientes').selectpicker();
jQuery('#cmb_clientes_edit').selectpicker();
jQuery('#cmb_estatus_form').selectpicker();
jQuery('#cmb_estatus_form_edit').selectpicker();
jQuery('#cmb_monedas').selectpicker();
jQuery('#cmb_monedas_edit').selectpicker();
jQuery('#cmb_formas_pagos').selectpicker();
jQuery('#cmb_formas_pagos_edit').selectpicker();
jQuery('#cmb_metodos_pagos').selectpicker();
jQuery('#cmb_metodos_pagos_edit').selectpicker();
jQuery('#cmb_productos').selectpicker();
jQuery('#cmb_productos_edit').selectpicker();
jQuery('#cmb_planes').selectpicker();
jQuery('#cmb_planes_edit').selectpicker();
jQuery('.fecha').datepicker( {format: 'yyyy-mm-dd' ,autoclose: true ,firstDay: 1}).datepicker("setDate", new Date());