const URL = {
    url_insert           : "orders/register" ,
    url_update           : 'orders/update' ,
    url_edit             : 'orders/{id}/edit' ,
    url_all              : 'orders/all' ,
    url_destroy          : "orders/{id}/destroy" ,
    url_close_box        : "boxes/{id}/close" ,
    url_destroy_concept  : "concept/{id}/destroy",
    url_update_concept   : 'concept/update'
};

app.controller('OrdersController', ['ServiceController','FactoryController','NotificationsFactory','$scope','$window' ,function( sc,fc,nf,$scope,w ) {

    $scope.constructor = function(){
        $scope.datos    = [];
        $scope.insert   = { status: 6, paymentForm: 1, paymentMethod: 1 };
        $scope.update   = {};
        $scope.fields   = {};
        $scope.payment  = true;
        $scope.order    = {};
        $scope.concepts = {};
        $scope.subtotal = 0;
        $scope.iva      = 0;
        $scope.total    = 0;
        $scope.index();

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
                $scope.payment = false;
                w.localStorage['orderId'] = response.data.data.order.id;
                $scope.insert.orderId = response.data.data.order.id;
                $scope.concepts = response.data.data.order.concepts;
                $scope.subtotal = response.data.data.subtotal;
                $scope.iva = response.data.data.iva;
                $scope.total = response.data.data.total;
                nf.toastSuccess(response.data.message, nf.titleRegisterSuccess);
            }
        });

    };

    $scope.paymentOrderSuccess = function(){
        $scope.mount = "";
        $scope.insert.swap = 0;
        nf.modal("#paymentForm");
    };

    $scope.paymentOrderCancel = function(){
        var id  = w.localStorage['orderId'];
        var url = fc.domain(URL.url_destroy,id);
        nf.buildSweetAlertOptions("¿Desea cancelar la Orden?", "¿Realmente desea cancelar la orden?", "warning", function () {
            sc.requestHttp(url, null, "DELETE", false).then(function (response) {
                if (sc.validateSessionStatus(response)) {
                    $scope.constructor();
                    w.localStorage.removeItem("orderId");
                }
            });
        }, null, "SI", "NO");

    };

    $scope.updateRegister = function(){
        var url = fc.domain(URL.url_update);
        var fields = $scope.insert;
        console.log(fields);return;
        $scope.spinning = true;
        sc.requestHttp(url, fields, 'PUT', false).then(function (response) {
            if (sc.validateSessionStatus(response)) {
                nf.toastInfo(response.data.message, nf.titleMgsSuccess);
                $scope.constructor();
                w.localStorage.removeItem("orderId");
            }
            $scope.spinning = false;
        });
    };

    $scope.findInsertOrder = function(selected){
        if ( angular.isDefined(selected) ){
            $scope.insert.productId = selected.originalObject.id;
            $scope.insertOrder();
        }
    };

    $scope.editRegister = function( id ){
        var url = fc.domain(URL.url_edit,id);
        sc.requestHttp(url,null,"GET",false).then(function (response) {
            $scope.insert.orderId = response.data.data.order.id;
            $scope.order    = response.data.data.order;
            $scope.concepts = response.data.data.order.concepts;
            $scope.subtotal = response.data.data.subtotal;
            $scope.iva      = response.data.data.iva;
            $scope.total    = response.data.data.total;
        });
    };

    $scope.calculateSwap = function(){
        console.log($scope.total);
        console.log($scope.mount);
        var swap = (parseFloat($scope.mount) - parseFloat($scope.total));
        $scope.insert.swap = fc.numberFormat(swap,2);
    };

    $scope.boxOpen = function (boxes) {

        nf.buildSweetAlertOptions("¿Apertura de Caja?", "¿Realmente desea abrir la caja ?", "warning", function () {

            if ( angular.isUndefined(w.localStorage['boxOpen'])  || w.localStorage['boxOpen'] == boxes.id){
                w.localStorage['boxOpen']      = boxes.id;
                w.localStorage['boxOpenName']  = boxes.name;
                $scope.boxName = boxes.name;
                if ( angular.isDefined(w.localStorage['orderId']) ){
                    $scope.payment = false;
                    $scope.editRegister(w.localStorage['orderId']);
                }
                nf.modal("#modal_add_register");
            }else{
                nf.buildSweetAlert("¡No puede abrir esta caja, tiene habilitada "+w.localStorage['boxOpenName']+"!","error");
            }

        }, null, "SI", "NO");

    };

    $scope.boxClosed = function () {
        var url = fc.domain(URL.url_close_box,w.localStorage["boxOpen"]);
        nf.buildSweetAlertOptions("¿Corte de caja?", "¿Realmente desea realizar el corte de caja?", "warning", function () {

            sc.requestHttp(url, null, 'GET', false).then(function (response) {
                if (sc.validateSessionStatus(response)) {
                    var total = response.data.data;
                    nf.buildSweetAlert("TOTAL DE VENTA DE LA CAJA "+w.localStorage['boxOpenName']+": $"+fc.numberFormat(total,2),"success",10000);
                    w.localStorage.removeItem('boxOpen');
                    w.localStorage.removeItem('boxOpenName');
                    w.localStorage.removeItem('orderId');
                    nf.modal("#modal_add_register",true);
                }
            });


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
            }
        });
    });


}]);