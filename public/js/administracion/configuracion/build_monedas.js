var url_insert  = "monedas/register";
var url_update   = "monedas/update";
var url_edit     = "monedas/edit";
var url_destroy  = "monedas/destroy";
var url_all      = "monedas/all";
var redireccion  = "configuracion/monedas";

new Vue({
  el: "#vue-monedas",
  created: function () {
    //this.consulta_general();
  },
  data: {
    datos: [],
    insert: {estatus:1 },
    update: {},
    edit: {estatus:1},
    fields: {},
  },
  mixins : [mixins],
  methods:{
    consulta_general(){
        var url = domain( url_all );
        var fields = {};
        var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
              var table_data = [];
              this.datos = response.data.result;
              var j = 0;
              for(var i in this.datos){
                  table_data[j] = [
                      this.datos[i].nombre
                      ,this.datos[i].descripcion
                      ,this.datos[i].estatus
                      ,'<button type="button" v-on:click="edit_register('+this.datos[i].id+')">Editar</button>'
                      ,'<button type="button" v-on:click="destroy_register('+this.datos[i].id+')">Borrar</button>'
                  ]
                  j++;
              }
              
              var table = {
                'titulos'    : ['Monedas','Descripción','Estatus','','']
                ,'registros' : table_data
                ,'id'        : 'data_table'
              }              
              jQuery('#data_table').html(data_table(table));
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
        var url = domain( url_insert );
        var fields = {};
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
              redirect();
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
    
    
  }


});
