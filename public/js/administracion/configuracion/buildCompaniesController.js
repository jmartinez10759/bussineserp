const URL = {
    url_insert            : "company/register"
    ,url_update           : 'company/update'
    ,url_edit             : 'company/{id}/edit'
    ,url_all              : 'company/all'
    ,url_destroy          : "company/{id}/destroy"
    ,url_country          : "edit/{countryId}/country"
    ,url_state            : "edit/{stateId}/state"
    ,url_code             : "edit/{code}/code"
    ,url_upload          : 'upload/files'
};
app.controller('CompaniesController', ['ServiceController','FactoryController','NotificationsFactory','$scope', function( sc,fc,nf,$scope ) {

    $scope.constructor = function(){
        $scope.datos  = [];
        $scope.cmbCompanies = [];
        $scope.cmbTradeService = [];
        $scope.cmbTaxRegime = [];
        $scope.insert = { estatus: 1 };
        $scope.update = {};
        $scope.fields = {};
        $scope.index();
        $scope.register = [];
        $scope.titles   = [
            "Nombre Comercial",
            "Razon Social",
            "RFC",
            "Servicio Comercial",
            "Contacto",
            "Telefono",
            "Estatus",
            ""
        ];
    };

    $scope.index = function(){
        var url = fc.domain( URL.url_all );
        sc.requestHttp(url,null,"GET",false).then(function (response) {
            if (sc.validateSessionStatus(response)){
                console.log(response);
                $scope.register = [];
                angular.forEach(response.data.data.companies,function (value,key) {
                    $scope.register[key] = {
                        'id'                : value.id ,
                        'companyName'       : value.nombre_comercial ,
                        'socialReason'      : value.razon_social ,
                        'rfc'               : value.rfc_emisor ,
                        'commercialName'    : value.comerciales.nombre ,
                        'contactName'       : (value.contacts.length > 0)? value.contacts[0].nombre_completo: '' ,
                        'contactPhone'      : (value.contacts.length > 0)? value.contacts[0].telefono: '' ,
                        'estatus'           : value.estatus ,
                        'btnDelete'         : ""
                    };
                });
                $scope.datos         = {"titles" : $scope.titles, "register" : $scope.register};
                $scope.cmbTradeService  = response.data.data.tradeService;
                $scope.cmbTaxRegime     = response.data.data.taxRegime;
                $scope.configPagePagination($scope.register);
            }
        });
    };

    $scope.insertRegister = function(){
        var url     = fc.domain(  URL.url_insert );
        var fields  = $scope.insert;
        $scope.spinning = true;
        if (!fields.correo || !fields.razon_social || !fields.rfc_emisor){
            $scope.spinning = false;
            return nf.toastWarning("Campos con asterisco vacios, favor de revisar", nf.titleMgsError);
        }
        sc.requestHttp(url, fields, 'POST', false).then(function (response) {
            if (sc.validateSessionStatus(response)) {
                nf.toastSuccess(response.data.message, nf.titleRegisterSuccess);
                nf.modal("#modal_add_register",true);
                $scope.index();
            }
        });
        $scope.spinning= false;

    };

    $scope.updateRegister = function(upload){
        var url = fc.domain(URL.url_update);
        var fields = sc.mapObject($scope.update, [
            'comerciales',
            'postal_code',
            'regimenes',
            'states',
            'countries'], false);
        $scope.spinning = true;
        if (!fields.correo || !fields.razon_social || !fields.rfc_emisor){
            $scope.spinning = false;
            return nf.toastWarning("Campos con asterisco vacios, favor de revisar", nf.titleMgsError);
        }
        sc.requestHttp(url, fields, 'PUT', false).then(function (response) {
            if (sc.validateSessionStatus(response)) {
                if (!upload){
                    nf.toastInfo(response.data.message, nf.titleMgsSuccess);
                    nf.modal("#modal_edit_register",true);
                }
                nf.trEffect($scope.update.id);
                $scope.index();
            }
            $scope.spinning = false;
        });
    };

    $scope.editRegister = function( id ){
        var url = fc.domain(URL.url_edit,id);
        sc.requestHttp(url,null,"GET",false).then(function (response) {
            var datos = ['created_at',"updated_at"];
            $scope.update = sc.mapObject(response.data.data, datos, false);
            if( response.data.data.contacts.length > 0 ){
                $scope.update.contacto     = response.data.data.contacts[0].nombre_completo;
                $scope.update.departamento = response.data.data.contacts[0].departamento;
                $scope.update.telefono     = response.data.data.contacts[0].telefono;
                $scope.update.correo       = response.data.data.contacts[0].correo;
            }
            console.log($scope.update);
            $scope.actionCodePostal(response.data.data.codigo,true);
            nf.modal("#modal_edit_register");
        });
    };

    $scope.destroyRegister = function( id ){
        var url = fc.domain( URL.url_destroy,id);
        nf.buildSweetAlertOptions("¿Borrar Registro?", "¿Realmente desea eliminar el registro?", "warning", function () {
            sc.requestHttp(url, null, "DELETE", false).then(function (response) {
                if (sc.validateSessionStatus(response)) {
                    nf.toastSuccess(response.data.message, nf.titleMgsSuccess);
                    $scope.index();
                }
            });
        }, null, "SI", "NO");

    };

    $scope.actionCodePostal = function(postalCode, update ){
        var url = fc.domain(URL.url_code, postalCode);
        $scope.cmbCountries = [];
        $scope.cmbStates    = [];
        $scope.cmbMunicipalities = [];
        if (postalCode){
            sc.requestHttp(url, null, "GET", false).then(function (response) {
                if (sc.validateSessionStatus(response)) {
                    if (angular.isDefined(response.data.data)){
                        console.log(response.data.data);
                        $scope.cmbMunicipalities = response.data.data;
                        if ( angular.isDefined(response.data.data[0] ) ){
                            $scope.cmbCountries = [response.data.data[0].countries];
                            $scope.cmbStates    = [{"id" : response.data.data[0].idEstado , "estados" : response.data.data[0].estado}];
                            if (update){
                                $scope.update.id_country    = response.data.data[0].countries.id;
                                $scope.update.id_estado     = response.data.data[0].idEstado;
                                $scope.update.id_municipay  = response.data.data[0].idMunicipio;
                            } else{
                                $scope.insert.id_country = response.data.data[0].countries.id;
                                $scope.insert.id_estado   = response.data.data[0].idEstado;
                            }

                        }
                        return;
                    }

                }

            });
        }
    };

    $scope.fileUpload = function(update){

        var uploadUrl = fc.domain( URL.url_upload );
        var identify = {
            div_content   : 'fileCompany',
            div_dropzone  : 'dropzoneFileCompanies',
            file_name     : 'file'
        };
        var message = "Dar Clíc aquí o arrastrar archivo";
        uploadFile({
            name: 'company_'+$scope.update.id ,
            path : 'upload_file/files/companies/'
        },uploadUrl,message,1,identify,'.png, .jpg, .jpeg',function( request ){
            console.log(request.data);
            var image = request.data[0]+"?version="+Math.random();
            if(update){
                $scope.update.logo = image;
                console.log($scope.update.logo);
            }else{
                $scope.insert.logo = image;
                console.log($scope.insert.logo);
            }
            $scope.updateRegister(true);
            nf.modal("#upload_file",true);
        });
        nf.modal("#upload_file");
    }

}]);