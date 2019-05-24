const URL = {
    urlListCompany        : "empresas/listado"
    ,urlListGroup         : 'list/sucursales'
    ,urlPortal            : 'portal'
};
app.controller('BussinesListController', ['masterservice','$scope', '$http', '$location', function( masterservice, $scope, $http, $location ) {

    $scope.constructor = function(){
        $scope.datos  = [];
        $scope.group  = false;
        $scope.company= true;
        $scope.sucursales = [];
        $scope.index();
    };
    $scope.index = function(){
        let url = domain( URL.urlListCompany );
        MasterController.request_http(url,{},'GET',$http, false )
            .then(function(response){
                if(masterservice.session_status( response )){return;};
                $scope.datos = response.data.result;
                console.log($scope.datos);
            }).catch( function(error){
                masterservice.session_status_error(error);
            });

    }
    $scope.BussinesGroup = function(companyId){
        var url = domain( URL.urlListGroup );
        var fields = {'id_empresa': companyId};
        MasterController.request_http(url,fields,'POST',$http, false )
            .then(function( response ){
                if(masterservice.session_status( response )){return;};
                $scope.sucursales = response.data.data.sucursales;
                jQuery('#modal-group').modal("show");
            }).catch(function( error ){
            masterservice.session_status_error(error);
        });

    };
    $scope.beginPortal = function(groupId){
        var url = domain(URL.urlPortal);
        var fields = { "group_id" :groupId };
        MasterController.request_http(url,fields,'GET',$http, false )
            .then(function( response ){
                if(masterservice.session_status( response )){return;};
                console.log(domain( response.data.data.ruta ) );
                redirect( domain( response.data.data.ruta ) );
            }).catch(function( error ){
            //masterservice.session_status_error(error);
        });
    };

}]);