const URL = {
  url_insert            : "correos/register"
  ,url_update           : 'correos/update'
  ,url_edit             : 'correos/edit'
  ,url_all              : 'correos/all'
  ,url_destroy          : "correos/destroy"
  ,redireccion          : "correos/recibidos"
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
        $scope.selections = 0;
        $scope.checkboxes = {};
        $scope.index();
        $scope.iterar_correo();
    }

    $scope.index = function(){

        var url = domain( URL.url_all );
        var fields = {};        
        MasterController.request_http(url,fields,'get',$http, false )
        .then(function(response){
            //not remove function this is  verify the session
            if(masterservice.session_status( response )){return;};

            $scope.datos = response.data.result;
            for( var i in $scope.datos.correos){
                $scope.checkboxes[$scope.datos.correos[i].id] = false;
            }
            console.log($scope.datos );
            $myLocalStorage.remove('correos');

        }).catch(function(error){
            masterservice.session_status_error( error );
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
            redirect(domain(URL.redireccion));
            $scope.index();
        }).catch(function( error ){
           masterservice.session_status_error(error);
        });

    }
    $scope.time_fechas = function( fecha ){
      //$timeout(masterservice.time_fechas(fecha), 60000 );
      return masterservice.time_fechas(fecha);

    }

    $scope.iterar_correo = function(){
      
      $scope.insert.emisor        = (isset($myLocalStorage.get('correos')))?$myLocalStorage.get('correos').correo: "";
      $scope.insert.asunto        = (isset($myLocalStorage.get('correos')))?$myLocalStorage.get('correos').asunto: "";
      $scope.insert.descripcion   = (isset($myLocalStorage.get('correos')))?$myLocalStorage.get('correos').descripcion: "";
       
    }

    $scope.details_mails = function( data ){

      var datos = ['asunto','correo','descripcion'];
      var fields = iterar_object(data,datos,true);
      $scope.update_register(data.id, { estatus_vistos : false } );
      $myLocalStorage.set('correos',fields);
      $scope.iterar_correo();
      redirect( domain('correos/redactar') );

    }

    $scope.checkbox = function(){
        $scope.selections =  !$scope.selections;
        $scope.selected = !$scope.selected;
        for(var i in $scope.checkboxes){
            $scope.checkboxes[i] = $scope.selected;
        }

    }
    $scope.vistos_style = function( estatus_vistos ){

        var ruta = window.location.pathname.split('/');
        ruta = ruta[2]+"/"+ruta[3];
        if (estatus_vistos == 0 && ruta == "correos/recibidos") {
            return {
              'cursor' : 'pointer'
              ,'font-weight' : 'bold'
            };
          
        }

    }

    $scope.activity_register = function( id, destacados, estatus ){

      var ruta = window.location.pathname.split('/');
      ruta = ruta[2]+"/"+ruta[3];

      if (ruta == "correos/papelera") {
        var url = domain(URL.url_destroy);
        var object = {};
        object[id] = estatus;
        var fields = (!estatus)? $scope.checkboxes : object;

        MasterController.request_http(url,fields,'delete',$http, false )
        .then(function( response ){
          //not remove function this is  verify the session
          if(masterservice.session_status( response )){return;};

            toastr.success( response.data.message , title );
            $scope.index();
        }).catch(function( error ){
            masterservice.session_status_error(error);
        });

      }else{
          $scope.update_register( id, destacados );
      }
        
    }

    $scope.update_register = function( id, destacados ){

        var estatus = {};
        if (isset(destacados)) {
          for(var i in destacados){
              estatus[0] = {id : id }
              estatus[0][i] = !destacados[i];
          }

        }else{
          var count = 0;
          for(var i in $scope.checkboxes){
              estatus[count] = {
                id: i 
                ,estatus_papelera : $scope.checkboxes[i]
              };
              count ++;
          }

        }
        //console.log(estatus);return;
        //console.log($scope.checkboxes);return;
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