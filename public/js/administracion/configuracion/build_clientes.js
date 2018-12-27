const URL = {
  url_insert            : "clientes/register"
  ,url_update           : 'clientes/update'
  ,url_edit             : 'clientes/edit'
  ,url_all              : 'clientes/all'
  ,url_destroy          : "clientes/destroy"
  ,url_destroy_files    : "clientes/files_destroy"
  ,url_upload_clientes  : 'clientes/uploads'
  ,redireccion          : "configuracion/clientes"
  ,url_display          : "clientes/display_sucursales"
  ,url_insert_permisos  : "clientes/register_permisos"
  ,url_edit_pais        : 'pais/edit'
  ,url_edit_codigos     : 'codigopostal/show'
  ,url_upload           : 'upload/files'
  ,url_update_estatus   : 'clientes/estatus'
  ,url_comments         : 'activities/register'
  ,url_comments_destroy : 'activities/destroy'
}

app.controller('ClientesController', function( masterservice, $scope, $http, $location, $timeout, $rootScope ) {
    /*se declaran las propiedades dentro del controller*/
    $scope.constructor = function(){
        $scope.datos  = [];
        $scope.contact  = {  id_study : 1 };
        $scope.insert = {
          estatus: 0 ,id_country: 151 ,id_servicio_comercial: 1
        };
        $scope.update         = {};
        $scope.comments       = {};
        $scope.list_comments  = {};
        $scope.archivos       = {};
        $scope.edit           = {};
        $scope.fields         = {};
        $scope.readonly = true;
        $scope.active_detalles = "";
        $scope.active_contactos = "active";
        $scope.select_estado();
        $scope.dropdown();
        $scope.index();
    }
    $scope.dropdown = function(){
      $scope.estudios = [
          {id:1, nombre: "ING"} ,{id:2, nombre: "LIC"} ,{id:3, nombre: "ARQ"}
      ];
      
      $scope.tasks = [
          {id:1, nombre: "LLAMADA"} ,{id:2, nombre: "REUNION"}
      ];

      $scope.cmb_estatus = [
        {id:0 ,nombre:"Prospectos"}, {id:1, nombre:"Clientes"}
      ];

    }
    $scope.click = function (){
      $location.path("/register");
    }
    $scope.index = function(){

        var url = domain( URL.url_all );
        var fields = {};        
        MasterController.request_http(url,fields,'get',$http, false )
        .then(function(response){
            //not remove function this is  verify the session
            if(masterservice.session_status( response )){return;};

            $scope.datos = response.data.result;
            //$rootScope.$emit("services", {});
            console.log($scope.datos);
        }).catch(function(error){
            masterservice.session_status_error(error);
        });
    
    }
    $scope.insert_register = function(){

        var validacion = {
            'RAZON SOCIAL'     : $scope.insert.razon_social
            ,'RFC'             : $scope.insert.rfc_receptor
          };
        if(validaciones_fields(validacion)){return;}
        if( !valida_rfc($scope.insert.rfc_receptor) ){
            toastr.error("RFC Incorrecto","Ocurrio un error, favor de verificar");
            return;
        }
        var url = domain( URL.url_insert );
        var fields = { cliente: $scope.insert };
        jQuery.fancybox.close({
            'type'      : 'inline'
            ,'src'      : "#modal_add_register"
            ,'modal'    : true
        });
        MasterController.request_http(url,fields,'post',$http, false )
        .then(function( response ){
            //not remove function this is  verify the session
            if(masterservice.session_status( response )){return;};

            $scope.insert = {};
            $scope.insert.estatus  = 0;
            toastr.success( response.data.message , title );
            $scope.index();
        }).catch(function( error ){
           masterservice.session_status_error(error);
        });

    }
    $scope.insert_register_contacto = function(){

        var validacion = {
           'CORREO'          : $scope.contact.correo
          ,'NOMBRE CONTACTO' : $scope.contact.contacto
          ,'TELEFONO'        : $scope.contact.telefono
        };
        if(validaciones_fields(validacion)){return;}
        if( !emailValidate( $scope.contact.correo ) ){  
            toastr.error("Correo Incorrecto","Ocurrio un error, favor de verificar");
            return;
        }
          var url = domain( URL.url_insert );
          var fields = { contactos : $scope.contact, cliente : $scope.insert };
        
        MasterController.request_http(url,fields,'post',$http, false )
          .then(function( response ){
              //not remove function this is  verify the session
              if(masterservice.session_status( response )){return;};
              
               $scope.active_contactos = "";
               $scope.active_detalles  = "active";
              buildSweetAlertOptions("¡Detalles de Facturación!","¿Desea capturar los Detalles de Facturación?",function(){
                   
                    toastr.success( response.data.message , title );
                    $scope.contact = {};
                    $scope.insert.id = response.data.result.id;
                    $scope.insert.estatus  = 0;
                    $scope.index();


              },"warning",true,["SI","NO"],function(){
                  $scope.active_contactos = "active";
                  $scope.active_detalles  = "";
                  $scope.insert = {};
                  $scope.contact = {};
                  $scope.insert.estatus  = 0;
                  $scope.index();
                  jQuery.fancybox.close({
                      'type'      : 'inline'
                      ,'src'      : "#modal_add_register"
                      ,'modal'    : true
                  });      
              });

          }).catch(function( error ){
             masterservice.session_status_error(error);
          });

    }
    $scope.update_register = function( dblclick = false ){

      var validacion = {
            'RAZON SOCIAL'     : $scope.update.razon_social
            ,'RFC'             : $scope.update.rfc_receptor
          };
        if(validaciones_fields(validacion)){return;}
        if( !valida_rfc($scope.update.rfc_receptor) ){
            toastr.error("RFC Incorrecto","Ocurrio un error, favor de verificar");
            return;
        }
      var url = domain( URL.url_update );
      var fields = $scope.update;
      MasterController.request_http(url,fields,'put',$http, false )
      .then(function( response ){
          //not remove function this is  verify the session
          if(masterservice.session_status( response )){return;};

          toastr.info( response.data.message , title );
          if (!dblclick) {
            jQuery('#modal_edit_register').modal('hide');
          }
          $scope.list_comments = response.data.result.actividades;
          //$scope.list_comments = [{titulo: "copia", descripcion: "copia desc"}];
          $scope.index();
          jQuery('#tr_'+$scope.update.id).effect("highlight",{},5000);
      }).catch(function( error ){
          masterservice.session_status_error(error);
      });

    }
    $scope.update_register_contacto = function( dblclick = false ){

        var validacion = {
             'CORREO'          : $scope.update.correo
            ,'NOMBRE CONTACTO' : $scope.update.contacto
            ,'TELEFONO'        : $scope.update.telefono
          };
        if(validaciones_fields(validacion)){return;}
        if( !emailValidate( $scope.update.correo ) ){  
            toastr.error("Correo Incorrecto","Ocurrio un error, favor de verificar");
            return;
        }
        var url = domain( URL.url_update );
        var fields = $scope.update;
        MasterController.request_http(url,fields,'put',$http, false )
        .then(function( response ){
            //not remove function this is  verify the session
            if(masterservice.session_status( response )){return;};

            toastr.info( response.data.message , title );
            if (!dblclick) {
               jQuery('#modal_edit_register').modal('hide');
            }
            $scope.list_comments = response.data.result.actividades;
            //$scope.list_comments = [{titulo: "copia", descripcion: "copia desc"}];
            $scope.index();
            jQuery('#tr_'+$scope.update.id).effect("highlight",{},5000);
        }).catch(function( error ){
            masterservice.session_status_error(error);
        });
      
    }
    $scope.edit_register = function( id ){
      
      var url = domain( URL.url_edit );
      var fields = {id : id };
      MasterController.request_http(url,fields,'get',$http, false )
        .then(function( response ){
          //not remove function this is  verify the session
          if(masterservice.session_status( response )){return;};

            var datos = ['updated_at','created_at'];
            $scope.update = iterar_object(response.data.result,datos);
           if( response.data.result.contactos.length > 0 ){
               $scope.update.contacto     = response.data.result.contactos[0].nombre_completo;
               $scope.update.departamento = response.data.result.contactos[0].departamento;
               $scope.update.telefono     = response.data.result.contactos[0].telefono;
               $scope.update.correo       = response.data.result.contactos[0].correo;
               $scope.update.cargo        = response.data.result.contactos[0].cargo;
               $scope.update.extension    = response.data.result.contactos[0].extension;
               $scope.update.id_study     = response.data.result.contactos[0].id_study;
           }
           $scope.list_comments = response.data.result.actividades;
           $scope.archivos = response.data.result.archivos;

           $scope.select_estado(1);
           $scope.select_codigos(1);
            var html = '';
            html = '<img class="img-responsive" src="'+$scope.update.logo+'?'+Math.random()+'" height="268px" width="200px">'
            jQuery('#imagen_edit').html("");        
            jQuery('#imagen_edit').html(html); 
            loading(true);
          /*jQuery.fancybox.open({
                'type'      : 'inline'
                ,'src'      : "#modal_edit_register"
                ,'modal': true
            });*/
            jQuery('#modal_edit_register').modal({
              keyboard: false,
              backdrop: "static",
              show    : true
            });

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
    $scope.destroy_files =  function(id){

        var url = domain( URL.url_destroy_files );
        var fields = {
           id         : id 
          ,id_cliente : $scope.update.id 
        };

        buildSweetAlertOptions("¿Borrar Registro?","¿Realmente desea eliminar el registro?",function(){
          MasterController.request_http(url,fields,'delete',$http, false )
          .then(function( response ){
            //not remove function this is  verify the session
            if(masterservice.session_status( response )){return;};

              toastr.success( response.data.message , title );
              $scope.archivos = response.data.result.archivos;
          }).catch(function( error ){
              masterservice.session_status_error(error);
          });
            
        },"warning",true,["SI","NO"]);  

    }
    $scope.select_estado = function( update = false){

      var url = domain( URL.url_edit_pais );
      var fields = { id: (!update)? $scope.insert.id_country: $scope.update.id_country};
      MasterController.request_http(url,fields,"get",$http,false)
      .then( response => {
          //not remove function this is  verify the session
          if(masterservice.session_status( response )){return;};

          $scope.cmb_estados = {};
          $scope.cmb_estados = response.data.result.estados;
          console.log($scope.cmb_estados);
          loading(true);
      }).catch( error => {
          masterservice.session_status_error(error);
      });

    }

    $scope.select_codigos = function( update = false ){

      var url = domain( URL.url_edit_codigos );
      var fields = {id: (!update)? $scope.insert.id_estado:$scope.update.id_estado};
      MasterController.request_http(url,fields,"get",$http,false)
      .then( response => {
          //not remove function this is  verify the session
          if(masterservice.session_status( response )){return;};

          $scope.cmb_codigos = response.data.result;
          console.log($scope.cmb_codigos);
          loading(true);
      }).catch( error => {
          masterservice.session_status_error(error);
      }); 
    }
    
    $scope.display_sucursales = function( id ) {

       var id_empresa = jQuery('#cmb_empresas_'+id).val().replace('number:','');
       var url = domain( URL.url_display );
       var fields = { 
           id_empresa : id_empresa
           ,id_cliente : id
       };
       $scope.fields.id_empresa = id_empresa;
       $scope.fields.id_cliente = id;
       MasterController.request_http(url, fields, "get", $http ,false)
       .then(response => {
            //not remove function this is  verify the session
          if(masterservice.session_status( response )){return;};

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
            , 'id_cliente': $scope.fields.id_cliente
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
            jQuery('#tr_'+$scope.fields.id_cliente).effect("highlight",{},5000);
            $scope.index();
        }).catch(error => {
           masterservice.session_status_error(error);
        });

    }
    $scope.update_estatus = function( id ){

        var url = domain( URL.url_update_estatus );
        var fields = {id: id, estatus: 1 };
        buildSweetAlertOptions("¿Cambiar a Cliente?","¿Realmente desea cambiar a cliente este prospecto?",function(){
          MasterController.request_http(url,fields,'put',$http, false )
          .then(function( response ){
              //not remove function this is  verify the session
              if(masterservice.session_status( response )){return;};
              
               toastr.info( response.data.message , title );
               jQuery('#tr_'+id).effect("highlight",{},5000);
               buildSweetAlert('# '+id,'Se genero el cliente con exito','success');
               $scope.index();
          }).catch(function( error ){
              masterservice.session_status_error(error);
          });
            
        },"warning",true,["SI","NO"]); 

    }
    $scope.save_activities = function(update){

      var validacion = { 
        ASUNTO          : $scope.activities.titulo 
        ,ASIGNADO       : $scope.activities.id_users 
        ,ACTIVIDAD      : $scope.activities.descripcion 
      };
      if(validaciones_fields(validacion)){return;}

        var url     = domain( URL.url_comments );
        var fields  = { id: (update)? $scope.update.id : $scope.insert.id , comentarios : $scope.activities};

        MasterController.request_http(url,fields,'post',$http, false )
          .then(function( response ){
              //not remove function this is  verify the session
              if(masterservice.session_status( response )){return;};
              //$scope.comment = false;
              $scope.activities = {};
              $scope.list_comments = response.data.result.actividades;
              jQuery('#modal_see_activities').modal('hide');
              //jQuery('#tr_'+$scope.update.id).effect("highlight",{},5000);
          }).catch(function( error ){
              masterservice.session_status_error( error );
          });

    }
    $scope.destroy_comment = function( id ){
        
        var url = domain( URL.url_comments_destroy );
        var fields = { id: id ,id_cliente : $scope.update.id  };
        buildSweetAlertOptions("¿Borrar Registro?","¿Realmente desea borrar el registro?",function(){
          MasterController.request_http(url,fields,'delete',$http, false )
          .then(function( response ){
              //not remove function this is  verify the session
              if(masterservice.session_status( response )){return;};

              toastr.info( response.data.message , title );
              $scope.list_comments = response.data.result.actividades;
          }).catch(function( error ){
              masterservice.session_status_error(error);
          });
            
        },"warning",true,["SI","NO"]); 

    }
   /* $scope.see_comment = function(hide = false){
        
        $scope.comments = {};
        if(hide){ $scope.comment = false;
        }else{ $scope.comment = true; }

    }*/
    $scope.time_fechas = function( fecha ){
      //$timeout(masterservice.time_fechas(fecha), 60000 );
      return masterservice.time_fechas(fecha);

    }
    $scope.upload_file = function(update){

      var upload_url = domain( URL.url_upload );
      var identificador = {
         div_content   : 'div_dropzone_file_clientes'
        ,div_dropzone  : 'dropzone_xlsx_file_clientes'
        ,file_name     : 'file'
      };
      var message = "Dar Clíc aquí o arrastrar archivo";
      $scope.update.logo = "";
      upload_file({'nombre': 'cliente_'+$scope.update.id },upload_url,message,1,identificador,'.png',function( request ){
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
    $scope.upload_files = function( id ){
      
      var upload_url = domain( URL.url_upload_clientes );
      var identificador = {
         div_content   : 'div_dropzone_files_clientes'
        ,div_dropzone  : 'dropzone_xlsx_files_clientes'
        ,file_name     : 'file'
      };
      var message = "Dar Clíc aquí o arrastrar archivo";
      var fields = {
        ruta   : "upload_file/archivos/clientes/"
        ,id     : id
        /*,nombre : id+"-"+Math.floor((Math.random() * 99999999999) + 1)*/
      };
      upload_file(fields,upload_url,message,10,identificador,'.pdf, .png, .xml, .xls, .jpg, .jpeg, .txt, .doc , .docx',function( request ){
        console.log($scope.archivos);
        toastr.success( request.message , title );
        $scope.archivos = request.result.archivos;
        $scope.index();
        jQuery('#upload_files').modal('hide');

      });
        
        jQuery('#upload_files').modal({
          keyboard: false,
          backdrop: "static",
          show    : true
        });
    
    }
    $scope.see_activities = function( id ){

      var url = domain( URL.url_edit );
      var fields = {id : id };
      MasterController.request_http(url,fields,'get',$http, false )
        .then(function( response ){
          //not remove function this is  verify the session
          if(masterservice.session_status( response )){return;};
          
          $scope.update.id  = id;
          $scope.list_comments = response.data.result.actividades;
          loading(true);
          jQuery.fancybox.open({
                'type'      : 'inline'
                ,'src'      : "#modal_see_activities"
                ,'modal': true
            });

        }).catch(function( error ){
            masterservice.session_status_error(error);
        });

    }



});

jQuery('#clientes_tabs').click(function(){
   jQuery('#form_general > #search_general').removeAttr('onkeyup');
   jQuery('#form_general > #search_general').attr("onkeyup","buscador_general(this,'#datatable_clientes',false)");
   jQuery('#form_general > #search_general').val("");
   jQuery('#form_general > #search_general').keyup();
});
jQuery('#prospectos_tabs').click(function(){
   jQuery('#form_general > #search_general').removeAttr('onkeyup');
   jQuery('#form_general > #search_general').attr("onkeyup","buscador_general(this,'#datatable')");
   jQuery('#form_general > #search_general').val("");
   jQuery('#form_general > #search_general').keyup();
});
//jQuery('#cmb_estados').selectpicker();
//jQuery('#cmb_estados_edit').selectpicker();