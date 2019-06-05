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
            "password"  : sha1($scope.datos.password)
        };
        $scope.enabled  = true;
        $scope.serching = true;
        sc.requestHttp(url, fields, 'POST', false).then(function (response) {
            if (sc.validateSessionStatus(response)) {
                w.localStorage['rolesId'] = response.data.data.id_rol;
                redirect(response.data.data.ruta);
                /*w.localStorage.removeItem('rolesId');
                console.log(w.localStorage['rolesId']);*/
            }
            $scope.enabled  = false;
            $scope.serching = false;
        });
    };

    $scope.randomImages = function () {


    };

}]);
