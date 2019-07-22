const URL = {
    url_insert            : "sales/register"
    ,url_edit             : "sales/{id}/edit"
    ,url_all              : "sales/{year}/filter"
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
    };

    $scope.index = function(){
        console.log($scope.user);
        var url = fc.domain( URL.url_all+"/"+$scope.month, $scope.year);
        sc.requestHttp(url,{ user : $scope.user },"POST",false).then(function (response) {
            if (sc.validateSessionStatus(response)){
                console.log(response);
                $scope.cmbUsers = response.data.data.users;
                $scope.datos    = response.data.data.sales;
                $scope.subtotal = response.data.data.subtotal;
                $scope.iva      = response.data.data.iva;
                $scope.total    = response.data.data.total;

            }
        });
    };

    $scope.monthFilter = function(data){
        for(var i in $scope.calFilter){ $scope.calFilter[i].class = "";}
        data.class = "active";
        $scope.month = data.id;
        let fields = {
            month:   $scope.month ,
            year:    $scope.year
        };
        $scope.index();
    };

    $scope.yearFilter = function(year){
        $scope.year = year;
        var fields = {
            month:     $scope.month,
            year:    $scope.year
        };
        $scope.index();
    };

    $scope.userFilter = function(user){
        $scope.user = user;
        $scope.index();
    };

    $scope.ticketWatch = function(path){
        jQuery.fancybox.open({
            'type': 'iframe' ,
            'src': fc.domain(path) ,
            'buttons' : ['share', 'close']
        });
    };

    $scope.takeOrder = function(id){
        var url = fc.domain(URL.url_update,id);
        var fields = {
            status_id: 9 ,
            user_id: $scope.loginUser.userId
        };
        sc.requestHttp(url, fields, 'PUT', false).then(function (response) {
            if (sc.validateSessionStatus(response)) {
                nf.toastInfo(response.data.message, nf.titleMgsSuccess);
                nf.trEffect(id);
                $scope.index();
            }
        });

    };

    $scope.closeOrder = function(id){
        var url = fc.domain(URL.url_update,id);
        var fields = {
            status_id: 7
        };
        sc.requestHttp(url, fields, 'PUT', false).then(function (response) {
            if (sc.validateSessionStatus(response)) {
                nf.toastInfo(response.data.message, nf.titleMgsSuccess);
                nf.trEffect(id);
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

    $scope.editRegister = function( entry ){
        var url = fc.domain(URL.url_edit,entry.id);
        sc.requestHttp(url,null,"GET",false).then(function (response) {
            //console.log(response.data.data.concepts);
            $scope.update = response.data.data.concepts;
            console.log($scope.update);
            nf.modal("#modal_edit_register");
        });
    };

    $scope.cancelOrders = function( id ){
        var url = fc.domain(URL.url_update,id);
        var fields = {
            status_id: 4
        };
        nf.buildSweetAlertOptions("¿Cancelar Pedido?", "¿Realmente desea cancelar el pedido?", "warning", function () {
            sc.requestHttp(url, fields, 'PUT', false).then(function (response) {
                if (sc.validateSessionStatus(response)) {
                    nf.toastInfo(response.data.message, nf.titleMgsSuccess);
                    nf.trEffect(id);
                    $scope.index();
                }
            });
        }, null, "SI", "NO");

    };

}]);
