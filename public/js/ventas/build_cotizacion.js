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
    cotizacion: [],
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
      //alert(jQuery('#id_concep_producto').val());
        var url = domain( url_all );
        var fields = {id: jQuery('#id_concep_producto').val() };
        var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
          //console.log(response.data.result.concep);
          this.datos = response.data.result.concep;
          this.cotizacion = response.data.result.cotiz_general;
          //console.log(response.data.result.cotiz_general);

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
               ,'id_concep_producto': jQuery('#id_concep_producto').val()
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
               $.fancybox.close({
                    'type': 'inline'
                    ,'src': "#modal_conceptos"
                    ,'buttons' : ['share', 'close']
                });
          }, 'success', true,['NO','SI'] );
              clean_input_product();
              toastr.success( response.data.message , title );
              jQuery('#id_concep_producto').val(response.data.result.id)
              console.log(response.data.result.id);
              this.consulta_general();
              
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
        var fields = {id : id.id_concepto };
         var promise = MasterController.method_master(url,fields,"delete");
          promise.then( response => {
              toastr.success( response.data.message , title );
              console.log(response);
              this.consulta_general();
          }).catch( error => {
            
              if( isset(error.response.status) && error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
          });
      //    buildSweetAlertOptions("¿Borrar Registro?","¿Realmente desea eliminar el registro?",function(){
      //     var promise = MasterController.method_master(url,fields,"delete");
      //     promise.then( response => {
      //         toastr.success( response.data.message , title );
      //         //this.consulta_general();
      //     }).catch( error => {
            
      //         if( isset(error.response.status) && error.response.status == 419 ){
      //               toastr.error( session_expired ); 
      //               redirect(domain("/"));
      //               return;
      //           }
      //         toastr.error( error.response.data.message , expired );
      //     });
      // },"warning",true,["SI","NO"]);   
        //this.consulta_general();
    }
    
    
  }


});
function clean_input_product() {
        jQuery('#cmb_productos').val(0)
        jQuery('#cmb_planes').val(0)
        jQuery('#cantidad_concepto').val('')
        jQuery('#precio_concepto').val('')
        jQuery('#total_concepto').val('')
        jQuery('#descripcion').val('')
        //jQuery('#id_concep_producto').val(1)
    }
jQuery('#modal_dialog').css('width', '75%');
jQuery('.add').fancybox();

jQuery('#cmb_clientes').selectpicker();