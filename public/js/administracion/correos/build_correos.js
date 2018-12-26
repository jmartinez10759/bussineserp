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
        $scope.files = {};
    }

    $scope.index = function(){

        var url = domain( URL.url_all );
        var fields = {};        
        MasterController.request_http(url,fields,'get',$http, false )
        .then(function(response){
            //not remove function this is  verify the session
            if(masterservice.session_status( response )){return;};

            $scope.datos = response.data.result;
            $scope.list_correos = response.data.result.contactos;
            for( var i in $scope.datos.total_correos.correos){
                $scope.checkboxes[$scope.datos.total_correos.correos[i].id] = false;
            }
            console.log($scope.datos );
            $myLocalStorage.remove('correos');

        }).catch(function(error){
            masterservice.session_status_error( error );
        });
    
    }

    $scope.resend = function(){
      console.log($scope.edit);
      $scope.send_correo(true);

    }

    $scope.readFile = function( $event ){
        var count = 0;
        $scope.files[count] = $event.target.files;  
        count ++;
        console.log($scope.files);
    }

    $scope.send_correo =  function( resend = false ){

      if (!resend ) {
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
        
      }
      /*se catch el archivo si es que se mando uno y se muestra en pantalla*/     
      /*  var fd = new FormData();
        console.log( $scope.files );
        angular.forEach($scope.files,function(file){
          fd.append('file',file);
        });
      
      return;*/
        var fields = (!resend)? $scope.insert : $scope.edit ;
        var url = domain(URL.url_envios);

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

    $scope.reply = function( data, estatus = false ){

      if (!estatus && data ) {
        var datos = ['asunto','correo','descripcion'];
        var fields = iterar_object(data,datos,true);
      }else{
        var object = {};
        object['correo'] = $scope.edit.emisor;
        object['asunto'] = $scope.edit.asunto;
        var fields = object;
      }
      $myLocalStorage.set('correos',fields);
      $scope.iterar_correo();
      redirect( domain('correos/redactar') );
      
    }
    
    $scope.details_mails = function( data ){

      var datos = ['asunto','correo','descripcion'];
      var fields = iterar_object(data,datos,true);
      $scope.update_register(data.id, { estatus_vistos : false } );

      $scope.edit.emisor      = data.correo
      $scope.edit.asunto      = data.asunto
      $scope.edit.descripcion = data.descripcion;
      
      jQuery('#modal_add_detalles').modal({backdrop: 'static', keyboard: false});
      jQuery('#modal_add_detalles').modal('show');
      

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
    $scope.autocomplete = function( string ){

        var output=[];
        angular.forEach( $scope.list_correos ,function( correos ){

            if( string.length > 0){
              if( correos.toLowerCase().indexOf( string.toLowerCase() ) >= 0 ){
                  output.push(correos);
              }
            }else{
              output = [];
            }

        });
        $scope.filter = output;
        console.log($scope.filter);
    }

    $scope.fillTextbox=function( string ){
      $scope.insert.emisor = string;
      $scope.filter  = null;
    }




});