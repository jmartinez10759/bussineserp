app.service('ServiceController',["$http","NotificationsFactory", function (http,nf) {

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
                nf.toastError(session_expired);
                setTimeout(function(){ redirect(domain()); }, 2000);
                return false;
            }
            if (response.status != 200 && response.status != 201 ){
                nf.toastError(error_mgs);
                return false;
            }
            return true;
        }
        nf.toastError(error_mgs);
        return false;
    };

    ServiceController.prototype.validateStatusError = function(error){

        if (angular.isDefined(error)){
            console.log(error);
            if( angular.isDefined(error.status) && error.status == 419 ){
                nf.toastError(session_expired );
                setTimeout(function(){ redirect(domain()); }, 1000);
                return;
            }
            nf.toastError(error.data.message, error_mgs);
            return;
        }
    };

    ServiceController.prototype.serviceNotification = function(scope){
        var url = domain('services');
        this.requestHttp(url,{},"GET", false).then(function (response) {
            scope.notificaciones = response.data.result.notification;
            scope.correos 		 = response.data.result.correos;
            scope.permisos 		 = response.data.result.permisos;
        }).catch(function (error) {
            console.error( error );
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