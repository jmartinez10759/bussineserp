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
