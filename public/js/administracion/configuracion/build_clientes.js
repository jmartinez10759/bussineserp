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

/*new Vue({
  el: "#vue-clientes",
  created: function () {
    this.consulta_general();
  },
  data: {
    datos: []
    ,register: {}
    ,update: {}
    ,edit: {}
  },
  mixins : [mixins],
  methods:{
    consulta_general(){}
    ,destroy( id_cliente ){
      var url = domain(url_destroy);
      var fields = {id_cliente: id_cliente};
      buildSweetAlertOptions("¿Borrar Registro?","¿Realmente desea eliminar el registro?",function(){
          var respuestas = MasterController.method_master(url,fields,'delete');
          respuestas.then( response => {
              toastr.success( response.data.message , title );
              redirect(domain(redireccion));
          }).catch(error => {
              toastr.error( error , expired );
          });
      },'warning',true,["SI","NO"]);

    }
    ,register_cliente(){
        var validacion = ['correo','razon_social','rfc_receptor'];
        if(validacion_fields(validacion) == "error"){return;}
        if( !emailValidate(jQuery('#correo').val()) ){
            jQuery('#correo').parent().parent().addClass('has-error');
            toastr.error("Correo Incorrecto","Ocurrio un error, favior de verificar");
            return;
        }
        if( !valida_rfc(jQuery('#rfc_receptor').val()) ){
            jQuery('#rfc_receptor').parent().addClass('has-error');
            toastr.error("RFC Incorrecto","Ocurrio un error, favior de verificar");
            return;
        }
        this.register.id_estado = jQuery('#cmb_estados').val();
        this.register.estatus = 0;
        var url = domain(url_insert);
        var fields = this.register;
        var response = MasterController.method_master(url,fields,'post');
          response.then( response => {
              toastr.success( response.data.message , title );
              redirect(domain(redireccion));
          }).catch(error => {
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
              //redirect();
          });
        
    }
    ,editar( id_cliente ){
          var url = domain(url_edit);
          var fields = {id_cliente: id_cliente};
          var respuestas = MasterController.method_master(url,fields,'get');
          respuestas.then( response => {
              this.edit = response.data.result;
              if(response.data.result.contactos.length > 0){
                  this.edit.contacto     = response.data.result.contactos[0].nombre_completo
                  this.edit.departamento = response.data.result.contactos[0].departamento
                  this.edit.telefono     = response.data.result.contactos[0].telefono
                  this.edit.correo       = response.data.result.contactos[0].correo
              }
              console.log(this.edit);
              jQuery('#cmb_estados_edit').selectpicker('val',[this.edit.id_estado]);
              jQuery('#cmb_estatus_edit').val(this.edit.estatus);
               jQuery.fancybox.open({
                   'type': 'inline'
                   ,'src': "#modal_edit_register"
                   ,'buttons' : ['share', 'close']
               });
              
          }).catch(error => {
              toastr.error( error , expired );
          });

    }
    ,update_cliente(){
        var validacion = ['correo_edit','razon_social_edit','rfc_receptor_edit'];
        if(validacion_fields(validacion) == "error"){return;}
        if( !emailValidate(jQuery('#correo_edit').val()) ){
            jQuery('#correo_edit').parent().parent().addClass('has-error');
            toastr.error("Correo Incorrecto","Ocurrio un error, favor de verificar");
            return;
        }
        if( !valida_rfc(jQuery('#rfc_receptor_edit').val()) ){
            jQuery('#rfc_receptor_edit').parent().parent().addClass('has-error');
            toastr.error("RFC Incorrecto","Ocurrio un error, favor de verificar");
            return;
        }
          var url = domain( url_update );
          this.edit.estatus = jQuery('#cmb_estatus_edit').val();
          this.edit.id_estado =jQuery('#cmb_estados_edit').val();
          
          var request = MasterController.method_master(url,this.edit,'put');
          request.then( response => {
              toastr.info( response.data.message , title );
                jQuery.fancybox.close({
                   'type': 'inline'
                   ,'src': "#modal_edit_register"
                   ,'buttons' : ['share', 'close']
               }); 
              //jQuery("#vue-clientes").load("#prospectos > *");
              redirect(domain(redireccion));
          }).catch( error => {
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
              //redirect();
          });
      }
    ,insert_permisos(){
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
            , 'id_empresa': jQuery('#id_empresa').val()
            , 'id_cliente': jQuery('#id_cliente').val()
        }
        var promise = MasterController.method_master(url, fields, "post");
        promise.then(response => {
            this.sucursales = response.data.result;
            jQuery.fancybox.close({
                'type': 'inline',
                'src': "#permisos",
                'buttons': ['share', 'close']
            });
        }).catch(error => {
            if (error.response.status == 419) {
                toastr.error(session_expired);
                redirect(domain("/"));
                return;
            }
            toastr.error(error.response.data.message, expired);

        });

        

    }
  }
});
*/

var app = angular.module('ng-clientes', ["ngRoute"]);

app.controller('ClientesController', function( $scope, $http, $location ) {
    /*se declaran las propiedades dentro del controller*/
    $scope.constructor = function(){
        $scope.datos  = [];
        $scope.insert = {
          estatus: "1"
          ,id_servicio: "0"
          ,id_country: "151"
        };
        $scope.update = {};
        $scope.edit   = {};
        $scope.fields = {};
        $scope.select_estado();
        $scope.consulta_general();
        //$scope.display_sucursales();
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
        this.insert.id_estado  = jQuery('#cmb_estados').val();
        this.insert.id_codigo  = jQuery('#cmb_codigo_postal').val();
        this.insert.id_uso_cfdi  = jQuery('#cmb_uso_cfdi').val();
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
            $scope.insert = {};
            jQuery('#cmb_uso_cfdi').val(0);
            jQuery('#cmb_codigo_postal').val(0);
            jQuery('#cmb_codigo_postal').prop('disabled',true);
            $scope.consulta_general();
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
      $scope.update = $scope.edit;
      $scope.update.id_estado  = jQuery('#cmb_estados_edit').val();
      $scope.update.id_codigo  = jQuery('#cmb_codigo_postal_edit').val();
      $scope.update.id_country    = jQuery('#cmb_pais_edit').val();
      $scope.update.estatus       = jQuery('#cmb_estatus_edit').val();
      $scope.update.id_servicio   = jQuery('#cmb_servicio_edit').val();
      $scope.update.id_uso_cfdi   = jQuery('#cmb_uso_cfdi_edit').val();
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

           $scope.edit = response.data.result;
           if( response.data.result.contactos.length > 0 ){
               $scope.edit.contacto     = response.data.result.contactos[0].nombre_completo;
               $scope.edit.departamento = response.data.result.contactos[0].departamento;
               $scope.edit.telefono     = response.data.result.contactos[0].telefono;
               $scope.edit.correo       = response.data.result.contactos[0].correo;
           }
           jQuery('#cmb_pais_edit').val($scope.edit.id_country);
           jQuery('#cmb_uso_cfdi_edit').val($scope.edit.id_uso_cfdi);
           jQuery('#cmb_servicio_edit').selectpicker('val',[$scope.edit.id_servicio]);
           jQuery('#cmb_regimen_fiscal_edit').val($scope.edit.id_regimen_fiscal);
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
          jQuery('#cmb_estados_edit').val($scope.edit.id_estado);
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
