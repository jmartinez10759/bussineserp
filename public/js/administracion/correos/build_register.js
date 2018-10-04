new Vue({
  el: "#vue-register",
  created: function () {
    this.consulta_general();
  },
  data: {
    datos: [],
    newKeep: {
      'emisor': ""
      ,'asunto' :""
      ,'descripcion' : ""
      //seccion de citas
      ,'nombre' : ""
      ,'correo' : ""
      ,'id_estate' : ""
      ,'fecha' : ""
      ,'horario' : ""
      ,'cita' : ""
      //seccion de notas
      ,'titulo' : ""
      ,'asunto' : ""
      ,'nota' : ""
    },
    fillKeep: {

    },

  },
  mixins : [mixins],
  methods:{
    consulta_general: function(){
        console.log("se cargo correctamente el vue");
    }
    ,correos: function(){
      // se realiza la carga de sus elementos
       jQuery('#modal_add_correo').modal('show');

    }
    ,send_correo: function(){

        if( !emailValidate( this.newKeep.emisor.toLowerCase().trim() ) ){
            toastr.error( 'Favor de verificar los campos de color rojo!' , "Correo Incorrecto" );
            jQuery('#emisor').parent().addClass('has-error');
            return;
        }
        if( this.newKeep.asunto.trim() == ""){
            toastr.error( 'Favor de verificar los campos de color rojo!' , "Campos Vacios" );
            jQuery('#asunto').parent().addClass('has-error');
            return;
        }
        this.newKeep.descripcion = jQuery('#compose-textarea').val();
        var url = domain('correos');
        var refresh = "";
        this.insert_general(url,refresh,function(response){
            jQuery('#modal_add_correo').modal('hide');
            redirect('registros');
        },function(){});
    }
    ,notas: function(){
      jQuery('#modal_add_notas').modal('show');
    }
    ,insert_notas: function(){

          console.log(this.newKeep);
          var url,refresh;
          url = domain('notas/insert');
          refresh = "";
          this.insert_general(url,refresh,function(response){
              jQuery('#modal_add_notas').modal('hide');
              //redirect('registros');
          },function(){});

    }
    ,citas: function(){
      jQuery('#modal_add_citas').modal('show');
    }
    ,insert_cita :function(){

      if( !emailValidate( this.newKeep.correo.trim().toLowerCase() ) ){
          toastr.error( 'Favor de verificar los campos de color rojo!' , "Correo Incorrecto" );
          jQuery('#correo').parent().addClass('has-error');
          return;
      }
      this.newKeep.nombre.toUpperCase().trim();
      this.newKeep.fecha = jQuery('#fecha').val();
      this.newKeep.horario = jQuery('#horario').val();
      console.log(this.newKeep);
      var url,refresh;
      url = domain('citas/insert');
      refresh = "";
      this.insert_general(url,refresh,function(response){
          jQuery('#modal_add_citas').modal('hide');
          jQuery('#fecha').val('');
          //redirect('registros');
      },function(){});

    }
    ,ordenes:function(){
      alert();
    }
  }


});
