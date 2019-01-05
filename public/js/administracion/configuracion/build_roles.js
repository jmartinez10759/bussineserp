const URL = {
  url_insert            : "roles/register"
  ,url_update           : 'roles/update'
  ,url_edit             : 'roles/edit'
  ,url_all              : 'roles/all'
  ,url_destroy          : "roles/destroy"
}

app.controller('RolesController', ['masterservice','$scope', '$http', '$location', function( masterservice , $scope, $http, $location ) {
    
    /*se declaran las propiedades dentro del controller*/
    $scope.constructor = function(){
      $scope.datos  = [];
      $scope.insert = { estatus: 1 };
      $scope.update = {};
      $scope.edit   = {};
      $scope.fields = {};
      $scope.cmb_estatus = [{id:0 ,descripcion:"Inactivo"}, {id:1, descripcion:"Activo"}];
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
            masterservice.session_status_error(error);
        });
    }
    /*$scope.mostarArcoiris = function(){
      $scope.oculto = !$scope.oculto;
    }*/

    $scope.insert_register = function( id ){
        var url = domain(  URL.url_insert );
        // var fields = {id: id };
        var fields = $scope.insert;
        MasterController.request_http(url,fields,'post',$http, false )
        .then(function( response ){
          //not remove function this is  verify the session
            if(masterservice.session_status( response )){return;};
            //$scope.index();
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
            masterservice.session_status_error(error);
        });
    }

    
    $scope.update_register = function(){

      
      $scope.update = $scope.edit;
      
      var url = domain(  URL.url_update );
      var fields = $scope.update;
      MasterController.request_http(url,fields,'put',$http, false )
      .then(function( response ){
        //not remove function this is  verify the session
            if(masterservice.session_status( response )){return;};
          toastr.info( response.data.message , title );
          jQuery.fancybox.close({
                'type'      : 'inline'
                ,'src'      : "#modal_edit_register"
                ,'modal'    : true
                ,'width'    : 900
                ,'height'   : 400
                ,'autoSize' : false
            });
          $scope.index();
          //redirect(domain(redireccion));
      }).catch(function( error ){
          masterservice.session_status_error(error);
      });
    }
    $scope.edit_register = function( entry ){
        var datos = ['id', 'perfil', 'clave_corta', 'estatus' ];
        $scope.update = iterar_object(entry, datos, true);
        console.log($scope.update);
        jQuery('#modal_edit_register').modal({keyboard: false,backdrop: "static" });

    }
    $scope.destroy_register = function( id ){

      var url = domain(  URL.url_destroy );
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

}]);

app.directive("tableFull",function(){
  alert();
  var table = '<table border="1px">';
          + '<tr>';
            + '<th ng-repeat="(head, value) in ds[0]"><span>{{head}}</span></th>';
          + '</tr>';
          + '<tr ng-repeat="row in ds">';
            + '<td ng-repeat="(name, value) in row" ng-scope> {{row[name]}} '; 
            + '</td>';    
          + '</tr>';
        + '</table>';

  return {
        restrict: 'EA', //E = element, A = attribute, C = class, M = comment
      transclude : true,
        scope: {
            ds: '='         
          },
        template: table,
        replace : true
    };

});

/*var url_insert  = "roles/register";
var url_update  = 'roles/update';
var url_edit    = 'roles/edit';
var url_destroy = "roles/destroy";
var redireccion = "configuracion/roles";

new Vue ({
el: "#vue_roles",
created: function () {
  this.index();
},
data: {
  datos: [],
  newKeep: {
    'perfil' : ""
    ,'clave_corta' : ""
    ,'estatus' : 1
  },
  fillKeep: {
    'perfil' : ""
    ,'clave_corta' : ""
    ,'estatus' : 1
  },

},
mixins : [mixins],
methods:{
    index: function(){}
    ,insert: function(){
        var url     = domain('roles/register');
        var refresh = domain('');
        this.insert_general(url,refresh,function(response){
            jQuery('#modal_add_register').modal('hide');
            redirect('roles');
        },function(){});
    }
    ,destroy: function( id ){
        var url = domain( url_destroy );
        var fields = {id_rol: id};
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
    ,update: function(){
        var url     = domain('roles/update');
        //var refresh = domain('configuracion/menus');
        axios.post( url,this.fillKeep, csrf_token ).then(response => {
          if (response.data.success == true) {
            redirect('roles');
          }else{
             toastr.error('¡No se Actualizo correctamente el registro!','¡Ocurrio un error.!'); //mensaje
          }
        }).catch(error => {
            toastr.error( error, expired );
        });
    }
    ,editar: function( keep ){
        var url = domain('roles/edit');
        var fields = {'id' : keep};
        axios.get( url, { params: fields }, csrf_token ).then(response => {
            if( response.data.success == true ){
              this.fillKeep = response.data.result;
              jQuery('#modal_edit_register').modal('show');
            }else{
                toastr.error( response.data.message, "¡Ningun Registro Encontrado!" );
            }
        }).catch(error => {
            toastr.error( error, expired );
        });

    }
}


});




//upload_files_general = function(){
//
//    var url = domain('upload/files_generales');
//    var fields = {};
//    var identificador = {
//       div_content  : 'div_dropzone_file'
//      ,div_dropzone : 'dropzone_xlsx_file'
//      ,file_name    : 'file'
//    };
//    upload_file(fields,url,null,identificador,".csv, .xlxs,.xls", function( request ){
//        console.log(request);
//    });
//
//}
*/