var url_insert  = "cotizacion/register";
var url_update   = "cotizacion/update";
var url_edit     = "cotizacion/edit";
var url_destroy  = "cotizacion/destroy";
var url_all      = "cotizacion/all";
var redireccion  = "ventas/cotizacion";

new Vue({
  el: "#vue-cotizacion",
  created: function () {
    this.consulta_general();
  },
  data: {
    datos: [],
    insert: {},
    update: {},
    edit: {},
    fields: {},
    clients: {},
    products: {},

  },
  mixins : [mixins],
  methods:{
    consulta_general(){
        var url = domain( url_all );
        var fields = {};
        var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
          
              
          }).catch( error => {
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
          });
    }
    ,insert_register(){
        var url = domain( url_insert );
        var fields = {
            'cotizacion': {
                'codigo'        : 'cot-1121'
               ,'descripcion'   : jQuery('#observaciones').val()
               ,'id_moneda'     : jQuery('#cmb_monedas').val()
               ,'id_contacto'   : jQuery('#cmb_contactos').val()
               ,'id_metodo_pago': jQuery('#cmb_metodos_pagos').val()
               ,'id_forma_pago' : jQuery('#cmb_formas_pagos').val()
               ,'id_estatus'    : jQuery('#cmb_estatus').val()
               ,'id_cliente'    : jQuery('#cmb_clientes').val()
            },
            'conceptos': {
                 'id_producto'  : jQuery('#cmb_productos').val()
                ,'id_plan'      : jQuery('#cmb_planes').val()
                ,'cantidad'     : jQuery('#cantidad_concepto').val()
                ,'precio'       : jQuery('#precio_concepto').val()
                ,'total'        : jQuery('#total_concepto').val()
            }
        };
        console.log(fields);
        var promise = MasterController.method_master(url,fields,"post");
          promise.then( response => {
              
              buildSweetAlertOptions("¡Registro agregado!", "¿Deseas seguir agregando registros?", function(){
               jQuery('#modal_conceptos').close();
          }, 'success', true,['NO','SI'] );
              toastr.success( response.data.message , title );
              
          }).catch( error => {
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
          });
    }
    ,update_register(){
        var url = domain( url_update );
        var fields = {};
        var promise = MasterController.method_master(url,fields,"put");
          promise.then( response => {
          
              toastr.success( response.data.message , title );
              
          }).catch( error => {
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
          });
    }
    ,edit_register( id ){
        var url = domain( url_edit );
        var fields = {id : id };
        var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
          
              toastr.success( response.data.message , title );
              
          }).catch( error => {
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );              
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
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
          });
      },"warning",true,["SI","NO"]);   
    }
    
    
  }


});

jQuery('#modal_dialog').css('width', '75%');
jQuery('.add').fancybox();