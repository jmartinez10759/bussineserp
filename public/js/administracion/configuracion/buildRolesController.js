const URL = {
  url_insert            : "roles/register"
  ,url_update           : 'roles/update'
  ,url_edit             : 'roles/edit'
  ,url_all              : 'roles/all'
  ,url_destroy          : "roles/destroy"
};

app.controller('RolesController', ['ServiceController','FactoryController','NotificationsFactory','$scope', function( sc,fc,nf,$scope ) {

    $scope.constructor = function(){
      $scope.datos  = [];
      $scope.insert = { estatus: 1 };
      $scope.update = {};
      $scope.edit   = {};
      $scope.fields = {};
      $scope.index();
    };

    $scope.index = function(){
        var url = fc.domain( URL.url_all );
        sc.requestHttp(url,null,"GET",false).then(function (response) {
            if (sc.validateSessionStatus(response)){
                console.log(response);
                $scope.datos = response.data.data.roles;
            }
        });
    };

    $scope.insertRegister = function(){
        var url     = fc.domain(  URL.url_insert );
        var fields  = $scope.insert;
        sc.requestHttp(url, fields, 'POST', false).then(function (response) {
            if (sc.validateSessionStatus(response)) {
                nf.toastSuccess(response.data.message, nf.titleRegisterSuccess);
                jQuery.fancybox.close({
                    'type'      : 'inline'
                    ,'src'      : "#modal_add_register"
                });
                $scope.index();
            }
        });

    };

    $scope.updateRegister = function(){
        let url = fc.domain(URL.url_update);
        var fields = sc.mapObject($scope.update, ['empresas'], false);
        sc.requestHttp(url, fields, 'PUT', false).then(function (response) {
            if (sc.validateSessionStatus(response)) {
                nf.toastInfo(response.data.message, nf.titleMgsSuccess);
                nf.modal("#modal_edit_register",true);
                nf.trEffect($scope.update.id);
                $scope.index();
            }
        });
    };

    $scope.editRegister = function( entry ){
        var datos = ['id', 'perfil', 'clave_corta', 'estatus',"empresas" ];
        $scope.update = sc.mapObject(entry, datos, true);
        $scope.update.companyId = [];
        angular.forEach($scope.update.empresas,function (value, key) {
            $scope.update.companyId[key] = value.id;
        });
        console.log($scope.update);
        nf.modal("#modal_edit_register");
    };

    $scope.destroyRegister = function( id ){

      var url = fc.domain( URL.url_destroy+"/"+id+"/company" );
        nf.buildSweetAlertOptions("¿Borrar Registro?", "¿Realmente desea eliminar el registro?", "warning", function () {
            sc.requestHttp(url, null, "DELETE", false).then(function (response) {
                if (sc.validateSessionStatus(response)) {
                    nf.toastSuccess(response.data.message, nf.titleMgsSuccess);
                    $scope.index();
                }
            });
        }, null, "SI", "NO");

    };

}]);