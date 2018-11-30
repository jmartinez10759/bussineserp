const URL = {
    url_insert             :  "facturaciones/register"
    ,url_update             :  "facturaciones/update"
    ,url_update_estatus     :  "facturaciones/estatus"
    ,url_edit               :  "facturaciones/edit"
    ,url_destroy            :  "facturaciones/destroy"
    ,url_destroy_conceptos  :  "facturaciones/destroy_concepto"
    ,url_all                :  "facturaciones/all"
    ,redireccion            :  "ventas/facturaciones"
    ,url_edit_clientes      :  "clientes/edit"
    ,url_edit_contactos     :  "contactos/edit"
    ,url_edit_productos     :  "productos/edit"
    ,url_edit_planes        :  "planes/edit"
} 

app.controller('FacturacionController', function( masterservice ,$scope, $http, $location ) {
    
    $scope.constructor = function(){
        $scope.datos  = [];
        $scope.insert = {
          id_forma_pago: 1, id_estatus: 6 ,id_metodo_pago : 1 , id_moneda : 100, id_tipo_comprobante:1
        };
        $scope.insertar = {};
        $scope.update = {};
        $scope.edit   = {};
        $scope.fields = {};
        $scope.correo = {
          asunto: "Envio de Factura"
        };
        $scope.products = {
          cantidad : 0 , total: 0  
        };
        $scope.filtro = masterservice.calendar();
        $scope.select_anios();
        $scope.table_concepts = {};
        $scope.check_meses();
        $scope.index();
    }

    $scope.index = function( array = {} ){
        var url = domain( URL.url_all );
        var fields = (array != 0)? array :{};
        MasterController.request_http(url,fields,'get',$http, false )
        .then(function(response){
            //not remove function this is  verify the session
            if(masterservice.session_status( URL )){return;};
            
            $scope.datos = response.data.result;
            console.log($scope.datos);
        }).catch(function(error){
              masterservice.session_status({},error);
        });
    
    }

    $scope.conceptos = function( update = false ){
        var url = domain( URL.url_edit );
        var fields = { id: (update)? $scope.update.id : $scope.insert.id };
        MasterController.request_http(url,fields,'get',$http, false )
        .then(function(response){
            //not remove function this is  verify the session
            if(masterservice.session_status( URL )){return;};
            
           console.log(response.data.result);
          if (update) {
            $scope.update.id        = response.data.result.request.id;
            $scope.update.subtotal  = response.data.result.subtotal_;
            $scope.update.iva       = response.data.result.iva_;
            $scope.update.total     = response.data.result.total_;
          }else{
            $scope.insert.id        = response.data.result.request.id;
            $scope.insert.subtotal  = response.data.result.subtotal_;
            $scope.insert.iva       = response.data.result.iva_;
            $scope.insert.total     = response.data.result.total_;
            
          }

            $scope.table_concepts   = response.data.result.request.conceptos;
            $scope.subtotal = response.data.result.subtotal;
            $scope.iva      = response.data.result.iva;
            $scope.total    = response.data.result.total;

        }).catch(function(error){
              masterservice.session_status({},error);
              console.error(error);
              toastr.error( error.result , expired );
        });

    }

    $scope.insert_register = function( update = false ){

        var url = domain( URL.url_insert );
        $scope.insertar.factura = (update)? $scope.update :$scope.insert;
        $scope.insertar.conceptos = [$scope.products];
        var validacion = {
          'CLIENTE'          : (update)? $scope.update.id_cliente    : $scope.insert.id_cliente
          ,'CONTACTOS'       : (update)? $scope.update.id_contacto   : $scope.insert.id_contacto
          ,'FORMAS DE PAGO'  : (update)? $scope.update.id_forma_pago : $scope.insert.id_forma_pago
          ,'METODOS DE PAGO' : (update)? $scope.update.id_metodo_pago: $scope.insert.id_metodo_pago
          ,'MONEDAS'         : (update)? $scope.update.id_moneda     : $scope.insert.id_moneda

        };
        
        if( $scope.products.id_producto == null && $scope.products.id_plan == null   ){
            return toastr.warning('Seleccione al menos un Producto y/o Plan','Conceptos');   
        }
        if($scope.products.cantidad == 0 || $scope.products.cantidad == ""){
            return toastr.warning('Debe de Ingresar al menos una cantidad','Agregar conceptos');
        }
        if(validaciones_fields(validacion)){
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
          factura     : $scope.insertar.factura
          ,conceptos  : $scope.insertar.conceptos
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
        MasterController.request_http(url,fields,'post',$http, false )
        .then(function( response ){
            //toastr.success( response.data.message , title );
            //not remove function this is  verify the session
              if(masterservice.session_status( URL )){return;};

            console.log(response.data.result);
            if(update){
                $scope.conceptos(update);
            }else{
              $scope.insert.id        = response.data.result.request.id;
              $scope.insert.subtotal  = response.data.result.subtotal_;
              $scope.insert.iva       = response.data.result.iva_;
              $scope.insert.total     = response.data.result.total_;
              $scope.table_concepts   = response.data.result.request.conceptos;
              $scope.subtotal         = response.data.result.subtotal;
              $scope.iva              = response.data.result.iva;
              $scope.total            = response.data.result.total;
            }
            $scope.products = {};
        }).catch(function( error ){
              masterservice.session_status( "", error );
              console.error( error );
              toastr.error( error.result , expired );
        });

    }

    $scope.update_register = function( update = false ){

        jQuery('.update').prop('disabled',true);
        $scope.insertar.factura = (update)? $scope.update : $scope.insert;                        
        var validacion = {
          'CLIENTE'          : (update)? $scope.update.id_cliente    : $scope.insert.id_cliente
          ,'CONTACTOS'       : (update)? $scope.update.id_contacto   : $scope.insert.id_contacto
          ,'FORMAS DE PAGO'  : (update)? $scope.update.id_forma_pago : $scope.insert.id_forma_pago
          ,'METODOS DE PAGO' : (update)? $scope.update.id_metodo_pago: $scope.insert.id_metodo_pago
          ,'MONEDAS'         : (update)? $scope.update.id_moneda     : $scope.insert.id_moneda

        };
        if(validaciones_fields(validacion)){
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
          var url = domain( URL.url_update );
          var fields = {factura : $scope.insertar.factura };
          MasterController.request_http(url,fields,'put',$http, false )
          .then(function( response ){
              //not remove function this is  verify the session
              if(masterservice.session_status( URL )){return;};
              
              toastr.info( response.data.message , title );
              jQuery.fancybox.close({
                    'type'      : 'inline'
                    ,'src'      : "#modal_edit_register"
                    ,'modal'    : true
                    ,'width'    : 900
                    ,'height'   : 400
                    ,'autoSize' : false
                });
              var id = (update)? $scope.update.id : $scope.insert.id;
              jQuery('#tr_'+id ).effect("highlight",{},5000);
              var data = {
                mes: $scope.meses ,anio: $scope.anio, usuario: $scope.usuario
              }
              $scope.index(data);
              if(response.data.result.request.id_estatus == 5){
                  $scope.update = response.data.result;
                  $scope.insert_facturacion();
              }
              if (update) {
                $scope.update = {}
              }else{
                $scope.insert = {}
                buildSweetAlert('Serie: A Folio:'+response.data.result.request.id,'Se genero la factura con exito','success');
              }
              $scope.fields = {}
              $scope.products = {}
              $scope.table_concepts = {}
              $scope.subtotal = "$ 0.00";
              $scope.iva = "$ 0.00";
              $scope.total = "$ 0.00";
              jQuery('.update').prop('disabled',false);

          }).catch(function( error ){
              masterservice.session_status({},error)
              console.error( error );
              toastr.error( error.result , expired );
          });
    
    }

    $scope.edit_register = function( data ){

        var datos = ['empresas','estatus','contactos','clientes','usuarios' ,'updated_at' ,'created_at','$$hashKey','conceptos','pivot'];
        $scope.update = iterar_object(data,datos);
        $scope.estatus = data.id_estatus;
        $scope.table_concepts   = data.conceptos;
        $scope.display_contactos(1);
        $scope.change_contactos(1);
            
        $scope.subtotal = "$ "+data.subtotal.toLocaleString();
        $scope.iva      = "$ "+data.iva.toLocaleString();
        $scope.total    = "$ "+data.total.toLocaleString();
        $scope.products = {};
        console.log($scope.update);
        console.log($scope.table_concepts);

        jQuery.fancybox.open({
            'type'      : 'inline'
            ,'src'      : "#modal_edit_register"
            ,'modal'    : true
        }); 
    
    }

    $scope.destroy_register = function( id, cancel = false ){

      var url = domain( URL.url_destroy );
      var fields = {id : id };
      var titulo = (cancel)? "¿Cancelar Pedido?" : "¿Borrar Registro?";
      var descripcion = (cancel)? "¿Realmente desea cancelar el pedido?" : "¿Realmente desea eliminar el registro?";
      buildSweetAlertOptions(titulo,descripcion,function(){
        MasterController.request_http(url,fields,'delete',$http, false )
        .then(function( response ){
            masterservice.session_status( URL );
            if(!cancel){
              toastr.success( response.data.message , title );
            }
            var data = {
                mes: $scope.meses ,anio: $scope.anio ,usuario: $scope.usuario
              }
            $scope.index(data);
        }).catch(function( error ){
            masterservice.session_status( {},error );
            console.error( error );
            toastr.error( error.result , expired );
        });
          
      },"warning",true,["SI","NO"]);  
    
    }

    $scope.destroy_concepto = function( id , update = false ){

        var url = domain( URL.url_destroy_conceptos );
        var fields = {id : id };
        MasterController.request_http(url,fields,'delete',$http, false )
        .then(function( response ){
              masterservice.session_status( URL );
              $scope.conceptos(update);
        }).catch(function( error ){
            masterservice.session_status( {},error );
            console.error( error );
            toastr.error( error.result , expired );
        });                
    
    }

    $scope.cancel_pedido = function( update = false ){

        var id_pedido = ( $scope.insert.id )? $scope.insert.id : "";
        if(id_pedido){
            $scope.destroy_register(id_pedido,1);
        }
        $scope.insert = {
          id_forma_pago: 1, id_estatus: 6 ,id_metodo_pago : 1 , id_moneda : 100
        };
        $scope.update = {};   
        $scope.fields = {};   
        $scope.products = {};   
        $scope.table_concepts = {};
        $scope.cmb_contactos = {};
        $scope.subtotal = "$ 0.00";
        $scope.iva = "$ 0.00";   
        $scope.total = "$ 0.00";

    }

    $scope.display_contactos = function( update = false ){

      var url = domain( URL.url_edit_clientes );
      var fields = {id : (update)? $scope.update.id_cliente : $scope.insert.id_cliente };

      MasterController.request_http(url,fields,"get",$http, false )
        .then(function( response ){
            masterservice.session_status( URL );
            $scope.cmb_contactos = response.data.result.contactos;
            $scope.fields.rfc = response.data.result.rfc_receptor
            $scope.fields.nombre_comercial = response.data.result.nombre_comercial
            $scope.fields.telefono_empresa = response.data.result.telefono
            console.log(response);
        }).catch(function( error ){
              masterservice.session_status( {},error );
              console.error( error );
              toastr.error( error.result , expired );
        });

    }

    $scope.change_contactos = function( update = false ){

      var url = domain( URL.url_edit_contactos );
      var fields = {id : (update)? $scope.update.id_contacto : $scope.insert.id_contacto };

      MasterController.request_http(url,fields,"get",$http, false )
        .then(function( response ){
            masterservice.session_status( URL );
            $scope.fields.telefono = response.data.result.telefono
            $scope.fields.correo = response.data.result.correo
            console.log(response);
        }).catch(function( error ){
              masterservice.session_status( {},error );
              console.error( error );
              toastr.error( error.result , expired );
        });
    
    }

    $scope.display_productos = function( update = false){

      var url = domain( URL.url_edit_productos );
      var fields = {id : (update)? $scope.products.id_producto : $scope.products.id_producto};

      MasterController.request_http(url,fields,"get",$http, false )
        .then(function( response ){
            masterservice.session_status( URL );
            $scope.products.id_plan = null;
            $scope.products.precio = response.data.result.total;
            $scope.products.descripcion = response.data.result.descripcion;
            $scope.products.cantidad = 0;
            $scope.products.total = 0;
            console.log(response);
        }).catch(function( error ){
            masterservice.session_status( {},error );
            console.error( error );
            toastr.error( error.result , expired );
        });

    }

    $scope.display_planes = function ( update = false ){

      var url = domain( URL.url_edit_planes );
      var fields = {id : (update)? $scope.products.id_plan : $scope.products.id_plan};

      MasterController.request_http(url,fields,"get",$http, false )
        .then(function( response ){
            masterservice.session_status( URL );
            $scope.products.id_producto = null;
            $scope.products.precio = response.data.result.total;
            $scope.products.descripcion = response.data.result.descripcion;
            $scope.products.cantidad = 0;
            $scope.products.total = 0;
            console.log(response);
        }).catch(function( error ){
            masterservice.session_status( {},error );
            console.error( error );
            toastr.error( error.result , expired );
        });

    }
    
    $scope.calcular_suma = function( update = false ){

      $scope.products.total = masterservice.calcular_suma( $scope.products.precio, $scope.products.cantidad );

    }

    $scope.update_estatus = function( id ){
        var status = parseInt(jQuery('#cmb_estatus_'+id).val().replace('number:',''));
        var url = domain( URL.url_update_estatus );
        var fields = {id : id, id_estatus: (status) };
        if( status === 8 ){
             buildSweetAlertOptions("¿Timbrar Factura?","¿Realmente desea timbrar la factura?",function(){
              //alert("Se realiza el timbrado favor de esperar....");  
              $scope.estatus_update(url,fields);
              jQuery('#tr_'+id ).effect("highlight",{},5000);
            },"warning",true,["SI","NO"],function(){
              var data = {
                  mes: $scope.meses, anio: $scope.anio, usuario: $scope.usuario
              }
                $scope.index(data);
            });  

        }else{
           $scope.estatus_update(url,fields);
           jQuery('#tr_'+id ).effect("highlight",{},5000);
        }

    }

    $scope.estatus_update = function(url,fields){

        MasterController.request_http(url,fields,'put',$http, false )
        .then(function( response ){
            //not remove function this is  verify the session
            if(masterservice.session_status( URL )){return;};

            toastr.info( response.data.message , title );
            var data = {
              mes: $scope.meses ,anio: $scope.anio, usuario: $scope.usuario
            }
            $scope.index(data);

        }).catch(function( error ){
            masterservice.session_status({},error);
        });

    }
    $scope.format_date = function( request, format ){

       return masterservice.format_date( request , format );

    }
    $scope.filtros_mes = function(data){
        for(var i in $scope.filtro){ $scope.filtro[i].class = "";}
        data.class = "active";
        $scope.meses = data.id;        
        var fields = {
           mes:     $scope.meses
          ,anio:    $scope.anio
          ,usuario: $scope.usuarios
        }
        $scope.index(fields);
    }

    $scope.filtros_anio = function(){
        var fields = {
           mes:     $scope.meses
          ,anio:    $scope.anio
          ,usuario: $scope.usuarios
        }
        $scope.index(fields);

    }

    $scope.filtros_usuarios = function(){
        var fields = {
           mes:     $scope.meses
          ,anio:    $scope.anio
          ,usuario: $scope.usuarios
        }
        $scope.index(fields);
    
    }

    $scope.check_meses = function(){
        var fecha = new Date();
        var mes = (fecha.getMonth() +1);
        $scope.meses = mes;
        for(var i in $scope.filtro){
          if ($scope.filtro[i].id == mes ) {
              $scope.filtro[i].class = "active";
          }
        }
    
    }
    $scope.select_anios = function(){
        $scope.anio = masterservice.select_anios().anio;
        $scope.cmb_anios = masterservice.select_anios().cmb_anios;
        console.log($scope.cmb_anios);
    
    }
    $scope.see_reporte = function( data ){

        jQuery.fancybox.open({
            'type': 'iframe'
            ,'src': domain( url_see_report+"/"+data.id )
            ,'buttons' : ['share', 'close']
        });

    }
    $scope.send_reporte = function(data){

        $scope.correo.email        = data.contactos.correo;
        $scope.correo.name         = data.contactos.nombre_completo;
        $scope.correo.mensaje      = "Se le hace el envio de su solicitud";
        $scope.correo.asunto       = "Confirmar Solicitud";
        $scope.correo.id_pedido    = data.id;

        jQuery.fancybox.open({
            'type'      : 'inline'
            ,'src'      : "#modal_correo_send"
            ,'modal'    : true
            ,'width'    : 900
            ,'height'   : 500
            ,'autoSize' : false
        });

    }
    $scope.send_correo = function(){

        var url = domain( URL.url_send_correo );
        var fields = $scope.correo;
        MasterController.request_http(url,fields,'post',$http, false )
        .then(function( response ){
            masterservice.session_status( URL );
            toastr.success( "Se envio el correo correctamente" , title ); 
            jQuery.fancybox.close({
                'type'      : 'inline'
                ,'src'      : "#modal_correo_send"
                ,'modal'    : true
                ,'width'    : 900
                ,'height'   : 500
                ,'autoSize' : false
            });           
            $scope.correo = {};
        }).catch(function( error ){
            masterservice.session_status( {},error );
            console.error( error );
            toastr.error( error.result , expired );
        }); 

    }

});

jQuery(".add").fancybox({ 
  modal: true ,width: 800 ,height: 600,autoSize: false
});














/*new Vue({
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
            this.datos = response.data.result;
            console.log(this.datos);
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
});*/

/*jQuery(".add").fancybox({ modal: true });
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
jQuery('.fecha').datepicker( {format: 'yyyy-mm-dd' ,autoclose: true ,firstDay: 1}).datepicker("setDate", new Date());*/