var url_insert  = "roles/register";
var url_update  = 'roles/update';
var url_edit    = 'roles/edit';
var url_destroy = "roles/destroy";
var redireccion = "configuracion/roles";

new Vue ({
  el: "#vue_roles",
  created: function () {
    this.consulta_general();
  },
  data: {
    datos: [],
    newKeep: {
      'perfil' : ""
      ,'clave_corta' : ""
      ,'estatus' : 1
    },
    fillKeep: {
      'perfil' : ""
      ,'clave_corta' : ""
      ,'estatus' : 1
    },

  },
  mixins : [mixins],
  methods:{
      consulta_general: function(){}
      ,insert: function(){
          var url     = domain('roles/register');
          var refresh = domain('');
          this.insert_general(url,refresh,function(response){
              jQuery('#modal_add_register').modal('hide');
              redirect('roles');
          },function(){});
      }
      ,destroy: function( id ){
          var url = domain( url_destroy );
          var fields = {id_rol: id};
          buildSweetAlertOptions("¿Borrar Registro?","¿Realmente desea eliminar el registro?",function(){
              var respuestas = MasterController.method_master(url,fields,'delete');
              respuestas.then( response => {
                  toastr.success( response.data.message , title );
                  redirect(domain(redireccion));
              }).catch(error => {
                  toastr.error( error , expired );
              });
          },'warning',true,["SI","NO"]);

      }
      ,update: function(){
          var url     = domain('roles/update');
          //var refresh = domain('configuracion/menus');
          axios.post( url,this.fillKeep, csrf_token ).then(response => {
            if (response.data.success == true) {
              redirect('roles');
            }else{
               toastr.error('¡No se Actualizo correctamente el registro!','¡Ocurrio un error.!'); //mensaje
            }
          }).catch(error => {
              toastr.error( error, expired );
          });
      }
      ,editar: function( keep ){
          var url = domain('roles/edit');
          var fields = {'id' : keep};
          axios.get( url, { params: fields }, csrf_token ).then(response => {
              if( response.data.success == true ){
                this.fillKeep = response.data.result;
                jQuery('#modal_edit_register').modal('show');
              }else{
                  toastr.error( response.data.message, "¡Ningun Registro Encontrado!" );
              }
          }).catch(error => {
              toastr.error( error, expired );
          });

      }
  }


});




//upload_files_general = function(){
//
//    var url = domain('upload/files_generales');
//    var fields = {};
//    var identificador = {
//       div_content  : 'div_dropzone_file'
//      ,div_dropzone : 'dropzone_xlsx_file'
//      ,file_name    : 'file'
//    };
//    upload_file(fields,url,null,identificador,".csv, .xlxs,.xls", function( request ){
//        console.log(request);
//    });
//
//}
