var url_insert  = "perfiles/register";
var url_update  = 'perfiles/update';
var url_edit    = 'perfiles/edit';
var url_destroy = "perfiles/destroy";
var redireccion = "configuracion/perfiles";

new Vue({
  el: ".vue-perfil",
  created: function () {
    this.consulta_general();
  },
  data: {
    datos: [],
    newKeep: {
      // 'nombre':''
      // ,'email' :''
      // ,'contraseña':''
      // ,'direccion':''
      // ,'telefono':''
      // ,'puesto':''
      // ,'genero':''
      // ,'estado_civil':''
      // ,'experiencia':''
      // ,'notas':''
      // ,'foto':''
    },
    fillKeep: {

    },

  },
  mixins : [mixins],
  methods:{
    consulta_general: function(){
        var url = domain(url_edit);
        var fields = {};
        axios.get( url, { params: fields }, csrf_token ).then(response => {
          loading(true);
            console.log( response.data.result );
            if( response.data.success == true ){
              this.datos = response.data.result;
            }else{
                toastr.error( response.data.message, "Ningun Registro Encontrado" );
            }
        }).catch(error => {
            toastr.error( error, expired );
        });

    }
    ,save_perfil: function(){
        for (var i in this.datos) { this.newKeep[i] = this.datos[i]; }
        var url = domain(url_insert);
        var refresh = domain(redireccion);
        this.insert_general(url,refresh,function( request ){
            //redirect(domain(redireccion));
        },function(){});

    }


  }


});
