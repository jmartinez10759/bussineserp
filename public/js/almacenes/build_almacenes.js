const URL = {

 url_insert  : "almacenes/register"
, url_update   : "almacenes/update"
, url_edit     : "almacenes/edit"
, url_destroy  : "almacenes/destroy"
, url_all      : "almacenes/all"
, redireccion  : "configuracion/almacenes"
,url_asign_insert    : "almacenes/asing_insert"
,url_productos       : "almacenes/asing_producto"
,url_insert_permisos : "almacenes/register_permisos"
,url_display         : "almacenes/display_sucursales"
}

app.controller('AlmacenesController', function( masterservice, $scope, $http, $location ) {
    /*se declaran las propiedades dentro del controller*/
    $scope.constructor = function(){
        $scope.datos  = [];
        $scope.insert = {
          estatus: 1
        };
        $scope.update = {};
        $scope.edit   = {};
        $scope.fields = {};
        $scope.cmb_estatus = [{id:0 ,descripcion:"Baja"}, {id:1, descripcion:"Activo"}];
        $scope.index();
    }

    $scope.click = function (){
      $location.path("/register");
      //$scope.index();
    }
    
    $scope.index = function(){

        var url = domain( URL.url_all );
        var fields = {};
        MasterController.request_http(url,fields,'get',$http, false )
        .then(function(response){
            //not remove function this is  verify the session
            if(masterservice.session_status( response )){return;};
            // loading(true);
            $scope.datos = response.data.result;
            console.log($scope.datos);
        }).catch(function(error){
            masterservice.session_status_error(error); 
        });
    
    }
    $scope.insert_register = function(){

        
        var url = domain( URL.url_insert );
        var fields = $scope.insert;
        MasterController.request_http(url,fields,'post',$http, false )
        .then(function( response ){
          //not remove function this is  verify the session
            if(masterservice.session_status( response )){return;};
            toastr.success( response.data.message , title );
            jQuery.fancybox.close({
                'type'      : 'inline'
                ,'src'      : "#modal_add_register"
                ,'modal'    : true
                ,'width'    : 900
                ,'height'   : 400
                ,'autoSize' : false
            });
            $scope.insert = {};
            $scope.index();
        }).catch(function( error ){
            masterservice.session_status_error(error); 
        });

    }

    $scope.update_register = function(){     
      var url = domain( URL.url_update );
      var fields = $scope.update;
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
          
          // console.log($scope.update);return;
          $scope.index();
          jQuery('#tr_'+$scope.update.id).effect("highlight",{},5000);
          //redirect(domain(redireccion));
      }).catch(function( error ){
          masterservice.session_status_error(error); 
      });
    }

    $scope.edit_register = function( id ){

      var url = domain( URL.url_edit );
      var fields = {id : id };
      MasterController.request_http(url,fields,'get',$http, false )
        .then(function( response ){
            $scope.update = response.data.result;

          jQuery.fancybox.open({
                "type"      : "inline"
                ,"src"      : "#modal_edit_register"
                ,"modal"    : true
                ,"width"    : 900
                ,"height"   : 400
                ,"autoSize" : false
            });   
            loading(true);       
            // console.log($scope.edit);return;        
        }).catch(function( error ){
            masterservice.session_status_error(error); 
        });
    }

    $scope.destroy_register = function( id ){

      var url = domain( URL.url_destroy );
      var fields = {id : id };
      buildSweetAlertOptions("¿Borrar Registro?","¿Realmente desea eliminar el registro?",function(){
        MasterController.request_http(url,fields,'delete',$http, false )
        .then(function( response ){
          //not remove function this is  verify the session
            if(masterservice.session_status( response )){return;};
            toastr.success( response.data.message , title );
            $scope.index();
        }).catch(function( error ){
            masterservice.session_status_error(error); 
        });
          
      },"warning",true,["SI","NO"]);  
    }

    $scope.display_sucursales = function( id ) {

       var id_empresa = jQuery('#cmb_empresas_'+id).val().replace('number:','');
       var url = domain( URL.url_display );
       var fields = { 
           id_empresa : id_empresa
           ,id_almacen : id
       };
       $scope.fields.id_empresa = id_empresa;
       $scope.fields.id_almacen = id;
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
               jQuery(`#sucursal_${response.data.result.sucursales[i].id_sucursal}`).prop('checked', true);
           };
           $scope.index();
           // loading(true);
       }).catch(error => {
           masterservice.session_status_error(error); 

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
        var url = domain(URL.url_insert_permisos);
        var fields = {
            'matrix' : matrix
            , 'id_empresa': $scope.fields.id_empresa
            , 'id_almacen': $scope.fields.id_almacen
        }
        MasterController.request_http(url, fields, "post", $http, false )
        .then(response => {
          //not remove function this is  verify the session
            if(masterservice.session_status( response )){return;};
            //this.sucursales = response.data.result;
            jQuery.fancybox.close({
                'type': 'inline',
                'src': "#permisos",
                'buttons': ['share', 'close']
            });
            jQuery('#tr_'+$scope.fields.id_almacen).effect("highlight",{},5000);
            $scope.index();

        }).catch(error => {
            if( isset(error.response) && error.response.status == 419 ){
              toastr.error( session_expired ); 
              redirect(domain("/"));
              return;
            }
              toastr.error( error.data.result , expired );  

        });
        
    }
    $scope.asignar_producto = function( id ){
      
      var url = domain( URL.url_productos);
      var fields = {id : id };
        MasterController.request_http(url,fields,"get",$http, false )
      .then(function( response ){
        // console.log(response.data.result.productos);
          //not remove function this is  verify the session
          if(masterservice.session_status( response )){return;};

          $scope.fields.id_almacen = id;
          $.fancybox.open({
              'type': 'inline',
              'src': "#modal_asing_producto",
              'buttons': ['share', 'close']
          });
          jQuery('#datatable_productos input[type="checkbox"]').prop('checked',false);
          if(response.data.result.productos.length > 0){
              for (var i = 0; i < response.data.result.productos.length; i++) {
                    jQuery('#'+response.data.result.productos[i].id).prop('checked', true);
              };
          }

      }).catch(function( error ){
          masterservice.session_status_error(error);
      });
    
    }
    $scope.save_asign_producto = function(){

        var matrix = [];
        var i = 0;
        jQuery('#datatable_productos input[type="checkbox"]').each(function () {
            if (jQuery(this).is(':checked') == true) {
                var id = jQuery(this).attr('id_producto');
                matrix[i] = `${id}|${jQuery(this).is(':checked')}`;
                i++;
            }
        });
        var url = domain( URL.url_asign_insert);
        var fields = {
            'matrix' : matrix
            , 'id_almacen': $scope.fields.id_almacen
            // , 'id_proveedor' : $scope.fields.id_proveedor
        }
        
        MasterController.request_http(url, fields, "post", $http, false )
        .then(response => {
          //not remove function this is  verify the session
            if(masterservice.session_status( response )){return;};
            jQuery.fancybox.close({
                'type': 'inline',
                'src': "#permisos",
                'buttons': ['share', 'close']
            });
            $scope.index();
        }).catch(error => {
            masterservice.session_status_error(error); 
        });
    
    }

});