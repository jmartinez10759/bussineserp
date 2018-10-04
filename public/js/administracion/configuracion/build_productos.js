var url_insert  = "productos/register";
var url_update   = "productos/update";
var url_edit     = "productos/edit";
var url_destroy  = "productos/destroy";
var url_all      = "productos/all";
var redireccion  = "configuracion/productos";

new Vue({
  el: "#vue-productos",
  created: function () {
    this.consulta_general();
  },
  data: {
    datos: [],
    insert: {
        clave_unidad: "E48"
        ,subtotal: 0
        ,iva    : 0 
        ,total  : 0
        ,stock  : 0
        ,estatus  : 1
    },
    update: {
        estatus: 1
    },
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
        this.insert.id_categoria = jQuery('#cmb_categorias').val();
        this.insert.descripcion = jQuery('#descripcion').val();
        var url = domain( url_insert );
        var fields = this.insert;
        var promise = MasterController.method_master(url,fields,"post");
          promise.then( response => {
               $.fancybox.close({
                   'type': 'inline',
                   'src': "#modal_add_register",
                   'buttons': ['share', 'close']
               });
              toastr.success( response.data.message , title );
              redirect( domain( redireccion ));
          }).catch( error => {
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
              //redirect();
          });
    }
    ,update_register(){
        this.update.id_unidadmedida = jQuery('#cmb_unidades_edit').val();
        this.update.id_categoria = jQuery('#cmb_categorias_edit').val();
        this.update.descripcion = jQuery('#descripcion_edit').val();
        var url = domain( url_update );
        var fields = this.update;
        var promise = MasterController.method_master(url,fields,"put");
          promise.then( response => {
               $.fancybox.close({
                   'type': 'inline',
                   'src': "#modal_edit_register",
                   'buttons': ['share', 'close']
               });
              toastr.success( response.data.message , title );
              redirect( domain( redireccion ));
          }).catch( error => {
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
              //redirect();
          });
    }
    ,edit_register( id ){
        var url = domain( url_edit );
        var fields = {id : id };
        var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
              this.update = response.data.result;
              jQuery('#descripcion_edit').val(response.data.result.descripcion);
              jQuery('#cmb_unidades_edit').val(response.data.result.id_unidadmedida);
              jQuery('#cmb_categorias_edit').val(response.data.result.id_categoria);
              $.fancybox.open({
                  'type': 'inline',
                  'src': "#modal_edit_register",
                  'buttons': ['share', 'close']
              });
          }).catch( error => {
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
              //redirect();
          });
        
    }
    ,destroy_register( id ){
        var url = domain( url_destroy );
        var fields = {id : id };
         buildSweetAlertOptions("¿Borrar Registro?","¿Realmente desea eliminar el registro?",function(){
          var promise = MasterController.method_master(url,fields,"delete");
          promise.then( response => {
              toastr.success( response.data.message , title );
              redirect(domain(redireccion));
          }).catch( error => {
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
              //redirect();
          });
      },"warning",true,["SI","NO"]);   
    },
    total_concepto(){
        var iva = (this.insert.iva) ? this.insert.iva : 0;
        var subtotal = (this.insert.subtotal) ? this.insert.subtotal : 0;
        var impuesto = parseFloat( subtotal * iva / 100);
        this.insert.total = parseFloat(parseFloat( subtotal ) + parseFloat(impuesto)).toFixed(2);
        console.log(this.insert.total);
    },
    total_concepto_edit() {
        var iva = (this.update.iva) ? this.update.iva : 0;
        var subtotal = (this.update.subtotal) ? this.update.subtotal : 0;
        var impuesto = parseFloat(subtotal * iva / 100);
        this.update.total = parseFloat(parseFloat(subtotal) + parseFloat(impuesto)).toFixed(2);
        console.log(this.update.total);
    }
    
  }


});

// jQuery('#cmb_categorias').selectpicker();
// jQuery('#cmb_categorias_edit').selectpicker();
// jQuery('#cmb_unidades').selectpicker();
// jQuery('#cmb_unidades_edit').selectpicker();