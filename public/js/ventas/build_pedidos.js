const URL = {
    url_insert             :  "pedidos/register"
    ,url_update             :  "pedidos/update"
    ,url_edit               :  "pedidos/edit"
    ,url_destroy            :  "pedidos/destroy"
    ,url_destroy_conceptos  :  "pedidos/destroy_concepto"
    ,url_all                :  "pedidos/all"
    ,url_see_report         :  "pedidos/reportes"
    ,url_send_correo        :  "pedidos/correo"
    ,redireccion            :  "ventas/pedidos"
    ,url_edit_clientes      :  "clientes/edit"
    ,url_edit_contactos     :  "contactos/edit"
    ,url_edit_productos     :  "productos/edit"
    ,url_edit_planes        :  "planes/edit"
    ,url_insert_factura     :  "facturaciones/insert"
} 

app.controller('PedidosController', function( masterservice, $scope, $http, $location ) {
    
    $scope.constructor = function(){
        $scope.datos  = [];
        $scope.insert = {
          id_forma_pago: 1, id_estatus: 6 ,id_metodo_pago : 1 , id_moneda : 100
        };
        $scope.insertar = {};
        $scope.update = {};
        $scope.edit   = {};
        $scope.fields = {};
        $scope.correo = {
          asunto: "Envio de Pedido"
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
            if(masterservice.session_status( response )){return;};
            loading(true);

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
           console.log(response.data.result);
          if (update) {
            $scope.update.id        = response.data.result.pedidos.id;
            $scope.update.subtotal  = response.data.result.subtotal_;
            $scope.update.iva       = response.data.result.iva_;
            $scope.update.total     = response.data.result.total_;
          }else{
            $scope.insert.id        = response.data.result.pedidos.id;
            $scope.insert.subtotal  = response.data.result.subtotal_;
            $scope.insert.iva       = response.data.result.iva_;
            $scope.insert.total     = response.data.result.total_;
            
          }

            $scope.table_concepts   = response.data.result.pedidos.conceptos;
            $scope.subtotal = response.data.result.subtotal;
            $scope.iva      = response.data.result.iva;
            $scope.total    = response.data.result.total;
            loading(true);
        }).catch(function(error){
            masterservice.session_status({},error);
        });

    }

    $scope.insert_register = function( update = false ){

        var url = domain( URL.url_insert );
        $scope.insertar.pedidos = (update)? $scope.update :$scope.insert;
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
          pedidos     : $scope.insertar.pedidos
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
            loading(true);
            //not remove function this is  verify the session
            if(masterservice.session_status( response )){return;};

            //toastr.success( response.data.message , title );
            console.log(response.data.result);
            if(update){
                $scope.conceptos(update);
            }else{
              $scope.insert.id        = response.data.result.pedidos.id;
              $scope.insert.subtotal  = response.data.result.subtotal_;
              $scope.insert.iva       = response.data.result.iva_;
              $scope.insert.total     = response.data.result.total_;
              $scope.table_concepts   = response.data.result.pedidos.conceptos;
              $scope.subtotal         = response.data.result.subtotal;
              $scope.iva              = response.data.result.iva;
              $scope.total            = response.data.result.total;
            }
            $scope.products = {};
        }).catch(function( error ){
            masterservice.session_status({},error);
        });

    }

    $scope.update_register = function( update = false ){

        jQuery('.update').prop('disabled',true);
        $scope.insertar.pedidos = (update)? $scope.update : $scope.insert;                        
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
          var fields = {pedidos : $scope.insertar.pedidos };
          MasterController.request_http(url,fields,'put',$http, false )
          .then(function( response ){
              //not remove function this is  verify the session
              if(masterservice.session_status( response )){return;};
              
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
                mes: $scope.meses
                ,anio: $scope.anio
                ,usuarios: $scope.usuarios
              }
              $scope.index(data);
              if(response.data.result.pedidos.id_estatus == 5){
                  $scope.update = response.data.result;
                  $scope.insert_facturacion();
              }
              if (update) {
                $scope.update = {}
              }else{
                $scope.insert = {}
                buildSweetAlert('# '+response.data.result.pedidos.id,'Se genero el pedido con exito','success');
              }
              $scope.fields = {}
              $scope.products = {}
              $scope.table_concepts = {}
              $scope.subtotal = "$ 0.00";
              $scope.iva = "$ 0.00";
              $scope.total = "$ 0.00";
              jQuery('.update').prop('disabled',false);

          }).catch(function( error ){
              masterservice.session_status({},error);
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
            //not remove function this is  verify the session
            if(masterservice.session_status( response )){return;};
            
            if(!cancel){
              toastr.success( response.data.message , title );
            }
            var data = {
                mes: $scope.meses
                ,anio: $scope.anio
              }
            $scope.index(data);
        }).catch(function( error ){
            masterservice.session_status({},error);
        });
          
      },"warning",true,["SI","NO"]);  
    
    }

    $scope.destroy_concepto = function( id , update = false ){

        var url = domain( URL.url_destroy_conceptos );
        var fields = {id : id };

        MasterController.request_http(url,fields,'delete',$http, false )
        .then(function( response ){
              //not remove function this is  verify the session
              if(masterservice.session_status( response )){return;};
              
              $scope.conceptos(update);
        }).catch(function( error ){
            masterservice.session_status({},error);
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
            //not remove function this is  verify the session
            if(masterservice.session_status( response )){return;};

            $scope.cmb_contactos = response.data.result.contactos;
            $scope.fields.rfc = response.data.result.rfc_receptor
            $scope.fields.nombre_comercial = response.data.result.nombre_comercial
            $scope.fields.telefono_empresa = response.data.result.telefono
            console.log(response);
            loading(true);
        }).catch(function( error ){
            masterservice.session_status({},error);
        });

    }

    $scope.change_contactos = function( update = false ){

      var url = domain( URL.url_edit_contactos );
      var fields = {id : (update)? $scope.update.id_contacto : $scope.insert.id_contacto };

      MasterController.request_http(url,fields,"get",$http, false )
        .then(function( response ){
            //not remove function this is  verify the session
            if(masterservice.session_status( response )){return;};

            $scope.fields.telefono = response.data.result.telefono
            $scope.fields.correo = response.data.result.correo
            console.log(response);
            loading(true);
        }).catch(function( error ){
            masterservice.session_status({},error);
        });
    
    }

    $scope.display_productos = function( update = false){

      var url = domain( URL.url_edit_productos );
      var fields = {id : (update)? $scope.products.id_producto : $scope.products.id_producto};

      MasterController.request_http(url,fields,"get",$http, false )
        .then(function( response ){
            //not remove function this is  verify the session
            if(masterservice.session_status( response )){return;};

            $scope.products.id_plan = null;
            $scope.products.precio = response.data.result.total;
            $scope.products.descripcion = response.data.result.descripcion;
            $scope.products.cantidad = 0;
            $scope.products.total = 0;
            console.log(response);
            loading(true);
        }).catch(function( error ){
            masterservice.session_status({},error);
        });

    }

    $scope.display_planes = function ( update = false ){

      var url = domain( URL.url_edit_planes );
      var fields = {id : (update)? $scope.products.id_plan : $scope.products.id_plan};

      MasterController.request_http(url,fields,"get",$http, false )
        .then(function( response ){
            //not remove function this is  verify the session
            if(masterservice.session_status( response )){return;};

            $scope.products.id_producto = null;
            $scope.products.precio = response.data.result.total;
            $scope.products.descripcion = response.data.result.descripcion;
            $scope.products.cantidad = 0;
            $scope.products.total = 0;
            console.log(response);
            loading(true);
        }).catch(function( error ){
            masterservice.session_status({},error);
        });

    }
    
    $scope.calcular_suma = function( update = false ){
        var precio = ($scope.products.precio != "") ? $scope.products.precio : 0;
        var cantidad = ($scope.products.cantidad != "") ? $scope.products.cantidad: 0;
        var total  = parseFloat(precio * cantidad);
        $scope.products.total = total.toFixed(2);

    }

    $scope.insert_facturacion = function(){

      var url = domain( URL.url_insert_factura );
      var fields = $scope.update.pedidos;
      MasterController.request_http(url,fields,'post',$http, false )
      .then( response => {
          buildSweetAlertOptions("Serie: A Folio: "+response.data.result.id,"Se genero la factura para timbrar",function(){
              redirect(domain("ventas/facturaciones"));
          },"success",false,["OK",""]);   
      }).catch( error => {
          masterservice.session_status({},error); 
      });

    }

    $scope.format_date = function( request, format ){

        return masterservice.format_date(request,format);

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
        var fecha = new Date();
        var year = (fecha.getFullYear());
        var select = [];
        var cont = 1;
        //console.log(year);return;
        for (var i = year; i >= 2000; i--) {
            select[cont] = { id: i ,descripcion: i };
            cont++;
        }
        $scope.anio = select[1].id;
        $scope.cmb_anios = select;
        console.log($scope.cmb_anios);

    }

    $scope.see_reporte = function( data ){

        jQuery.fancybox.open({
            'type': 'iframe'
            ,'src': domain( URL.url_see_report+"/"+data.id )
            ,'buttons' : ['share', 'close']
        });

    }

    $scope.send_reporte = function(data){

        $scope.correo.email        = data.contactos.correo;
        $scope.correo.name         = data.contactos.nombre_completo;
        $scope.correo.mensaje      = "Se le hace el envio de su solicitud";
        $scope.correo.asunto       = "Confirmar Solicitud";
        $scope.correo.id_pedido    = data.id;
        //$scope.correo.descripcion = "Es ";
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
        jQuery.fancybox.close({
            'type'      : 'inline'
            ,'src'      : "#modal_correo_send"
            ,'modal'    : true
            ,'width'    : 900
            ,'height'   : 500
            ,'autoSize' : false
        });
        var url = domain( URL.url_send_correo );
        var fields = $scope.correo;
        MasterController.request_http(url,fields,'post',$http, false )
        .then(function( response ){
            //not remove function this is  verify the session
            if(masterservice.session_status( response )){return;};

            $scope.index();
            toastr.success( "Se envio el correo correctamente" , title ); 
            $scope.correo = {};
        }).catch(function( error ){
            masterservice.session_status({},error);
        }); 

    }

    $scope.update_estatus = function(id, estatus){
        
        var url = domain( URL.url_update );
        var fields = { pedidos : {id: id ,id_estatus : estatus } };

        buildSweetAlertOptions("¿Cambiar Estatus?","¿Realmente desea cambiar el estatus del pedido?",function(){
            
            MasterController.request_http(url,fields,'put',$http, false )
            .then(function( response ){
              //not remove function this is  verify the session
              if(masterservice.session_status( response )){return;};

              toastr.info( response.data.message , title );
              jQuery('#tr_'+id ).effect("highlight",{},5000);
              var data = {
                mes: $scope.meses ,anio: $scope.anio ,usuarios : $scope.usuarios
              }
              $scope.index(data);
              
              if(response.data.result.pedidos.id_estatus == 5){
                  $scope.update = response.data.result;
                  $scope.insert_facturacion();
              }

              }).catch(function( error ){
                  masterservice.session_status({},error);
              });
          
        },"warning",true,["SI","NO"]); 

    }


    /*$scope.upload_file = function(update){

      var upload_url = domain( url_upload );
      var identificador = {
         div_content   : 'div_dropzone_file_empresas'
        ,div_dropzone  : 'dropzone_xlsx_file_empresas'
        ,file_name     : 'file'
      };
      var message = "Dar Clíc aquí o arrastrar archivo";
      $scope.update.logo = "";
      upload_file({'nombre': 'empresas_'+$scope.update.id },upload_url,message,1,identificador,'.png',function( request ){
          if(update){
            $scope.update.logo = domain(request.result);
            var html = '';
            html = '<img class="img-responsive" src="'+$scope.update.logo+'?'+Math.random()+'" height="268px" width="200px">'
            jQuery('#imagen_edit').html("");        
            jQuery('#imagen_edit').html(html);        
          }else{
            $scope.insert.logo = domain(request.result);
            var html = '';
            html = '<img class="img-responsive" src="'+$scope.insert.logo+'" height="268px" width="200px">'
            jQuery('#imagen').html("");        
            jQuery('#imagen').html(html);        
            
          }
          jQuery.fancybox.close({
              'type'      : 'inline'
              ,'src'      : "#upload_file"
              ,'modal'    : true
          });
      });

      jQuery.fancybox.open({
          'type'      : 'inline'
          ,'src'      : "#upload_file"
          ,'modal'    : true
      });

    }*/

});


jQuery(".add").fancybox({ 
  modal: true ,width: 800 ,height: 600,autoSize: false
});