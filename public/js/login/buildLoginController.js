const URL = {
    url_edit    : 'login'
};

app.controller('LoginController', ['ServiceController','FactoryController','NotificationsFactory','$scope',"$timeout",'$window', function( sc,fc,nf,$scope,time,w ) {

    $scope.constructor = function () {
        $scope.datos    = [];
        $scope.serching = false;
        $scope.enabled  = false;
        $scope.randomImages()
    };

    $scope.startSession = function () {
        let url = fc.domain(URL.url_edit);
        let fields = {
            "email"     : $scope.datos.email.trim().toLowerCase() ,
            "password"  : ($scope.datos.password)
        };
        $scope.enabled  = true;
        $scope.serching = true;
        sc.requestHttp(url, fields, 'POST', false).then(function (response) {
            if (sc.validateSessionStatus(response)) {
                w.localStorage['rolesId'] = response.data.data.roles_id;
                w.localStorage['pathWeb'] = response.data.data.ruta;
                redirect(response.data.data.ruta);
                /*w.localStorage.removeItem('rolesId');
                console.log(w.localStorage['rolesId']);*/
                return;
            }
            $scope.enabled  = false;
            $scope.serching = false;
        });
    };

    $scope.randomImages = function () {


    };

}]);
