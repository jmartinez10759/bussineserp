var url_insert  = "usocfdi/register";
var url_update   = "usocfdi/update";
var url_edit     = "usocfdi/edit";
var url_destroy  = "usocfdi/destroy";
var url_all      = "usocfdi/all";
var redireccion  = "configuracion/usocfdi";

new Vue({
  el: "#vue-usocfdi",
  created: function () {
    this.consulta_general();
  },
  data: {
    datos: [],
    insert: {},
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
          this.datos = response.data.result;          
              
          }).catch( error => {
              if( isset(error.response) && error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
                console.error(error);
                toastr.error( error.result , expired );
          });
    }
    ,insert_register(){
        var url = domain( url_insert );
        var fields = this.insert;
        var promise = MasterController.method_master(url,fields,"post");
          promise.then( response => {
          
              toastr.success( response.data.message , title );
              this.consulta_general();
              jQuery.fancybox.close({
                'type'      : 'inline'
                ,'src'      : "#modal_add_register"
                ,'modal'    : true
                ,'width'    : 900
                ,'height'   : 400
                ,'autoSize' : false
            }); 
              
          }).catch( error => {
                if( isset(error.response) && error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
                console.error(error);
                toastr.error( error.result  , expired );
          });
    }
    ,update_register(){
        var url = domain( url_update );
        var fields = this.edit;
        var promise = MasterController.method_master(url,fields,"put");
          promise.then( response => {
          
              jQuery.fancybox.close({
                  'type'      : 'inline'
                  ,'src'      : "#modal_edit_register"
                  ,'modal': true
              });   
              toastr.success( response.data.message , title );
              this.consulta_general();
              
          }).catch( error => {
              if( isset(error.response) && error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
                console.error(error);
                toastr.error( error.result  , expired );
          });
    }
    ,edit_register( id ){
        var url = domain( url_edit );
        var fields = {id : id };
        var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
          
              // toastr.success( response.data.message , title );
              this.edit = response.data.result;              
              jQuery.fancybox.open({
                  'type'      : 'inline'
                  ,'src'      : "#modal_edit_register"
                  ,'modal': true
              });
              
          }).catch( error => {
              if( isset(error.response) && error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
                console.error(error);
                toastr.error( error.result  , expired );           
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
                console.error(error);
                toastr.error( error.result  , expired );
          });
      },"warning",true,["SI","NO"]);   
    }
    
    
  }


});