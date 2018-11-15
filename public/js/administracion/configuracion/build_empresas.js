var url_insert  = "empresas/register";
var url_all     = "empresas/all";
var url_update  = 'empresas/update';
var url_edit    = 'empresas/edit';
var url_destroy = "empresas/destroy/";
var redireccion = "configuracion/empresas";
var url_relacion      = "empresas/insert_relacion";
var url_edit_pais     = 'pais/edit';
var url_edit_codigos  = 'codigopostal/show';

var app = angular.module('ng-empresas', ["ngRoute"]);
app.controller('EmpresasController', function( $scope, $http, $location ) {
    /*se declaran las propiedades dentro del controller*/
    $scope.constructor = function(){
        $scope.datos  = [];
        $scope.insert = {
          estatus: "1"
          ,id_regimen_fiscal: "0"
          ,id_servicio: "0"
          ,id_country: "151"
        };
        $scope.update = {};
        $scope.edit   = {};
        $scope.fields = {};
        $scope.select_estado();
        $scope.consulta_general();
    }

    $scope.click = function (){
      $location.path("/register");
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

        var validacion = ['correo','razon_social','rfc_emisor'];
        if(validacion_fields(validacion) == "error"){return;}
        if( !emailValidate(jQuery('#correo').val()) ){  
            jQuery('#correo').parent().addClass('has-error');
            toastr.error("Correo Incorrecto","Ocurrio un error, favior de verificar");
            return;
        }
        if( !valida_rfc(jQuery('#rfc_emisor').val()) ){
            jQuery('#rfc_emisor').parent().addClass('has-error');
            toastr.error("RFC Incorrecto","Ocurrio un error, favior de verificar");
            return;
        }
        this.insert.id_estado  = jQuery('#cmb_estados').val();
        this.insert.id_codigo  = jQuery('#cmb_codigo_postal').val();
        this.insert.id_servicio_comercial  = jQuery('#cmb_servicio_comerciales').val();
        var url = domain( url_insert );
        var fields = this.insert;
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
            $scope.constructor();
        }).catch(function( error ){
            if( isset(error.response) && error.response.status == 419 ){
                  toastr.error( session_expired ); 
                  redirect(domain("/"));
                  return;
              }
              console.error( error.data );
              toastr.error( error.data.message , expired );
        });
    }

    $scope.update_register = function(){

      var validacion = ['correo_edit','razon_social_edit','rfc_emisor_edit'];
      if(validacion_fields(validacion) == "error"){return;}
      if( !emailValidate(jQuery('#correo_edit').val()) ){  
          jQuery('#correo_edit').parent().addClass('has-error');
          toastr.error("Correo Incorrecto","Ocurrio un error, favior de verificar");
          return;
      }
      if( !valida_rfc(jQuery('#rfc_emisor_edit').val()) ){
          jQuery('#rfc_emisor_edit').parent().addClass('has-error');
          toastr.error("RFC Incorrecto","Ocurrio un error, favior de verificar");
          return;
      }
      $scope.update = $scope.edit;
      $scope.update.id_estado              = jQuery('#cmb_estados_edit').val();
      $scope.update.id_codigo              = jQuery('#cmb_codigo_postal_edit').val();
      $scope.update.id_country             = jQuery('#cmb_pais_edit').val();
      $scope.update.estatus                = jQuery('#cmb_estatus_edit').val();
      $scope.update.id_servicio_comercial  = jQuery('#cmb_servicio_comerciales_edit').val();
      $scope.update.id_regimen_fiscal      = jQuery('#cmb_regimen_fiscal_edit').val();
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

          var id_edit = {
              div_content  : 'div_dropzone_file_empresa_dit'
              ,div_dropzone : 'dropzone_xlsx_file_empresa_edit'
              ,file_name    : 'file'
            };
            upload_file('',upload_url,message,1,id_edit,'.jpg,.png,.jpeg',function( request ){
                console.log(request);
            });

           $scope.edit = response.data.result;
           if( response.data.result.contactos.length > 0 ){
               $scope.edit.contacto     = response.data.result.contactos[0].nombre_completo;
               $scope.edit.departamento = response.data.result.contactos[0].departamento;
               $scope.edit.telefono     = response.data.result.contactos[0].telefono;
               $scope.edit.correo       = response.data.result.contactos[0].correo;
           }
           jQuery('#cmb_pais_edit').val($scope.edit.id_country).trigger("chosen:updated");
           jQuery('#cmb_estatus_edit').val($scope.edit.estatus).trigger("chosen:updated");
           jQuery('#cmb_servicio_comerciales_edit').val($scope.edit.id_servicio_comercial).trigger("chosen:updated");
           jQuery('#cmb_regimen_fiscal_edit').val($scope.edit.id_regimen_fiscal).trigger("chosen:updated");
           $scope.select_estado_edit();
           select_codigos_edit($scope.edit.id_estado,$scope.edit.id_codigo);

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
            redirect(domain(redireccion));
            //$scope.consulta_general();
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

    $scope.select_estado = function(){
      var url = domain( url_edit_pais );
      var fields = { id: jQuery('#cmb_pais').val() };
      MasterController.request_http(url,fields,"get",$http,false)
      .then( response => {
          var estados = {
              'data'    : response.data.result.estados
              ,'text'   : "nombre"
              ,'value'  : "id"
              ,'name'   : "cmb_estados"
              ,'class'  : 'form-control'
              ,'leyenda': 'Seleccione Opción'
              ,'attr'   : 'data-live-search="true" '
              ,'event'  : "select_codigos()"
          };
          jQuery('#div_cmb_estados').html('');
          jQuery('#div_cmb_estados').html( select_general( estados ) );
          jQuery('#cmb_estados').chosen({width: "100%"});
      }).catch( error => {
          if( isset(error.response) && error.response.status == 419 ){
            toastr.error( session_expired ); 
            redirect(domain("/"));
            return;
          }
            toastr.error( error.data.result , expired );   
      });    
    }

    $scope.select_estado_edit = function(){
      var url = domain( url_edit_pais );
      var fields = { id: jQuery('#cmb_pais_edit').val() };
      MasterController.request_http(url,fields,"get",$http,false)
      .then( response => {
          var estados = {
              'data'    : response.data.result.estados
              ,'text'   : "nombre"
              ,'value'  : "id"
              ,'name'   : "cmb_estados_edit"
              ,'class'  : 'form-control'
              ,'leyenda': 'Seleccione Opción'
              ,'attr'   : 'data-live-search="true" '
              ,'event'  : "select_codigos_edit()"
          };
          jQuery('#div_cmb_estados_edit').html('');
          jQuery('#div_cmb_estados_edit').html( select_general( estados ) );
          jQuery('#cmb_estados_edit').chosen({width: "100%"});
          jQuery('#cmb_estados_edit').val($scope.edit.id_estado).trigger("chosen:updated");
      }).catch( error => {
          if( isset(error.response) && error.response.status == 419 ){
            toastr.error( session_expired ); 
            redirect(domain("/"));
            return;
          }
            toastr.error( error.data.result , expired );   
      });    
    } 

    $scope.sucursales = function( id_empresa ){
      var url     = domain( url_edit );
      var fields  = {'id' : id_empresa };
      MasterController.request_http(url,fields,'get',$http, false )
        .then(function( response ){
          $scope.fields.id_empresa = id_empresa;
          console.log($scope.fields);
          if( response.data.result.sucursales.length > 0 ){
                jQuery('input[type="checkbox"]').each(function(){
                  var id_sucursal = jQuery(this).attr('id_sucursal');
                  jQuery('#'+id_sucursal).prop('checked',false);
                });
                for (var i in response.data.result.sucursales ) {
                    jQuery('input[type="checkbox"]').each(function(){
                        jQuery('#'+response.data.result.sucursales[i].id).prop('checked',response.data.result.sucursales[i].estatus);
                    });
                }
          }else{
            jQuery('input[type="checkbox"]').each(function(){
                var id_sucursal = jQuery(this).attr('id_sucursal');
                jQuery('#'+id_sucursal).prop('checked',false);
            });

          }

          jQuery.fancybox.open({
                'type'      : 'inline'
                ,'src'      : "#modal_sucusales_register"
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
              toastr.error( error , expired );
        });

    }

    $scope.insert_sucursales = function(){

        var id_empresa = $scope.fields.id_empresa;
        var matrix = [];
        var i = 0;
        jQuery('input[type="checkbox"]').each(function(){
            var id_sucursal = jQuery(this).attr('id_sucursal');
            if( isset(id_sucursal) === true && jQuery('#'+id_sucursal).is(':checked') === true ){
              matrix[i] = id_sucursal+'|'+jQuery('#'+id_sucursal).is(':checked');
              i++;
            }
        });
        console.log(matrix);
        var fields = {
          'id_empresa' : id_empresa
          ,'matrix'    : matrix
        }
        var url = domain( url_relacion );
        MasterController.request_http(url,fields,'post',$http, false )
        .then(function( response ){
            toastr.info( response.data.message , title );
            jQuery.fancybox.close({
                'type'      : 'inline'
                ,'src'      : "#modal_sucusales_register"
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
              console.error( error.data );
              toastr.error( error.data.message , expired );
        });
    
    }

});

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
          jQuery('#cmb_codigo_postal').chosen({width: "100%"});
      }).catch( error => {
          if( isset(error.response) && error.response.status == 419 ){
            toastr.error( session_expired ); 
            redirect(domain("/"));
            return;
          }
            toastr.error( error.data.result , expired );  
      }); 
}

function select_codigos_edit(id = false,id_codigo =false){
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
          jQuery('#cmb_codigo_postal_edit').chosen({width: "100%"});
          jQuery('#cmb_codigo_postal_edit').val( id_codigo ).trigger("chosen:updated");
      }).catch( error => {
          if( isset(error.response) && error.response.status == 419 ){
            toastr.error( session_expired ); 
            redirect(domain("/"));
            return;
          }
            toastr.error( error , expired );  
      }); 
}

jQuery('#cmb_pais').chosen({width: "100%"});
jQuery('#cmb_pais_edit').chosen({width: "100%"});
jQuery('#cmb_regimen_fiscal').chosen({width: "100%"});
jQuery('#cmb_regimen_fiscal_edit').chosen({width: "100%"});
jQuery('#cmb_servicio_comerciales').chosen({width: "100%"});
jQuery('#cmb_servicio_comerciales_edit').chosen({width: "100%"});

var upload_url = domain('empresas/upload');
var ids = {
  div_content  : 'div_dropzone_file_empresa'
  ,div_dropzone : 'dropzone_xlsx_file_empresa'
  ,file_name    : 'file'
};
var message = "Dar Clic aquí o arrastrar archivo";
upload_file('',upload_url,message,1,ids,'.jpg,.png,.jpeg',function( request ){
    console.log(request);
});