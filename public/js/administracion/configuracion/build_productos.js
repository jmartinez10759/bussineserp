var url_insert  = "productos/register";
var url_update   = "productos/update";
var url_edit     = "productos/edit";
var url_destroy  = "productos/destroy";
var url_all      = "productos/all";
var redireccion  = "configuracion/productos";
var url_display         = "productos/display_sucursales";
var url_insert_permisos = "productos/register_permisos";
var url_unidades        = 'unidadesmedidas/edit';
var url_edit_tipo       = "tasa/factor_tasa";
var url_edit_tasa       = "impuesto/clave_impuesto";

var app = angular.module('ng-productos', ["ngRoute"]);
app.controller('ProductosController', function( $scope, $http, $location ) {
    /*se declaran las propiedades dentro del controller*/
    $scope.constructor = function(){
        $scope.datos  = [];
        $scope.insert = {estatus: 1};
        $scope.update = {};
        $scope.edit   = {};
        $scope.fields = {};
        $scope.cmb_estatus = [{id: 0 ,descripcion:"Inactivo"},{id: 1 ,descripcion :"Activo"}];
        $scope.consulta_general();
    }

    $scope.consulta_general = function(){
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
        $scope.insert.id_categoria    = jQuery('#cmb_categorias').val();
        $scope.insert.id_servicio     = jQuery('#cmb_servicio').val();
        $scope.insert.id_impuesto     = jQuery('#cmb_impuestos').val();
        var url = domain( url_insert );
        var fields = $scope.insert;
        MasterController.request_http(url,fields,'post',$http, false )
        .then(function( response ){
            toastr.success( response.data.message , title );
            for(var i in $scope.insert){
               $scope.insert[i] = "";
            }
            //var values = ['cmb_empresas','cmb_sucursales','cmb_clientes_asignados','cmb_contactos','cmb_clientes','cmb_servicios'];
            $scope.constructor();
            //clear_values_select(values);
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
      $scope.update.id_categoria = jQuery('#cmb_categorias_edit').val();
      $scope.update.id_servicio = jQuery('#cmb_servicio_edit').val();
      $scope.update.id_impuesto = jQuery('#cmb_impuestos_edit').val();
      $scope.update.id_tipo_factor = jQuery('#cmb_tipofactor_edit').val();
      $scope.update.id_tasa = jQuery('#cmb_tasas_edit').val();
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
          $scope.constructor();
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
      jQuery('#cmb_unidades_edit').val($scope.update.id_unidadmedida).trigger("chosen:updated");
      jQuery('#cmb_categorias_edit').val($scope.update.id_categoria).trigger("chosen:updated");
      jQuery('#cmb_servicio_edit').val($scope.update.id_servicio).trigger("chosen:updated");
      jQuery('#cmb_impuestos_edit').val($scope.update.id_impuesto).trigger("chosen:updated");
      jQuery('#cmb_tipofactor_edit').val($scope.update.id_tipo_factor).trigger("chosen:updated");
      jQuery('#cmb_tasas_edit').val($scope.update.id_tasa).trigger("chosen:updated");
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
            $scope.constructor();
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

    $scope.parser_iva = function(){
      console.log($scope.insert.tasa);
    }

    $scope.display_sucursales = function( id ) {
       var id_empresa = jQuery('#cmb_empresas_'+id).val().replace('number:','');
       var url = domain( url_display );
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
            , 'id_producto': $scope.fields.id_producto
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
            $scope.constructor();
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
});

jQuery('#cmb_servicio').chosen({width: "100%"}).trigger("chosen:updated");;
jQuery('#cmb_servicio_edit').chosen({width: "100%"}).trigger("chosen:updated");;
jQuery('#cmb_categorias').chosen({width: "100%"}).trigger("chosen:updated");;
jQuery('#cmb_categorias_edit').chosen({width: "100%"}).trigger("chosen:updated");
jQuery('#cmb_unidades').chosen({width: "100%"}).trigger("chosen:updated");;
jQuery('#cmb_unidades_edit').chosen({width: "100%"}).trigger("chosen:updated");;