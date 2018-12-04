const URL = {

  url_insert           : "productos/register"
  ,url_update          : "productos/update"
  ,url_edit            : "productos/edit"
  ,url_destroy         : "productos/destroy"
  ,url_all             : "productos/all"
  ,redireccion         : "configuracion/productos"
  ,url_display         : "productos/display_sucursales"
  ,url_insert_permisos : "productos/register_permisos"
  ,url_unidades        : 'unidadesmedidas/edit'
  ,url_edit_tipo       : "tasa/factor_tasa"
  ,url_edit_tasa       : "impuesto/clave_impuesto"
  ,url_upload          : 'upload/files'

}

app.controller('ProductosController', function( masterservice ,$scope, $http, $location ) {
    /*se declaran las propiedades dentro del controller*/
    $scope.constructor = function(){
        $scope.datos  = [];
        $scope.insert = {estatus: 1};
        $scope.update = {};
        $scope.edit   = {};
        $scope.fields = {};
        $scope.cmb_estatus = [{id: 0 ,descripcion:"Inactivo"},{id: 1 ,descripcion :"Activo"}];
        $scope.index();
    }

    $scope.index = function(){
        var url = domain( URL.url_all );
        var fields = {};
        MasterController.request_http(url,fields,'get',$http, false )
        .then(function(response){
            $scope.datos = response.data.result;
            loading(true);
        }).catch(function(error){
            masterservice.session_status({},error);
        });
    }
    
    $scope.insert_register = function(){

        var validacion = {
             'CODIGO'       : $scope.insert.codigo
            ,'PRODUCTOS'    : $scope.insert.nombre
            ,'DESCRIPCION'  : $scope.insert.descripcion
          };
        if(validaciones_fields(validacion)){return;}
        var url = domain( URL.url_insert );
        var fields = $scope.insert;
        MasterController.request_http(url,fields,'post',$http, false )
        .then(function( response ){
            toastr.success( response.data.message , title );
            jQuery.fancybox.close({
                'type'      : 'inline'
                ,'src'      : "#modal_add_register"
                ,'modal'    : true
                ,'width'    : 900
                ,'height'   : 400
                ,'autoSize' : false
            });
            $scope.index();
            for(var i in $scope.insert){ $scope.insert[i] = ""; }
        }).catch(function( error ){
            masterservice.session_status({},error);
        });
    }
    $scope.update_register = function(){

      var validacion = {
             'CODIGO'       : $scope.update.codigo
            ,'PRODUCTOS'    : $scope.update.nombre
            ,'DESCRIPCION'  : $scope.update.descripcion
          };
      if(validaciones_fields(validacion)){return;}
      var url = domain( URL.url_update );
      var fields = $scope.update;
      MasterController.request_http(url,fields,"put",$http, false )
      .then(function( response ){
          toastr.info( response.data.message , title );
          jQuery.fancybox.close({
                'type'      : 'inline'
                ,'src'      : "#modal_edit_register"
                ,'modal'    : true
                ,'width'    : 900
                ,'height'   : 400
                ,'autoSize' : false
            });
          jQuery('#tr_'+$scope.update.id).effect("highlight",{},5000);
          $scope.index();
      }).catch(function( error ){
          masterservice.session_status({},error);
      });
    
    }

    $scope.edit_register = function( data ){

      var datos = ['empresas','categorias','unidades','updated_at','created_at','$$hashKey'];
      $scope.update = iterar_object(data,datos);
      var html = '';
      html = '<img class="img-responsive" src="'+$scope.update.logo+'?'+Math.random()+'" height="268px" width="200px">'
      jQuery('#imagen_edit').html("");        
      jQuery('#imagen_edit').html(html);

      jQuery.fancybox.open({
          'type'      : 'inline'
          ,'src'      : "#modal_edit_register"
          ,'modal'    : true
      });
      $scope.tipo_factor(1);
      $scope.clave_impuesto(1);
      console.log($scope.update);
    
    }

    $scope.destroy_register = function( id ){

      var url = domain( URL.url_destroy );
      var fields = {id : id };
      buildSweetAlertOptions("¿Borrar Registro?","¿Realmente desea eliminar el registro?",function(){
        MasterController.request_http(url,fields,'delete',$http, false )
        .then(function( response ){
            toastr.success( response.data.message , title );
            $scope.index();
        }).catch(function( error ){
            masterservice.session_status({},error);
        });
          
      },"warning",true,["SI","NO"]);  
    
    }

    $scope.total_concepto = function(){

        var iva = ($scope.insert.iva) ? $scope.insert.iva : 0;
        var subtotal = ($scope.insert.subtotal) ? $scope.insert.subtotal : 0;
        //var impuesto = parseFloat( subtotal * iva / 100);
        console.log(iva);
        console.log(subtotal);
        var impuesto = parseFloat( subtotal * iva );
        $scope.insert.total = parseFloat(parseFloat( subtotal ) + parseFloat(impuesto)).toFixed(2);
        console.log($scope.insert.total);
    
    }

    $scope.total_concepto_edit = function() {

        var iva = ($scope.update.iva) ? $scope.update.iva : 0;
        var subtotal = ($scope.update.subtotal) ? $scope.update.subtotal : 0;
        //var impuesto = parseFloat( subtotal * iva / 100);
        console.log(iva);
        console.log(subtotal);
        var impuesto = parseFloat( subtotal * iva );
        $scope.update.total = parseFloat(parseFloat( subtotal ) + parseFloat(impuesto)).toFixed(2);
        console.log($scope.update.total);
    
    }

    $scope.display_sucursales = function( id ) {

       var id_empresa = jQuery('#cmb_empresas_'+id).val().replace('number:','');
       var url = domain( URL.url_display );
       var fields = { 
           id_empresa : id_empresa
           ,id_producto : id
       };
       $scope.fields.id_empresa = id_empresa;
       $scope.fields.id_producto = id;
       MasterController.request_http(url, fields, "get", $http ,false)
       .then(response => {
           jQuery('#sucursal_empresa').html(response.data.result.tabla_sucursales);
           jQuery.fancybox.open({
               'type': 'inline',
               'src':  "#permisos",
               'buttons': ['share', 'close']
           });
           for (var i = 0; i < response.data.result.sucursales.length; i++) {
               console.log(response.data.result.sucursales[i].id_sucursal);
               jQuery(`#${response.data.result.sucursales[i].id_sucursal}`).prop('checked', true);
           };
       }).catch(error => {
          masterservice.session_status({},error); 
       });

    }

    $scope.insert_permisos = function(){

        var matrix = [];
        var i = 0;
        jQuery('#sucursales input[type="checkbox"]').each(function () {
            if (jQuery(this).is(':checked') == true) {
                var id = jQuery(this).attr('id_sucursal');
                matrix[i] = `${id}|${jQuery(this).is(':checked')}`;
                i++;
            }
        });
        var url = domain( URL.url_insert_permisos);
        var fields = {
            'matrix' : matrix
            , 'id_empresa': $scope.fields.id_empresa
            , 'id_producto': $scope.fields.id_producto
        }
        MasterController.request_http(url, fields, "post", $http, false )
        .then(response => {

            jQuery.fancybox.close({
                'type': 'inline',
                'src': "#permisos",
                'buttons': ['share', 'close']
            });
            jQuery('#tr_'+$scope.fields.id_producto).effect("highlight",{},5000);
            $scope.index();

        }).catch(error => {
            masterservice.session_status({},error);
        });

    }

    $scope.tipo_factor = function( update = false){

      var url = domain( URL.url_edit_tipo );
      var fields = {id : (update)?$scope.update.id_tipo_factor:$scope.insert.id_tipo_factor };
      MasterController.request_http(url,fields,'get',$http, false )
        .then(function( response ){
            $scope.cmb_tasas = response.data.result;
            loading(true);
        }).catch(function( error ){
           masterservice.session_status({},error);
        });
    
    }
    $scope.clave_impuesto = function( update = false ){

      var url = domain( URL.url_edit_tasa );
      var fields = {id : (update)? $scope.update.id_tasa: $scope.insert.id_tasa };
      
      MasterController.request_http(url,fields,'get',$http, false )
        .then(function( response ){
            $scope.cmb_impuestos = response.data.result.response;
            if (update) {
              $scope.update.iva = response.data.result.valor_maximo;
            }else{
              $scope.insert.iva = response.data.result.valor_maximo;
            }
            loading(true);
        }).catch(function( error ){
            masterservice.session_status({},error);
        });
    
    }

    $scope.upload_file = function(update){

      var upload_url = domain( URL.url_upload );
      var identificador = {
        div_content   : 'div_dropzone_file_productos',
        div_dropzone  : 'dropzone_xlsx_file_productos',
        file_name     : 'file'
      };
      var message = "Dar Clíc aquí o arrastrar archivo";
      $scope.update.logo = "";
      upload_file({'nombre': 'producto_'+$scope.update.id },upload_url,message,1,identificador,'.png',function( request ){
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

    }

});
