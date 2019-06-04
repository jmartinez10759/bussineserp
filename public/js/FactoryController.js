app.factory('FactoryController',['$http', function (http) {

    function FactoryController() {

    };
    FactoryController.prototype.formatDate  = function(date,format) {
        var d = new Date(date);
        if( format === "yyyy-mm-dd"){
            return d.getFullYear() + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" +  ("0" +(d.getDate())).slice(-2);
        }else{
            return ("0" + d.getDate()).slice(-2) + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" + d.getFullYear();
        }
    };

    FactoryController.prototype.calendar = function(){
        var calendar = [];
        var count = 1;
        var nombres = ['ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC','TODOS'];
        for (var i = 0; i < nombres.length; i++) {
            calendar[i] = { id: count , nombre:nombres[i] };
            count++;
        }
        return calendar;
    };

    FactoryController.prototype.selectYears  =  function(){
        var fecha = new Date();
        var year = (fecha.getFullYear());
        var select = [];
        var cont = 1;
        for (var i = year; i >= 2000; i--) {
            select[cont] = { id: i ,descripcion: i };
            cont++;
        }
        return { anio: select[1].id, cmb_anios: select };
    };

    FactoryController.prototype.calculateSum = function(precio = false,cantidad = false ){
        var precio = (precio != "") ? precio : 0;
        var cantidad = (cantidad != "") ? cantidad: 0;
        var total  = parseFloat(precio * cantidad);
        return total.toFixed(2);
    };

    FactoryController.prototype.timeDate =  function(date){
        // asignar el valor de las unidades en milisegundos
        var msecPerMinute = 1000 * 60;
        var msecPerHour = msecPerMinute * 60;
        var msecPerDay = msecPerHour * 24;
        // asignar la date en milisegundos
        var date = new Date(date);
        var dateMsec = date.getTime();
        // asignar la date el 1 de enero del a la media noche
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
        var hours = Math.floor(interval / msecPerHour );
        interval = interval - (hours * msecPerHour );
        var minutes = Math.floor(interval / msecPerMinute );
        interval = interval - (minutes * msecPerMinute );
        var seconds = Math.floor(interval / 1000 );
        //var time_elapsed = ( (days > 0 ) ? days + " dias, " : "" ) + ( (hours > 0 )? hours + " horas, " : " " ) + ( (minutes > 0) ? minutes + " minutos, ": "" )+ ((seconds > 0)? seconds + " segundos." : "");
        var time_elapsed = ( (days > 0 ) ? days + " dias, " : "" ) + ( (hours > 0 )? hours + " horas, " : " " ) + ( (minutes > 0) ? minutes + " minutos, ": " unos segundos" );
        return  time_elapsed;
        //Output: 164 días, 23 horas, 0 minutos, 0 segundos.

    };

    FactoryController.prototype.diffDaysToday = function (startDay) {
        let changeDay = new Date( startDay );
        var today  = new Date();
        const MILISENGUNDOS_POR_DIA = 1000 * 60 * 60 * 24;
        let utc1 = Date.UTC(changeDay.getFullYear(), changeDay.getMonth(), changeDay.getDate());
        let utc2 = Date.UTC(today.getFullYear(), today.getMonth(), today.getDate());
        return Math.floor((utc2 - utc1) / MILISENGUNDOS_POR_DIA);
    };

    FactoryController.prototype.domain = function (url) {
        var pathGeneral = document.getElementsByTagName("META");
        var content = "";
        for (var i = 0; i < pathGeneral.length; i++) {
            if (pathGeneral[i].name == 'ruta-general') {
                content = pathGeneral[i].content;
            }
        }
        var meta = content.split('/');
        var ruta = window.location.href.split("/");
        var http = window.location.protocol;
        var host = window.location.host;
        var public = ( !angular.isUndefined(ruta[4]) && ruta[4] == "public") ? ruta[4] + "/" : "";
        var project = (!angular.isUndefined(ruta[3])) ? ruta[3] + "/" : "";

        if ( !angular.isUndefined(meta[1]) && meta[1] == "index.php" || meta[1] == "server.php") {
            return http + "//" + host + "/" + url;
        }
        if (public && project) {
            return http + "//" + host + "/" + project + public + url;
        }
        if (public == "" && project) {
            return http + "//" + host + "/" + project + url;
        }
    };

    FactoryController.prototype.sha1 = function (entry) {

    };

    return new FactoryController();

}]);