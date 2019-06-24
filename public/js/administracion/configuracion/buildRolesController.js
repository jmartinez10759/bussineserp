const URL = {
  url_insert            : "roles/register"
  ,url_update           : 'roles/update'
  ,url_edit             : 'roles/edit/{id}/company'
  ,url_all              : 'roles/all'
  ,url_destroy          : "roles/{id}/destroy"
};

app.controller('RolesController', ['ServiceController','FactoryController','NotificationsFactory','$scope', function( sc,fc,nf,$scope ) {

    $scope.constructor = function(){
        $scope.datos  = [];
        $scope.insert = { estatus: 1 };
        $scope.update = {};
        $scope.fields = {};
        $scope.index();
        $scope.register = [];
        $scope.titles   = [
            "Perfil",
            "Nombre Corto",
            "Estatus",
            ""
        ];
    };

    $scope.index = function(){
        var url = fc.domain( URL.url_all );
        sc.requestHttp(url,null,"GET",false).then(function (response) {
            if (sc.validateSessionStatus(response)){
                console.log(response);
                angular.forEach(response.data.data.roles,function (value,key) {
                    $scope.register[key] = {
                        'id'          : value.id ,
                        'perfil'      : value.perfil,
                        'shortKey'    : value.clave_corta ,
                        'estatus'     : value.estatus ,
                        'btnDelete'   : ""
                    };
                });
                $scope.datos         = {"titles" : $scope.titles, "register" : $scope.register};
            }
        });

    };

    $scope.insertRegister = function(){
        var url     = fc.domain(  URL.url_insert );
        var fields  = $scope.insert;
        sc.requestHttp(url, fields, 'POST', false).then(function (response) {
            if (sc.validateSessionStatus(response)) {
                nf.toastSuccess(response.data.message, nf.titleRegisterSuccess);
                nf.modal("#modal_add_register",true);
                $scope.index();
            }
        });

    };

    $scope.updateRegister = function(){
        let url = fc.domain(URL.url_update);
        var fields = sc.mapObject($scope.update, ['companies_roles'], false);
        $scope.spinning = true;
        sc.requestHttp(url, fields, 'PUT', false).then(function (response) {
            if (sc.validateSessionStatus(response)) {
                nf.toastInfo(response.data.message, nf.titleMgsSuccess);
                nf.modal("#modal_edit_register",true);
                nf.trEffect($scope.update.id);
                $scope.index();
            }
            $scope.spinning = false;
        });
    };

    $scope.editRegister = function( id ){
        var url = fc.domain(URL.url_edit,id);
        sc.requestHttp(url,null,"GET",false).then(function (response) {
            var datos = ['id', 'perfil', 'clave_corta', 'estatus',"companies_roles"];
            $scope.update = sc.mapObject(response.data.data, datos, true);
            $scope.update.companyId = [];
            angular.forEach($scope.update.companies_roles,function (value, key) {
                $scope.update.companyId[key] = value.id;
            });
            console.log($scope.update);
            nf.modal("#modal_edit_register");
        });
    };

    $scope.destroyRegister = function( id ){

      var url = fc.domain( URL.url_destroy,id );
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