var url_insert              = "cuentas/register";
var url_update              = "cuentas/update";
var url_edit                = "cuentas/edit";
var url_destroy             = "cuentas/destroy";
var url_all                 = "cuentas/all";
var url_display_clientes    = "empresas/edit";
var url_display_contactos   = "clientes/edit";
var redireccion             = "configuracion/cuentas";

var app = angular.module('ng-cuentas', ["ngRoute"]);
app.config(function( $routeProvider, $locationProvider ) {
    $routeProvider
    .when("/register", {
        controller : "PruebasController",
        template : "<h1>Rayos esto necesita un template</h1>",
    })
    .when("/london", {
        template : "<h1> Bienvenidos 2</h1>",
        //controller : "londonCtrl"
    })
    .when("/paris", {
        templateUrl : "paris.htm",
        controller : "parisCtrl"
    });
    $locationProvider.html5Mode(true); //activamos el modo HTML5
});
app.controller('CuentasController', function( $scope, $http, $location ) {
    /*se declaran las propiedades dentro del controller*/
    $scope.constructor = function(){
        $scope.datos  = [];
        $scope.insert = { estatus: "1" };
        $scope.update = {};
        $scope.edit   = {};
        $scope.fields = {};
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
        var validacion = ['cmb_empresas','cmb_sucursales'];
        if(validacion_fields(validacion) == "error"){return;}
        $scope.insert.empresa     = jQuery('#cmb_empresas').val();
        $scope.insert.sucursal    = jQuery('#cmb_sucursales').val();
        $scope.insert.clientes    = jQuery('#cmb_clientes_asignados').val();
        $scope.insert.contacto    = jQuery('#cmb_contactos').val();
        $scope.insert.id_cliente  = jQuery('#cmb_clientes').val();
        $scope.insert.id_servicio = jQuery('#cmb_servicios').val();
        var url = domain( url_insert );
        var fields = $scope.insert;
        MasterController.request_http(url,fields,'post',$http, false )
        .then(function( response ){
            toastr.success( response.data.message , title );
            $scope.insert = {};
            var values = ['cmb_empresas','cmb_sucursales','cmb_clientes_asignados','cmb_contactos','cmb_clientes','cmb_servicios'];
            $scope.constructor();
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

      var validacion = ['cmb_empresas_edit','cmb_sucursales_edit'];
        if(validacion_fields(validacion) == "error"){return;}
        $scope.update             = $scope.edit;
        $scope.update.empresa     = jQuery('#cmb_empresas_edit').val();
        $scope.update.sucursal    = jQuery('#cmb_sucursales_edit').val();
        $scope.update.clientes    = jQuery('#cmb_clientes_asignados_edit').val();
        $scope.update.contacto    = jQuery('#cmb_contactos_edit').val();
        $scope.update.id_cliente  = jQuery('#cmb_clientes_edit').val();
        $scope.update.id_servicio = jQuery('#cmb_servicios_edit').val();
        $scope.update.estatus     = jQuery('#cmb_estatus_edit').val();
      var url = domain( url_update );
      var fields = $scope.update;
      MasterController.request_http(url,fields,'put',$http, false )
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

    $scope.edit_register = function( id ){
      var url = domain( url_edit );
      var fields = {id : id };
      MasterController.request_http(url,fields,'get',$http, false )
        .then(function( response ){
          $scope.edit = response.data.result;           
          jQuery('#cmb_empresas_edit').selectpicker('val',[$scope.edit.empresas[0].id]);
          jQuery('#cmb_estatus_edit').val($scope.edit.estatus);
          jQuery('#cmb_servicios_edit').val($scope.edit.id_servicio);
          var clientes = [];
          var j = 0;
          if($scope.edit.clientes.length > 0){
            for (var i in $scope.edit.clientes) {
              clientes[j] = $scope.edit.clientes[i].id;
              j++;
            }
          }
          display_clientes_edit( $scope.edit.sucursales[0].id, clientes , $scope.edit.id_cliente, $scope.edit.contactos[0].id);
          jQuery.fancybox.open({
              'type'      : 'inline'
              ,'src'      : "#modal_edit_register"
              ,'modal'    : true
          });

        }).catch(function( error ){
            if( isset(error.response) && error.response.status == 419 ){
                  toastr.error( session_expired ); 
                  redirect(domain("/"));
                  return;
              }
              console.error( error );
              toastr.error( error , expired );
        });
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
});

jQuery('#cmb_empresas').selectpicker();
jQuery('#cmb_empresas_edit').selectpicker();

function display_clientes(){
    
    var id_empresa = jQuery('#cmb_empresas').val();
    var url = domain( url_display_clientes );
    var fields = {id : id_empresa };
    var promise = MasterController.method_master(url,fields,"get");
      promise.then( response => {
        console.log(response.data.result.clientes);
        var clientes = {
             'data'    : response.data.result.clientes
             ,'text'   : "nombre_comercial"
             ,'value'  : "id"
             ,'name'   : 'cmb_clientes'
             ,'class'  : 'form-control'
             ,'leyenda': 'Seleccione Opcion'
             ,'event'  : 'change_clientes()'
            ,'attr'    : 'data-live-search="true"'     
         };
          
         var clientes_asignados = {
             'data'    : response.data.result.clientes
             ,'text'   : "nombre_comercial"
             ,'value'  : "id"
             ,'name'   : 'cmb_clientes_asignados'
             ,'class'  : 'form-control'
             ,'leyenda': 'Seleccione Opcion'
             //,'event'  : 'change_clientes()'
            ,'attr'    : 'multiple data-live-search="true"'     
         };
          
       var sucursales = {
            'data'    : response.data.result.sucursales
            ,'text'   : "sucursal"
            ,'value'  : "id"
            ,'name'   : 'cmb_sucursales'
            ,'class'  : 'form-control'
            ,'leyenda': 'Seleccione Opcion'
            ,attr     : 'data-live-search="true"'
        };
          
         jQuery('#div_cmb_clientes').html('');
         jQuery('#div_cmb_clientes').html( select_general(clientes) );
          
         jQuery('#div_cmb_clientes_asignados').html('');
         jQuery('#div_cmb_clientes_asignados').html( select_general(clientes_asignados) );
          
         jQuery('#div_cmb_sucursales').html('');
         jQuery('#div_cmb_sucursales').html( select_general(sucursales) );
          
         jQuery('#cmb_clientes_asignados').selectpicker();
         jQuery('#cmb_clientes').selectpicker();
         jQuery('#cmb_sucursales').selectpicker();
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

function change_clientes(){
    var id_cliente = jQuery('#cmb_clientes').val();
    var url = domain(url_display_contactos);
    var fields = { id: id_cliente };
    var promise = MasterController.method_master(url,fields,"get");
      promise.then( response => {
        console.log(response.data.result.contactos);
        var contactos = {
             'data'    : response.data.result.contactos
             ,'text'   : "nombre_completo"
             ,'value'  : "id"
             ,'name'   : 'cmb_contactos'
             ,'class'  : 'form-control'
             ,'leyenda': 'Seleccione Opcion'
             //,'event'  : 'change_clientes()'
            ,'attr'    : 'data-live-search="true"'     
         };
         jQuery('#div_cmb_contactos').html('');
         jQuery('#div_cmb_contactos').html( select_general(contactos) );
         jQuery('#cmb_contactos').selectpicker();
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

function display_clientes_edit( id_sucursal, id_clientes = {}, id_cliente, id_contacto ){
    
    var id_empresa = jQuery('#cmb_empresas_edit').val();
    var url = domain( url_display_clientes );
    var fields = {id : id_empresa };
    var promise = MasterController.method_master(url,fields,"get");
      promise.then( response => {
        console.log(response.data.result.clientes);
        var clientes = {
             'data'    : response.data.result.clientes
             ,'text'   : "nombre_comercial"
             ,'value'  : "id"
             ,'name'   : 'cmb_clientes_edit'
             ,'class'  : 'form-control'
             ,'leyenda': 'Seleccione Opcion'
             ,'event'  : 'change_clientes_edit()'
             ,'attr'   : 'data-live-search="true"' 
             ,selected : (id_cliente != "")?id_cliente: 0
         };
          
         var clientes_asignados = {
             'data'    : response.data.result.clientes
             ,'text'   : "nombre_comercial"
             ,'value'  : "id"
             ,'name'   : 'cmb_clientes_asignados_edit'
             ,'class'  : 'form-control'
             ,'leyenda': 'Seleccione Opcion'
             ,'attr'    : 'multiple data-live-search="true"'
         };
          
       var sucursales = {
            'data'    : response.data.result.sucursales
            ,'text'   : "sucursal"
            ,'value'  : "id"
            ,'name'   : 'cmb_sucursales_edit'
            ,'class'  : 'form-control'
            ,'leyenda': 'Seleccione Opcion'
            ,selected : ( id_sucursal != "" )? id_sucursal: 0
            ,attr     : 'data-live-search="true"'
        };
         
         jQuery('#div_cmb_clientes_edit').html('');
         jQuery('#div_cmb_clientes_edit').html( select_general(clientes) );
          
         jQuery('#div_cmb_clientes_asignados_edit').html('');
         jQuery('#div_cmb_clientes_asignados_edit').html( select_general(clientes_asignados) );
          
         jQuery('#div_cmb_sucursales_edit').html('');
         jQuery('#div_cmb_sucursales_edit').html( select_general(sucursales) );
         jQuery('#cmb_clientes_asignados_edit').selectpicker('val',id_clientes);
         jQuery('#cmb_clientes_edit').selectpicker();
         jQuery('#cmb_sucursales_edit').selectpicker();
         change_clientes_edit(id_contacto);
          //jQuery('#cmb_sucursales_edit').selectpicker('val',[1]);
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

function change_clientes_edit( id_contacto ){
    var id_cliente = jQuery('#cmb_clientes_edit').val();
    var url = domain(url_display_contactos);
    var fields = { id: id_cliente };
    var promise = MasterController.method_master(url,fields,"get");
      promise.then( response => {
        console.log(response.data.result.contactos);
        var contactos = {
             'data'    : response.data.result.contactos
             ,'text'   : "nombre_completo"
             ,'value'  : "id"
             ,'name'   : 'cmb_contactos_edit'
             ,'class'  : 'form-control'
             ,'leyenda': 'Seleccione Opcion'
            ,'attr'    : 'data-live-search="true"'     
            ,selected  : (id_contacto != "")?id_contacto : 0   
         };
         jQuery('#div_cmb_contactos_edit').html('');
         jQuery('#div_cmb_contactos_edit').html( select_general(contactos) );
         jQuery('#cmb_contactos_edit').selectpicker();
         //toastr.success( response.data.message , title );
      }).catch( error => {
          if( isset(error.response) && error.response.status == 419 ){
            toastr.error( session_expired ); 
            redirect(domain("/"));
            return;
         }
         toastr.error( error , expired );           
      });
    
}
