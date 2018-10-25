var url_insert  = "pedidos/register";
var url_update   = "pedidos/update";
var url_edit     = "pedidos/edit";
var url_destroy  = "pedidos/destroy";
var url_destroy_conceptos  = "pedidos/destroy_concepto";
var url_all      = "pedidos/all";
var redireccion  = "ventas/pedidos";
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
    conceptos: {},
    conceptos_edit: {},

  },
  mixins : [mixins],
  methods:{
    consulta_general(){
        var url = domain( url_all );
        var fields = {};
        var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
              this.datos = response.data.result;
          }).catch( error => {
              if( isset(error.response) && error.response.status == 419 ){
                toastr.error( session_expired ); 
                redirect(domain("/"));
                return;
              }
                toastr.error( error.result , expired );  
          });
    }
    ,consulta_conceptos( id ){
        var url = domain( url_edit );
        var fields = {id : id };
        var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
              jQuery('#id_pedido').val(id);
              this.conceptos = response.data.result.pedidos.conceptos;
              jQuery('#subtotal').text(response.data.result.subtotal);
              jQuery('#iva').text(response.data.result.iva);
              jQuery('#total').text(response.data.result.total);

              jQuery('#subtotal_').val(response.data.result.subtotal_);
              jQuery('#iva_').val(response.data.result.iva_);
              jQuery('#total_').val(response.data.result.total_);
              this.consulta_general();
          }).catch( error => {
              if( isset(error.response) && error.response.status == 419 ){
                toastr.error( session_expired ); 
                redirect(domain("/"));
                return;
              }
                toastr.error( error.result , expired );  
          });
    }
    ,consulta_conceptos_edit( id ){
        var url = domain( url_edit );
        var fields = {id : id };
        var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
              jQuery('#id_pedido_edit').val(id);
              this.conceptos = response.data.result.pedidos.conceptos;
              jQuery('#subtotal_edit').text(response.data.result.subtotal);
              jQuery('#iva_edit').text(response.data.result.iva);
              jQuery('#total_edit').text(response.data.result.total);

              jQuery('#edit_subtotal_').val(response.data.result.subtotal_);
              jQuery('#edit_iva_').val(response.data.result.iva_);
              jQuery('#edit_total_').val(response.data.result.total_);
              //mandar a llamar un metodo para la parte de actualizacion de los registros de las cantidades
              this.consulta_general();
              // if( jQuery('#cmb_estatus_form_edit').val() == 5){
              //   alert();
              // }

          }).catch( error => {
              if( isset(error.response) && error.response.status == 419 ){
                toastr.error( session_expired ); 
                redirect(domain("/"));
                return;
              }
                toastr.error( error.result , expired );  
          });
    }
    ,insert_register(update){
        var url = domain( url_insert );
        this.insert.pedidos = {
            id                : (update)? jQuery('#id_pedido_edit').val() : jQuery('#id_pedido').val()
           ,id_cliente        : (update)? jQuery('#cmb_clientes_edit').val() : jQuery('#cmb_clientes').val()
           ,id_contacto       : (update)? jQuery('#cmb_contactos_edit').val() : jQuery('#cmb_contactos').val()
           ,id_forma_pago     : (update)? jQuery('#cmb_formas_pagos_edit').val()  : jQuery('#cmb_formas_pagos').val() 
           ,id_metodo_pago    : (update)? jQuery('#cmb_metodos_pagos_edit').val()  : jQuery('#cmb_metodos_pagos').val() 
           ,id_estatus        : (update)? jQuery('#cmb_estatus_form_edit').val() : jQuery('#cmb_estatus_form').val()
           ,id_moneda         : (update)? jQuery('#cmb_monedas_edit').val() : jQuery('#cmb_monedas').val()
           ,descripcion       : (update)? jQuery('#observaciones_edit').val() : jQuery('#observaciones').val()
           ,iva               : (update)? jQuery('#edit_iva_').val().replace(',',"") : jQuery('#iva_').val().replace(',',"")
           ,subtotal          : (update)? jQuery('#edit_subtotal_').val().replace(',',"") : jQuery('#subtotal_').val().replace(',',"")
           ,total             : (update)? jQuery('#edit_total_').val().replace(',',"") : jQuery('#total_').val().replace(',',"")
        };

        this.insert.conceptos = [{
           id_producto        : (update)? jQuery('#cmb_productos_edit').val() : jQuery('#cmb_productos').val()
           ,id_plan           : (update)? jQuery('#cmb_planes_edit').val() : jQuery('#cmb_planes').val()
           ,cantidad          : (update)? jQuery('#cantidad_concepto_edit').val() : jQuery('#cantidad_concepto').val() 
           ,precio            : (update)? jQuery('#precio_concepto_edit').val() : jQuery('#precio_concepto').val() 
           ,total             : (update)? jQuery('#total_concepto_edit').val() : jQuery('#total_concepto').val()
        }];
        if(update){
          var fields = [
            'cmb_clientes_edit'
            ,'cmb_contactos_edit'
            ,'cmb_formas_pagos_edit'
            ,'cmb_metodos_pagos_edit'
            ,'cmb_estatus_form_edit'
            ,'cmb_monedas_edit'
          ];
        }else{
          var fields = [
            'cmb_clientes'
            ,'cmb_contactos'
            ,'cmb_formas_pagos'
            ,'cmb_metodos_pagos'
            ,'cmb_estatus_form'
            ,'cmb_monedas'
          ];
        }
        if(this.insert.conceptos[0].cantidad == 0 || this.insert.conceptos[0].cantidad == ""){
            return toastr.warning('Debe de Ingresar al menos una cantidad','Agregar conceptos');
        }
        if( this.insert.conceptos[0].id_producto == 0 && this.insert.conceptos[0].id_plan == 0 ){
            return toastr.warning('Seleccione al menos un Producto y/o Plan','Conceptos');   
        }
        if(validacion_select(fields) == "error"){

          if(update){
            jQuery.fancybox.close({
                'type'      : 'inline'
                ,'src'      : "#modal_conceptos_edit"
                ,'buttons'  : ['share', 'close']
            });
          }else{
            jQuery.fancybox.close({
                'type'      : 'inline'
                ,'src'      : "#modal_conceptos"
                ,'buttons'  : ['share', 'close']
            });
          }
          return toastr.warning('Sección de Pedidos');
        }
        var fields = {
          pedidos : this.insert.pedidos
          ,conceptos : this.insert.conceptos
        };
        
        if(update){
            jQuery.fancybox.close({
                'type'      : 'inline'
                ,'src'      : "#modal_conceptos_edit"
                ,'buttons'  : ['share', 'close']
            });
          }else{
            jQuery.fancybox.close({
                'type'      : 'inline'
                ,'src'      : "#modal_conceptos"
                ,'buttons'  : ['share', 'close']
            });
          }
        jQuery('.agregar').prop('disabled',true);
        var promise = MasterController.method_master(url,fields,"post");
          promise.then( response => {
              jQuery('.agregar').prop('disabled',false);
              if(update){
                this.consulta_conceptos_edit( response.data.result.id );
              }
                this.consulta_conceptos( response.data.result.id );
          }).catch( error => {
              if( isset(error.response) && error.response.status == 419 ){
                toastr.error( session_expired ); 
                redirect(domain("/"));
                return;
              }
                toastr.error( error.result , expired );  
          });
    }
    ,update_register(insert){
      jQuery('.update').prop('disabled',true);
        var url = domain( url_update );
        this.update.pedidos = {
            id                : (insert)? jQuery('#id_pedido').val(): jQuery('#id_pedido_edit').val()
           ,id_cliente        : (insert)? jQuery('#cmb_clientes').val() :jQuery('#cmb_clientes_edit').val()
           ,id_contacto       : (insert)? jQuery('#cmb_contactos').val() :jQuery('#cmb_contactos_edit').val()
           ,id_forma_pago     : (insert)? jQuery('#cmb_formas_pagos').val() :jQuery('#cmb_formas_pagos_edit').val() 
           ,id_metodo_pago    : (insert)? jQuery('#cmb_metodos_pagos').val() :jQuery('#cmb_metodos_pagos_edit').val() 
           ,id_estatus        : (insert)? jQuery('#cmb_estatus_form').val() :jQuery('#cmb_estatus_form_edit').val()
           ,id_moneda         : (insert)? jQuery('#cmb_monedas').val() :jQuery('#cmb_monedas_edit').val()
           ,descripcion       : (insert)? jQuery('#observaciones').val() :jQuery('#observaciones_edit').val()
           ,iva               : (insert)? jQuery('#iva_').val().replace(',',"") :jQuery('#edit_iva_').val().replace(',',"")
           ,subtotal          : (insert)? jQuery('#subtotal_').val().replace(',',"") :jQuery('#edit_subtotal_').val().replace(',',"")
           ,total             : (insert)? jQuery('#total_').val().replace(',',"") :jQuery('#edit_total_').val().replace(',',"")
        };
        var tuplas = [];
        var i = 0;
        var identificador = (insert)?'#modal_conceptos' :'#modal_conceptos_edit'
        if(insert){
          var fields = [
            'cmb_clientes'
            ,'cmb_contactos'
            ,'cmb_formas_pagos'
            ,'cmb_metodos_pagos'
            ,'cmb_estatus_form'
            ,'cmb_monedas'
          ];

          jQuery('#table_concepts tbody').find('tr').each(function(){ tuplas[i] = 1; i++; });

        }else{
          var fields = [
            'cmb_clientes_edit'
            ,'cmb_contactos_edit'
            ,'cmb_formas_pagos_edit'
            ,'cmb_metodos_pagos_edit'
            ,'cmb_estatus_form_edit'
            ,'cmb_monedas_edit'
          ];
          jQuery('#table_concepts_edit tbody').find('tr').each(function(){ tuplas[i] = 1; i++; });

        }
        if(validacion_select(fields) == "error"){return;}
        if(tuplas.length < 1){
          jQuery.fancybox.open({
                'type'      : 'inline'
                ,'src'      : identificador
                ,'buttons'  : ['share', 'close']
          });
          return toastr.warning('Debe de Ingresar al menos un concepto','Agregar conceptos');
        }
        //console.log(this.update.pedidos);return;
        var fields = { pedidos : this.update.pedidos };
        var promise = MasterController.method_master(url,fields,"put");
          promise.then( response => {
              jQuery('.update').prop('disabled',false);
              if (insert) {
                  buildSweetAlert('# '+response.data.result.id,'Se genero el pedido con exito','success');
              }
              jQuery.fancybox.close({
                  'type'      : 'inline'
                  ,'src'      : "#modal_edit_register"
                  ,'modal': true
              });
              this.consulta_conceptos_edit( response.data.result.id );
              
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
        this.conceptos = [];
        var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
            this.edit.pedidos = response.data.result.pedidos;
            this.edit.cantidades = response.data.result;
            this.conceptos = response.data.result.pedidos.conceptos;
            console.log(this.conceptos);
            jQuery('#id_pedido_edit').val(this.edit.pedidos.id);
            jQuery('#cmb_clientes_edit').selectpicker('val',[this.edit.pedidos.id_cliente]);
            //jQuery('#cmb_contactos_edit').selectpicker('val',[this.edit.pedidos.id_contacto]);
            jQuery('#cmb_formas_pagos_edit').selectpicker('val',[this.edit.pedidos.id_forma_pago]);
            jQuery('#cmb_metodos_pagos_edit').selectpicker('val',[this.edit.pedidos.id_metodo_pago]);
            jQuery('#cmb_monedas_edit').selectpicker('val',[this.edit.pedidos.id_moneda]);
            jQuery('#cmb_estatus_form_edit').selectpicker('val',[this.edit.pedidos.id_estatus]);
            jQuery('#observaciones_edit').val(this.edit.pedidos.descripcion);

            jQuery('#rfc_receptor_edit').val(this.edit.pedidos.clientes.rfc_receptor);
            jQuery('#nombre_comercial_edit').val(this.edit.pedidos.clientes.nombre_comercial);
            jQuery('#telefono_cliente_edit').val(this.edit.pedidos.clientes.telefono);
            
            jQuery('#telefono_contacto_edit').val(this.edit.pedidos.contactos.telefono);
            jQuery('#correo_contacto_edit').val(this.edit.pedidos.contactos.correo);
            
            jQuery('#iva_edit').text(this.edit.cantidades.iva);
            jQuery('#subtotal_edit').text(this.edit.cantidades.subtotal);
            jQuery('#total_edit').text(this.edit.cantidades.total);

            jQuery('#edit_subtotal_').val(this.edit.cantidades.subtotal_);
            jQuery('#edit_iva_').val(this.edit.cantidades.iva_);
            jQuery('#edit_total_').val(this.edit.cantidades.total_);

            display_contactos_edit(this.edit.pedidos.id_contacto);
            change_contactos_edit(this.edit.pedidos.id_contacto);

            jQuery.fancybox.open({
                  'type'      : 'inline'
                  ,'src'      : "#modal_edit_register"
                  ,'modal': true
              });
              //this.conceptos = [];
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
    ,destroy_register( id ){
        var url = domain( url_destroy );
        var fields = {id : id };
         buildSweetAlertOptions("¿Borrar Registro?","¿Realmente desea eliminar el registro?",function(){
          var promise = MasterController.method_master(url,fields,"delete");
          promise.then( response => {
              toastr.success( response.data.message , title );
              redirect(domain(redireccion));
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
    ,destroy_concepto( id , update ){
        var url = domain( url_destroy_conceptos );
        var fields = {id : id };
        var promise = MasterController.method_master(url,fields,"delete");
        promise.then( response => {
            if(update){
              this.consulta_conceptos_edit( jQuery('#id_pedido_edit').val());
            }else{
              this.consulta_conceptos( jQuery('#id_pedido').val() );
            }
        }).catch( error => {
            if( isset(error.response) && error.response.status == 419 ){
              toastr.error( session_expired ); 
              redirect(domain("/"));
              return;
            }
              toastr.error( error.result , expired );  
        });
    }
    ,cancel_pedido(){
        var id_pedido = ( jQuery('#id_pedido').val() )? jQuery('#id_pedido').val() : "";
        if(id_pedido){
            var url = domain( url_destroy );
            var fields = {id : id_pedido };
            var promise = MasterController.method_master(url,fields,"delete");
            promise.then( response => {
                this.consulta_general();
            }).catch( error => {
                if( isset(error.response) && error.response.status == 419 ){
                  toastr.error( session_expired ); 
                  redirect(domain("/"));
                  return;
                }
                  toastr.error( error.result , expired );  
            });
        }
    }
    ,update_pedidos(){
      var url = domain( url_update );
      var fields = { pedidos : {
          id        : jQuery('#id_pedido_edit').val().replace()
          ,iva      : jQuery('#edit_iva_').val().replace(',',"")
          ,subtotal : jQuery('#edit_subtotal_').val().replace(',',"")
          ,total    : jQuery('#edit_total_').val().replace(',',"")
        }
      }
      var promise = MasterController.method_master(url,fields,"put");
        promise.then( response => {
            jQuery.fancybox.close({
                  'type'      : 'inline'
                  ,'src'      : "#modal_edit_register"
                  ,'modal': true
              });
            this.consulta_general();
        }).catch( error => {
            if( isset(error.response) && error.response.status == 419 ){
              toastr.error( session_expired ); 
              redirect(domain("/"));
              return;
            }
              toastr.error( error.result , expired );  
        });
    }
    ,insert_facturacion(){

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
function display_contactos_edit(id_contacto){
    var url = domain( url_edit_clientes );
    var fields = {id_cliente : jQuery('#cmb_clientes_edit').val() };
    jQuery('#correo_contacto_edit').val('');
    jQuery('#telefono_contacto_edit').val('');
    var promise = MasterController.method_master(url,fields,"get");
      promise.then( response => {
          console.log(response.data.result);
          jQuery('#rfc_receptor_edit').val(response.data.result.rfc_receptor);
          jQuery('#nombre_comercial_edit').val(response.data.result.nombre_comercial);
          jQuery('#telefono_cliente_edit').val(response.data.result.telefono);
          var contactos = {
             'data'    : response.data.result.contactos
             ,'text'   : "nombre_completo"
             ,'value'  : "id"
             ,'name'   : 'cmb_contactos_edit'
             ,'class'  : 'form-control input-sm'
             ,'leyenda': 'Seleccione Opcion'
             ,'event'  : 'change_contactos_edit()'
            ,'attr'    : 'data-live-search="true"'     
         };
          
         jQuery('#div_contacto_edit').html('');
         jQuery('#div_contacto_edit').html( select_general(contactos) );
         jQuery('#cmb_contactos_edit').selectpicker('val',[id_contacto]);
         //change_contactos_edit();

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
function change_contactos_edit(id_contacto){
    
    var url = domain( url_edit_contactos );
    var fields = {
      id : (id_contacto)? id_contacto :jQuery('#cmb_contactos_edit').val()
    };
    var promise = MasterController.method_master(url,fields,"get");
      promise.then( response => {
          console.log(response.data.result);
          jQuery('#correo_contacto_edit').val(response.data.result.correo);
          jQuery('#telefono_contacto_edit').val(response.data.result.telefono);
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
function display_productos_edit(){
    var url = domain( url_edit_productos );
    var fields = {id : jQuery('#cmb_productos_edit').val() };
    jQuery('#cmb_planes_edit').selectpicker('val',[0]);
    jQuery('#cantidad_concepto_edit').val(0);
    jQuery('#total_concepto_edit').val(0);
    var promise = MasterController.method_master(url,fields,"get");
      promise.then( response => {
          console.log(response.data.result);
          jQuery('#precio_concepto_edit').val(response.data.result.total);
          jQuery('#descripcion_edit').val(response.data.result.descripcion);
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
function display_planes_edit(){
    var url = domain( url_edit_planes );
    var fields = {id : jQuery('#cmb_planes_edit').val() };
    jQuery('#cmb_productos_edit').selectpicker('val',[0]);
    jQuery('#cantidad_concepto_edit').val(0);
    jQuery('#total_concepto_edit').val(0);
    var promise = MasterController.method_master(url,fields,"get");
      promise.then( response => {
          console.log(response.data.result);
          jQuery('#precio_concepto_edit').val(response.data.result.total);
          jQuery('#descripcion_edit').val(response.data.result.descripcion);
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
function calcular_suma_edit(){
   var precio = (jQuery('#precio_concepto_edit').val() != "") ? jQuery('#precio_concepto_edit').val(): 0;
    var cantidad = (jQuery('#cantidad_concepto_edit').val() != "") ? jQuery('#cantidad_concepto_edit').val(): 0;
    var total  = parseFloat(precio * cantidad);
    jQuery('#total_concepto_edit').val(total.toFixed(2));
}

//jQuery('.add').fancybox();
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

jQuery('#modal_general').click(function(){
      var clear = [
      'rfc_receptor'
      ,'nombre_comercial'
      ,'telefono_cliente'
      ,'telefono_contacto'
      ,'correo_contacto'
      ,'observaciones'
      ,'id_pedido'
      ,'subtotal_'
      ,'iva_'
      ,'total_'
      ,'descripcion'
      ];
      var clear_select = [
          'cmb_productos'
          ,'cmb_planes'
          ,'cmb_clientes'
          ,'cmb_contactos'
          ,'cmb_planes'
          ,'cmb_planes'
      ];
      clear_values_input(clear);
      clear_values_select(clear_select);
});
jQuery('.add').click(function(){
    jQuery('#cmb_productos').selectpicker('val',[0]);
    jQuery('#cmb_planes').selectpicker('val',[0]);
    jQuery('#cantidad_concepto').val(0);
    jQuery('#precio_concepto').val(0);
    jQuery('#descripcion').val("");
    jQuery('#total_concepto').val(0);

    jQuery('#cmb_productos_edit').selectpicker('val',[0]);
    jQuery('#cmb_planes_edit').selectpicker('val',[0]);
    jQuery('#cantidad_concepto_edit').val(0);
    jQuery('#precio_concepto_edit').val(0);
    jQuery('#descripcion_edit').val("");
    jQuery('#total_concepto_edit').val(0);
});