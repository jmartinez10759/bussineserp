var url_insert  = "proveedores/register";
var url_update   = "proveedores/update";
var url_edit     = "proveedores/edit";
var url_destroy  = "proveedores/destroy";
var url_all      = "proveedores/all";
var redireccion  = "configuracion/proveedores";

new Vue({
  el: "#vue-proveedores",
  created: function () {
    // this.consulta_general();
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
        this.edit.id_estado = jQuery('#cmb_estados_edit').val();
        this.edit.giro_comercial = jQuery('#cmb_servicio_edit').val();
        var fields = this.edit;
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
              // redirect();
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
               if( response.data.result.contactos.length > 0 ){
                   this.edit.contacto = response.data.result.contactos[0].nombre_completo;
                   this.edit.departamento = response.data.result.contactos[0].departamento;
                   this.edit.telefono = response.data.result.contactos[0].telefono;
                   this.edit.correo = response.data.result.contactos[0].correo;
               }

               
               jQuery('#cmb_estados_edit').selectpicker("val",[response.data.result.id_estado]);
               jQuery('#cmb_servicio_edit').selectpicker("val",[response.data.result.giro_comercial]);
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
