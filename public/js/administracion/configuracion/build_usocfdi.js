const URL = {
url_insert   : "usocfdi/register"
,url_update   :  "usocfdi/update"
,url_edit     :  "usocfdi/edit"
,url_destroy  :  "usocfdi/destroy"
,url_all      :  "usocfdi/all"
,redireccion  :  "configuracion/usocfdi"
}
app.controller('UsoCfdiController', function( masterservice, $scope, $http, $location ) {
    /*se declaran las propiedades dentro del controller*/
    $scope.constructor = function(){
        $scope.datos  = [];
        $scope.insert = {};
        $scope.update = {};
        $scope.edit   = {};
        $scope.fields = {};
        $scope.index();
    }

    $scope.click = function (){
      $location.path("/register");
      //$scope.index();
    }
    
    $scope.index = function(){

        var url = domain( URL.url_all );
        var fields = {};
        MasterController.request_http(url,fields,'get',$http, false )
        .then(function(response){
            loading(true);
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

        
        var url = domain( URL.url_insert );
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

    }

    $scope.update_register = function(){     
      var url = domain( URL.url_update );
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
          
          // console.log($scope.update);return;
          $scope.index();
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

      var url = domain( URL.url_edit );
      var fields = {id : id };
      MasterController.request_http(url,fields,'get',$http, false )
        .then(function( response ){
            $scope.update = response.data.result;

          jQuery.fancybox.open({
                "type"      : "inline"
                ,"src"      : "#modal_edit_register"
                ,"modal"    : true
                ,"width"    : 900
                ,"height"   : 400
                ,"autoSize" : false
            });  
            loading(true);        
            // console.log($scope.edit);return;        
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

});