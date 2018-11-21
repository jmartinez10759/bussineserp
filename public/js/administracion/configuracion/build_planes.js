var url_insert  = "planes/register";
var url_update   = "planes/update";
var url_edit     = "planes/edit";
var url_destroy  = "planes/destroy";
var url_all      = "planes/all";
var redireccion  = "configuracion/planes";
var url_productos       = "planes/asing_producto";
var url_asign_insert    = "planes/asing_insert";
var url_unidades        = 'unidadesmedidas/edit';
var url_display         = "planes/display_sucursales";
var url_insert_permisos = "planes/register_permisos";
var url_edit_tipo       = "tasa/factor_tasa";
var url_edit_tasa       = "impuesto/clave_impuesto";

var app = angular.module('ng-planes', ["ngRoute"]);
app.controller('planesController', function( $scope, $http, $location ) {
    /*se declaran las propiedades dentro del controller*/
    $scope.constructor = function(){
        $scope.datos  = [];
        $scope.insert = {
          estatus: 1
          ,id_tipo_factor: 1
          ,id_impuesto: 0 
        };
        $scope.update = {};
        $scope.edit   = {};
        $scope.fields = {};
        $scope.cmb_estatus = [{id: 0 ,descripcion:"Inactivo"},{id: 1 ,descripcion :"Activo"}];
        $scope.cmb_tasas = [{id: 0 ,clave:"Seleccione una Opcion"}];
        $scope.cmb_impuestos = [{ id: 0,descripcion:"Seleccione una Opcion" }];
        $scope.index();
        $scope.tipo_factor();
    }

    $scope.index = function(){
        var url = domain( url_all );
        var fields = {};
        MasterController.request_http(url,fields,'get',$http, false )
        .then(function(response){
            $scope.datos = response.data.result;
        }).catch(function(error){
            if( isset(error.response) && error.response.status == 419 ){
                  toastr.error( session_expired ); 
                  redirect(domain("/"));
                  return;
              }
              console.error(error);
              toastr.error( error.message , expired );
        });
    }
    
    $scope.insert_register = function(){

        $scope.insert.id_unidadmedida = jQuery('#cmb_unidades').val();
        $scope.insert.id_servicio     = jQuery('#cmb_servicio').val();
        var url = domain( url_insert );
        var fields = $scope.insert;
        MasterController.request_http(url,fields,'post',$http, false )
        .then(function( response ){
            toastr.success( response.data.message , title );
            for(var i in $scope.insert){
               $scope.insert[i] = "";
            }
            var values = ['cmb_servicios','cmb_unidades'];
            $scope.index();
            clear_values_select(values);
            jQuery.fancybox.close({
                'type'      : 'inline'
                ,'src'      : "#modal_add_register"
                ,'modal'    : true
                ,'width'    : 900
                ,'height'   : 400
                ,'autoSize' : false
            });
        }).catch(function( error ){
            if( isset(error.response) && error.response.status == 419 ){
                  toastr.error( session_expired ); 
                  redirect(domain("/"));
                  return;
              }
              console.error( error );
              toastr.error( error.data.result , expired );
        });
    }

    $scope.update_register = function(){
      var url = domain( url_update );
      $scope.update.id_unidadmedida = jQuery('#cmb_unidades_edit').val();
      $scope.update.id_servicio = jQuery('#cmb_servicio_edit').val();
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
          if( isset(error.response) && error.response.status == 419 ){
                toastr.error( session_expired ); 
                redirect(domain("/"));
                return;
            }
            console.error( error );
            toastr.error( error.result , expired );
      });
    }

    $scope.edit_register = function( data ){
      var datos = ['empresas','categorias','unidades','updated_at','created_at','$$hashKey'];
      $scope.update = iterar_object(data,datos);
      $scope.tipo_factor_edit();
      $scope.clave_impuesto_edit();
      jQuery('#cmb_unidades_edit').val($scope.update.id_unidadmedida).trigger("chosen:updated");
      jQuery('#cmb_servicio_edit').val($scope.update.id_servicio).trigger("chosen:updated");
      jQuery.fancybox.open({
          'type'      : 'inline'
          ,'src'      : "#modal_edit_register"
          ,'modal'    : true
      });
      console.log($scope.update);
    }

    $scope.destroy_register = function( id ){

      var url = domain( url_destroy );
      var fields = {id : id };
      buildSweetAlertOptions("¿Borrar Registro?","¿Realmente desea eliminar el registro?",function(){
        MasterController.request_http(url,fields,'delete',$http, false )
        .then(function( response ){
            toastr.success( response.data.message , title );
            $scope.index();
        }).catch(function( error ){
            if( isset(error.response) && error.response.status == 419 ){
                  toastr.error( session_expired ); 
                  redirect(domain("/"));
                  return;
              }
              console.error( error );
              toastr.error( error.data.result , expired );
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
    },

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
       var url = domain( url_display );
       var fields = { 
           id_empresa : id_empresa
           ,id_plan : id
       };
       $scope.fields.id_empresa = id_empresa;
       $scope.fields.id_plan = id;
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
           if( isset(error.response) && error.response.status == 419 ){
            toastr.error( session_expired ); 
            redirect(domain("/"));
            return;
          }
            console.error(error);
            toastr.error( error.result , expired );  

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
        var url = domain(url_insert_permisos);
        var fields = {
            'matrix' : matrix
            , 'id_empresa': $scope.fields.id_empresa
            , 'id_plan': $scope.fields.id_plan
        }
        //console.log(fields);return;
        MasterController.request_http(url, fields, "post", $http, false )
        .then(response => {
            //this.sucursales = response.data.result;
            jQuery.fancybox.close({
                'type': 'inline',
                'src': "#permisos",
                'buttons': ['share', 'close']
            });
            $scope.index();
        }).catch(error => {
            if( isset(error.response) && error.response.status == 419 ){
              toastr.error( session_expired ); 
              redirect(domain("/"));
              return;
            }
            console.error(error);
              toastr.error( error.result , expired );  

        });

    }

    $scope.asignar_producto = function( id ){
      
      var url = domain( url_productos);
      var fields = {id : id };
        MasterController.request_http(url,fields,"get",$http, false )
      .then(function( response ){
          $scope.fields.id_plan = id;
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
          if( isset(error.response) && error.response.status == 419 ){
                toastr.error( session_expired ); 
                redirect(domain("/"));
                return;
            }
            console.error( error );
            toastr.error( error.result , expired );
      });
    }

    $scope.save_asign_producto = function(){
        console.log($scope.fields.id_plan);

        var matrix = [];
        var i = 0;
        jQuery('#datatable_productos input[type="checkbox"]').each(function () {
            if (jQuery(this).is(':checked') == true) {
                var id = jQuery(this).attr('id_producto');
                matrix[i] = `${id}|${jQuery(this).is(':checked')}`;
                i++;
            }
        });
        var url = domain(url_asign_insert);
        var fields = {
            'matrix' : matrix
            , 'id_plan': $scope.fields.id_plan
        }
        //console.log(fields);return;
        MasterController.request_http(url, fields, "post", $http, false )
        .then(response => {
            //this.sucursales = response.data.result;
            jQuery.fancybox.close({
                'type': 'inline',
                'src': "#permisos",
                'buttons': ['share', 'close']
            });
            $scope.index();
        }).catch(error => {
            if( isset(error.response) && error.response.status == 419 ){
              toastr.error( session_expired ); 
              redirect(domain("/"));
              return;
            }
            console.error(error);
              toastr.error( error.result , expired );  

        });
    }

    $scope.tipo_factor = function(){
      var url = domain( url_edit_tipo );
      var fields = {id : $scope.insert.id_tipo_factor };
      $scope.cmb_tasas = [{id: 0 ,clave:"Seleccione una Opcion"}];
      $scope.cmb_impuestos = [{id: 0 ,descripcion:"Seleccione una Opcion"}];
      MasterController.request_http(url,fields,'get',$http, false )
        .then(function( response ){
            $scope.cmb_tasas = response.data.result;
        }).catch(function( error ){
            if( isset(error.response) && error.response.status == 419 ){
                  toastr.error( session_expired ); 
                  redirect(domain("/"));
                  return;
              }
              console.error( error );
              toastr.error( error.result , expired );
        });
    }

    $scope.clave_impuesto = function(){
      var url = domain( url_edit_tasa );
      var fields = {id : $scope.insert.id_tasa };
      MasterController.request_http(url,fields,'get',$http, false )
        .then(function( response ){
            $scope.cmb_impuestos = response.data.result.response;
            $scope.insert.iva = response.data.result.valor_maximo;
            jQuery('.cmb_impuestos').prop('disabled',false);
        }).catch(function( error ){
            if( isset(error.response) && error.response.status == 419 ){
                  toastr.error( session_expired ); 
                  redirect(domain("/"));
                  return;
              }
              console.error( error );
              toastr.error( error.result , expired );
        });
    }

    $scope.tipo_factor_edit = function(){
      var url = domain( url_edit_tipo );
      var fields = {id : $scope.update.id_tipo_factor };
      /*$scope.cmb_tasas = [{id: 0 ,clave:"Seleccione una Opcion"}];
      $scope.cmb_impuestos = [{id: 0 ,descripcion:"Seleccione una Opcion"}];*/
      MasterController.request_http(url,fields,'get',$http, false )
        .then(function( response ){
            $scope.cmb_tasas = response.data.result;
        }).catch(function( error ){
            if( isset(error.response) && error.response.status == 419 ){
                  toastr.error( session_expired ); 
                  redirect(domain("/"));
                  return;
              }
              console.error( error );
              toastr.error( error.result , expired );
        });
    }

    $scope.clave_impuesto_edit = function(){

      var url = domain( url_edit_tasa );
      var fields = {id : $scope.update.id_tasa };
      MasterController.request_http(url,fields,'get',$http, false )
        .then(function( response ){
            $scope.cmb_impuestos = response.data.result.response;
            $scope.update.iva = response.data.result.valor_maximo;
            jQuery('.cmb_impuestos').prop('disabled',false);
        }).catch(function( error ){
            if( isset(error.response) && error.response.status == 419 ){
                  toastr.error( session_expired ); 
                  redirect(domain("/"));
                  return;
              }
              console.error( error );
              toastr.error( error.result , expired );
        });
    }

});



/*jQuery('#cmb_servicio').chosen({width: "100%"}).trigger("chosen:updated");
jQuery('#cmb_servicio_edit').chosen({width: "100%"}).trigger("chosen:updated");
jQuery('#cmb_unidades').chosen({width: "100%"}).trigger("chosen:updated");
jQuery('#cmb_unidades_edit').chosen({width: "100%"}).trigger("chosen:updated");*/