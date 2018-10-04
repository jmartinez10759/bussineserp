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
          console.log(this.newKeep);
          var url     = domain('menus/register');
          var refresh = domain('configuracion/menus');
          this.insert_general(url,refresh,function(response){
              jQuery('#modal_add_register').modal('hide');
              redirect('menus');
          },function(){});
      }
      ,destroy: function( id ){
          var url = domain(`menus/destroy/${id}`);
          //var refresh = domain('cv/show');
          axios.get( url, csrf_token ).then(response => {
            if (response.data.success == true) {
              redirect('menus');
            }else{
               toastr.error('¡No se elimino correctamente el registro!','¡Ocurrio un error.!'); //mensaje
            }
          }).catch(error => {
              toastr.error( error, expired );
          });
      }
      ,update: function(){
          var url     = domain('menus/update');
          //var refresh = domain('configuracion/menus');
          axios.post( url,this.fillKeep, csrf_token ).then(response => {
            if (response.data.success == true) {
              redirect('menus');
            }else{
               toastr.error('¡No se Actualizo correctamente el registro!','¡Ocurrio un error.!'); //mensaje
            }
          }).catch(error => {
              toastr.error( error, expired );
          });
      }
      ,editar: function( keep ){
          var url = domain('menus/edit');
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
