const URL = {
    url_insert            : "menus/register"
    ,url_update           : 'menus/update'
    ,url_edit             : 'menus/{id}/edit'
    ,url_all              : 'menus/all'
    ,url_destroy          : "menus/destroy/{id}/company"
};

app.controller('MenusController', ['ServiceController','FactoryController','NotificationsFactory','$scope', function( sc,fc,nf,scope ) {

    scope.constructor = function(){
        scope.datos  = [];
        scope.insert = { estatus: 1 };
        scope.update = {};
        scope.fields = {};
        scope.cmbTypeMenu= [{id:"SIMPLE",descripcion: "Principal"},{id:"PADRE",descripcion: "Menu"},{id:"HIJO",descripcion: "SubMenus"}];
        scope.cmbTypeMenus= {};
        scope.index();
        scope.register = [];
        scope.titles   = [
            "Menu",
            "Url",
            "Tipo Menu",
            "Icono",
            "Estatus",
            ""
        ];
    };

    scope.index = function(){
        var url = fc.domain( URL.url_all );
        sc.requestHttp(url,null,"GET",false).then(function (response) {
            if (sc.validateSessionStatus(response)){
                console.log(response);
                scope.register = [];
                angular.forEach(response.data.data.menus,function (value,key) {
                    scope.register[key] = {
                        'id'          : value.id ,
                        'texto'       : value.texto ,
                        'link'        : value.link ,
                        'tipo'        : value.tipo ,
                        'icon'        : value.icon ,
                        'estatus'     : value.estatus ,
                        'btnDelete'   : ""
                    };
                });
                scope.datos         = {"titles" : scope.titles, "register" : scope.register};
                scope.configPagePagination(scope.register);
                scope.cmbTypeMenus = response.data.data.cmbMenus
            }
        });
    };

    scope.insertRegister = function(){
        var url     = fc.domain(  URL.url_insert );
        var fields  = scope.insert;
        scope.spinning = true;
        sc.requestHttp(url, fields, 'POST', false).then(function (response) {
            if (sc.validateSessionStatus(response)) {
                nf.toastSuccess(response.data.message, nf.titleRegisterSuccess);
                nf.modal("#modal_add_register",true);
                scope.constructor();
            }
            scope.spinning = false;
        });

    };

    scope.updateRegister = function(){
        var url = fc.domain(URL.url_update);
        var fields = sc.mapObject(scope.update, ['companies_menus','pivot'], false);
        scope.spinning = true;
        sc.requestHttp(url, fields, 'PUT', false).then(function (response) {
            if (sc.validateSessionStatus(response)) {
                nf.toastInfo(response.data.message, nf.titleMgsSuccess);
                nf.modal("#modal_edit_register",true);
                nf.trEffect(scope.update.id);
                scope.index();
            }
            scope.spinning = false;
        });
    };

    scope.editRegister = function( id ){
        var url = fc.domain(URL.url_edit,id);
        sc.requestHttp(url,null,"GET",false).then(function (response) {

            var datos = ["created_at","updated_at"];
            scope.update = sc.mapObject(response.data.data, datos, false);
            scope.update.companyId = [];
            angular.forEach(scope.update.companies_menus,function (value, key) {
                scope.update.companyId[key] = value.id;
            });
            console.log(scope.update);
            nf.modal("#modal_edit_register");

        });
    };

    scope.destroyRegister = function( id ){

        var url = fc.domain( URL.url_destroy,id);
        nf.buildSweetAlertOptions("¿Borrar Registro?", "¿Realmente desea eliminar el registro?", "warning", function () {
            sc.requestHttp(url, null, "DELETE", false).then(function (response) {
                if (sc.validateSessionStatus(response)) {
                    nf.toastSuccess(response.data.message, nf.titleMgsSuccess);
                    scope.index();
                }
            });
        }, null, "SI", "NO");

    };

}]);