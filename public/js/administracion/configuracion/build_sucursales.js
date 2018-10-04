var url_insert  = "sucursales/register";
var url_update  = 'sucursales/update';
var url_edit    = 'sucursales/edit';
var url_destroy = "sucursales/destroy/";
var redireccion = "configuracion/sucursales";

new Vue ({
  el: "#vue_sucursales",
  created: function () {
    this.consulta_general();
  },
  data: {
    datos: [],
    newKeep: { 'estatus' : 1 },
    fillKeep: { 'estatus' : 1},
  },
  mixins : [mixins],
  methods:{
    consulta_general(){}
    ,insert(){
        var url = domain( url_insert );
        var fields = this.newKeep;
        var promise = MasterController.method_master(url,fields,"post");
          promise.then( response => {
              toastr.success( response.data.message , title );
              jQuery('#modal_add_register').modal('hide');
              redirect();
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
    ,destroy( id ){
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
        
    }
    ,update(){
        var url = domain( url_update );
        var fields = this.fillKeep;
        var promise = MasterController.method_master(url,fields,"put");
          promise.then( response => {
              toastr.info( response.data.message , title );
              redirect();
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
    ,editar( id ){
        var url = domain( url_edit );
        var fields = {'id' : id};
        var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
               this.fillKeep    = response.data.result;
               this.fillKeep.id = response.data.result.id;
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
  }


});
