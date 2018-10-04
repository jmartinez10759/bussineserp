var url_insert  = "actions/register";
var url_update  = 'actions/update';
var url_edit    = 'actions/edit';
var url_destroy = "actions/destroy/";
var redireccion = "actions";

new Vue({
  el: "#vue_actions",
  created: function () {
    this.consulta_general();
  },
  data: {
    datos: [],
    newKeep: {
      'clave_corta':""
      ,'descripcion':""
      ,'estatus':""
    },
    fillKeep: {
      'clave_corta':""
      ,'descripcion':""
      ,'estatus':""
    },

  },
  mixins : [mixins],
  methods:{
    consulta_general: function(){}
    ,insert: function(){
        var url     = domain(url_insert);
        var refresh = domain('');
        this.insert_general(url,refresh,function(response){
            jQuery('#modal_add_register').modal('hide');
            redirect(redireccion);
        },function(){});
    }
    ,destroy: function( id ){
        var url = domain(`${url_destroy}${id}`);
        axios.get( url, csrf_token ).then(response => {
          if (response.data.success == true) {
            redirect(redireccion);
          }else{
             toastr.error('¡No se elimino correctamente el registro!','¡Ocurrio un error.!'); //mensaje
          }
        }).catch(error => {
            toastr.error( error, expired );
        });
    }
    ,update: function(){
        var url     = domain( url_update );
        //var refresh = domain('configuracion/menus');
        axios.post( url,this.fillKeep, csrf_token ).then(response => {
          if (response.data.success == true) {
            redirect( redireccion );
          }else{
             toastr.error('¡No se Actualizo correctamente el registro!','¡Ocurrio un error.!'); //mensaje
          }
        }).catch(error => {
            toastr.error( error, expired );
        });
    }
    ,editar: function( keep ){
        var url = domain( url_edit );
        var fields = {'id' : keep};
        axios.get( url, { params: fields }, csrf_token ).then(response => {
            if( response.data.success == true ){
              this.fillKeep = response.data.result;
              jQuery('#modal_edit_register').modal('show');
            }else{
                toastr.error( response.data.message, "¡Ningun Registro Encontrado!" );
            }
        }).catch(error => {
            toastr.error( error, expired );
        });

    }
  }


});
