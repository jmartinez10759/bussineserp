const URL = {
    url_insert            : "sales/register"
    ,url_edit             : "sales/{id}/edit"
    ,url_all              : "sales/all"
    ,url_update           : "sales/{id}/update"
    ,url_destroy          : "sales/{id}/destroy"
};

app.controller('SalesController', ['ServiceController','FactoryController','NotificationsFactory','$scope', function( sc,fc,nf,$scope ) {

    $scope.constructor = function(){
        $scope.datos  = [];
        $scope.insert = { status: 1 };
        $scope.update = {};
        $scope.fields = {};
        $scope.index();
        $scope.register = [];
        $scope.titles   = [
            "Caja",
            "Forma de Pago",
            "Metodo de Pago",
            "Comentarios",
            "Subtotal",
            "Iva",
            "Total",
            "Estatus",
            ""
        ];
    };

    $scope.index = function(){
        var url = fc.domain( URL.url_all );
        sc.requestHttp(url,null,"GET",false).then(function (response) {
            if (sc.validateSessionStatus(response)){
                console.log(response);
                $scope.register = [];
                angular.forEach(response.data.data.sales,function (value,key) {
                    $scope.register[key] = {
                        'id'            : value.id ,
                        'boxes'         : value.boxes.name,
                        'paymentForms'  : (value.payments_forms) ? value.payments_forms.descripcion : "",
                        'paymentMethod' : (value.payments_methods) ? value.payments_methods.descripcion: "" ,
                        'comments'      : value.comments ,
                        'subtotal'      : value.subtotal ,
                        'iva'           : value.iva ,
                        'total'         : value.total ,
                        'status'        : value.status.nombre ,
                        'btnDelete'     : ""
                    };
                });
                $scope.datos         = {"titles" : $scope.titles, "register" : $scope.register};
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

    $scope.editRegister = function( id ){
        var url = fc.domain(URL.url_edit,id);
        sc.requestHttp(url,null,"GET",false).then(function (response) {
            var datos = ['id', 'name', 'description', 'status',"companies",'groups','users'];
            $scope.update = sc.mapObject(response.data.data, datos, true);
            $scope.update.companyId = angular.isDefined($scope.update.companies[0])?$scope.update.companies[0].id : "";
            $scope.update.userId    = angular.isDefined($scope.update.users[0])?$scope.update.users[0].id : "";
            $scope.getGroupByCompany($scope.update.companyId);
            $scope.update.groupId    = angular.isDefined($scope.update.groups[0])?$scope.update.groups[0].id : "";
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