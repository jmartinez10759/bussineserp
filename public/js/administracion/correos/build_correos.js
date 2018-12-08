const URL = {
  url_insert            : "correos/register"
  ,url_update           : 'correos/update'
  ,url_edit             : 'correos/edit'
  ,url_all              : 'correos/all'
  ,url_destroy          : "correos/destroy"
  ,redireccion          : "configuracion/recibidos"
  ,url_envios           : "correos/send"
  ,url_display          : "correos/display_sucursales"
  ,url_insert_permisos  : "correos/register_permisos"
  ,url_edit_pais        : 'pais/edit'
  ,url_edit_codigos     : 'codigopostal/show'
  ,url_upload           : 'upload/files'
  ,url_update_estatus   : 'correos/estatus'
  ,url_comments         : 'activities/register'
  ,url_comments_destroy : 'activities/destroy'
}

app.controller('CorreosController', function( masterservice, $scope, $http, $location, $timeout ) {
    /*se declaran las propiedades dentro del controller*/
    $scope.constructor = function(){
        $scope.datos  = [];
        $scope.insert = {};
        $scope.update = {};
        $scope.comments = {};
        $scope.list_comments = {};
        $scope.edit   = {};
        $scope.fields = {};
        $scope.index();
    }

    $scope.index = function(){

        var url = domain( URL.url_all );
        var fields = {};        
        MasterController.request_http(url,fields,'get',$http, false )
        .then(function(response){
            //not remove function this is  verify the session
            if(masterservice.session_status( response )){return;};

            $scope.datos = response.data.result;
            console.log($scope.datos);
            
        }).catch(function(error){
            masterservice.session_status_error( error );
        });
    
    }
    $scope.insert_register = function(){

        var validacion = {
             'CORREO'          : $scope.insert.correo
            ,'NOMBRE CONTACTO' : $scope.insert.contacto
            ,'RAZON SOCIAL'    : $scope.insert.razon_social
            ,'RFC'             : $scope.insert.rfc_receptor
            ,'TELEFONO'        : $scope.insert.telefono
          };
        if(validaciones_fields(validacion)){return;}
        if( !emailValidate( $scope.insert.correo ) ){  
            toastr.error("Correo Incorrecto","Ocurrio un error, favor de verificar");
            return;
        }
        if( !valida_rfc($scope.insert.rfc_receptor) ){
            toastr.error("RFC Incorrecto","Ocurrio un error, favor de verificar");
            return;
        }
        var url = domain( URL.url_insert );
        var fields = $scope.insert;
        jQuery.fancybox.close({
            'type'      : 'inline'
            ,'src'      : "#modal_add_register"
            ,'modal'    : true
        });
        MasterController.request_http(url,fields,'post',$http, false )
        .then(function( response ){
            //not remove function this is  verify the session
            if(masterservice.session_status( response )){return;};

            toastr.success( response.data.message , title );
            $scope.index();
        }).catch(function( error ){
           masterservice.session_status({},error);
        });

    }

    $scope.send_correo =  function(){

        var validacion = {
             'CORREO'   : $scope.insert.emisor
            ,'ASUNTO'   : $scope.insert.asunto
          };
        if(validaciones_fields(validacion)){return;}
        if( !emailValidate( $scope.insert.emisor ) ){  
            toastr.error("Correo Incorrecto","Ocurrio un error, favor de verificar");
            return;
        }
        $scope.insert.descripcion = jQuery('.compose-textarea').val();
        var url = domain(URL.url_envios);
        var fields = $scope.insert;

        MasterController.request_http(url,fields,'post',$http, false )
        .then(function( response ){
            //not remove function this is  verify the session
            if(masterservice.session_status( response )){return;};

            toastr.success( response.data.message , title );
            $scope.index();
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
           $scope.select_estado(1);
           $scope.select_codigos(1);
            var html = '';
            html = '<img class="img-responsive" src="'+$scope.update.logo+'?'+Math.random()+'" height="268px" width="200px">'
            jQuery('#imagen_edit').html("");        
            jQuery('#imagen_edit').html(html); 
            loading(true);
          jQuery.fancybox.open({
                'type'      : 'inline'
                ,'src'      : "#modal_edit_register"
                ,'modal': true
            });

        }).catch(function( error ){
            masterservice.session_status({},error);
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
            masterservice.session_status({},error);
        });
          
      },"warning",true,["SI","NO"]);  
    }

    $scope.register_comment = function(update){

      var validacion = { COMENTARIO : $scope.comments.descripcion };
      if(validaciones_fields(validacion)){return;}

        var url = domain( URL.url_comments );
        var fields = { id: (update)? $scope.update.id : $scope.insert.id , comentarios : $scope.comments};
        MasterController.request_http(url,fields,'post',$http, false )
          .then(function( response ){
              //not remove function this is  verify the session
              if(masterservice.session_status( response )){return;};

              $scope.comment = false;
              $scope.comments = {};
              $scope.list_comments = response.data.result.actividades;
              loading(true);
              //jQuery('#tr_'+$scope.update.id).effect("highlight",{},5000);
          }).catch(function( error ){
              masterservice.session_status({},error);
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
              loading(true);
          }).catch(function( error ){
              masterservice.session_status({},error);
          });
            
        },"warning",true,["SI","NO"]); 

    }

    $scope.see_comment = function(hide = false){
        
        $scope.comments = {};
        if(hide){ $scope.comment = false;
        }else{ $scope.comment = true; }

    }

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

    $scope.see_activities = function( id ){

      var url = domain( URL.url_edit );
      var fields = {id : id };
      MasterController.request_http(url,fields,'get',$http, false )
        .then(function( response ){
          $scope.update.id  = id;
          $scope.list_comments = response.data.result.actividades;
          loading(true);
          jQuery.fancybox.open({
                'type'      : 'inline'
                ,'src'      : "#see_activities"
                ,'modal': true
            });

        }).catch(function( error ){
            masterservice.session_status({},error);
        });

    }

    $scope.checkbox = function(){
        $scope.selections =  !$scope.selections;
        $scope.selected = !$scope.selected;
    }

    $scope.update_register = function( id, destacados ){
        var estatus = {};
        for(var i in destacados){
            estatus = {id: id};
            estatus[i] = !destacados[i];
        }
        //console.log(estatus);return;
        var url = domain( URL.url_update );
        var fields = estatus
        MasterController.request_http(url,fields,'put',$http, false )
          .then(function( response ){
            //not remove function this is  verify the session
            if(masterservice.session_status( response )){return;};
            $scope.index();
            
          }).catch(function( error ){
              masterservice.session_status_error( error );
          });

    }



});


/*new Vue({
  el: "#vue-redactar",
  created: function () {
    this.consulta_general();
  },
  data: {
    datos: [],
    newKeep: {
      'emisor': ""
      ,'asunto': ""
      ,'archivo': ""
    },
    fillKeep: {
      'emisor': ""
      ,'asunto': ""
      ,'archivo': ""
    },

  },
  mixins : [mixins],
  methods:{
    consulta_general: function(){}
    ,send_correo: function(){

        if( this.newKeep.emisor == "" || this.newKeep.asunto == ""){
          toastr.error( 'Favor de verificar los campos de color rojo!' , "Campos Vacios" );
          if( this.newKeep.emisor == ""){
            jQuery('#emisor').parent().addClass('has-error');
          }else{
            jQuery('#asunto').parent().addClass('has-error');
          }
          return;
        }
        if( !emailValidate( this.newKeep.emisor.toLowerCase().trim() ) ){
            toastr.error( 'Favor de verificar los campos de color rojo!' , "Correo Incorrecto" );
            jQuery('#emisor').parent().addClass('has-error');
            return;
        }
        this.newKeep.descripcion = jQuery('#compose-textarea').val();
        var url = domain('correos/send');
        var refresh = "";
        this.insert_general(url,refresh,function(response){
            //jQuery('#modal_add_correo').modal('hide');
            redirect( domain('correos/recibidos') );
        },function(){});
    }
  }


});

new Vue({
  el: "#vue-recibidos",
  created: function () {
    //this.consulta_general();
  },
  data: {
    datos: [],
    newKeep: {
      'categoria':""
      ,'descripcion':""
       ,'emisor': ""
       ,'id_estate' : ""
       ,'attachment' : ""
    },
    fillKeep: {
      'categoria':""
      ,'descripcion':""
    },

  },
  mixins : [mixins],
  methods:{
    consulta_general: function(){
      var url = domain('correos/show');
      var fields = {};
      axios.get( url, { params: fields }, csrf_token ).then(response => {
          console.log( response.data.result );
          if( response.data.success == true ){
            this.datos = response.data.result;
          }else{
            toastr.error( response.data.message, "¡Bandeja de entrada Vacia !" );
          }
      }).catch(error => {
          toastr.error( error, expired );
      });

    }
    ,estatus_papelera: function( id_correo ){
        //necesito barrer todos los checkebox si estan checked
        var matrix_check = [];
        var i = 0;
        if( id_correo == undefined ){
          jQuery('.mailbox-messages input[type="checkbox"]').each(function(){
            if(jQuery(this).is(':checked') == true){
              var id_correo = jQuery(this).attr('id');
              matrix_check[i] = `${id_correo}|${jQuery(this).is(':checked')}`;
              i++;
            }

          });

        }else{
          matrix_check = [`${id_correo}|true`];
        }
        console.log(matrix_check);
        var url = domain('correos/papelera');
        var fields = { 'matrix' : matrix_check };
        axios.post( url, fields , csrf_token ).then(response => {
            console.log( response.data.result );
            if( response.data.success == true ){
                //redirect( domain('correos/recibidos') );
                location.reload();
            }else{
              toastr.error( response.data.message, "¡Oops !" );
            }
        }).catch(error => {
            toastr.error( error, expired );
        });

    }
    ,insert_categorias: function(){

      var url = domain('categorias/insert');
      this.insert_general( url, '', function(){
          //redirect(domain(''));
          location.reload();
      }, function(){} );

    }
    ,redactar(request){
        //jQuery('#modal_add_correo').modal('show');
        this.datos = request;
        for (var i in this.newKeep) {this.newKeep[i] = ""; }
        this.newKeep.emisor = this.datos.correo;
        jQuery('#modal_add_detalles').modal('show');
        jQuery('.mensaje').show('slow');
        jQuery('.recibidos').hide('slow');
       //jQuery('#modal_add_detalles').hide();
       //this.redactar(this.datos.correo);
    }
    ,modal_show( id_correo, identificador ){
        jQuery(`#${identificador}`).modal('show');
        switch(identificador) {
          case "modal_add_notas":
                console.log(identificador);
              break;
          case "modal_add_citas":
                console.log(identificador);
              break;
          }


    }
    ,send_correo: function(){
        if( this.newKeep.asunto == "" || this.newKeep.emisor == ""){
          toastr.error( 'Favor de verificar los campos de color rojo!' , "Campos Vacios" );
          if(this.newKeep.emisor == ""){
            jQuery('#emisor').parent().addClass('has-error');
          }else{
            jQuery('#asunto').parent().addClass('has-error');
          }
          return;
        }
        if( !emailValidate( this.newKeep.emisor.toLowerCase().trim() ) ){
            toastr.error( 'Favor de verificar los campos de color rojo!' , "Correo Incorrecto" );
            jQuery('#emisor').parent().addClass('has-error');
            return;
        }
        this.newKeep.descripcion = jQuery('.compose-textarea').val();
        var url = domain('correos/send');
        var refresh = "";
        this.insert_general(url,refresh,function(response){
            //jQuery('#modal_add_correo').modal('hide');
            redirect( domain('correos/recibidos') );
        },function(){});
    }
    ,details_mails: function( id_correo, object ){

        var correos = [];
        var atributo = "";
        var j = 0;
        for(var i=0; i < jQuery('#bandeja_correos').children('tbody').children('tr').length; i++){
            correos[j] = jQuery('#bandeja_correos').children('tbody').children('tr')[i];
            j++;
        }
        for(var i=0; i < correos.length; i++){
            if(jQuery(correos[i]).attr('id_email') == id_correo ){
                jQuery(correos[i]).removeClass('info');
                jQuery(correos[i]).attr('style','cursor: pointer; font-weight: none;');
            }
        }
        var url = domain('correos/detalles');
        var refresh = location.href;
        var fields = { 'id': id_correo }
        axios.get( url, { params: fields }, csrf_token ).then(response => {
            console.log( response.data.result );
            if( response.data.success == true ){
                this.datos = response.data.result;
                 jQuery('#modal_add_detalles').modal('show');
                 jQuery('.mensaje').hide('slow');
                 jQuery('.recibidos').show('slow');
            }else{
              toastr.error( response.data.message, "¡No se mostro detalles del Correo.!" );
            }
        }).catch(error => {
            toastr.error( error, expired );
        });

    }
    ,mostrar: function (){
         jQuery('.mensaje').show('slow');
         jQuery('.recibidos').hide('slow');
        //jQuery('#modal_add_detalles').hide();
        for (var i in this.newKeep) {this.newKeep[i] = ""; }
        this.newKeep.asunto = this.datos.asunto;
        this.newKeep.emisor = this.datos.correo;
    }

  }

});
*/