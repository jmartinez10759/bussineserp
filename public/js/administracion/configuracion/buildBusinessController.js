const URL = {
    urlListCompany        : "empresas/listado"
    ,urlListGroup         : 'list/sucursales'
    ,urlPortal            : 'portal'
};
app.controller('BussinesListController', ['ServiceController','FactoryController','NotificationsFactory','masterservice','$scope', '$http', '$location', function( sc,fc,nf,masterservice, $scope, $http, $location ) {

    $scope.constructor = function(){
        $scope.datos  = [];
        $scope.group  = false;
        $scope.company= true;
        $scope.sucursales = [];
        $scope.index();
    };
    $scope.index = function(){
        let url = domain( URL.urlListCompany );
        sc.requestHttp(url,null,"GET",false).then(function (response) {
            if (sc.validateSessionStatus(response)){
                $scope.datos = response.data.data;
            }
        });
    };

    $scope.BussinesGroup = function(companyId){
        var url = domain( URL.urlListGroup );
        var fields = {'id_empresa': companyId};
        sc.requestHttp(url,fields,"POST",false).then(function (response) {
            if (sc.validateSessionStatus(response)){
                $scope.sucursales = response.data.data.groups;
                nf.modal('#modal-group');
            }
        });

    };
    $scope.beginPortal = function(groupId){
        var url = domain(URL.urlPortal+"/"+groupId);
        sc.requestHttp(url,null,"GET",false).then(function (response) {
            if (sc.validateSessionStatus(response)){
                console.log(domain( response.data.data.ruta ) );
                redirect( domain( response.data.data.ruta ) );
            }
        });
    };

}]);