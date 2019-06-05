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
        var fields = sc.mapObject(scope.update, ['empresas'], false);
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
        var datos = ['id', 'perfil', 'clave_corta', 'estatus',"empresas" ];
        scope.update = sc.mapObject(entry, datos, true);
        scope.update.companyId = [];
        angular.forEach(scope.update.empresas,function (value, key) {
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


/*
var url_insert    = "menus/register";
var url_update    = "menus/update";
var url_edit      = "menus/edit";
var url_destroy   = "menus/destroy";
var url_all       = "menus/all";
var redireccion   = "configuracion/menus";

new Vue ({
  el: "#vue_menus",
  created: function () {
    this.consulta_general();
  },
  data: {
    datos: [],
    newKeep: {
      'texto': ""
      ,'tipo': "SIMPLE"
      ,'id_padre': ""
      ,'link': ""
      ,'icon': ""
      ,'orden': ""
      ,'estatus': 1
    },
    fillKeep: {
      'texto': ""
      ,'tipo': ""
      ,'id_padre': ""
      ,'link': ""
      ,'icon': ""
      ,'orden': ""
      ,'estatus': 1
    },

  },
  mixins : [mixins],
  methods:{
      consulta_general: function(){

      },
      tipo_menu: function(){
        var url = domain('menus/tipo');
        var fields = {'tipo': 'PADRE'};
        if( this.newKeep.tipo == "HIJO" || this.fillKeep.tipo == "HIJO"){
            this.get_general(url,fields);
        }else{
          this.newKeep.id_padre = "";
          this.fillKeep.id_padre = "";
        }

      }
      ,insert: function(){
          var url = domain(url_insert);
          var fields = this.newKeep;
          var promise = MasterController.method_master(url, fields, "post");
          promise.then(response => {
            toastr.success(response.data.message, title);
            redirect(domain(redireccion));
          }).catch(error => {
            if (error.response.status == 419) {
              toastr.error(session_expired);
              redirect(domain("/"));
              return;
            }
            toastr.error(error.response.data.message, expired);

          });
      }
      ,destroy: function( id ){
          var url = domain(url_destroy);
          var fields = {id: id};
          buildSweetAlertOptions("¿Borrar Registro?", "¿Realmente desea eliminar el registro?", function () {
            var promise = MasterController.method_master(url, fields, "delete");
            promise.then(response => {
              toastr.info(response.data.message, title);
              redirect(domain(redireccion));
            }).catch(error => {
              if (error.response.status == 419) {
                toastr.error(session_expired);
                redirect(domain("/"));
                return;
              }
              toastr.error(error.response.data.message, expired);
            });
          }, "warning", true, ["SI", "NO"]);

      }
      ,update: function(){
        var url = domain(url_update);
        var fields = this.fillKeep;
        var promise = MasterController.method_master(url, fields, "put");
        promise.then(response => {
          toastr.info(response.data.message, title);
          redirect(domain(redireccion));
        }).catch(error => {
          if (error.response.status == 419) {
            toastr.error(session_expired);
            redirect(domain("/"));
            return;
          }
          toastr.error(error.response.data.message, expired);
          
        });

      }
      ,editar: function( keep ){
          var url = domain(url_edit );
          var fields = {'id' : keep};
          axios.get( url, { params: fields }, csrf_token ).then(response => {
              if( response.data.success == true ){
                this.fillKeep = response.data.result;
                this.tipo_menu();
                jQuery('#modal_edit_register').modal('show');
              }else{
                  toastr.error( response.data.message, "Ningun Registro Encontrado" );
              }
          }).catch(error => {
              toastr.error( error, expired );
          });

      }
  }


});
*/
