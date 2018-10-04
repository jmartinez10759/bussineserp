new Vue({
  el: "#vue-business",
  created: function () {
    this.consulta_general();
  },
  data: {
    datos: [],
    newKeep: {
      'id_empresa': ''
    },
    fillKeep: {
    },
    fields:{
      'id_empresa':''
    },
    sucursal: {}
  },
  mixins : [mixins],
  methods:{
    consulta_general: function(){
        var url = domain('empresas/listado');
        this.all_register(url,{},'datos');
    }
    ,bussiness_sucursales( id_empresa ){
          var url = domain('list/sucursales');
          var fields = {'id_empresa': id_empresa};
          axios.post(url, fields, csrf_token ).then(response => {
              if (response.data.success == true) {
                  this.sucursal = response.data.result.sucursales;
                  console.log(this.sucursal);
                  $.fancybox.open({
                      src  : '#content_sucusales',
                      type : 'inline'
                    });

              }else{
                  toastr.error( response.data.message, title_error );
              }
          }).catch(error => {
              toastr.error( error,expired );
          });
          //const list = new Bussiness;
          //list.list_sucursales( url, id_empresa );


    }
    ,portal( id_sucursal ){
      var url = domain('portal');
      var fields = { id_sucursal:id_sucursal };
      axios.get( url, { params: fields }, csrf_token ).then( response => {
          if (response.data.success == true) {
              console.log(response.data.result.ruta);
              redirect( domain( response.data.result.ruta ) );
          }
      }).catch(error => {
          toastr.error( error, expired );
      });


    }


  }

});
