const URL = {
    url_insert            : "usuarios/register"
    ,url_update           : 'usuarios/update'
    ,url_edit             : 'usuarios/edit'
    ,url_all              : 'usuarios/all'
    ,url_destroy          : "usuarios/destroy"
}

app.controller('UsuarioController', ['ServiceController','FactoryController','NotificationsFactory','masterservice','$scope', '$http', '$location', function( ms,fm,nf,masterservice ,$scope, $http, $location ) {

    $scope.constructor = function () {
        $scope.datos = [];
        $scope.insert = {estatus: 1};
        $scope.update = {};
        $scope.edit = {};
        $scope.fields = {};
        $scope.today = new Date();
        $scope.cmb_estatus = [{id: 0, descripcion: "Inactivo"}, {id: 1, descripcion: "Activo"}];
        $scope.cmbCompanies = [];
        $scope.cmbGroups = [];
        $scope.cmbRoles = [];
        $scope.permission = {};
        $scope.actions = {};
        $scope.index();
    };

    $scope.index = function () {
        let url = domain(URL.url_all);
        let fields = {};
        ms.requestHttp(url, fields, 'GET', false).then(function (response) {
            if (ms.validateSessionStatus(response)) {
                console.log(response.data.result);
                $scope.datos = response.data.result.users;
                $scope.cmbCompanies = response.data.result.companies;
                $scope.cmbRoles = response.data.result.roles;
                $scope.cmbGroupsEdit = response.data.result.groups;
            }
        });
    };

    $scope.insertRegister = function () {
        var url = domain(URL.url_insert);
        var fields = $scope.insert;
        ms.requestHttp(url, fields, 'POST', false).then(function (response) {
            if (ms.validateSessionStatus(response)) {
                nf.toastSuccess(response.data.message, title);
                jQuery.fancybox.close({
                    'type'      : 'inline'
                    ,'src'      : "#modal_add_register"
                });
                $scope.index();
            }
        }).catch(function (error) {
            ms.validateStatusError(error);
        });
    };

    $scope.updateRegister = function () {
        let discrim = ['empresas', 'sucursales', 'roles', 'created_at', 'id_bitacora'];
        let url = domain(URL.url_update);
        let fields = ms.mapObject($scope.update, discrim, false);
        ms.requestHttp(url, fields, 'PUT', false).then(function (response) {
            if (ms.validateSessionStatus(response)) {
                nf.toastInfo(response.data.message, title);
                $('#modal_edit_register').modal('hide');
                jQuery('#tr_' + $scope.update.id).effect("highlight", {}, 8000);
                $scope.index();
            }
        }).catch(function (error) {
            ms.validateStatusError(error);
        });

    };

    $scope.editRegister = function (entry) {
        let discrim = ['$$hashKey', 'password'];
        $scope.update = ms.mapObject(entry, discrim, false);
        $scope.update.name = entry.name + " " + entry.first_surname + " " + entry.second_surname;
        var i = 0;
        $scope.update.id_empresa = [];
        $scope.update.id_sucursal = [];
        angular.forEach($scope.update.empresas, function (value, key) {
            $scope.update.id_empresa[i] = value.id;
            i++;
        });
        var j = 0;
        angular.forEach($scope.update.sucursales, function (value, key) {
            $scope.update.id_sucursal[j] = value.id;
            j++;
        });
        $scope.update.id_rol = angular.isDefined($scope.update.roles[0]) ? $scope.update.roles[0].id : 0;
        $scope.findGroupOfCompany($scope.update.id_empresa);
        console.log($scope.update);

        $('#modal_edit_register').modal({keyboard: false, backdrop: "static"});
    };

    $scope.destroyRegister = function (id) {
        var url = domain(URL.url_destroy+"/"+id+"/user");
        nf.buildSweetAlertOptions("¿Borrar Registro?", "¿Realmente desea eliminar el registro?", "warning", function () {
            ms.requestHttp(url, null, "DELETE", false).then(function (response) {
                if (ms.validateSessionStatus(response)) {
                    nf.toastSuccess(response.data.message, title);
                    $scope.index();
                }
            }).catch(function (error) {
                ms.validateStatusError(error);
            });
        }, null, "SI", "NO");

    };

    $scope.permissionMenuUsers = function( id ){
        var url = domain(URL.url_edit+"/"+id);
        ms.requestHttp(url,null,"GET", false).then(function (response) {
            if (ms.validateSessionStatus(response)){

                $scope.permission.id            = id;
                $scope.permission.companyId     = null;
                $scope.permission.groupsId      = null;
                $scope.permission.cmbGroups     = [];
                $scope.permission.dataChecked   = [];
                $scope.permission.disabledCheck = true;

                $scope.permission.TblMenus      = response.data.data.menus;
                $scope.permission.TblAction     = response.data.data.action;
                $scope.permission.cmbCompanies  = response.data.data.companyByUser;
                $scope.permission.cmbRoles      = response.data.data.rolesByUser;
                $scope.permission.rolesId       = angular.isDefined(response.data.data.rolesByUser[0])? response.data.data.rolesByUser[0].id : 0 ;

                console.log($scope.permission);
                $('#modal_permission_user').modal({keyboard: false, backdrop: "static"});
            }
        }).catch(function (error) {
            ms.validateStatusError(error);
        });
    };

    $scope.findPermissionMenuByUser = function(groupsId){

        var url = domain("setting/users/permission");
        var fields = {
            "companyId" : $scope.permission.companyId ,
            "rolesId"   : $scope.permission.rolesId ,
            "groupId"   : groupsId ,
            "userId"    : $scope.permission.id
        };
        $scope.permission.dataChecked = [];
        ms.requestHttp(url,fields,"POST",false).then(function (response) {
            if (ms.validateSessionStatus(response)){
                console.log(response.data.data);
                $scope.permission.disabledCheck = false;
                angular.forEach( response.data.data.menusByUser, function (value, key ) {
                    $scope.permission.dataChecked[value.id] = true;
                });
                return;
            }
            $scope.permission.disabledCheck = true;
        }).catch(function (error) {
            ms.validateStatusError(error);
        });

    };

    $scope.actionsMenuByUsers = function( menuId ){
        $scope.permission.menuId = menuId;
        if ($scope.permission.dataChecked[menuId]){

            var url = domain("setting/menus/action");
            var fields = {
                "menuId"    : menuId ,
                "companyId" : $scope.permission.companyId ,
                "groupId"   : $scope.permission.groupsId ,
                "rolesId"   : $scope.permission.rolesId ,
                "userId"    : $scope.permission.id
            };
            $scope.actions.dataChecked = [];
            ms.requestHttp(url,fields,"POST",false).then(function (response) {
                if (ms.validateSessionStatus(response)){
                    angular.forEach( response.data.data.actionsByUser, function (value, key ) {
                        $scope.actions.dataChecked[value.id] = true;
                    });
                    console.log($scope.actions.dataChecked);
                    jQuery.fancybox.open({
                        'type'      : 'inline'
                        ,'src'      : "#modal_toAssign_action"
                        ,'modal'    : true
                        ,'width'    : 500
                        ,'height'   : 500
                        ,'autoSize' : false
                    });

                }

            }).catch(function (error) {
                ms.validateStatusError(error);
            });

        }else {
            nf.toastError("¡Favor de Seleccionar el menu para obtener sus acciones!", title_error);
            return;
        }

    };

    $scope.findGroupOfCompany = function (companyId) {
        var url = domain('empresas/findGroups');
        var fields = {'id_empresa': companyId };

        ms.requestHttp(url,fields,"POST",false).then(function (response) {
            if (ms.validateSessionStatus(response)){
                $scope.cmbGroups = response.data.data;
                $scope.permission.cmbGroups = response.data.data;
                console.log( $scope.cmbGroups );
            }
        });

    };

    $scope.findByUserGroupOfCompany = function (companyId) {
        var url = domain('empresas/findByUserGroups');
        var fields = {
            'companyId' : companyId ,
            'rolId'     : $scope.permission.rolesId ,
            'userId'    : $scope.permission.id
        };
        ms.requestHttp(url,fields,"POST",false).then(function (response) {
            if (ms.validateSessionStatus(response)){
                $scope.permission.cmbGroups = response.data.data;
                console.log( $scope.permission.cmbGroups );
            }
        }).catch(function (error) {
            ms.validateStatusError(error);
        });
    };
    
    $scope.actionsUserRegister = function () {
        var url = domain("setting/actions/register");
        var fields = {
          "userId"      : $scope.permission.id ,
          "rolesId"     : $scope.permission.rolesId ,
          "companyId"   : $scope.permission.companyId ,
          "groupId"     : $scope.permission.groupsId ,
          "menuId"      : $scope.permission.menuId ,
          "actions"     : $scope.actions.dataChecked
        };

        ms.requestHttp(url,fields,"POST",false).then(function (response) {
            if (ms.validateSessionStatus(response)){
                nf.toastSuccess(response.data.message,success_mgs);

            }
        }).catch(function (error) {
            ms.validateStatusError(error);
        })



    };

}]);