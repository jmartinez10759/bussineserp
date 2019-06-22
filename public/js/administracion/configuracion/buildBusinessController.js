const URL = {
    urlListCompany        : "empresas/listado"
    ,urlListGroup         : 'list/sucursales'
    ,urlPortal            : 'portal'
};
app.controller('BussinesListController', ['ServiceController','FactoryController','NotificationsFactory','$scope', '$http', '$location','$window', function( sc,fc,nf,$scope,$http,$location, w ) {

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
        var url = fc.domain(URL.urlPortal+"/"+groupId);
        sc.requestHttp(url,null,"GET",false).then(function (response) {
            if (sc.validateSessionStatus(response)){
                w.localStorage['rolesId'] = response.data.data.roles_id;
                if (w.localStorage['rolesId'] != 1 && w.localStorage['pathWeb']){
                    redirect(fc.domain(w.localStorage['pathWeb']));
                }else{
                    redirect( fc.domain( response.data.data.ruta ) );
                }
            }
        });
    };

}]);