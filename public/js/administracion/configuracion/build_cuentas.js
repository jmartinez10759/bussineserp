var url_insert  = "cuentas/register";
var url_update   = "cuentas/update";
var url_edit     = "cuentas/edit";
var url_destroy  = "cuentas/destroy";
var url_all      = "cuentas/all";
var url_display_clientes  = "empresas/edit";
var url_display_contactos  = "clientes/edit";
var redireccion  = "configuracion/cuentas";

new Vue({
  el: "#vue-cuentas",
  created: function () {
    //this.consulta_general();
  },
  data: {
    datos: [],
    insert: {
        estatus: 1
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
              if( isset(error.response) && error.response.status == 419 ){
                toastr.error( session_expired ); 
                redirect(domain("/"));
                return;
              }
              toastr.error( error.result , expired );  
          });
    }
    ,insert_register(){
        var url = domain( url_insert );
        this.insert.empresa = jQuery('#cmb_empresas').val();
        this.insert.sucursal = jQuery('#cmb_sucursales').val();
        this.insert.clientes = jQuery('#cmb_clientes_asignados').val();
        this.insert.contacto = jQuery('#cmb_contactos').val();
        this.insert.id_cliente  = jQuery('#cmb_clientes').val();
        var fields = this.insert;
        var promise = MasterController.method_master(url,fields,"post");
          promise.then( response => {
              toastr.success( response.data.message , title );
              //redirect(domain(redireccion));
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
        this.update.id = this.edit.id;
        this.update.id_empresa  = jQuery('#cmb_empresas_edit').val();
        this.update.id_sucursal = jQuery('#cmb_sucursales_edit').val();
        this.update.clientes    = jQuery('#cmb_clientes_asignados_edit').val();
        this.update.id_contacto = jQuery('#cmb_contactos_edit').val();
        this.update.id_cliente  = jQuery('#cmb_clientes_edit').val();
        this.update.nombre_comercial    = this.edit.nombre_comercial
        this.update.giro_comercial      = this.edit.giro_comercial
        this.update.estatus             = this.edit.estatus
        
        var fields = this.update;
        var promise = MasterController.method_master(url,fields,"put");
          promise.then( response => {
              toastr.success( response.data.message , title );
              redirect(domain(redireccion));
          }).catch( error => {
              if( isset(error.response) && error.response.status == 419 ){
                toastr.error( session_expired ); 
                redirect(domain("/"));
                return;
             }
            toastr.error( error.result , expired );  
          });
    }
    ,edit_register( id ){
        var url = domain( url_edit );
        var fields = {id : id };
        var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
              this.edit = response.data.result;
              jQuery('#cmb_empresas_edit').selectpicker('val',[this.edit.empresas[0].id]);
              var clientes = [];
              var j = 0;
              if(this.edit.clientes.length > 0){
                 for (var i in this.edit.clientes) {
                    clientes[j] = this.edit.clientes[i].id;
                    j++;
                }
              }
              display_clientes_edit( this.edit.sucursales[0].id, clientes , this.edit.id_cliente, this.edit.contactos[0].id);
              jQuery.fancybox.open({
                  'type': 'inline'
                  ,'src': "#modal_edit_register"
                  ,'buttons' : ['share', 'close']
               });
          }).catch( error => {
              if( isset(error.response) && error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.result , expired );              
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
              if( isset(error.response) && error.response.status == 419 ){
                toastr.error( session_expired ); 
                redirect(domain("/"));
                return;
              }
                toastr.error( error.result , expired );  
          });
      },"warning",true,["SI","NO"]);   
    }
    
    
  }


});
jQuery('#cmb_empresas').selectpicker();
jQuery('#cmb_empresas_edit').selectpicker();

function display_clientes(){
    
    var id_empresa = jQuery('#cmb_empresas').val();
    var url = domain( url_display_clientes );
    var fields = {id : id_empresa };
    var promise = MasterController.method_master(url,fields,"get");
      promise.then( response => {
        console.log(response.data.result.clientes);
        var clientes = {
             'data'    : response.data.result.clientes
             ,'text'   : "nombre_comercial"
             ,'value'  : "id"
             ,'name'   : 'cmb_clientes'
             ,'class'  : 'form-control'
             ,'leyenda': 'Seleccione Opcion'
             ,'event'  : 'change_clientes()'
            ,'attr'    : 'data-live-search="true"'     
         };
          
         var clientes_asignados = {
             'data'    : response.data.result.clientes
             ,'text'   : "nombre_comercial"
             ,'value'  : "id"
             ,'name'   : 'cmb_clientes_asignados'
             ,'class'  : 'form-control'
             ,'leyenda': 'Seleccione Opcion'
             //,'event'  : 'change_clientes()'
            ,'attr'    : 'multiple data-live-search="true"'     
         };
          
       var sucursales = {
            'data'    : response.data.result.sucursales
            ,'text'   : "sucursal"
            ,'value'  : "id"
            ,'name'   : 'cmb_sucursales'
            ,'class'  : 'form-control'
            ,'leyenda': 'Seleccione Opcion'
            ,attr     : 'data-live-search="true"'
        };
          
         jQuery('#div_cmb_clientes').html('');
         jQuery('#div_cmb_clientes').html( select_general(clientes) );
          
         jQuery('#div_cmb_clientes_asignados').html('');
         jQuery('#div_cmb_clientes_asignados').html( select_general(clientes_asignados) );
          
         jQuery('#div_cmb_sucursales').html('');
         jQuery('#div_cmb_sucursales').html( select_general(sucursales) );
          
         jQuery('#cmb_clientes_asignados').selectpicker();
         jQuery('#cmb_clientes').selectpicker();
         jQuery('#cmb_sucursales').selectpicker();
        //toastr.success( response.data.message , title );

      }).catch( error => {
          if( isset(error.response) && error.response.status == 419 ){
                toastr.error( session_expired ); 
                redirect(domain("/"));
                return;
            }
          toastr.error( error.result , expired );              
      });
     
}

function change_clientes(){
    var id_cliente = jQuery('#cmb_clientes').val();
    var url = domain(url_display_contactos);
    var fields = { id_cliente: id_cliente };
    var promise = MasterController.method_master(url,fields,"get");
      promise.then( response => {
        console.log(response.data.result.contactos);
        var contactos = {
             'data'    : response.data.result.contactos
             ,'text'   : "nombre_completo"
             ,'value'  : "id"
             ,'name'   : 'cmb_contactos'
             ,'class'  : 'form-control'
             ,'leyenda': 'Seleccione Opcion'
             //,'event'  : 'change_clientes()'
            ,'attr'    : 'data-live-search="true"'     
         };
         jQuery('#div_cmb_contactos').html('');
         jQuery('#div_cmb_contactos').html( select_general(contactos) );
         jQuery('#cmb_contactos').selectpicker();
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

function display_clientes_edit( id_sucursal, id_clientes = {}, id_cliente, id_contacto ){
    
    var id_empresa = jQuery('#cmb_empresas_edit').val();
    var url = domain( url_display_clientes );
    var fields = {id : id_empresa };
    var promise = MasterController.method_master(url,fields,"get");
      promise.then( response => {
        console.log(response.data.result.clientes);
        var clientes = {
             'data'    : response.data.result.clientes
             ,'text'   : "nombre_comercial"
             ,'value'  : "id"
             ,'name'   : 'cmb_clientes_edit'
             ,'class'  : 'form-control'
             ,'leyenda': 'Seleccione Opcion'
             ,'event'  : 'change_clientes_edit()'
             ,'attr'   : 'data-live-search="true"' 
             ,selected : (id_cliente != "")?id_cliente: 0
         };
          
         var clientes_asignados = {
             'data'    : response.data.result.clientes
             ,'text'   : "nombre_comercial"
             ,'value'  : "id"
             ,'name'   : 'cmb_clientes_asignados_edit'
             ,'class'  : 'form-control'
             ,'leyenda': 'Seleccione Opcion'
             ,'attr'    : 'multiple data-live-search="true"'
         };
          
       var sucursales = {
            'data'    : response.data.result.sucursales
            ,'text'   : "sucursal"
            ,'value'  : "id"
            ,'name'   : 'cmb_sucursales_edit'
            ,'class'  : 'form-control'
            ,'leyenda': 'Seleccione Opcion'
            ,selected : ( id_sucursal != "" )? id_sucursal: 0
            ,attr     : 'data-live-search="true"'
        };
         
         jQuery('#div_cmb_clientes_edit').html('');
         jQuery('#div_cmb_clientes_edit').html( select_general(clientes) );
          
         jQuery('#div_cmb_clientes_asignados_edit').html('');
         jQuery('#div_cmb_clientes_asignados_edit').html( select_general(clientes_asignados) );
          
         jQuery('#div_cmb_sucursales_edit').html('');
         jQuery('#div_cmb_sucursales_edit').html( select_general(sucursales) );
         jQuery('#cmb_clientes_asignados_edit').selectpicker('val',id_clientes);
         jQuery('#cmb_clientes_edit').selectpicker();
         jQuery('#cmb_sucursales_edit').selectpicker();
         change_clientes_edit(id_contacto);
          //jQuery('#cmb_sucursales_edit').selectpicker('val',[1]);
        //toastr.success( response.data.message , title );

      }).catch( error => {
          
          if( isset(error.response) && error.response.status == 419 ){
                toastr.error( session_expired ); 
                redirect(domain("/"));
                return;
            }
          toastr.error( error.result , expired );              
      });
     
}

function change_clientes_edit( id_contacto ){
    var id_cliente = jQuery('#cmb_clientes_edit').val();
    var url = domain(url_display_contactos);
    var fields = { id_cliente: id_cliente };
    var promise = MasterController.method_master(url,fields,"get");
      promise.then( response => {
        console.log(response.data.result.contactos);
        var contactos = {
             'data'    : response.data.result.contactos
             ,'text'   : "nombre_completo"
             ,'value'  : "id"
             ,'name'   : 'cmb_contactos_edit'
             ,'class'  : 'form-control'
             ,'leyenda': 'Seleccione Opcion'
            ,'attr'    : 'data-live-search="true"'     
            ,selected  : (id_contacto != "")?id_contacto : 0   
         };
         jQuery('#div_cmb_contactos_edit').html('');
         jQuery('#div_cmb_contactos_edit').html( select_general(contactos) );
         jQuery('#cmb_contactos_edit').selectpicker();
         toastr.success( response.data.message , title );
      }).catch( error => {
          if( isset(error.response) && error.response.status == 419 ){
            toastr.error( session_expired ); 
            redirect(domain("/"));
            return;
         }
         toastr.error( error , expired );           
      });
    
}
