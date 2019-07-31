const URL = {
    url_insert            : "cuts/register"
    ,url_edit             : "cuts/{id}/edit"
    ,url_all              : "cuts/{year}/filter"
    ,url_update           : "cuts/{id}/update"
    ,url_destroy          : "cuts/{id}/destroy"
};

app.controller('CutsController', ['ServiceController','FactoryController','NotificationsFactory','$scope', function( sc,fc,nf,$scope ) {

    $scope.constructor = function(){
        $scope.datos  = [];
        $scope.insert = { status: 1 };
        $scope.update = {};
        $scope.fields = {};
        $scope.index();
    };

    $scope.index = function(){
        console.log($scope.user);
        var url = fc.domain( URL.url_all+"/"+$scope.month, $scope.year);
        sc.requestHttp(url,{ user : $scope.user },"POST",false).then(function (response) {
            if (sc.validateSessionStatus(response)){
                console.log(response);
                $scope.cmbUsers = response.data.data.users;
                $scope.datos    = response.data.data.cuts;
                $scope.subtotal = response.data.data.subtotal;
                $scope.iva      = response.data.data.iva;
                $scope.total    = response.data.data.total;

            }
        });
    };

    $scope.monthFilter = function(data){
        for(var i in $scope.calFilter){ $scope.calFilter[i].class = "";}
        data.class = "active";
        $scope.month = data.id;
        let fields = {
            month:   $scope.month ,
            year:    $scope.year
        };
        $scope.index();
    };

    $scope.yearFilter = function(year){
        $scope.year = year;
        var fields = {
            month:     $scope.month,
            year:    $scope.year
        };
        $scope.index();
    };

    $scope.userFilter = function(user){
        $scope.user = user;
        $scope.index();
    };

    $scope.ticketWatch = function(path){
        jQuery.fancybox.open({
            'type': 'iframe' ,
            'src': fc.domain(path) ,
            'buttons' : ['share', 'close']
        });
    };

    /*$scope.updateRegister = function(){
        let url = fc.domain(URL.url_update);
        var fields = sc.mapObject($scope.update, ['companies_roles'], false);
        $scope.spinning = true;
        sc.requestHttp(url, fields, 'PUT', false).then(function (response) {
            if (sc.validateSessionStatus(response)) {
                nf.toastInfo(response.data.message, nf.titleMgsSuccess);
                nf.modal("#modal_edit_register",true);
                nf.trEffect($scope.update.id);
                $scope.index();
            }
            $scope.spinning = false;
        });
    };*/

    $scope.editRegister = function( entry ){
        var url = fc.domain(URL.url_edit,entry.id);
        sc.requestHttp(url,null,"GET",false).then(function (response) {
            //console.log(response.data.data.concepts);
            $scope.update = response.data.data.concepts;
            console.log($scope.update);
            nf.modal("#modal_edit_register");
        });
    };

    /*$scope.cancelOrders = function( id ){
        var url = fc.domain(URL.url_update,id);
        var fields = {
            status_id: 4
        };
        nf.buildSweetAlertOptions("¿Cancelar Pedido?", "¿Realmente desea cancelar el pedido?", "warning", function () {
            sc.requestHttp(url, fields, 'PUT', false).then(function (response) {
                if (sc.validateSessionStatus(response)) {
                    nf.toastInfo(response.data.message, nf.titleMgsSuccess);
                    nf.trEffect(id);
                    $scope.index();
                }
            });
        }, null, "SI", "NO");

    };*/

    $scope.downloadReportPDF = function(){
        var register = $scope.datos;
        var columns = ["Nombre","RFC","Cliente","N°Factura",'Fecha Pago','Total Comisión','Total Pago','Total Factura'];
        var data = [];
        var reports= [];
        var count = 0;
        var j = 0;
        alert();
        console.log(register);return;
        for (var i in register) {
            data[register[i].id_usuario] = [];
        }
        for (var i in register) {
            data[register[i].id_usuario][count] = [
                register[i].nombre_completo
                //,register[i].perfil
                ,register[i].rfc_receptor
                ,register[i].razon_social
                ,register[i].factura
                ,(register[i].fecha_pago !== null)?register[i].fecha_pago: ""
                ,"$"+number_format(register[i].comision_general,2)
                ,"$"+number_format(register[i].pago_general,2)
                ,"$"+number_format(register[i].total_general,2)
            ];
            count++;
        }
        for ( var i in data) {
            reports[j] = Object.values(data[i]);
            j++
        }
        var fields = {
            'columnas' : columns
            ,'titulo'  : "REPORTE MENSUAL DE VENTAS DE"
            ,'datos'   :  reports
        };
        var options ={
            // Styling
            theme: 'striped', // 'striped', 'grid' or 'plain'
            styles: {
                columnWidth: 34, // 'auto', 'wrap' or a number
                overflow: 'linebreak', // visible, hidden, ellipsize or linebreak
                //cellPadding: 2, // a number, array or object (see margin below)
            },
            headerStyles: {},
            bodyStyles: {},
            alternateRowStyles: {},
            columnStyles: {},
            // Properties
            startY: false, // false (indicates margin top value) or a number
            margin: {top: 30}, // a number, array or object
            pageBreak: 'auto', // 'auto', 'avoid' or 'always'
            tableWidth: 'auto', // 'auto', 'wrap' or a number,
            showHeader: 'firstPage', // 'everyPage', 'firstPage', 'never',
            tableLineColor: 200, // number, array (see color section below)
            tableLineWidth: 0,
            // Hooks
            createdHeaderCell: function (cell, data) {},
            createdCell: function (cell, data) {},
            drawHeaderRow: function (row, data) {},
            drawRow: function (row, data) {},
            drawHeaderCell: function (cell, data) {},
            drawCell: function (cell, data) {},
            addPageContent: function (data) {}
        };
        fc.reportPdf(fields,options);

    };

}]);
