app.service('ServiceController',["$http","NotificationsFactory", "FactoryController","$timeout","$location","$window",function (http,nf,fc,time,l,w) {

    function ServiceController() {

    };

    ServiceController.prototype.requestHttp = function ( url, fields, methods,headers ) {
        return http({
            method: methods,
            url: url,
            headers: headers,
            data: fields
        }).then(function successCallback(resp) {
            return resp
        }).catch(function errorCallback(error) {
            console.error(error);
            return error;
        });
    };

    ServiceController.prototype.validateSessionStatus = function(response){
        if ( angular.isDefined(response.status)){

            if( response.status == 419 ){
                nf.toastError(nf.sessionExpired);
                time(function(){ redirect(fc.domain()); }, 2000);
                return false;
            }
            if (response.status != 200 && response.status != 201 ){
                nf.toastError(response.data.message,nf.titleMgsError);
                return false;
            }
            return true;
        }
        nf.toastError(nf.titleMgsError);
        return false;
    };

    ServiceController.prototype.serviceNotification = function(scope){
        var url = fc.domain('services');
        this.requestHttp(url,{},"GET", false).then(function (response) {
            scope.notificaciones     = response.data.data.notification;
            scope.correos 		    = response.data.data.correos;
            scope.permisos 		    = response.data.data.permisos;
            w.localStorage['pathWeb']= response.data.data.pathWeb;
            scope.rootCmbCompanies  = response.data.data.companies;
            scope.cmbEstatusRoot    = [{id:0 ,descripcion:"Inactivo"}, {id:1, descripcion:"Activo"}];
            scope.loader = false;
        });

    };

    ServiceController.prototype.mapObject = function( data, array2, discrim = false ){
        var response = {};
        for(var i in data ){
            if(!discrim ){
                if ( !array2.includes(i) ) {
                    response[i] = data[i];
                }
            }
            if(discrim){
                if ( array2.includes(i) ) {
                    response[i] = data[i];
                }
            }
        }
        return response;
    };

    return new ServiceController();

}]);