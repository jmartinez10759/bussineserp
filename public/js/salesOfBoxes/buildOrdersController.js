const URL = {
    url_insert           : "orders/register" ,
    url_insert_tip       : "orders/register" ,
    url_update           : 'orders/update' ,
    url_edit             : 'orders/{id}/edit' ,
    url_all              : 'orders/all' ,
    url_destroy          : "orders/{id}/destroy" ,

    url_destroy_concept  : "concept/{id}/destroy",
    url_update_concept   : 'concept/update'
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
                $scope.insert.orderId = response.data.data.order.id;
                $scope.concepts = response.data.data.order.concepts;
                $scope.subtotal = response.data.data.subtotal;
                $scope.iva = response.data.data.iva;
                $scope.total = response.data.data.total;
                nf.toastSuccess(response.data.message, nf.titleRegisterSuccess);
            }
        });

    };

/*
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
*/

    $scope.findInsertOrder = function(selected){
        if ( angular.isDefined(selected) ){
            $scope.insert.productId = selected.originalObject.id;
            $scope.insertOrder();
        }
    };

    $scope.editRegister = function( id ){
        var url = fc.domain(URL.url_edit,id);
        sc.requestHttp(url,null,"GET",false).then(function (response) {
            $scope.order    = response.data.data.order;
            $scope.concepts = response.data.data.order.concepts;
            $scope.subtotal = response.data.data.subtotal;
            $scope.iva      = response.data.data.iva;
            $scope.total    = response.data.data.total;
        });
    };

/*
    $scope.destroyRegister = function( id ){
        var url = fc.domain( URL.url_destroy,id);
        nf.buildSweetAlertOptions("¿Borrar Registro?", "¿Realmente desea eliminar el registro?", "warning", function () {
            sc.requestHttp(url, null, "DELETE", false).then(function (response) {
                if (sc.validateSessionStatus(response)) {
                    nf.toastSuccess(response.data.message, nf.titleMgsSuccess);
                    $scope.index();
                }
            });
        }, null, "SI", "NO");

    };
*/

    $scope.BoxOpen = function (boxes) {
        w.localStorage['boxOpen'] = boxes.id;
        $scope.boxName = boxes.name;
        nf.modal("#modal_add_register");
    };

    $scope.boxClosed = function () {

        nf.buildSweetAlertOptions("¿Corte de caja?", "¿Realmente desea realizar el corte de caja?", "warning", function () {
            w.localStorage.removeItem('boxOpen');
            nf.modal("#modal_add_register",true);
        }, null, "SI", "NO");
    };

    $scope.destroyConcept = function( id ){

        var url = fc.domain( URL.url_destroy_concept,id);
        nf.buildSweetAlertOptions("¿Borrar Registro?", "¿Realmente desea eliminar el registro?", "warning", function () {
            sc.requestHttp(url, null, "DELETE", false).then(function (response) {
                if (sc.validateSessionStatus(response)) {
                    $scope.editRegister($scope.insert.orderId);
                }
            });
        }, null, "SI", "NO");
    };

    $scope.$on('editRegisterConcepts', function (evt, item) {
        var url = fc.domain(URL.url_update_concept);
        sc.requestHttp(url, $scope.concepts, 'PUT', false).then(function (response) {
            if (sc.validateSessionStatus(response)) {
                $scope.editRegister($scope.insert.orderId);
                /*$scope.insert.orderId   = response.data.data[0].order_id;
                $scope.concepts         = response.data.data;
                $scope.subtotal         = response.data.data.subtotal;
                $scope.iva              = response.data.data.iva;
                $scope.total            = response.data.data.total;*/
            }
        });
    });
    




}]);