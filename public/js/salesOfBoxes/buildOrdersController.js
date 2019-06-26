const URL = {
    url_insert            : "orders/register"
    ,url_update           : 'orders/update'
    ,url_edit             : 'orders/{id}/edit'
    ,url_all              : 'orders/all'
    ,url_destroy          : "orders/{id}/destroy"
};

app.controller('OrdersController', ['ServiceController','FactoryController','NotificationsFactory','$scope','$window' ,function( sc,fc,nf,$scope,w ) {

    $scope.constructor = function(){
        $scope.datos  = [];
        $scope.insert = { status: 6, paymentForm: 1, paymentMethod: 1 };
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
                $scope.datos            = response.data.data.boxes;
                $scope.cmbPaymentForm   = response.data.data.paymentForm;
                $scope.cmbPaymentMethod = response.data.data.paymentMethod;
                $scope.products         = response.data.data.products;
            }
        });

    };

    $scope.insertOrder = function(){
        var url     = fc.domain(  URL.url_insert );
        $scope.insert.boxId = w.localStorage['boxOpen'];
        var fields  = $scope.insert;
        sc.requestHttp(url, fields, 'POST', false).then(function (response) {
            if (sc.validateSessionStatus(response)) {
                $scope.insert.orderId = response.data.data.id;
                $scope.concepts= response.data.data.concepts;
                console.log(response.data.data);
                console.log($scope.insert.orderId);
                console.log($scope.concepts);
                nf.toastSuccess(response.data.message, nf.titleRegisterSuccess);
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
        var url = fc.domain( URL.url_destroy.id);
        nf.buildSweetAlertOptions("¿Borrar Registro?", "¿Realmente desea eliminar el registro?", "warning", function () {
            sc.requestHttp(url, null, "DELETE", false).then(function (response) {
                if (sc.validateSessionStatus(response)) {
                    nf.toastSuccess(response.data.message, nf.titleMgsSuccess);
                    $scope.index();
                }
            });
        }, null, "SI", "NO");

    };

    $scope.BoxOpen = function (boxes) {
        w.localStorage['boxOpen'] = boxes.id;
        $scope.boxName = boxes.name;
        nf.modal("#modal_add_register");
        /*alert(w.localStorage['boxOpen']);*/

    };

    $scope.boxClosed = function () {
        w.localStorage.removeItem('boxOpen');
        alert(w.localStorage['boxOpen']);
    };






}]);