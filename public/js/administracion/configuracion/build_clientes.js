var url_insert  = "clientes/register";
var url_update  = 'clientes/update';
var url_edit    = 'clientes/edit';
var url_all     = 'clientes/all';
var url_destroy = "clientes/destroy";
var redireccion = "configuracion/clientes";
var url_display = "clientes/display_sucursales";
var url_insert_permisos = "clientes/register_permisos";
var url_edit_pais       = 'pais/edit';
var url_edit_codigos    = 'codigopostal/show';

var app = angular.module('ng-clientes', ["ngRoute"]);
app.config(function( $routeProvider, $locationProvider ) {
    $routeProvider
    .when("/ruta1", {
        template : "<h1></h1>",
    })
    .when("/ruta2", {
        template : "<h1></h1>",
    })
    .when("/ruta3", {
        templateUrl : "ruta3.html",
        controller : ""
    });
    $locationProvider.html5Mode(true);
});
app.controller('ClientesController', function( $scope, $http, $location ) {
    /*se declaran las propiedades dentro del controller*/
    $scope.constructor = function(){
        $scope.datos  = [];
        $scope.insert = {
          estatus: 0
          ,id_servicio_comercial: 0
          ,id_country: 151
          ,id_servicio_comercial: null
        };
        $scope.update = {};
        $scope.edit   = {};
        $scope.fields = {};
        $scope.cmb_estatus = [{id:0 ,nombre:"Prospectos"}, {id:1, nombre:"Clientes"}];
        $scope.select_estado();
        $scope.consulta_general();
        //$scope.display_sucursales();
    }

    $scope.click = function (){
      $location.path("/register");
      //$scope.consulta_general();
    }

    $scope.consulta_general = function(){
        var url = domain( url_all );
        var fields = {};
        MasterController.request_http(url,fields,'get',$http, false )
        .then(function(response){
            $scope.datos = response.data.result;
            console.log($scope.datos);
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

        var validacion = ['correo','razon_social','rfc_receptor'];
        if(validacion_fields(validacion) == "error"){return;}
        if( !emailValidate(jQuery('#correo').val()) ){  
            jQuery('#correo').parent().addClass('has-error');
            toastr.error("Correo Incorrecto","Ocurrio un error, favor de verificar");
            return;
        }
        if( !valida_rfc(jQuery('#rfc_receptor').val()) ){
            jQuery('#rfc_receptor').parent().addClass('has-error');
            toastr.error("RFC Incorrecto","Ocurrio un error, favor de verificar");
            return;
        }
        var url = domain( url_insert );
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
            $scope.consulta_general();
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

      var validacion = ['correo_edit','razon_social_edit','rfc_receptor_edit'];
      if(validacion_fields(validacion) == "error"){return;}
      if( !emailValidate(jQuery('#correo_edit').val()) ){  
          jQuery('#correo_edit').parent().addClass('has-error');
          toastr.error("Correo Incorrecto","Ocurrio un error, favior de verificar");
          return;
      }
      if( !valida_rfc(jQuery('#rfc_receptor_edit').val()) ){
          jQuery('#rfc_receptor_edit').parent().addClass('has-error');
          toastr.error("RFC Incorrecto","Ocurrio un error, favior de verificar");
          return;
      }
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
          $scope.consulta_general();
          jQuery('#tr_'+$scope.update.id).effect("highlight",{},5000);
          //redirect(domain(redireccion));
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
         /* var id_edit = {
              div_content  : 'div_dropzone_file_empresa_dit'
              ,div_dropzone : 'dropzone_xlsx_file_empresa_edit'
              ,file_name    : 'file'
            };
            upload_file('',upload_url,message,1,id_edit,'.jpg,.png,.jpeg',function( request ){
                console.log(request);
            });*/
            var datos = ['updated_at','created_at'];
            $scope.update = iterar_object(response.data.result,datos);
           if( response.data.result.contactos.length > 0 ){
               $scope.update.contacto     = response.data.result.contactos[0].nombre_completo;
               $scope.update.departamento = response.data.result.contactos[0].departamento;
               $scope.update.telefono     = response.data.result.contactos[0].telefono;
               $scope.update.correo       = response.data.result.contactos[0].correo;
           }
           $scope.select_estado(1);
           $scope.select_codigos(1);
          jQuery.fancybox.open({
                'type'      : 'inline'
                ,'src'      : "#modal_edit_register"
                ,'modal': true
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
            $scope.consulta_general();
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

    $scope.select_estado = function( update = false){
      var url = domain( url_edit_pais );
      var fields = { id: (!update)? $scope.insert.id_country: $scope.update.id_country};
      MasterController.request_http(url,fields,"get",$http,false)
      .then( response => {
          $scope.cmb_estados = response.data.result.estados;
          console.log($scope.cmb_estados);
      }).catch( error => {
          if( isset(error.response) && error.response.status == 419 ){
            toastr.error( session_expired ); 
            redirect(domain("/"));
            return;
          }
          console.log(error);
            toastr.error( error.result , expired );   
      });    
    }

    $scope.select_codigos = function( update = false ){
      var url = domain( url_edit_codigos );
      var fields = {id: (!update)? $scope.insert.id_estado:$scope.update.id_estado};
      MasterController.method_master(url,fields,"get")
      .then( response => {
          $scope.cmb_codigos = response.data.result;
          console.log($scope.cmb_codigos);
      }).catch( error => {
          if( isset(error.response) && error.response.status == 419 ){
            toastr.error( session_expired ); 
            redirect(domain("/"));
            return;
          }
            toastr.error( error.data.result , expired );  
      }); 
    }
    
    $scope.display_sucursales = function( id ) {
       var id_empresa = jQuery('#cmb_empresas_'+id).val().replace('number:','');
       var url = domain( url_display );
       var fields = { 
           id_empresa : id_empresa
           ,id_cliente : id
       };
       $scope.fields.id_empresa = id_empresa;
       $scope.fields.id_cliente = id;
          /*jQuery('#id_cliente').val(id);
          jQuery('#id_empresa').val(id_empresa);*/
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
       }).catch(error => {
           if( isset(error.response) && error.response.status == 419 ){
            toastr.error( session_expired ); 
            redirect(domain("/"));
            return;
          }
            toastr.error( error.data.result , expired );  

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
            , 'id_cliente': $scope.fields.id_cliente
        }
        MasterController.request_http(url, fields, "post", $http, false )
        .then(response => {
            //this.sucursales = response.data.result;
            jQuery.fancybox.close({
                'type': 'inline',
                'src': "#permisos",
                'buttons': ['share', 'close']
            });
            $scope.consulta_general();
        }).catch(error => {
            if( isset(error.response) && error.response.status == 419 ){
              toastr.error( session_expired ); 
              redirect(domain("/"));
              return;
            }
              toastr.error( error.data.result , expired );  

        });

    }

});

//jQuery('#cmb_estados').selectpicker();
//jQuery('#cmb_estados_edit').selectpicker();
jQuery('#clientes_tabs').click(function(){
   jQuery('#search_general').removeAttr('onkeyup');
   jQuery('#search_general').attr("onkeyup","buscador_general(this,'#datatable_clientes',false)");
   jQuery('#search_general').val("");
   jQuery('#search_general').keyup();
});
jQuery('#prospectos_tabs').click(function(){
   jQuery('#search_general').removeAttr('onkeyup');
   jQuery('#search_general').attr("onkeyup","buscador_general(this,'#datatable')");
   jQuery('#search_general').val("");
   jQuery('#search_general').keyup();
});

/*
function select_codigos(){
      var url = domain( url_edit_codigos );
      var fields = {id: jQuery('#cmb_estados').val()}
      MasterController.method_master(url,fields,"get")
      .then( response => {
          var codigos = {
              'data'    : response.data.result
              ,'text'   : "codigo_postal"
              ,'value'  : "id"
              ,'name'   : "cmb_codigo_postal"
              ,'class'  : 'form-control'
              ,'attr'   : 'data-live-search="true" '
              ,'leyenda': 'Seleccione Opción'
          };
          jQuery('#div_cmb_codigos').html('');
          jQuery('#div_cmb_codigos').html( select_general( codigos ) );
      }).catch( error => {
          if( isset(error.response) && error.response.status == 419 ){
            toastr.error( session_expired ); 
            redirect(domain("/"));
            return;
          }
            toastr.error( error.data.result , expired );  
      }); 
}

function select_codigos_edit(id = false, id_codigo =false){
      var id_estado = (id)? id : jQuery('#cmb_estados_edit').val();
      var url = domain( url_edit_codigos );
      var fields = {id: id_estado}
      MasterController.method_master(url,fields,"get")
      .then( response => {
          var codigos = {
              'data'    : response.data.result
              ,'text'   : "codigo_postal"
              ,'value'  : "id"
              ,'name'   : "cmb_codigo_postal_edit"
              ,'class'  : 'form-control'
              ,'attr'   : 'data-live-search="true" '
              ,'leyenda': 'Seleccione Opción'
          };
          jQuery('#div_cmb_codigos_edit').html('');
          jQuery('#div_cmb_codigos_edit').html( select_general( codigos ) );
          jQuery('#cmb_codigo_postal_edit').val( id_codigo );
      }).catch( error => {
          if( isset(error.response) && error.response.status == 419 ){
            toastr.error( session_expired ); 
            redirect(domain("/"));
            return;
          }
            toastr.error( error , expired );  
      }); 
}
*/