var app = angular.module('application',["ngRoute",'localytics.directives','components',"stringToNumber",'html-unsafe']);
/*app.config([ '$routeProvider' ,function( $routeProvider ) {
    $routeProvider
    .when("/paises", {
        templateUrl : "/template_ng/table_paises.html",
        controller : "PaisesController"
    })
    .when("/london", {
        template : "<h1> Bienvenidos 2</h1>",
        //controller : "londonCtrl"
    })
    .when("/paris", {
        templateUrl : "paris.htm",
        controller : "parisCtrl"
    });

}]);*/

app.service('MasterServices',["$http","$rootScope", function ( http, rtScope ) {
	
	function MasterServices() {
		this.loading();
	};

	MasterServices.prototype.requestHttp = function ( url, fields, methods,headers ) {
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

	MasterServices.prototype.validateSessionStatus = function(response){
		if( typeof response.data != "object" ){
			toastr.error( session_expired );
			setTimeout(function(){ redirect(domain()); }, 2000);
			return false;
		}
		return true;
	};

	MasterServices.prototype.validateStatusError = function(error){

		if( angular.isDefined(error.status) && error.status == 419 ){
			toastr.error( session_expired );
			setTimeout(function(){ redirect(domain()); }, 1000);
			return;
		}
		console.error( error );
		toastr.error( error.result , expired );
	};

	MasterServices.prototype.serviceNotification = function(scope){
		var url = domain('services');
		this.requestHttp(url,{},"GET", false).then(function (response) {
			scope.notificaciones = response.data.result.notification;
			scope.correos 		 = response.data.result.correos;
			scope.permisos 		 = response.data.result.permisos;
		}).catch(function (error) {
			console.error( error );
		});

	};

	MasterServices.prototype.loading = function (hide = false) {
		if (hide) {
			jQuery('.loader').fadeOut('hide');
			return;
		}
		jQuery('.loader').fadeIn('slow');

	};

	MasterServices.prototype.mapObject = function( data, array2, discrim = false ){
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

	return new MasterServices();

}]);


app.service('masterservice', ['$http','$rootScope', function( $http , $rootScope ) {
  
	return {
	    
	    format_date : function(fecha, format) {
		    var d = new Date(fecha);
	        if( format === "yyyy-mm-dd"){
	          return d.getFullYear() + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" +  ("0" +(d.getDate())).slice(-2);
	        }else{
	          return ("0" + d.getDate()).slice(-2) + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" + d.getFullYear();
	        }

	    },

	    calendar : function(){

  		    var calendar = [];
  		    var count = 1;
  		    var nombres = ['ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC','TODOS'];
  		    for (var i = 0; i < nombres.length; i++) {
  		        calendar[i] = { id: count , nombre:nombres[i] };
  		        count++;
  		    }
  		    return calendar;
  		
  		},

		select_anios : function(){
	        var fecha = new Date();
	        var year = (fecha.getFullYear());
	        var select = [];
	        var cont = 1;
	        for (var i = year; i >= 2000; i--) {
	            select[cont] = { id: i ,descripcion: i };
	            cont++;
	        }
	        return { anio: select[1].id, cmb_anios: select };
	    
	    },

		calcular_suma : function( precio = false, cantidad = false ){

	        var precio = (precio != "") ? precio : 0;
	        var cantidad = (cantidad != "") ? cantidad: 0;
	        var total  = parseFloat(precio * cantidad);
	        return total.toFixed(2);

	    },

	    session_status: function( response = {} ){
	    	/*se carga el metodo para obtener los correos y/o las notificaciones*/
        	$rootScope.$emit("services", {});
			if( typeof response.data != "object" ){
			  toastr.error( session_expired );
			  setTimeout(function(){ redirect(domain()); }, 2000);
			  return true;
			}

	    },

	    session_status_error: function( error = {} ){
	    	loading(true);
	    	if( isset(error.status) && error.status == 419 ){
              toastr.error( session_expired );
              setTimeout(function(){ redirect(domain()); }, 1000);  
              return;
            }
	        console.error( error );
            toastr.error( error.result , expired );
	    
	    },

	    time_fechas: function( fecha ){

	    	// asignar el valor de las unidades en milisegundos
  			var msecPerMinute = 1000 * 60;
  			var msecPerHour = msecPerMinute * 60;
  			var msecPerDay = msecPerHour * 24;
  			// asignar la fecha en milisegundos
  			var date = new Date(fecha);
  			var dateMsec = date.getTime();
  			// asignar la fecha el 1 de enero del a la media noche
  			date.setMonth(0);
  			date.setDate(1);
  			date.setHours(0, 0, 0, 0);
  			// Obtener la diferencia en milisegundos
  			//var interval = dateMsec - date.getTime();
  			//var interval = dateMsec - now_date.getTime();
  			var now_date = new Date();
  			var interval = now_date.getTime() - dateMsec;
  			// Calcular cuentos días contiene el intervalo. Substraer cuantos días
  			//tiene el intervalo para determinar el sobrante
  			var days = Math.floor(interval / msecPerDay );
  			interval = interval - (days * msecPerDay );
  			// Calcular las horas , minutos y segundos
  			var hours = Math.floor(interval / msecPerHour );
  			interval = interval - (hours * msecPerHour );
  			
  			var minutes = Math.floor(interval / msecPerMinute );
  			interval = interval - (minutes * msecPerMinute );

  			var seconds = Math.floor(interval / 1000 );
  			// Mostrar el resultado.
  			//var time_elapsed = ( (days > 0 ) ? days + " dias, " : "" ) + ( (hours > 0 )? hours + " horas, " : " " ) + ( (minutes > 0) ? minutes + " minutos, ": "" )+ ((seconds > 0)? seconds + " segundos." : ""); 
  			var time_elapsed = ( (days > 0 ) ? days + " dias, " : "" ) + ( (hours > 0 )? hours + " horas, " : " " ) + ( (minutes > 0) ? minutes + " minutos, ": " unos segundos" );
  			return  time_elapsed;
  			//Output: 164 días, 23 horas, 0 minutos, 0 segundos.
	    
	    },

		mapObject: function( data, array2, discrim = false ){
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
		},

		/*httpRequest: function ( url, fields, methods, $http ,headers  ) {
				this.loading();
				var config = [];
				config['method']  = methods;
				config['url']     = url;
				config['headers'] = headers;
				if(methods == "get" || methods == "delete" || methods == "GET" || methods == "DELETE"){
					config['params'] = fields;
				}else{ config['data'] = fields; }
				return $http(config);
		},*/



  	}

}]);

app.controller('ApplicationController', ['$scope','masterservice','MasterServices','$http','$rootScope' ,function( $scope,masterservice, ms , $http, $rootScope ){

	$rootScope.$on("services", function(){
	    $scope.services();
	});
	$scope.constructor = function(){
	  $scope.services();
	  $scope.notificaciones = {};
	  $scope.correos = {};
	  $scope.update = {};
	  $scope.permisos = {};
	  $scope.loader = true;
	
	}
	$scope.services = function(){
		ms.serviceNotification( $scope );
	};

	$scope.update_notify = function(){

	    var url      = domain('api/sistema/token');
	    var fields   = { email: "jorge.martinez@burolaboralmexico.com" };
	    jQuery('#modal_notificaciones').modal('hide');

	    MasterController.method_master(url, fields, 'post')
	    .then( response => {
	        var headers = {
	           usuario: response.data.result[0].email, token: response.data.result[0].api_token
	        };
	        var uri = domain('api/sistema/notification');
	        var data = {id:  $scope.update.id };
	        MasterController.method_master(uri, data, 'delete', headers)
	        .then(response => {
	            $scope.services();
	        }).catch(error => {
	            toastr.error(error, "Ocurrio un Error");
	        });
	    }).catch(error => {
	        toastr.error(error, "Ocurrio un Error");
	    });

	}
	$scope.time_fechas = function( fecha ){

		return masterservice.time_fechas(fecha);

	}
	$scope.users_notify = function( id ){

	  	var url = domain('notificaciones/edit');
	  	var fields = { id : id };
		  	MasterController.request_http(url,fields,'get',$http, false )
		      .then(function( response ){
		          //not remove function this is  verify the session
		            if(masterservice.session_status( response )){return;};

		            $scope.update.id 	  = response.data.result.id; 
		            $scope.update.portal  = response.data.result.portal;
		            $scope.update.titulo  = response.data.result.titulo;
		            $scope.update.mensaje = response.data.result.mensaje;
		            console.log($scope.update);
				  	jQuery('#modal_notificaciones').modal({
				      keyboard: false, backdrop: "static"
				    });	

		      }).catch(function( error ){
		        loading(true);
		        console.error( error );
		        masterservice.session_status_error( error );
		      });

	}

}]);