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

	$scope.notifyDetails = function(notify) {
        var url = fc.domain("notifications/{id}/destroy",notify.id);
        sc.requestHttp(url, null, 'DELETE', false).then(function (response) {
            if (sc.validateSessionStatus(response)) {
                redirect(fc.domain(notify.module));
            }
        });
	};

	$scope.timeDate = function(date){
		return fc.timeDate(date);
	};

	$scope.notificationEvent = function(){
		var channel = sc.pusher().subscribe('notifications');
		// Bind a function to a Event (the full Laravel class)
		channel.bind('notification-event', function(data) {
			$scope.services();
			if($scope.loginUser.rolesId == 3 || $scope.loginUser.rolesId == 12){
                nf.toastInfo(data.message,data.title,{
                	timeOut: 0 ,
					extendedTimeOut : 0 ,
					tapToDismiss: false
				});
            }

		});
	};

	/*$scope.downloadReportPDF = function () {
		$scope.downloadPDF();
	};*/

	$scope.reportCsv = function (fields) {
		let columns  = (angular.isDefined(fields.columnas))? fields.columnas : [];
		/*let title    = (angular.isDefined(fields.titulo))? fields.titulo : "";*/
		let data    = (angular.isDefined(fields.datos))? fields.datos : {};

		jQuery('#csv').jexcel({
			data			: data ,
			colHeaders 		: columns ,
			colWidths  		: [ 150, 150, 400, 150,150, 150, 150 ] ,
			csvHeaders 		: true ,
			tableOverflow 	: true ,
			tableHeight		: '50px'
		});
		jQuery.fancybox.open({
			'type': 'inline' ,
			'src': "#contentCsv" ,
			'buttons' : ['share', 'close']
		});
	};



}]);
