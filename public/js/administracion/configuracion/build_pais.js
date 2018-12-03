const URL = {
url_insert  : "pais/register"
,url_update   : "pais/update"
,url_edit     : "pais/edit"
,url_destroy  : "pais/destroy"
,url_all      : "pais/all"
,redireccion  : "configuracion/pais"
}

/*app.filter('filter', ['$sce', ( $sce ) => {
    return function( html ) {
      return $sce.trustAsHtml(html);
    };
}]);*/
/*app.config(function( $routeProvider ) {
    $routeProvider
    .when("/paises", {
        templateUrl : "/template_ng/table_paises.html",
        controller : "PaisesController"
    })
    .when("/london", {
        template : "<h1> Bienvenidos 2</h1>",
        //controller : "londonCtrl"
    })
    .when("/paris", {
        templateUrl : "paris.htm",
        controller : "parisCtrl"
    });
});*/
app.controller('PaisesController', function( $scope, $http ) {
    /*se declaran las propiedades dentro del controller*/
    $scope.constructor = function(){
    $scope.datos  = [];
    $scope.insert = {};
    $scope.update = {};
    $scope.edit   = {};
    $scope.fields = {};
    $scope.consulta_general();
  }

    $scope.consulta_general = function(){
        var url = domain( URL.url_all );
        var fields = {};
        MasterController.request_http(url,fields,'get',$http, false )
        .then(function(response){
            $scope.datos = response.data.result;
            
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
    
    $scope.insert_register = function( id ){
        var url = domain(  URL.url_insert );
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
      
      var url = domain(  URL.url_update );
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
      var url = domain(  URL.url_edit );
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

      var url = domain(  URL.url_destroy );
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