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

    FactoryController.prototype.domain = function (url, replaceString = "" ) {
        var url = (url)? url.replace(/{(.*)}/,replaceString ) : "";
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

    FactoryController.prototype.validateRfc = function(rfc) {
        var strSuccessfully;
        strSuccessfully = rfc;
        var valid = "";
        if ( rfc.length == 12 ){
            valid = '^(([A-Z]|[a-z]){3})([0-9]{6})((([A-Z]|[a-z]|[0-9]){3}))';
        }else{
            valid = '^(([A-Z]|[a-z]|\s){1})(([A-Z]|[a-z]){3})([0-9]{6})((([A-Z]|[a-z]|[0-9]){3}))';
        }
        var validRfc = new RegExp( valid );
        var matchArray =strSuccessfully.match(validRfc);
        return (matchArray != null)? true : false;
    };

    FactoryController.prototype.validateEmail = function (email) {
        if (email) {
            const re = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
            var valido = email.match(re);
            if (!valido) {
                return false;
            }
            return true;
        }
        return false;
    };

    FactoryController.prototype.validateCurp = function (curp) {
        var re = /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/,
            validado = curp.match(re);
        if (!validado){
            return false;
        }
        function digitoVerificador(curp17) {
            //Fuente https://consultas.curp.gob.mx/CurpSP/
            var diccionario = "0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ",
                lngSuma = 0.0,
                lngDigito = 0.0;
            for (var i = 0; i < 17; i++)
                lngSuma = lngSuma + diccionario.indexOf(curp17.charAt(i)) * (18 - i);
            lngDigito = 10 - lngSuma % 10;
            if (lngDigito == 10) return 0;
            return lngDigito;
        }
        if (validado[2] != digitoVerificador(validado[1])){
            return false;
        }
        return true;
    };

    FactoryController.prototype.validateNss = function (nss) {
        const re = /^(\d{2})(\d{2})(\d{2})\d{5}$/,
            validado = nss.match(re);
        if (!validado) // 11 dígitos y subdelegación válida?
            return false;
        const subDeleg = parseInt(validado[1], 10),
            anno = new Date().getFullYear() % 100;
        var annoAlta = parseInt(validado[2], 10),
            annoNac = parseInt(validado[3], 10);
        //Comparar años (excepto que no tenga año de nacimiento)
        if (subDeleg != 97) {
            if (annoAlta <= anno) annoAlta += 100;
            if (annoNac <= anno) annoNac += 100;
            if (annoNac > annoAlta)
                return false; // Err: se dio de alta antes de nacer!
        }
        function luhn(nss) {
            var suma = 0,
                par = false,
                digito;
            for (var i = nss.length - 1; i >= 0; i--) {
                var digito = parseInt(nss.charAt(i), 10);
                if (par)
                    if ((digito *= 2) > 9)
                        digito -= 9;
                par = !par;
                suma += digito;
            }
            return (suma % 10) == 0;
        }
        return luhn(nss);
    };

    FactoryController.prototype.numberFormat = function (amount, decimals) {
        amount += ''; // por si pasan un numero en vez de un string
        amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto
        decimals = decimals || 0; // por si la variable no fue fue pasada
        // si no es un numero o es igual a cero retorno el mismo cero
        if (isNaN(amount) || amount === 0)
            return parseFloat(0).toFixed(decimals);
        // si es mayor o menor que cero retorno el valor formateado como numero
        amount = '' + amount.toFixed(decimals);
        var amount_parts = amount.split('.'),
            regexp = /(\d+)(\d{3})/;
        while (regexp.test(amount_parts[0]))
            amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');
        return amount_parts.join('.');
    };

    return new FactoryController();

}]);