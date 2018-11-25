var url_insert  = "empresas/register";
var url_all     = "empresas/all";
var url_update  = 'empresas/update';
var url_edit    = 'empresas/edit';
var url_destroy = "empresas/destroy/";
var redireccion = "configuracion/empresas";
var url_relacion      = "empresas/insert_relacion";
var url_edit_pais     = 'pais/edit';
var url_edit_codigos  = 'codigopostal/show';
var url_upload          = 'upload/files';

var app = angular.module('ng-empresas', ["ngRoute",'localytics.directives','components']);
app.controller('EmpresasController', function( $scope, $http, $location ) {
    
    $scope.constructor = function(){
        $scope.datos  = [];
        $scope.insert = {
          estatus: 1 ,id_country: 151
        };
        $scope.cmb_estatus = [{id:0 ,descripcion:"Inactivo"}, {id:1, descripcion:"Activo"}];
        $scope.update = {};
        $scope.edit   = {};
        $scope.fields = {};
        $scope.select_estado();
        $scope.index();
    }

    $scope.click = function (){
      $location.path("/register");
      $scope.index();
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

        var validacion = {
             'CORREO'       : $scope.insert.correo
            ,'RAZON SOCIAL' : $scope.insert.razon_social
            ,'RFC'          : $scope.insert.rfc_emisor
          };
        if(validaciones_fields(validacion)){return;}
        if( !emailValidate( $scope.insert.correo ) ){  
            toastr.error("Correo Incorrecto","Ocurrio un error, favor de verificar");
            return;
        }
        if( !valida_rfc($scope.insert.rfc_emisor) ){
            toastr.error("RFC Incorrecto","Ocurrio un error, favor de verificar");
            return;
        }
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
            $scope.index();
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

      var validacion = {
             'CORREO'       : $scope.update.correo
            ,'RAZON SOCIAL' : $scope.update.razon_social
            ,'RFC'          : $scope.update.rfc_emisor
          };
        if(validaciones_fields(validacion)){return;}
        if( !emailValidate( $scope.update.correo ) ){  
            toastr.error("Correo Incorrecto","Ocurrio un error, favor de verificar");
            return;
        }
        if( !valida_rfc($scope.update.rfc_emisor) ){
            toastr.error("RFC Incorrecto","Ocurrio un error, favor de verificar");
            return;
        }
        /*var datos = ['contactos'];
        $scope.update = iterar_object($scope.update,datos);*/
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

       var datos = ['updated_at','created_at','clientes','codigos','comerciales','regimenes','sucursales','$$hashKey'];
            $scope.update = iterar_object(data,datos);
            console.log($scope.update);
           if( data.contactos.length > 0 ){
               $scope.update.contacto     = data.contactos[0].nombre_completo;
               $scope.update.departamento = data.contactos[0].departamento;
               $scope.update.telefono     = data.contactos[0].telefono;
               $scope.update.correo       = data.contactos[0].correo;
           }
           $scope.select_estado(1);
           $scope.select_codigos(1);
            var html = '';
            html = '<img class="img-responsive" src="'+$scope.update.logo+'?'+Math.random()+'" height="268px" width="200px">'
            jQuery('#imagen_edit').html("");        
            jQuery('#imagen_edit').html(html); 

          jQuery.fancybox.open({
                'type'      : 'inline'
                ,'src'      : "#modal_edit_register"
                ,'modal': true
            }); 
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

    $scope.select_estado = function( update = false ){
      var url = domain( url_edit_pais );
      var fields = { id: (update)? $scope.update.id_country: $scope.insert.id_country};
      MasterController.request_http(url,fields,"get",$http,false)
      .then( response => {
         $scope.cmb_estados = response.data.result.estados;
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
      MasterController.request_http(url,fields,"get",$http,false)
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
            jQuery('#tr_'+id_empresa).effect("highlight",{},5000);
            $scope.index();
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

    $scope.upload_file = function(update){

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

    }

});