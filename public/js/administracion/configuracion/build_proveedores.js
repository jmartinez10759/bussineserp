var url_insert  = "proveedores/register";
var url_update   = "proveedores/update";
var url_edit     = "proveedores/edit";
var url_destroy  = "proveedores/destroy";
var url_all      = "proveedores/all";
var redireccion  = "configuracion/proveedores";
var url_edit_pais       = 'pais/edit';
var url_edit_codigos    = 'codigopostal/show';
var url_upload          = 'upload/files';

// new Vue({
//   el: "#vue-proveedores",
//   created: function () {
//     // this.consulta_general();
//   },
//   data: {
//     datos: [],
//     insert: {'estatus':'1'},
//     update: {'estatus':'1'},
//     edit: {'estatus':'1'},
//     fields: {},

//   },
//   mixins : [mixins],
//   methods:{
//     consulta_general(){
//         var url = domain( url_all );
//         var fields = {};
//         var promise = MasterController.method_master(url,fields,"get");
//           promise.then( response => {
          
              
//           }).catch( error => {
//               if( error.response.status == 419 ){
//                     toastr.error( session_expired ); 
//                     redirect(domain("/"));
//                     return;
//                 }
//               toastr.error( error.response.data.message , expired );
//           });
//     }
//     ,insert_register(){
//       var validacion = ['cmb_estados'];
//       var url = domain( url_insert );
//         this.insert.id_estado = jQuery('#cmb_estados').val();
//         this.insert.giro_comercial = jQuery('#cmb_servicio').val();
//         var fields = this.insert;
//         var promise = MasterController.method_master(url,fields,"post");
//           promise.then( response => {
          
//               toastr.success( response.data.message , title );
//               redirect(domain(redireccion)); 
              
//           }).catch( error => {
//               if( error.response.status == 419 ){
//                     toastr.error( session_expired ); 
//                     redirect(domain("/"));
//                     return;
//                 }
//               toastr.error( error.response.data.message , expired );
//               redirect();
//           });
//     }
//     ,update_register(){
//        var url = domain( url_update );
//         this.edit.id_estado = jQuery('#cmb_estados_edit').val();
//         this.edit.giro_comercial = jQuery('#cmb_servicio_edit').val();
//         var fields = this.edit;
//         var promise = MasterController.method_master(url,fields,"put");
//           promise.then( response => {
//               toastr.success( response.data.message , title );
//               redirect(domain(redireccion));   
              
//           }).catch( error => {
//               if( error.response.status == 419 ){
//                     toastr.error( session_expired ); 
//                     redirect(domain("/"));
//                     return;
//                 }
//               toastr.error( error.response.data.message , expired );
//               // redirect();
//           });
//     }
//     ,edit_register( id ){
//         var url = domain( url_edit );
//         var fields = {id : id };
//         var promise = MasterController.method_master(url,fields,"get");
//           promise.then( response => {
          
//               // toastr.success( response.data.message , title );
//                this.edit = response.data.result;
//                // console.log(this.edit);
//                // return;
//                //this.edit.id = response.data.result.id;
//                if( response.data.result.contactos.length > 0 ){
//                    this.edit.contacto = response.data.result.contactos[0].nombre_completo;
//                    this.edit.departamento = response.data.result.contactos[0].departamento;
//                    this.edit.telefono = response.data.result.contactos[0].telefono;
//                    this.edit.correo = response.data.result.contactos[0].correo;
//                }

               
//                jQuery('#cmb_estados_edit').selectpicker("val",[response.data.result.id_estado]);
//                jQuery('#cmb_servicio_edit').selectpicker("val",[response.data.result.giro_comercial]);
//                jQuery('#modal_edit_register').modal('show');
               
              
//           }).catch( error => {
//               if( error.response.status == 419 ){
//                     toastr.error( session_expired ); 
//                     redirect(domain("/"));
//                     return;
//                 }
//               toastr.error( error.response.data.message , expired );
//               //redirect();
//           });
        
//     }
//     ,destroy_register( id ){
//         var url = domain( url_destroy );
//         var fields = {id : id };
//          buildSweetAlertOptions("¿Borrar Registro?","¿Realmente desea eliminar el registro?",function(){
//           var promise = MasterController.method_master(url,fields,"delete");
//           promise.then( response => {
//               toastr.success( response.data.message , title );
//                location.reload();
//           }).catch( error => {
//               if( error.response.status == 419 ){
//                     toastr.error( session_expired ); 
//                     redirect(domain("/"));
//                     return;
//                 }
//               toastr.error( error.response.data.message , expired );
//               redirect();
//           });
//       },"warning",true,["SI","NO"]);   
//     }
    
   
    
    
//   }


// });
var app = angular.module('ng-proveedores', ["ngRoute",'components','localytics.directives'])
app.controller('ProveedoresController', function( $scope, $http, $location ) {
    /*se declaran las propiedades dentro del controller*/
    $scope.constructor = function(){
        $scope.datos  = [];
        $scope.insert = {
          estatus: '1'
          ,id_regimen_fiscal: 0
          ,id_country: 151
          ,id_servicio_comercial: 0
        };
        $scope.update = {};
        $scope.edit   = {};
        $scope.fields = {};
        $scope.consulta_general();
        $scope.select_estado();
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
            html = '<img class="img-responsive" src="'+$scope.update.logo+'?'+Math.random()
            +'" height="268px" width="200px">'
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
            redirect(domain(redireccion));
            // $scope.consulta_general();
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