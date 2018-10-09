var url_insert  = "planes/register";
var url_update   = "planes/update";
var url_edit     = "planes/edit";
var url_destroy  = "planes/destroy";
var url_all      = "planes/all";
var redireccion  = "configuracion/planes";

new Vue({
  el: "#vue-planes",
  created: function () {
    this.consulta_general();
  },
  data: {
    datos: [],
    insert: {
        estatus: 1,
        clave_unidad: "E48",
        total: 0,
        stock: 0
    },
    update: {},
    edit: {},
    fields: {},

  },
  mixins : [mixins],
  methods:{
    consulta_general(){
        var url = domain( url_all );
        var fields = {};
        var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
             this.fields = response.data.result;
             console.log(this.fields);
          }).catch( error => {
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
          });
    }
    ,insert_register(){
        this.insert.id_unidadmedida = jQuery('#cmb_unidades').val();
        this.insert.descripcion = jQuery('#descripcion').val();
        var url = domain(url_insert);
        var fields = this.insert;
        var promise = MasterController.method_master(url,fields,"post");
          promise.then( response => {
          
              toastr.success( response.data.message , title );
              
          }).catch( error => {
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
              
          });
    }
    ,update_register(){
        var url = domain( url_update );
        var fields = {};
        var promise = MasterController.method_master(url,fields,"put");
          promise.then( response => {
          
              toastr.success( response.data.message , title );
              
          }).catch( error => {
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
              redirect();
          });
    }
    ,edit_register( id ){
        var url = domain( url_edit );
        var fields = {id : id };
        var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
          
              toastr.success( response.data.message , title );
              
          }).catch( error => {
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
              
          });
        
    }
    ,destroy_register( id ){
        var url = domain( url_destroy );
        var fields = {id : id };
         buildSweetAlertOptions("¿Borrar Registro?","¿Realmente desea eliminar el registro?",function(){
          var promise = MasterController.method_master(url,fields,"delete");
          promise.then( response => {
              toastr.success( response.data.message , title );
          }).catch( error => {
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
              redirect();
          });
      },"warning",true,["SI","NO"]);   
    }
     ,total_concepto() {
             var iva = (this.insert.iva) ? this.insert.iva : 0;
             var subtotal = (this.insert.subtotal) ? this.insert.subtotal : 0;
             var impuesto = parseFloat(subtotal * iva / 100);
             this.insert.total = parseFloat(parseFloat(subtotal) + parseFloat(impuesto)).toFixed(2);
             console.log(this.insert.total);
         },
    total_concepto_edit() {
        var iva = (this.update.iva) ? this.update.iva : 0;
        var subtotal = (this.update.subtotal) ? this.update.subtotal : 0;
        var impuesto = parseFloat(subtotal * iva / 100);
        this.update.total = parseFloat(parseFloat(subtotal) + parseFloat(impuesto)).toFixed(2);
        console.log(this.update.total);
    },
    
    
  }


});