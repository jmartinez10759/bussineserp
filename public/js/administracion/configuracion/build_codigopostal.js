const URL = {
url_insert : "codigopostal/register"
,url_update  : "codigopostal/update"
,url_edit    : "codigopostal/edit"
,url_destroy : "codigopostal/destroy"
,url_all     : "codigopostal/all"
,redireccion : "configuracion/codigopostal"
}


app.controller('CodigoPostal', function( $scope, $http ) {
    /*se declaran las propiedades dentro del controller*/
    $scope.constructor = function(){
    $scope.datos  = [];
    $scope.insert = {};
    $scope.update = {};
    $scope.edit   = {};
    $scope.fields = {};
  }

    $scope.consulta_general = function(){
        var url = domain( URL.url_all );
        var fields = {};
        MasterController.request_http(url,fields,'get',$http, false )
        .then(function(response){
            $scope.datos = response.data.result;
        //     var registros = [];
        //     var j = 0;
        //     for (var i = 0; i < $scope.datos.length; i++) {
        //       registros[j] = [
        //         $scope.datos[i].id
        //         ,$scope.datos[i].codigo_postal
        //         ,$scope.datos[i].estado
        //         ,$scope.datos[i].municipio
        //         ,$scope.datos[i].localidad
        //         ,'<button type="button" class="btn btn-primary" ng-click="edit_register('+$scope.datos[i].id+')">Editar</button>'
        //         ,'<button type="button" class="btn btn-danger" ng-click="delete_register('+$scope.datos[i].id+')">Borrar</button>'
        //       ];
        //       j++;
        //     }
        // var titulos = ['id', 'Código Postal','Estado','Municipio','Localidad','',''];
        // var table = {
        //     'titulos'         : titulos
        //     ,'registros'      : registros
        //     ,'id'             : "datatable"
        //     ,'class'          : "fixed_header"
        //   };
        //   $scope.fields = data_table(table);
          //jQuery('#data_table').html(data_table(table));
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
    $scope.consulta_general();
    $scope.insert_register = function( id ){
        var url = domain( URL.url_insert );
        // var fields = {id: id };
        var fields = $scope.insert;
        MasterController.request_http(url,fields,'post',$http, false )
        .then(function( response ){
            //$scope.consulta_general();
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
              console.error(error);
              toastr.error( error.message , expired );
        });
    }

    
    $scope.update_register = function(){

      
      $scope.update = $scope.edit;
      
      var url = domain( URL.url_update );
      var fields = $scope.edit;
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
      var url = domain( URL.url_edit );
      var fields = {id : id };
      MasterController.request_http(url,fields,'get',$http, false )
        .then(function( response ){

           $scope.edit = response.data.result;
          
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

      var url = domain( URL.url_destroy );
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



});