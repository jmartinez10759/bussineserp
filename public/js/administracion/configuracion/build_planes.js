var url_insert  = "planes/register";
var url_update   = "planes/update";
var url_edit     = "planes/edit";
var url_destroy  = "planes/destroy";
var url_all      = "planes/all";
var redireccion  = "configuracion/planes";
var url_productos  = "planes/asing_producto";
var url_asign_insert  = "planes/asing_insert";

new Vue({
  el: "#vue-planes",
  created: function () {
    this.consulta_general();
  },
  data: {
    datos: [],
    insert: {
        estatus: 1,
        total: 0,
        stock: 0
    },
    update: {},
    edit: {},
    fields: {},
    asignar: {},

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
        this.update.descripcion = jQuery('#descripcion_edit').val();
        this.update.id_unidadmedida  = jQuery('#cmb_unidades_edit').val();
        var fields = this.update;
        var promise = MasterController.method_master(url,fields,"put");
          promise.then( response => {
          
              $.fancybox.close({
                   'type': 'inline',
                   'src': "#modal_edit_register",
                   'buttons': ['share', 'close']
               });
              toastr.info( response.data.message , title );
              //redirect( domain( redireccion ));
              
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
              //toastr.success( response.data.message , title );
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
          });
      },"warning",true,["SI","NO"]);   
    }
    ,total_concepto() {
             var iva = (this.insert.iva) ? this.insert.iva : 0;
             var subtotal = (this.insert.subtotal) ? this.insert.subtotal : 0;
             var impuesto = parseFloat(subtotal * iva / 100);
             this.insert.total = parseFloat(parseFloat(subtotal) + parseFloat(impuesto)).toFixed(2);
             console.log(this.insert.total);
         }
    ,total_concepto_edit() {
        var iva = (this.update.iva) ? this.update.iva : 0;
        var subtotal = (this.update.subtotal) ? this.update.subtotal : 0;
        var impuesto = parseFloat(subtotal * iva / 100);
        this.update.total = parseFloat(parseFloat(subtotal) + parseFloat(impuesto)).toFixed(2);
        console.log(this.update.total);
    }
    ,save_asign_producto(){
        this.asignar.id_plan = jQuery('#id_plan').val();
        var matrix = [];
        var i = 0;
        jQuery('#datatable_productos input[type="checkbox"]').each(function () {
            if (jQuery(this).is(':checked') == true) {
                var id = jQuery(this).attr('id');
                matrix[i] = `${id}|${jQuery(this).is(':checked')}`;
                i++;
            }
        });
        this.asignar.matrix = matrix;
        var url = domain(url_asign_insert);
        var fields = this.asignar;
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
      
  }


});


function asignar_producto( id ){
    var url = domain( url_productos);
    var fields = {id : id };
    var promise = MasterController.method_master(url,fields,"get");
      promise.then( response => {
           jQuery('#id_plan').val(id);
          $.fancybox.open({
              'type': 'inline',
              'src': "#modal_asing_producto",
              'buttons': ['share', 'close']
          });
          if(response.data.result.productos.length > 0){
              for (var i = 0; i < response.data.result.productos.length; i++) {
                    console.log(response.data.result.productos[i].id);
                    jQuery('#'+response.data.result.productos[i].id).prop('checked', true);
              };
          }
            
          
      }).catch( error => {
          if( error.response.status == 419 ){
                toastr.error( session_expired ); 
                redirect(domain("/"));
                return;
            }
          toastr.error( error.response.data.message , expired );

      });

    
    

}