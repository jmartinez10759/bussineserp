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
    ,estatus_papelera: function(){
        //necesito barrer todos los checkebox si estan checked
        var matrix_check = [];
        var i = 0;
        jQuery('.mailbox-messages input[type="checkbox"]').each(function(){
             if(jQuery(this).is(':checked') == true){
               var id_correo = jQuery(this).attr('id');
               matrix_check[i] = `${id_correo}|${jQuery(this).is(':checked')}`;
               i++;
             }

        });
        console.log(matrix_check);
        var url = domain('correos/papelera');
        var fields = { 'matrix' : matrix_check };
        axios.post( url, fields , csrf_token ).then(response => {
            console.log( response.data.result );
            if( response.data.success == true ){
                redirect( domain('correos/recibidos') );
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
          redirect(domain('correos/recibidos'));
      }, function(){} );

    }

  }


});
