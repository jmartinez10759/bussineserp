const URL = {
    url_insert            : "menus/register"
    ,url_update           : 'menus/update'
    ,url_edit             : 'menus/edit'
    ,url_all              : 'menus/all'
    ,url_destroy          : "menus/destroy"
};

app.controller('MenusController', ['ServiceController','FactoryController','NotificationsFactory','$scope', function( sc,fc,nf,scope ) {

    scope.constructor = function(){
        scope.datos  = [];
        scope.insert = { estatus: 1 };
        scope.update = {};
        scope.edit   = {};
        scope.fields = {};
        scope.cmbTypeMenu= [{id:"SIMPLE",descripcion: "Principal"},{id:"PADRE",descripcion: "Menu"},{id:"HIJO",descripcion: "SubMenus"}];
        scope.cmbTypeMenus= {};
        scope.index();
    };

    scope.index = function(){
        var url = fc.domain( URL.url_all );
        sc.requestHttp(url,null,"GET",false).then(function (response) {
            if (sc.validateSessionStatus(response)){
                console.log(response);
                scope.datos = response.data.data.menus;
                scope.cmbTypeMenus = response.data.data.cmbMenus
            }
        });
    };

    scope.insertRegister = function(){
        var url     = fc.domain(  URL.url_insert );
        var fields  = scope.insert;
        sc.requestHttp(url, fields, 'POST', false).then(function (response) {
            if (sc.validateSessionStatus(response)) {
                nf.toastSuccess(response.data.message, nf.titleRegisterSuccess);
                jQuery.fancybox.close({
                    'type'      : 'inline'
                    ,'src'      : "#modal_add_register"
                });
                scope.index();
            }
        });

    };

    scope.updateRegister = function(){
        let url = fc.domain(URL.url_update);
        var fields = sc.mapObject(scope.update, ['companies'], false);
        sc.requestHttp(url, fields, 'PUT', false).then(function (response) {
            if (sc.validateSessionStatus(response)) {
                nf.toastInfo(response.data.message, nf.titleMgsSuccess);
                nf.modal("#modal_edit_register",true);
                nf.trEffect(scope.update.id);
                scope.index();
            }
        });
    };

    scope.editRegister = function( entry ){
        var datos = ["created_at","updated_at"];
        scope.update = sc.mapObject(entry, datos, false);
        scope.update.companyId = [];
        angular.forEach(scope.update.companies,function (value, key) {
            scope.update.companyId[key] = value.id;
        });
        console.log(scope.update);
        nf.modal("#modal_edit_register");
    };

    scope.destroyRegister = function( id ){

        var url = fc.domain( URL.url_destroy+"/"+id+"/company" );
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