var app = angular.module('application',["ngRoute",'localytics.directives','components',"stringToNumber",'html-unsafe','dataTable']);

app.config([ '$routeProvider' ,function( $routeProvider ) {
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
	    	//loading(true);
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
	    
	    }

  	}

}]);
app.controller('ApplicationController', ['$scope','masterservice','$http','$rootScope' ,function( $scope, masterservice, $http, $rootScope ){

	$rootScope.$on("services", function(){ 
	    
	    $scope.services(); 

	});
	$scope.constructor = function(){
	  $scope.services();
	  $scope.notificaciones = {};
	  $scope.correos = {};
	  $scope.update = {};
	
	}
	$scope.services = function(){

		var url = domain('services');
		var fields = {};
		MasterController.request_http(url,fields,'get',$http, false )
		  .then(function( response ){
		      loading(true);
		      $scope.notificaciones = response.data.result.notification;
		      $scope.correos = response.data.result.correos;

		  }).catch(function( error ){
		    loading(true);
		    console.error( error );
		  });

	}
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



/*app.controller('ApplicationControllers',function( masterservice, $scope, $http ,$rootScope ) {

  $rootScope.$on("services", function(){ 
      $scope.services(); 
  });
  $scope.constructor = function(){
      $scope.services();
      $scope.notificaciones = {};
      $scope.correos = {};
      $scope.update = {};
  }
  $scope.services = function(){
    var url = domain('services');
    var fields = {};
    MasterController.request_http(url,fields,'get',$http, false )
      .then(function( response ){
          loading(true);
          $scope.notificaciones = response.data.result.notification;
          $scope.correos = response.data.result.correos;

      }).catch(function( error ){
        loading(true);
        console.error( error );
      });
  }
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


});*/

/*app.service('masterservice',function(){

	this.url_upload = "";

    this.upload_file = function( update = false ){

      var upload_url = domain( $scope.url_upload );
      var identificador = {
         div_content   : 'div_dropzone_file_empresas' ,div_dropzone  : 'dropzone_xlsx_file_empresas' ,file_name     : 'file'
      };
      var message = "Dar Clíc aquí o arrastrar archivo";
      var fields = {'nombre': 'empresas_'+$scope.update.id };
      $scope.update.logo = "";
      upload_file(fields ,upload_url,message,1,identificador,'.png',function( request ){
          if(update){
            $scope.update.logo = domain(request.result);
            var html = '';
            html = '<img class="img-responsive" src="'+$scope.update.logo+'?'+Math.random()+'" height="268px" width="200px">'
            jQuery('#imagen_edit').html("");        
            jQuery('#imagen_edit').html(html);        
          }else{
            $scope.insert.logo = domain(request.result);
            var html = '';
            html = '<img class="img-responsive" src="'+$scope.insert.logo+'" height="268px" width="200px">'
            jQuery('#imagen').html("");        
            jQuery('#imagen').html(html);        
            
          }
          jQuery.fancybox.close({
              'type'      : 'inline'
              ,'src'      : "#upload_file"
              ,'modal'    : true
          });
      });

      jQuery.fancybox.open({
          'type'      : 'inline'
          ,'src'      : "#upload_file"
          ,'modal'    : true
      });

    }
    this.format_date = function( fecha, format ){
        var d = new Date(fecha);
        if( format === "yyyy-mm-dd"){
          return d.getFullYear() + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" +  ("0" +(d.getDate())).slice(-2);
        }else{
          return ("0" + d.getDate()).slice(-2) + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" + d.getFullYear();
        }
    
    }
    this.send_reporte = function(data){

        $scope.correo.email        = data.contactos.correo;
        $scope.correo.name         = data.contactos.nombre_completo;
        $scope.correo.mensaje      = "Se le hace el envio de su solicitud";
        $scope.correo.asunto       = "Confirmar Solicitud";
        $scope.correo.id_pedido    = data.id;
        //$scope.correo.descripcion = "Es ";
        jQuery.fancybox.open({
            'type'      : 'inline'
            ,'src'      : "#modal_correo_send"
            ,'modal'    : true
            ,'width'    : 900
            ,'height'   : 500
            ,'autoSize' : false
        });

    }
    this.send_correo = function(url, fields ){
        
        MasterController.request_http(url,fields,'post',$http, false )
        .then(function( response ){
            toastr.success( "Se envio el correo correctamente" , title ); 
            jQuery.fancybox.close({
                'type'      : 'inline'
                ,'src'      : "#modal_correo_send"
                ,'modal'    : true
                ,'width'    : 900
                ,'height'   : 500
                ,'autoSize' : false
            });           
            $scope.correo = {};
        }).catch(function( error ){
            if( isset(error.response) && error.response.status == 419 ){
                  toastr.error( session_expired ); 
                  redirect(domain("/"));
                  return;
              }
              console.error( error );
              toastr.error( error.result , expired );
        }); 

    }
    this.method_proof =function() {
    	alert("llego a utilizar esta funcion desde cualquier controller");
    }




});*/