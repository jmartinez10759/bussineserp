var url_insert  = "proveedores/register";
var url_update   = "proveedores/update";
var url_edit     = "proveedores/edit";
var url_destroy  = "proveedores/destroy";
var url_all      = "proveedores/all";
var redireccion  = "configuracion/proveedores";

new Vue({
  el: "#vue-proveedores",
  created: function () {
    //this.consulta_general();
  },
  data: {
    datos: [],
    insert: {'estatus':'1'},
    update: {'estatus':'1'},
    edit: {'estatus':'1'},
    fields: {},

  },
  mixins : [mixins],
  methods:{
    consulta_general(){
        var url = domain( url_all );
        var fields = {};
        var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
          
              
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
      var validacion = ['cmb_estados'];
      var url = domain( url_insert );
        this.insert.id_estado = jQuery('#cmb_estados').val();
        this.insert.giro_comercial = jQuery('#cmb_servicio').val();
        var fields = this.insert;
        var promise = MasterController.method_master(url,fields,"post");
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
              redirect();
          });
    }
    ,update_register(){
       var url = domain( url_update );
        this.update.id_estado = jQuery('#cmb_estados_edit').val();
        this.update.giro_comercial = jQuery('#cmb_servicio_edit').val();
        var fields = this.update;
        var promise = MasterController.method_master(url,fields,"put");
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
              redirect();
          });
    }
    ,edit_register( id ){
        var url = domain( url_edit );
        var fields = {id : id };
        var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
          
              // toastr.success( response.data.message , title );
               this.edit = response.data.result;
               // console.log(this.edit);
               // return;
               //this.edit.id = response.data.result.id;
               
                   // this.edit.contacto = response.data.result.contacto;
                   // this.edit.departamento = response.data.result.departamento;
                   // this.edit.telefono = response.data.result.telefono;
                   // this.edit.correo = response.data.result.correo;
                   // this.edit.nombre_comercial = response.data.result.nombre_comercial;
                   // this.edit.razon_social = response.data.razon_social;
                   // this.edit.rfc = response.data.result.rfc;
                   // this.edit.calle = response.data.result.calle;
                   // this.edit.municipio = response.data.result.municipio;
                   // this.edit.cp = response.data.result.cp;

               // console.log(response.data.result);
                  

               //jQuery('#contacto_edit').val(response.data.result.calle);
               // jQuery('#departamento_edit').val(response.data.result[0].departamento);
               // jQuery('#telefono_edit').val(response.data.result[0].telefono);
               // jQuery('#correo_edit').val(response.data.result[0].correo);
               // // jQuery('#nombre_comercial_edit').val(response.data.result[0].nombre_comercial);
               // jQuery('#razon_social_edit').val(response.data.result[0].razon_social);
               // jQuery('#rfc_edit').val(response.data.result[0].rfc);
               // jQuery('#calle_edit').val(response.data.result[0].calle);
               // jQuery('#municipio_edit').val(response.data.result[0].municipio);
               // jQuery('#cp_edit').val(response.data.result[0].cp);

               
               // jQuery('#cmb_estados_edit').selectpicker("val",[response.data.result.id_estado]);
               // jQuery('#cmb_servicio_edit').selectpicker("val",[response.data.result.giro_comercial]);
               jQuery('#modal_edit_register').modal('show');
               
              
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
               location.reload();
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
    
   
    
    
  }


});
jQuery('#cmb_servicio').selectpicker({width:'80%'});
jQuery('#cmb_servicio_edit').selectpicker({width:'80%'});
jQuery('#cmb_estados').selectpicker();
jQuery('#cmb_estados_edit').selectpicker();
