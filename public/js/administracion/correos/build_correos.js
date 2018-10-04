new Vue({
  el: "#vue-redactar",
  created: function () {
    this.consulta_general();
  },
  data: {
    datos: [],
    newKeep: {
      'emisor': ""
      ,'asunto': ""
      ,'archivo': ""
    },
    fillKeep: {
      'emisor': ""
      ,'asunto': ""
      ,'archivo': ""
    },

  },
  mixins : [mixins],
  methods:{
    consulta_general: function(){}
    ,send_correo: function(){

        if( this.newKeep.emisor == "" || this.newKeep.asunto == ""){
          toastr.error( 'Favor de verificar los campos de color rojo!' , "Campos Vacios" );
          if( this.newKeep.emisor == ""){
            jQuery('#emisor').parent().addClass('has-error');
          }else{
            jQuery('#asunto').parent().addClass('has-error');
          }
          return;
        }
        if( !emailValidate( this.newKeep.emisor.toLowerCase().trim() ) ){
            toastr.error( 'Favor de verificar los campos de color rojo!' , "Correo Incorrecto" );
            jQuery('#emisor').parent().addClass('has-error');
            return;
        }
        this.newKeep.descripcion = jQuery('#compose-textarea').val();
        var url = domain('correos/send');
        var refresh = "";
        this.insert_general(url,refresh,function(response){
            //jQuery('#modal_add_correo').modal('hide');
            redirect( domain('correos/recibidos') );
        },function(){});
    }
  }


});

new Vue({
  el: "#vue-recibidos",
  created: function () {
    //this.consulta_general();
  },
  data: {
    datos: [],
    newKeep: {
      'categoria':""
      ,'descripcion':""
       ,'emisor': ""
       ,'id_estate' : ""
       ,'attachment' : ""
    },
    fillKeep: {
      'categoria':""
      ,'descripcion':""
    },

  },
  mixins : [mixins],
  methods:{
    consulta_general: function(){
      var url = domain('correos/show');
      var fields = {};
      axios.get( url, { params: fields }, csrf_token ).then(response => {
          console.log( response.data.result );
          if( response.data.success == true ){
            this.datos = response.data.result;
          }else{
            toastr.error( response.data.message, "¡Bandeja de entrada Vacia !" );
          }
      }).catch(error => {
          toastr.error( error, expired );
      });

    }
    ,estatus_papelera: function( id_correo ){
        //necesito barrer todos los checkebox si estan checked
        var matrix_check = [];
        var i = 0;
        if( id_correo == undefined ){
          jQuery('.mailbox-messages input[type="checkbox"]').each(function(){
            if(jQuery(this).is(':checked') == true){
              var id_correo = jQuery(this).attr('id');
              matrix_check[i] = `${id_correo}|${jQuery(this).is(':checked')}`;
              i++;
            }

          });

        }else{
          matrix_check = [`${id_correo}|true`];
        }
        console.log(matrix_check);
        var url = domain('correos/papelera');
        var fields = { 'matrix' : matrix_check };
        axios.post( url, fields , csrf_token ).then(response => {
            console.log( response.data.result );
            if( response.data.success == true ){
                //redirect( domain('correos/recibidos') );
                location.reload();
            }else{
              toastr.error( response.data.message, "¡Oops !" );
            }
        }).catch(error => {
            toastr.error( error, expired );
        });

    }
    ,insert_categorias: function(){

      var url = domain('categorias/insert');
      this.insert_general( url, '', function(){
          //redirect(domain(''));
          location.reload();
      }, function(){} );

    }
    ,redactar(request){
        //jQuery('#modal_add_correo').modal('show');
        this.datos = request;
        for (var i in this.newKeep) {this.newKeep[i] = ""; }
        this.newKeep.emisor = this.datos.correo;
        jQuery('#modal_add_detalles').modal('show');
        jQuery('.mensaje').show('slow');
        jQuery('.recibidos').hide('slow');
       //jQuery('#modal_add_detalles').hide();
       //this.redactar(this.datos.correo);
    }
    ,modal_show( id_correo, identificador ){
        jQuery(`#${identificador}`).modal('show');
        switch(identificador) {
          case "modal_add_notas":
                console.log(identificador);
              break;
          case "modal_add_citas":
                console.log(identificador);
              break;
          }


    }
    ,send_correo: function(){
        if( this.newKeep.asunto == "" || this.newKeep.emisor == ""){
          toastr.error( 'Favor de verificar los campos de color rojo!' , "Campos Vacios" );
          if(this.newKeep.emisor == ""){
            jQuery('#emisor').parent().addClass('has-error');
          }else{
            jQuery('#asunto').parent().addClass('has-error');
          }
          return;
        }
        if( !emailValidate( this.newKeep.emisor.toLowerCase().trim() ) ){
            toastr.error( 'Favor de verificar los campos de color rojo!' , "Correo Incorrecto" );
            jQuery('#emisor').parent().addClass('has-error');
            return;
        }
        this.newKeep.descripcion = jQuery('.compose-textarea').val();
        var url = domain('correos/send');
        var refresh = "";
        this.insert_general(url,refresh,function(response){
            //jQuery('#modal_add_correo').modal('hide');
            redirect( domain('correos/recibidos') );
        },function(){});
    }
    ,details_mails: function( id_correo, object ){

        var correos = [];
        var atributo = "";
        var j = 0;
        for(var i=0; i < jQuery('#bandeja_correos').children('tbody').children('tr').length; i++){
            correos[j] = jQuery('#bandeja_correos').children('tbody').children('tr')[i];
            j++;
        }
        for(var i=0; i < correos.length; i++){
            if(jQuery(correos[i]).attr('id_email') == id_correo ){
                jQuery(correos[i]).removeClass('info');
                jQuery(correos[i]).attr('style','cursor: pointer; font-weight: none;');
            }
        }
        var url = domain('correos/detalles');
        var refresh = location.href;
        var fields = { 'id': id_correo }
        axios.get( url, { params: fields }, csrf_token ).then(response => {
            console.log( response.data.result );
            if( response.data.success == true ){
                this.datos = response.data.result;
                 jQuery('#modal_add_detalles').modal('show');
                 jQuery('.mensaje').hide('slow');
                 jQuery('.recibidos').show('slow');
            }else{
              toastr.error( response.data.message, "¡No se mostro detalles del Correo.!" );
            }
        }).catch(error => {
            toastr.error( error, expired );
        });

    }
    ,mostrar: function (){
         jQuery('.mensaje').show('slow');
         jQuery('.recibidos').hide('slow');
        //jQuery('#modal_add_detalles').hide();
        for (var i in this.newKeep) {this.newKeep[i] = ""; }
        this.newKeep.asunto = this.datos.asunto;
        this.newKeep.emisor = this.datos.correo;
    }

  }

});
