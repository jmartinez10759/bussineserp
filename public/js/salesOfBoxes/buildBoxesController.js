const URL = {
    url_insert            : "boxes/register"
    ,url_update           : "boxes/update"
    ,url_edit             : "boxes/{id}/edit"
    ,url_all              : "boxes/all"
    ,url_destroy          : "boxes/{id}/destroy"
};

app.controller('BoxesController', ['ServiceController','FactoryController','NotificationsFactory','$scope', function( sc,fc,nf,$scope ) {

    $scope.constructor = function(){
        $scope.datos  = [];
        $scope.insert = { status: 1 };
        $scope.update = {};
        $scope.fields = {};
        $scope.index();
        $scope.register = [];
        $scope.titles   = [
            "Nombre",
            "Descripcion",
            "Monto Inicial",
            "Estatus",
            "Caja",
            ""
        ];
    };

    $scope.index = function(){
        var url = fc.domain( URL.url_all );
        sc.requestHttp(url,null,"GET",false).then(function (response) {
            if (sc.validateSessionStatus(response)){
                console.log(response);
                $scope.register = [];
                angular.forEach(response.data.data.boxes,function (value,key) {
                    $scope.register[key] = {
                        'id'          : value.id ,
                        'name'        : value.name,
                        'description' : value.description ,
                        'mount'       : '$'+fc.numberFormat(value.init_mount,2) ,
                        'estatus'     : value.status ,
                        'is_active'   : value.is_active ,
                        'btnDelete'   : ""
                    };
                });
                /*$scope.datos         = {"titles" : $scope.titles, "register" : $scope.register};*/
                $scope.datos         = response.data.data.boxes;
                $scope.cmbUsers      = response.data.data.users;
            }
        });

    };

    $scope.insertRegister = function(){
        var url     = fc.domain(  URL.url_insert );
        var fields  = $scope.insert;
        $scope.spinning = true;
        sc.requestHttp(url, fields, 'POST', false).then(function (response) {
            if (sc.validateSessionStatus(response)) {
                nf.toastSuccess(response.data.message, nf.titleRegisterSuccess);
                nf.modal("#modal_add_register",true);
                $scope.constructor();
            }
            $scope.spinning = false;
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

    $scope.editRegister = function( id, is_extract){
        var url = fc.domain(URL.url_edit,id);
        sc.requestHttp(url,null,"GET",false).then(function (response) {
            var datos = ['id', 'name', 'description','init_mount','status',"companies",'groups','users','extracts'];
            $scope.update = sc.mapObject(response.data.data, datos, true);
            $scope.update.companyId = angular.isDefined($scope.update.companies[0])?$scope.update.companies[0].id : "";
            $scope.update.userId    = angular.isDefined($scope.update.users[0])?$scope.update.users[0].id : "";
            $scope.getGroupByCompany($scope.update.companyId);
            $scope.update.groupId    = angular.isDefined($scope.update.groups[0])?$scope.update.groups[0].id : "";
            console.log($scope.update);
            if (is_extract){
                nf.modal("#extracts");
            }else {
                nf.modal("#modal_edit_register");
            }
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
