app.service('ServiceController',["$http","NotificationsFactory", "FactoryController","$timeout","$location",function (http,nf,fc,time,l) {

    function ServiceController() {
        this.loading();
    };

    ServiceController.prototype.requestHttp = function ( url, fields, methods,headers ) {
        return http({
            method: methods,
            url: url,
            headers: headers,
            data: fields
        }).then(function successCallback(resp) {
            this.loading(true);
            return resp
        }).catch(function errorCallback(error) {
            this.loading(true);
            console.error(error);
            return error;
        });
    };

    ServiceController.prototype.validateSessionStatus = function(response){
        if ( angular.isDefined(response.status) ){

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

    ServiceController.prototype.validateStatusError = function(error){

        if (angular.isDefined(error)){
            if( angular.isDefined(error.status) && error.status == 419 ){
                nf.toastError(nf.sessionExpired );
                time(function(){ redirect( fc.domain() ); }, 1000);
                return;
            }
            nf.toastError(error.data.message, nf.titleMgsError);
            return;
        }
    };

    ServiceController.prototype.serviceNotification = function(scope){
        var url = domain('services');
        this.requestHttp(url,{},"GET", false).then(function (response) {
            scope.notificaciones = response.data.result.notification;
            scope.correos 		 = response.data.result.correos;
            scope.permisos 		 = response.data.result.permisos;
        });

    };

    ServiceController.prototype.loading = function (hide = false) {
        if (hide) {
            jQuery('.loader').fadeOut('hide');
            return;
        }
        jQuery('.loader').fadeIn('slow');

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