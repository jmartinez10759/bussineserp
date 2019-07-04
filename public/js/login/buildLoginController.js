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
                w.localStorage['data'] = JSON.stringify({
                    "userId" : response.data.data.id ,
                    "rolesId" : response.data.data.roles_id ,
                    "companyId" : response.data.data.company_id ,
                    "groupId" : response.data.data.group_id
                });
                var data = JSON.parse(w.localStorage['data']);
                w.localStorage['skin'] = "skin-black";
                if (data.rolesId == 1 && w.localStorage['pathWeb']){
                    redirect(w.localStorage['pathWeb']);
                }else{
                    var path = angular.isDefined(w.localStorage['pathWeb'])? w.localStorage['pathWeb'] : response.data.data.ruta;
                    redirect(path);
                }
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
