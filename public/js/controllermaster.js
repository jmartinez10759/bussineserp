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

app.controller('ApplicationController', ['$scope','ServiceController','$http','$rootScope','FactoryController',"NotificationsFactory",'$window','$location','$pusher',function( $scope,sc,$http,rs,fc,nf,w,l,$pusher ){

	rs.$on("services", function(){
	    $scope.services();
	});
	$scope.constructor = function(){
	  $scope.services();
	  $scope.notificaciones = {};
	  $scope.correos = {};
	  $scope.permisos = {};
	  $scope.cmbEstatusRoot = [];
	  $scope.rootCmbCompanies = {};
	  $scope.rootCmbGroups = {};
	  $scope.spinning= false;
	  $scope.loader = true;
	  $scope.userLogged;
	  $scope.loginUser;
	  $scope.calFilter 	= fc.calendar();
	  $scope.cmbAnios   = fc.selectYears().cmb_anios;
	  $scope.year       = fc.selectYears().anio;
	  $scope.checkMonth();
	  $scope.notificationEvent();
	};

	$scope.services = function(){
		sc.serviceNotification($scope);
		$scope.loginUser   = JSON.parse(w.localStorage['data']);
		$scope.userLogged  = $scope.loginUser.rolesId;
	};

	$scope.getGroupByCompany = function(companyId){
		var url = fc.domain("empresas/findGroups");
		var fields = {"id_empresa" : companyId };
		sc.requestHttp(url,fields,"POST", false).then(function (response) {
			console.log(response.data.data);
			$scope.rootCmbGroups = response.data.data;
		});
	};

	$scope.modalShow = function(){
		nf.modal("#modal_add_register");
	};

	$scope.checkMonth = function(){
		var date = new Date();
		var month = (date.getMonth() +1);
		$scope.month = month;
		for(var i in $scope.calFilter){
			if ($scope.calFilter[i].id == month ) {
				$scope.calFilter[i].class = "active";
			}
		}
	};

	$scope.notifyDetails = function(notifyId) {
		alert(notifyId);
	};

	$scope.timeDate = function(date){
		return fc.timeDate(date);
	};

	$scope.notificationEvent = function(){
		Pusher.logToConsole = true;
		var client = new Pusher("a9721493e8adefe5f824", {
			cluster: "us2" ,
			encrypted: true
		});
		var pusher = $pusher(client);
		let channel = pusher.subscribe('notifications');
		// Bind a function to a Event (the full Laravel class)
		channel.bind('notification-event', function(data) {
				$scope.notificaciones = {id: 1, title: "Nueva Notificacion",message:"Se creo una nueva orden"};
				console.log($scope.notificaciones);
		});
	};

	/*$scope.monthFilter = function(data){
		for(var i in $scope.calFilter){ $scope.calFilter[i].class = "";}
		data.class = "active";
		$scope.month = data.id;
		let fields = {
			month:   $scope.month ,
			year:    $scope.year
		};
		console.log(fields);
	};

	$scope.yearFilter = function(year){
		$scope.year = year;
		var fields = {
			month:     $scope.month,
			year:    $scope.year
		};
		console.log(fields);
	};*/


	/*$scope.update_notify = function(){

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

	}*/

}]);
