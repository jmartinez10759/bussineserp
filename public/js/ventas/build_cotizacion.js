var url_insert  = "cotizacion/register";
var url_update   = "cotizacion/update";
var url_edit     = "cotizacion/edit";
var url_destroy  = "cotizacion/destroy";
var url_destroy_cont  = "cotizacion/destroy/gen";
var url_destroy_edit  = "cotizacion/destroy/edit";
var url_all           = "cotizacion/all";
var url_email         = "cotizacion/send/email";
var url_pdf_send      = "pdf/email";
var redireccion       = "ventas/cotizacion";

new Vue({
  el: "#vue-cotizacion",
  created: function () {
    this.consulta_general();
  },
  data: {
    datos: [],
    cotizacion: [],
    edit_cotizacion: [],
    insert: {},
    update: {},
    edit: {},
    fields: {},
    clients: {},
    products: {},
    totales: {'iva': '', 'subtotal': '', 'Total': ''},
    loading: false,
  },
  mixins : [mixins],
  methods:{
    consulta_general(id){
      //alert(jQuery('#id_concep_producto').val());
        var url = domain( url_all );
        if(jQuery('#id_concep_producto').val() == ''){
            var id = id;
        }else{
            var id = jQuery('#id_concep_producto').val();
        }
        console.log(id);
        var fields = {id: id };
        var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
          //console.log(response.data.result.concep);
          this.datos = response.data.result.concep;
          this.cotizacion = response.data.result.cotiz_general;
          this.edit = response.data.result.totales;
          //console.log(response.data.result.cotiz_general);
          /* Calcular total de productos (conceptos)*/
          var msgTotal = this.datos.reduce(function(prev, cur) {
            return prev + cur.total;
          }, 0);
          var subt = msgTotal;
          var get_iva = jQuery('#Iva').val() / 100;
          var iv = subt * get_iva;
          var tol = subt + iv;

          this.totales.subtotal = myRound(subt);
          this.totales.iva = myRound(iv);
          this.totales.Total = myRound(tol);

          /*hasta aca*/
          }).catch( error => {
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
          });
    }
    ,insert_register(estatus){
        var url = domain( url_insert );
        if(estatus == 1){
        var fields = {
            'cotizacion': {
                'codigo'        : ''
               ,'descripcion'   : jQuery('#observaciones').val()
               ,'id_moneda'     : jQuery('#cmb_monedas').val()
               ,'id_contacto'   : jQuery('#cmb_contactos').val()
               ,'id_metodo_pago': jQuery('#cmb_metodos_pagos').val()
               ,'id_forma_pago' : jQuery('#cmb_formas_pagos').val()
               ,'id_estatus'    : jQuery('#cmb_estatus').val()
               ,'id_cliente'    : jQuery('#cmb_clientes').val()
               ,'id_concep_producto': jQuery('#id_concep_producto').val()
               ,'iva'           : this.totales.iva
               ,'subtotal'      : this.totales.subtotal
               ,'Total'         : this.totales.Total
               ,'upd'           : '0'
            },
            'conceptos': {
                 'id_producto'  : jQuery('#cmb_productos').val()
                ,'id_plan'      : jQuery('#cmb_planes').val()
                ,'cantidad'     : jQuery('#cantidad_concepto').val()
                ,'precio'       : jQuery('#precio_concepto').val()
                ,'total'        : jQuery('#total_concepto').val()
            }
        };
        var field = [
            'cmb_clientes'
            ,'cmb_contactos'
            ,'cmb_formas_pagos'
            ,'cmb_metodos_pagos'
            ,'cmb_estatus_form'
            ,'cmb_monedas'
          ];
        
        if( jQuery('#cmb_productos').val() == 0 && jQuery('#cmb_planes').val() == 0 ){
            return toastr.warning('Seleccione al menos un Producto y/o Plan','Conceptos');   
        }
        if(jQuery('#cantidad_concepto').val() == 0 || jQuery('#cantidad_concepto').val() == ""){
            return toastr.warning('Debe de Ingresar al menos una cantidad','Agregar conceptos');
        }
        if( jQuery('#total_concepto').val() == 0.00 ){
            return toastr.warning('Seleccione un Producto y/o Plan con la cantidad','Conceptos');   
        }
        if(validacion_select(field) == "error"){

            jQuery.fancybox.close({
                'type'      : 'inline'
                ,'src'      : "#modal_conceptos"
                ,'buttons'  : ['share', 'close']
            });
          
          return toastr.warning('Sección de Cotizaciones');
        }
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
        }else{
          this.insert_register_update();
        }
    }
    ,insert_register_update(){
        var url = domain( url_insert );
        var fields = {
            'cotizacion': {
                'codigo'        : ''
               ,'descripcion'   : jQuery('#observaciones').val()
               ,'id_moneda'     : jQuery('#cmb_monedas').val()
               ,'id_contacto'   : jQuery('#cmb_contactos').val()
               ,'id_metodo_pago': jQuery('#cmb_metodos_pagos').val()
               ,'id_forma_pago' : jQuery('#cmb_formas_pagos').val()
               ,'id_estatus'    : jQuery('#cmb_estatus').val()
               ,'id_cliente'    : jQuery('#cmb_clientes').val()
               ,'id_concep_producto': jQuery('#id_concep_producto').val()
               ,'iva'           : this.totales.iva
               ,'subtotal'      : this.totales.subtotal
               ,'Total'         : this.totales.Total
               ,'upd'           : '1'
            }/*,
            'conceptos': {
                 'id_producto'  : jQuery('#cmb_productos').val()
                ,'id_plan'      : jQuery('#cmb_planes').val()
                ,'cantidad'     : jQuery('#cantidad_concepto').val()
                ,'precio'       : jQuery('#precio_concepto').val()
                ,'total'        : jQuery('#total_concepto').val()
            }*/
        };
        var tuplas = [];
        var i = 0;
        var identificador = '#modal_conceptos'
        
        var field = [
            'cmb_clientes'
            ,'cmb_contactos'
            ,'cmb_formas_pagos'
            ,'cmb_metodos_pagos'
            ,'cmb_estatus_form'
            ,'cmb_monedas'
          ];

          jQuery('#table_concepts tbody').find('tr').each(function(){ tuplas[i] = 1; i++; });

        if(validacion_select(field) == "error"){return;}
        if(tuplas.length < 1){
          jQuery.fancybox.open({
                'type'      : 'inline'
                ,'src'      : identificador
                ,'buttons'  : ['share', 'close']
          });
          return toastr.warning('Debe de Ingresar al menos un concepto','Agregar conceptos');
        }
        console.log(fields);
        var promise = MasterController.method_master(url,fields,"post");
          promise.then( response => {
              
               $.fancybox.close({
                    'type': 'inline'
                    ,'src': "#modal_conceptos"
                    ,'buttons' : ['share', 'close']
                });
                buildSweetAlert('# '+response.data.result.id,'Se género la cotización con éxito','success');
              clean_input_general();
              toastr.success( response.data.message , title );
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
    ,insert_register_edit(estatus){
        var url = domain( url_insert );
        if(estatus == 1){
        var fields = {
            'cotizacion': {
                'codigo'        : ''
               ,'descripcion'   : jQuery('#observaciones_edit').val()
               ,'id_moneda'     : jQuery('#cmb_monedas_edit').val()
               ,'id_contacto'   : jQuery('#cmb_contactos_edit').val()
               ,'id_metodo_pago': jQuery('#cmb_metodos_pagos_edit').val()
               ,'id_forma_pago' : jQuery('#cmb_formas_pagos_edit').val()
               ,'id_estatus'    : jQuery('#cmb_estatus_edit').val()
               ,'id_cliente'    : jQuery('#cmb_clientes_edit').val()
               ,'id_concep_producto': jQuery('#id_cotizacion_edit').val()
               ,'upd'           : '0'

            },
            'conceptos': {
                 'id_producto'  : jQuery('#cmb_productos_edit').val()
                ,'id_plan'      : jQuery('#cmb_planes_edit').val()
                ,'cantidad'     : jQuery('#cantidad_concepto_edit').val()
                ,'precio'       : jQuery('#precio_concepto_edit').val()
                ,'total'        : jQuery('#total_concepto_edit').val()
            }
        };
        var field = [
            'cmb_clientes_edit'
            ,'cmb_contactos_edit'
            ,'cmb_formas_pagos_edit'
            ,'cmb_metodos_pagos_edit'
            ,'cmb_estatus_edit'
            ,'cmb_monedas_edit'
          ];
        
        if( jQuery('#cmb_productos_edit').val() == 0 && jQuery('#cmb_planes_edit').val() == 0 ){
            return toastr.warning('Seleccione al menos un Producto y/o Plan','Conceptos');   
        }
          if(jQuery('#cantidad_concepto_edit').val() == 0 || jQuery('#cantidad_concepto_edit').val() == ""){
            return toastr.warning('Debe de Ingresar al menos una cantidad','Agregar conceptos');
        }
        if(validacion_select(field) == "error"){

            jQuery.fancybox.close({
                'type'      : 'inline'
                ,'src'      : "#modal_conceptos_editar"
                ,'buttons'  : ['share', 'close']
            });
          
          return toastr.warning('Sección de editar Cotizaciones');
        }
        console.log(fields);
        var promise = MasterController.method_master(url,fields,"post");
          promise.then( response => {

              buildSweetAlertOptions("¡Registro agregado!", "¿Deseas seguir agregando registros?", function(){
               $.fancybox.close({
                    'type': 'inline'
                    ,'src': "#modal_conceptos_editar"
                    ,'buttons' : ['share', 'close']
                });
          }, 'success', true,['NO','SI'] );

              clean_input_product_edit();
              toastr.success( response.data.message , title );
              //jQuery('#id_concep_producto').val(response.data.result.id)
              //console.log(response.data.result.id);
              this.consulta_general(jQuery('#id_cotizacion_edit').val());
              
          }).catch( error => {
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
          });
        }else{
          this.insert_register_edit_update();
        }
    }
    ,insert_register_edit_update(){
        var url = domain( url_insert );
        var fields = {
            'cotizacion': {
                'codigo'        : ''
               ,'descripcion'   : jQuery('#observaciones_edit').val()
               ,'id_moneda'     : jQuery('#cmb_monedas_edit').val()
               ,'id_contacto'   : jQuery('#cmb_contactos_edit').val()
               ,'id_metodo_pago': jQuery('#cmb_metodos_pagos_edit').val()
               ,'id_forma_pago' : jQuery('#cmb_formas_pagos_edit').val()
               ,'id_estatus'    : jQuery('#cmb_estatus_edit').val()
               ,'id_cliente'    : jQuery('#cmb_clientes_edit').val()
               ,'id_concep_producto': jQuery('#id_cotizacion_edit').val()
               ,'iva'           : this.totales.iva
               ,'subtotal'      : this.totales.subtotal
               ,'Total'         : this.totales.Total
               ,'upd'           : '1'
            }
        };
        var tuplas = [];
        var i = 0;
        var identificador = '#modal_conceptos_editar'
        
        var field = [
            'cmb_clientes_edit'
            ,'cmb_contactos_edit'
            ,'cmb_formas_pagos_edit'
            ,'cmb_metodos_pagos_edit'
            ,'cmb_estatus_edit'
            ,'cmb_monedas_edit'
          ];

          jQuery('#table_concepts_edit tbody').find('tr').each(function(){ tuplas[i] = 1; i++; });

        if(validacion_select(field) == "error"){return;}
        if(tuplas.length < 1){
          jQuery.fancybox.open({
                'type'      : 'inline'
                ,'src'      : identificador
                ,'buttons'  : ['share', 'close']
          });
          return toastr.warning('Debe de Ingresar al menos un concepto','Agregar conceptos');
        }
        console.log(fields);
        var promise = MasterController.method_master(url,fields,"post");
          promise.then( response => {
              
               $.fancybox.close({
                    'type': 'inline'
                    ,'src': "#modal_conceptos_editar"
                    ,'buttons' : ['share', 'close']
                });
                if(jQuery('#cmb_estatus_edit').val() == 5){
                    buildSweetAlert('# '+response.data.result.id_pedido,'Se género el pedido con éxito','success');
                    setTimeout("window.location.href=domain('ventas/pedidos');",4000);

                }
              jQuery('#id_cotizacion_edit').val();
              clean_input_general_edit();
              toastr.success( response.data.message , title );
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
        var fields = {id : id.id_cotizacion };
        var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
              $.fancybox.open({
                  'type'      : 'inline'
                  ,'src'      : "#modal_edit_register"
                  ,'modal': true
              });
              var id_cliente=jQuery('#cmb_clientes_edit').val(response.data.result.cotizacion[0].id_cliente);
              var id_contacto=jQuery('#cmb_contactos_edit').val(response.data.result.cotizacion[0].id_contacto);
              display_contactos_edit(id_cliente);
              parser_data_edit(response.data.result.cotizacion[0].id_contacto);
              jQuery('#cmb_formas_pagos_edit').val(response.data.result.cotizacion[0].id_forma_pago);
              jQuery('#cmb_metodos_pagos_edit').val(response.data.result.cotizacion[0].id_metodo_pago);
              jQuery('#cmb_estatus_edit').val(response.data.result.cotizacion[0].id_estatus);
              jQuery('#observaciones_edit').val(response.data.result.cotizacion[0].des_cot);
              jQuery('#cmb_monedas_edit').val(response.data.result.cotizacion[0].id_moneda);

              jQuery('#subtotal_edit').text(response.data.result.conceptos[0].subtotal);
              jQuery('#iva_edit').text(response.data.result.conceptos[0].iva);
              jQuery('#total_edit').text(response.data.result.conceptos[0].total_conc);
              if(response.data.result.cotizacion[0].id_estatus == 5){
                jQuery('#cmb_estatus_edit').prop('disabled', true)
                jQuery('#add_concepto_edit').attr("disabled", true)
                jQuery('#insertar_add_edit').attr("disabled", true)
              }else{
                jQuery('#cmb_estatus_edit').prop('disabled', false)
                jQuery('#add_concepto_edit').attr("disabled", false)
                jQuery('#insertar_add_edit').attr("disabled", false)
              }
              //console.log(response.data.result);
              toastr.success( response.data.message , title );
              this.edit_cotizacion = response.data.result;
              //console.log(this.edit_cotizacion.cotizacion);
              this.consulta_general(response.data.result.conceptos[0].id_cotizacion);
              
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
        var fields = {id : id.id_concepto, total: id.total };
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
    ,destroy_cotizacion( id ){
        var url = domain( url_destroy_cont );
        var fields = {id : id.id_cotizacion };
         buildSweetAlertOptions("¿Borrar Registro?","¿Realmente desea eliminar el registro?",function(){
          var promise = MasterController.method_master(url,fields,"delete");
          promise.then( response => {
              toastr.success( response.data.message , title );
              location.reload();
              //this.consulta_general();
          }).catch( error => {
            
              if( isset(error.response.status) && error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
          });
      },"warning",true,["SI","NO"]);   
        this.consulta_general();
    }
    ,destroy_register_edit( id ){
        var url = domain( url_destroy_edit );
        var fields = {id : id.id_concepto, total: id.total };
        var promise = MasterController.method_master(url,fields,"delete");
          promise.then( response => {
              toastr.success( response.data.message , title );
              console.log(response);
              this.consulta_general(jQuery('#id_cotizacion_edit').val());
          }).catch( error => {
            
              if( isset(error.response.status) && error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
          });
    }
    ,cancel_cotizacion(){
        var id_cotizacion = ( jQuery('#id_concep_producto').val() )? jQuery('#id_concep_producto').val() : "";
        if(id_cotizacion != ""){
            var url = domain( url_destroy_cont );
            var fields = {id : id_cotizacion };
            var promise = MasterController.method_master(url,fields,"delete");
            promise.then( response => {
                clean_input_general();
                this.datos = [];
                this.consulta_general();
            }).catch( error => {
                if( isset(error.response) && error.response.status == 419 ){
                  toastr.error( session_expired ); 
                  redirect(domain("/"));
                  return;
                }
                  toastr.error( error.result , expired );  
            });
        }else{
            clean_input_general();
        }
    }
    ,cancel_cotizacion_edit(){
        var id_cotizacion = ( jQuery('#id_concep_producto').val() )? jQuery('#id_concep_producto').val() : "";
        if(id_cotizacion != ""){
           //var url = domain( url_destroy_cont );
            //var fields = {id : id_cotizacion };
            //var promise = MasterController.method_master(url,fields,"delete");
            promise.then( response => {
                clean_input_general();
                this.datos = [];
                this.consulta_general();
                alert();
                console.log(this.datos);
            }).catch( error => {
                if( isset(error.response) && error.response.status == 419 ){
                  toastr.error( session_expired ); 
                  redirect(domain("/"));
                  return;
                }
                  toastr.error( error.result , expired );  
            });
        }else{
            clean_input_general();
            this.datos = [];
            this.consulta_general();
        }
    }
    ,pdf_print( id ){
        var pdf = "pdf/cotizacion/"+id.id_cotizacion;
        $.fancybox.open({
            'type': 'iframe'
            ,'src': domain(pdf)
            ,'buttons' : ['share', 'close']
        });
        return;
    }
    ,pdf_email( id ){
        var url = domain( url_email );
        var fields = {id : id.id_cotizacion };
        var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
              $.fancybox.open({
                  'type'      : 'inline'
                  ,'src'      : "#modal_send_email"
                  ,'modal': true
              });

              jQuery('#destinatario_pdf').val(response.data.result[0].correo);
              jQuery('#nomb_contacto').val(response.data.result[0].contacto);
              jQuery('#id_cotzacion').val(response.data.result[0].id_cotizacion);
              
              //toastr.success( response.data.message , title );
              
          }).catch( error => {
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );              
          });
        
    }
    ,send_pdf( ){
        var url = domain( url_pdf_send );
        var fields = {
               'correo'     : jQuery('#destinatario_pdf').val()
               ,'contacto'  : jQuery('#nomb_contacto').val()
               ,'asunto'    : jQuery('#asunto_pdf').val()
               ,'mensaje'   : jQuery('#mensaje_pdf').val()
               ,'id'        : jQuery('#id_cotzacion').val()
        };
        this.loading = true;
        var promise = MasterController.method_master(url,fields,"post");
          promise.then( response => {
            
            toastr.success( 'Correo enviado' , title );
              $.fancybox.close({
                'type'      : 'inline'
                ,'src'      : "#modal_send_email"
            });
            this.loading = false;
            jQuery('#destinatario_pdf').val('')
            jQuery('#nomb_contacto').val('')
            jQuery('#asunto_pdf').val('')
            jQuery('#id_cotzacion').val('')
  
          }).catch( error => {
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );              
          });
        
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
function clean_input_general() {
        jQuery('#id_concep_producto').val('');
        jQuery("#cmb_clientes").val(0);
        jQuery('#cmb_clientes').change();
        // jQuery('#cmb_formas_pagos').val(0)
        // jQuery("#cmb_metodos_pagos").val(0);
        // jQuery("#cmb_estatus").val(0);
        jQuery("#observaciones").val('');
        //jQuery("#cmb_monedas").val(0);
}

function clean_input_general_edit() {
        jQuery('#id_cotizacion_edit').val('');
        jQuery("#cmb_clientes_edit").val(0);
        jQuery('#cmb_clientes_edit').change();
        jQuery('#cmb_formas_pagos_edit').val(0)
        jQuery("#cmb_metodos_pagos_edit").val(0);
        jQuery("#cmb_estatus_edit").val(0);
        jQuery("#observaciones_edit").val('');
        jQuery("#cmb_monedas_edit").val(0);
}

function clean_input_product_edit() {
        jQuery('#cmb_productos_edit').val(0)
        jQuery('#cmb_planes_edit').val(0)
        jQuery('#cantidad_concepto_edit').val('')
        jQuery('#precio_concepto_edit').val('')
        jQuery('#total_concepto_edit').val('')
        jQuery('#descripcion_edit').val('')
        //jQuery('#id_concep_producto').val(1)
}
function myRound(num, dec) {
    var exp = Math.pow(10, dec || 2); // 2 decimales por defecto
    return parseInt(num * exp, 10) / exp;
}

function valida_num(){
    $('#cantidad_concepto').on('input', function () { 
        this.value = this.value.replace(/[^0-9]/g,'');
        if (this.value.length > 5) 
         this.value = this.value.slice(0,5);
    });
}

function valida_num_edit(){
    $('#cantidad_concepto_edit').on('input', function () { 
        this.value = this.value.replace(/[^0-9]/g,'');
        if (this.value.length > 5) 
         this.value = this.value.slice(0,5);
    });
}
// Abrir modales para add y modificar conceptos
function facyadd_pro(){
    $.fancybox.open({
        'type'      : 'inline'
        ,'src'      : "#modal_conceptos"
        ,'modal': true
    });
  }
  
  function facyadd_pro_edit(){
      $.fancybox.open({
          'type'      : 'inline'
          ,'src'      : "#modal_conceptos_editar"
          ,'modal': true
      });
    }

jQuery('#modal_dialog').css('width', '75%');
jQuery('.add').fancybox();

jQuery('#cmb_clientes').selectpicker();
jQuery('.fecha').datepicker( {format: 'yyyy-mm-dd' ,autoclose: true ,firstDay: 1}).datepicker("setDate", new Date());

jQuery('#cmb_formas_pagos').val(1);
jQuery('#cmb_estatus').val(6);
jQuery('#cmb_estatus').prop('disabled', true);

jQuery('#cmb_metodos_pagos').val(1);
jQuery('#cmb_monedas').val(100);

