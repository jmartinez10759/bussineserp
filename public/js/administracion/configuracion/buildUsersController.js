const URL = {
    url_insert            : "usuarios/register"
    ,url_update           : 'usuarios/update'
    ,url_edit             : 'usuarios/edit'
    ,url_all              : 'usuarios/all'
    ,url_destroy          : "usuarios/destroy"
}

app.controller('UsuarioController', ['ServiceController','FactoryController','NotificationsFactory','$scope','$location', function( sc,fm,nf,$scope, $location ) {

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
        let url = fm.domain(URL.url_all);
        let fields = {};
        sc.requestHttp(url, fields, 'GET', false).then(function (response) {
            if (sc.validateSessionStatus(response)) {
                console.log(response.data.data);
                $scope.datos = response.data.data.users;
                $scope.cmbCompanies = response.data.data.companies;
                $scope.cmbRoles = response.data.data.roles;
                $scope.cmbGroupsEdit = response.data.data.groups;
            }
        });
    };

    $scope.insertRegister = function () {
        var url = fm.domain(URL.url_insert);
        var fields = $scope.insert;
        sc.requestHttp(url, fields, 'POST', false).then(function (response) {
            if (sc.validateSessionStatus(response)) {
                nf.toastSuccess(response.data.message, nf.titleMgsSuccess);
                nf.modal("#modal_add_register",true);
                $scope.index();
            }
        });
    };

    $scope.updateRegister = function () {
        let discrim = ['companies', 'groups', 'roles', 'created_at', 'bitacora','id_bitacora'];
        let url = fm.domain(URL.url_update);
        let fields = sc.mapObject($scope.update, discrim, false);
        sc.requestHttp(url, fields, 'PUT', false).then(function (response) {
            if (sc.validateSessionStatus(response)) {
                nf.toastInfo(response.data.message, nf.titleMgsSuccess);
                nf.modal("#modal_edit_register",true);
                nf.trEffect($scope.update.id);
                $scope.index();
            }
        });

    };

    $scope.editRegister = function (entry) {
        var discrim = ['$$hashKey', 'password'];
        $scope.update = sc.mapObject(entry, discrim, false);
        $scope.update.name = entry.name + " " + entry.first_surname + " " + entry.second_surname;
        var i = 0;
        $scope.update.id_empresa = [];
        $scope.update.id_sucursal = [];
        angular.forEach($scope.update.companies, function (value, key) {
            $scope.update.id_empresa[i] = value.id;
            i++;
        });
        var j = 0;
        angular.forEach($scope.update.groups, function (value, key) {
            $scope.update.id_sucursal[j] = value.id;
            j++;
        });
        $scope.update.id_rol = angular.isDefined($scope.update.roles[0]) ? $scope.update.roles[0].id : 0;
        $scope.findGroupOfCompany($scope.update.id_empresa);
        console.log($scope.update);
        nf.modal("#modal_edit_register");
    };

    $scope.destroyRegister = function (id) {
        var url = fm.domain(URL.url_destroy+"/"+id+"/user");
        nf.buildSweetAlertOptions("¿Borrar Registro?", "¿Realmente desea eliminar el registro?", "warning", function () {
            sc.requestHttp(url, null, "DELETE", false).then(function (response) {
                if (sc.validateSessionStatus(response)) {
                    nf.toastSuccess(response.data.message, nf.titleMgsSuccess);
                    $scope.index();
                }
            });
        }, null, "SI", "NO");

    };

    $scope.permissionMenuUsers = function( id ){
        var url = fm.domain(URL.url_edit+"/"+id);
        sc.requestHttp(url,null,"GET", false).then(function (response) {
            if (sc.validateSessionStatus(response)){

                $scope.permission.id            = id;
                $scope.permission.companyId     = 0;
                $scope.permission.groupsId      = 0;
                $scope.permission.cmbGroups     = [];
                $scope.permission.dataChecked   = [];
                $scope.permission.disabledCheck = true;

                $scope.permission.TblMenus      = response.data.data.menus;
                $scope.permission.TblAction     = response.data.data.action;
                $scope.permission.cmbCompanies  = response.data.data.companyByUser;
                $scope.permission.cmbRoles      = response.data.data.rolesByUser;
                $scope.permission.rolesId       = angular.isDefined(response.data.data.rolesByUser[0])? response.data.data.rolesByUser[0].id : 0 ;
                if ($scope.permission.rolesId == 1){
                    $scope.findPermissionMenuByUser($scope.permission.groupsId);
                }
                console.log($scope.permission);
                nf.modal("#modal_permission_user");
            }
        });
    };

    $scope.findPermissionMenuByUser = function(groupsId){
        var url = fm.domain("setting/users/permission");
        var fields = {
            "companyId" : $scope.permission.companyId ,
            "rolesId"   : $scope.permission.rolesId ,
            "groupId"   : groupsId ,
            "userId"    : $scope.permission.id
        };
        $scope.permission.dataChecked = [];
        sc.requestHttp(url,fields,"POST",false).then(function (response) {
            if (sc.validateSessionStatus(response)){
                console.log(response.data.data);
                $scope.permission.disabledCheck = false;
                angular.forEach( response.data.data.menusByUser, function (value, key ) {
                    $scope.permission.dataChecked[value.id] = true;
                });
                return;
            }
            $scope.permission.disabledCheck = true;
        });

    };

    $scope.actionsMenuByUsers = function( menuId ){
         $scope.permission.menuId = menuId;
        if ($scope.permission.dataChecked[menuId]){
            var url = fm.domain("setting/menus/action");
            var fields = {
                "menuId"    : $scope.permission.menuId ,
                "companyId" : $scope.permission.companyId ,
                "groupId"   : $scope.permission.groupsId ,
                "rolesId"   : $scope.permission.rolesId ,
                "userId"    : $scope.permission.id
            };
            $scope.actions.dataChecked = [];
            sc.requestHttp(url,fields,"POST",false).then(function (response) {
                if (sc.validateSessionStatus(response)){
                    angular.forEach( response.data.data.actionsByUser, function (value, key ) {
                        $scope.actions.dataChecked[value.id] = true;
                    });
                    console.log($scope.actions.dataChecked);
                    nf.modal("#modal_toAssign_action");
                }

            });

        }else {
            nf.toastError("¡Favor de Seleccionar el menu para obtener sus acciones!", title_error);
            return;
        }

    };

    $scope.findGroupOfCompany = function (companyId) {
        var url = fm.domain('empresas/findGroups');
        var fields = {'id_empresa': companyId };

        sc.requestHttp(url,fields,"POST",false).then(function (response) {
            if (sc.validateSessionStatus(response)){
                $scope.cmbGroups = response.data.data;
                //$scope.permission.cmbGroups = response.data.data;
                console.log( $scope.cmbGroups );
            }
        });

    };

    $scope.findByUserGroupOfCompany = function (companyId) {
        var url = fm.domain('empresas/findByUserGroups');
        var fields = {
            'companyId' : companyId ,
            'rolId'     : $scope.permission.rolesId ,
            'userId'    : $scope.permission.id
        };
        sc.requestHttp(url,fields,"POST",false).then(function (response) {
            if (sc.validateSessionStatus(response)){
                $scope.permission.cmbGroups = response.data.data;
                console.log( $scope.permission.cmbGroups );
            }
        });
    };
    
    $scope.actionsUserRegister = function () {
        var url = fm.domain("setting/actions/register");
        var fields = {
          "userId"      : $scope.permission.id ,
          "rolesId"     : $scope.permission.rolesId ,
          "companyId"   : $scope.permission.companyId ,
          "groupId"     : $scope.permission.groupsId ,
          "menuId"      : $scope.permission.menuId ,
          "actions"     : $scope.actions.dataChecked
        };
        if ($scope.actions.dataChecked.length > 0){

            sc.requestHttp(url,fields,"POST",false).then(function (response) {
                if (sc.validateSessionStatus(response)){
                    nf.toastSuccess(response.data.message,nf.titleMgsSuccess);
                    nf.modal('#modal_toAssign_action',true);
                    $scope.index();
                }
            });
            return;
        }
        nf.toastError("¡Favor de Seleccionar almenos una acción!",nf.titleMgsError);

    };

    $scope.permissionUserRegister = function () {
        var url = fm.domain("setting/permission/register");
        var fields = {
            "userId"      : $scope.permission.id ,
            "rolesId"     : $scope.permission.rolesId ,
            "companyId"   : $scope.permission.companyId ,
            "groupId"     : $scope.permission.groupsId ,
            "menus"       : $scope.permission.dataChecked
        };
        if ($scope.permission.dataChecked.length > 0){

            sc.requestHttp(url,fields,"POST",false).then(function (response) {
                if (sc.validateSessionStatus(response)){
                    nf.toastSuccess(response.data.message,nf.titleMgsSuccess);
                    nf.modal("#modal_permission_user",true);
                    $scope.index();
                }
            });
            return;
        }
        nf.toastWarning("¡Favor de seleccionar un menu!",nf.titleMgsError);

    }

}]);