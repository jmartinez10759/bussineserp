var url_insert  = "proveedores/register";
var url_update   = "proveedores/update";
var url_edit     = "proveedores/edit";
var url_destroy  = "proveedores/destroy";
var url_all      = "proveedores/all";
var redireccion  = "configuracion/proveedores";
var url_edit_pais       = 'pais/edit';
var url_edit_codigos    = 'codigopostal/show';
var url_upload          = 'upload/files';
<<<<<<< HEAD

=======
>>>>>>> d48190b7095d50f6ca288774f3370a47ceae36f8
var app = angular.module('ng-proveedores', ["ngRoute",'components','localytics.directives'])
app.controller('ProveedoresController', function( $scope, $http, $location ) {
    /*se declaran las propiedades dentro del controller*/
    $scope.constructor = function(){
        $scope.datos  = [];
        $scope.insert = {
          id_regimen_fiscal: null
          ,id_country: 151
          ,id_servicio_comercial: null
          // ,estatus: 1
        };
        $scope.update = {};
        $scope.edit   = {};
        $scope.fields = {};
        $scope.consulta_general();
        $scope.select_estado();
        $scope.cmb_estatus = [{id:0 ,descripcion:"Baja"}, {id:1, descripcion:"Activo"}];
    }

    $scope.click = function (){
      $location.path("/register");
      // $scope.consulta_general();
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

      var validacion = {
            'CORREO'               : $scope.insert.correo
            ,'RAZON SOCIAL'        : $scope.insert.razon_social
            ,'RFC'                 : $scope.insert.rfc
            ,'PAIS'                : $scope.insert.id_country
            ,'ESTADO'              : $scope.insert.id_estado
            ,'CODIGO POSTAL'       : $scope.insert.id_codigo
            ,'SERVICIO COMERCIAL'  : $scope.insert.id_servicio_comercial
            ,'REGIMEN FISCAL'      : $scope.insert.id_regimen_fiscal
            ,'ESTATUS'             : $scope.insert.estatus

           };
           if(validaciones_fields(validacion)){return;}
        if( !emailValidate( $scope.insert.correo ) ){  
            toastr.error("Correo Incorrecto","Ocurrio un error, favor de verificar");
            return;
        }
        if( !valida_rfc($scope.insert.rfc) ){
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
            $scope.insert = {};
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

      var validacion = {
             'CORREO'              : $scope.update.correo
            ,'RAZON SOCIAL'        : $scope.update.razon_social
            ,'RFC'                 : $scope.update.rfc
            ,'PAIS'                : $scope.update.id_country
            ,'ESTADO'              : $scope.update.id_estado
            ,'CODIGO POSTAL'       : $scope.update.id_codigo
            ,'SERVICIO COMERCIAL'  : $scope.update.id_servicio_comercial
            ,'REGIMEN FISCAL'      : $scope.update.id_regimen_fiscal
            ,'ESTATUS'             : $scope.update.estatus
          };
        if(validaciones_fields(validacion)){return;}
        if( !emailValidate( $scope.update.correo ) ){  
            toastr.error("Correo Incorrecto","Ocurrio un error, favor de verificar");
            return;
        }
        if( !valida_rfc($scope.update.rfc) ){
            toastr.error("RFC Incorrecto","Ocurrio un error, favor de verificar");
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
            var html = '';
            html = '<img class="img-responsive" src="'+$scope.update.logo+'?'+Math.random()+'" height="268px" width="200px">'
            jQuery('#imagen_edit').html("");        
            jQuery('#imagen_edit').html(html); 
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
            // redirect(domain(redireccion));
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
          $scope.cmb_estados = {};  
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
    $scope.upload_file = function(update){

      var upload_url = domain( url_upload );
      var identificador = {
         div_content   : 'div_dropzone_file_proveedores'
        ,div_dropzone  : 'dropzone_xlsx_file_proveedores'
        ,file_name     : 'file'
      };
      var message = "Dar Clíc aquí o arrastrar archivo";
      $scope.update.logo = "";
      upload_file({'nombre': 'proveedor_'+$scope.update.id },upload_url,message,1,identificador,'.jpg,.png,.jpeg',function( request ){
          if(update){
            $scope.update.logo = domain(request.result);
            var html = '';
             html = '<img class="img-responsive" src="'+$scope.update.logo+'?'+Math.random()
            +'" height="268px" width="200px">'
            jQuery('#imagen_edit').html("");        
            jQuery('#imagen_edit').html(html);        
          }else{
            $scope.insert.logo = domain(request.result);
            var html = '';
             html = '<img class="img-responsive" src="'+$scope.update.logo+'?'+Math.random()
            +'" height="268px" width="200px">'
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