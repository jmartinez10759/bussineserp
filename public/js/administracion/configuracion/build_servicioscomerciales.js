const URL = {
 url_insert  : "servicioscomerciales/register"
 ,url_update   : "servicioscomerciales/update"
 ,url_edit     : "servicioscomerciales/edit"
 ,url_destroy  : "servicioscomerciales/destroy"
 ,url_all      : "servicioscomerciales/all"
 ,redireccion  : "configuracion/servicioscomerciales"
}

// app.config(function( $routeProvider, $locationProvider ) {
//     $routeProvider
//     .when("/ruta1", {
//         template : "<h1></h1>",
//     })
//     .when("/ruta2", {
//         template : "<h1></h1>",
//     })
//     .when("/ruta3", {
//         templateUrl : "ruta3.html",
//         controller : ""
//     });
//     $locationProvider.html5Mode(true);
// });
app.controller("servicioscomercialesController", function(masterservice, $scope, $http, $location ) {
    /*se declaran las propiedades dentro del controller*/
    //El constructor funciona para inicializar las variables 
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
        MasterController.request_http(url,fields,"get",$http, false )
        .then(function(response){
          //not remove function this is  verify the session
            if(masterservice.session_status( response )){return;};
          //devuelve un Array con todos los datos

          // loading(true);
            $scope.datos = response.data.result;
            // console.log($scope.datos);
        }).catch(function(error){
             masterservice.session_status({},error);
        });
    }
    
    $scope.insert_register = function(){

        var url = domain( URL.url_insert );
        var fields = $scope.insert;
        MasterController.request_http(url,fields,"post",$http, false )
        .then(function( response ){
          //not remove function this is  verify the session
            if(masterservice.session_status( response )){return;};
            toastr.success( response.data.message , title );
            jQuery.fancybox.close({
                "type"      : "inline"
                ,"src"      : "#modal_add_register"
                ,"modal"    : true
                ,"width"    : 900
                ,"height"   : 400
                ,"autoSize" : false
            });
            //devuelve un Array con los datos actualizados
            $scope.constructor();
            // console.log($scope.constructor());return;

        }).catch(function( error ){
             masterservice.session_status({},error);
        });

    }

    $scope.update_register = function(){
     
      $scope.update = $scope.edit;
      var url = domain( URL.url_update );
      var fields = $scope.update;
      MasterController.request_http(url,fields,"put",$http, false )
      .then(function( response ){
        //not remove function this is  verify the session
            if(masterservice.session_status( response )){return;};
          toastr.info( response.data.message , title );
          jQuery.fancybox.close({
                "type"      : "inline"
                ,"src"      : "#modal_edit_register"
                ,"modal"    : true
                ,"width"    : 900
                ,"height"   : 400
                ,"autoSize" : false
            });
          $scope.consulta_general();
          // console.log($scope.consulta_general());return;
          jQuery('#tr_'+$scope.update.id).effect("highlight",{},5000);
      }).catch(function( error ){
           masterservice.session_status({},error);
      });
    }

    $scope.edit_register = function( id ){

      var url = domain( URL.url_edit );
      var fields = {id : id };
      MasterController.request_http(url,fields,"get",$http, false )
        .then(function( response ){

          //Regresa un objeto con los datos del registro seleccionado
           $scope.edit = response.data.result;

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
             masterservice.session_status({},error);
        });
    }

    $scope.destroy_register = function( id ){

      var url = domain( URL.url_destroy );
      var fields = {id : id };
      buildSweetAlertOptions("¿Borrar Registro?","¿Realmente desea eliminar el registro?",function(){
        MasterController.request_http(url,fields,"delete",$http, false )
        .then(function( response ){
          //not remove function this is  verify the session
            if(masterservice.session_status( response )){return;};
            toastr.success( response.data.message , title );
            $scope.consulta_general();
            // console.log($scope.consulta_general());return;
        }).catch(function( error ){
            masterservice.session_status({},error);
        });
          
      },"warning",true,["SI","NO"]);  
    }


});
