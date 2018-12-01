var app = angular.module('application',["ngRoute",'localytics.directives','components',"stringToNumber"]);
app.service('masterservice', function() {

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
	    session_status: function( url = {}, error = {} ){
	    	//console.log(url);
    		for(var i in url ){
		    	if( url[i] === domain() ){
	              toastr.error( session_expired );
	              setTimeout(function(){ redirect(domain()); }, 1500); 
	              return true;
	            }
    			
    		}

	    	if ( error.length > 0 ) {
		    	if( isset(error.response) && error.response.status == 419 ){
	                  toastr.error( session_expired );
	                  setTimeout(function(){ redirect(domain()); }, 1000);  
	                  return;
	            }
	            console.error( error );
              	toastr.error( error.result , expired );

	    	}

	    }





  	}

});
app.directive('habilitar', function() {
	 return {
		 link: function(scope, element, attrs, controller) {
		 	element[0].focus();
		 }
	 };
	 });


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