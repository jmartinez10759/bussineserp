var url_insert  = "usuarios/register";
var url_update  = 'usuarios/update';
var url_edit    = 'usuarios/edit';
var url_destroy = "usuarios/destroy";
var redireccion = "configuracion/usuarios";

new Vue({
  el: ".vue_usuarios",
  created: function () {
    this.consulta_general();
  },
  data: {
    datos: [],
    newKeep: {
      'name':''
      ,'email':''
      ,'password':''
      ,'estatus': 1
    },
    fillKeep: {
      'name': ''
      ,'email': ''
      ,'password': ''
      ,'estatus': ''
    },
    fields: {}

  },
  mixins : [mixins],
  methods:{
    consulta_general(){}
    ,insert_register(){
        var url = domain(url_insert);
        this.newKeep.id_rol =  jQuery('#cmb_roles').val();
        this.newKeep.id_sucursal = jQuery('#cmb_sucursales').val();
        var fields = this.newKeep;
        if( !emailValidate(this.newKeep.email) ){
            toastr.error( "Correo electronico incorrecto", "Ocurrio un error, favor de verificar" ); 
            return;
        }
        var promise = MasterController.method_master(url,fields,'post');
        promise.then( response => {
          toastr.info( response.data.message, "¡Registro generado correctamente!" );
          jQuery('#modal_add_register').modal('hide');
          redirect(domain(redireccion));
        }).catch( error => {
            if( isset(error.response) && error.response.status == 419 ){
                toastr.error( session_expired ); 
                redirect(domain("/"));
                return;
              }
              console.log(error);
              toastr.error( error.result , expired );  
        });
    }
    ,destroy_register( id ){
        var url = domain( url_destroy );
        var fields = {'id' : id };
         buildSweetAlertOptions("¿Borrar Registro?","¿Realmente desea eliminar el registro?",function(){
          var promise = MasterController.method_master(url,fields,'delete');
          promise.then( response => {
              console.log(response);
              toastr.success( response.data.message , title );
              redirect();
          }).catch( error => {
              if( isset(error.response) && error.response.status == 419 ){
                toastr.error( session_expired ); 
                redirect(domain("/"));
                return;
              }
              console.log(error);
              toastr.error( error.result , expired );  
          });
      },'warning',true,["SI","NO"]);        
        
    }
    ,update_register(){
        var url     = domain( url_update );
        this.fillKeep.id_rol =  jQuery('#cmb_roles_edit').val();
        this.fillKeep.id_sucursal = jQuery('#cmb_sucursal_edit').val();
        this.fillKeep.id_empresa  = jQuery('#cmb_empresas_edit').val();

        var fields = this.fillKeep;
        var promise = MasterController.method_master(url,fields,'put');
        promise.then( response => {
            toastr.info('¡Se actualizo correctamente el registro!','¡Registro Actualizado!'); //mensaje
            redirect(domain(redireccion));
        }).catch( error => {
            if( isset(error.response) && error.response.status == 419 ){
                toastr.error( session_expired ); 
                redirect(domain("/"));
                return;
              }
              console.log(error);
              toastr.error( error.result , expired );  
        });
    }
    ,editar_register( id_usuario ){
        var url = domain( url_edit );
        var fields = {'id' : id_usuario };
        var promise = MasterController.method_master(url,fields,'get');
        promise.then( response => {
            
              this.fillKeep.id      =  id_usuario;
              this.fillKeep.name    = `${response.data.result.name} ${response.data.result.first_surname} ${response.data.result.second_surname}`;
              this.fillKeep.email   =  response.data.result.email;
              this.datos.id_empresa =   response.data.result.id_empresa;
              this.datos.id_rol      =  response.data.result.id_rol;
              this.datos.id_sucursal =  response.data.result.id_sucursal;
              this.fillKeep.estatus  = response.data.result.estatus;
              var id_empresa  = [];
              var id_rol = [];
              var id_sucursal = [];
              var j = 0;
              for (var i in this.datos.id_empresa) {
                id_empresa[j] = this.datos.id_empresa[i].id;
                j++;
              }
              //recorro los inputs de los select
              if( this.datos.id_sucursal.length > 0 ){
                for (var i in this.datos.id_sucursal) {
                    id_sucursal[j] = this.datos.id_sucursal[i].id;
                    j++;
                }
              }
              for (var i in this.datos.id_rol) {
                  id_rol[j] = this.datos.id_rol[i].id;
                  j++;
              }
              if( id_empresa.length > 0){
                jQuery('#cmb_empresas_edit').selectpicker('val', id_empresa );
              }else{
                jQuery('#cmb_empresas_edit').selectpicker('val', [0] );
              }
              jQuery('#cmb_roles_edit').selectpicker('val', id_rol );
              this.change_empresas('cmb_sucursal_edit','cmb_empresas_edit','div_edit_sucursales',id_sucursal);
              jQuery('#modal_edit_register').modal('show');
            
        }).catch( error => {
            if( error.response.status == 419 ){
                toastr.error( session_expired ); 
                redirect();
                return;
            }
            toastr.error( response.data.message, "¡Ningun Registro Encontrado!" );
        });

    }
    ,change_empresas( cmb_sucursales, cmb_empresas, contenido, data={} ){

       var url = domain('empresas/show_sucursal');
       var fields = {'id_empresa': jQuery('#'+cmb_empresas).val() };
       axios.get( url, { params: fields }, csrf_token ).then(response => {
           if( response.data.success == true ){
              this.datos.empresas = response.data.result
              var select = '';
                  select += '<select class="form-control" id="'+cmb_sucursales+'" multiple>';
                    for (var i in this.datos.empresas) {
                      select +=  '<optgroup  label="'+this.datos.empresas[i].nombre_comercial+'">';
                      select +=  '<option value="0" class="options">Todas las Sucursales</option>';
                          for (var j in this.datos.empresas[i].sucursales) {
                            if( this.datos.empresas[i].sucursales[j].pivot.estatus == 1){
                              select +=  '<option value="'+this.datos.empresas[i].sucursales[j].id+'" >'+this.datos.empresas[i].sucursales[j].sucursal+'</option>';
                            }
                          }
                      select +=  '</optgroup>';
                    }
                  select +=  '</select>';
                  jQuery('#'+contenido).html('');
                  jQuery('#'+contenido).html(select);
                  if(data.length > 0){
                    jQuery('#'+cmb_sucursales).selectpicker('val',data);
                  }else{
                    jQuery('#'+cmb_sucursales).selectpicker('val',[0]);
                  }

           }else{
               toastr.error( response.data.message, "¡Ningun Registro Encontrado!" );
           }
       }).catch(error => {
           toastr.error( error, expired );
       });

    }
    ,permisos( id_users ){
        var url = domain( url_edit );
        var fields = {'id' : id_users};
        var permiso = new ChangeSelect;
        permiso.permisos( url, fields );

    }
    ,register_permisos(){
      //valores para validar la informacion de un input o select
      let validacion = [ 'cmb_roles_permisos','cmb_empresas_permisos','cmb_sucursal_permisos' ];
      if(validacion_fields(validacion) == "error"){return;}
      let url = domain("permisos/register");
      let register_permisos = new ChangeSelect;
      register_permisos.register_permisos( url );
        //send_post(fields,url,false,false);

    }
    ,register_acciones(){
          let url = domain("permisos/actions");
          const acciones = new ChangeSelect;
          acciones.register_acciones( url );
    }

  }

});
jQuery('#cmb_empresas').selectpicker();
jQuery('#cmb_roles').selectpicker();
change_empresas =  function( cmb_sucursales, cmb_empresas, contenido, data = {} ){
   var url = domain('empresas/edit');
   var fields = {'id': jQuery('#'+cmb_empresas).val() };
   var select_html = '<select class="form-control" onchange="change_sucursales()" id="cmb_sucursal_permisos">';
       select_html += '<option value="">Seleccione Opcion </option>';
       select_html += '<option value="0">Todas Las Sucursales </option>';
       select_html += '</select>';
   axios.get( url, { params: fields }, csrf_token ).then(response => {
       if( response.data.success == true ){
        //console.log(response.data.result.sucursales);
        var sucursales_length = (response.data.result.sucursales.length > 0 )? response.data.result.sucursales: [{'id':0, 'sucursal': 'Todas las Sucursales'}];
         var sucursales = {
             'data'    : sucursales_length
             ,'text'   : "sucursal"
             ,'value'  : "id"
             ,'name'   : cmb_sucursales
             ,'class'  : 'form-control'
             ,'leyenda': 'Seleccione Opcion'
             ,'event'  : 'change_sucursales()'
         };
         //console.log( select_general(sucursales) );
         jQuery('#'+contenido).html('');
         jQuery('#'+contenido).html( select_general(sucursales) );
         if(data.length > 0){
           jQuery('#'+cmb_sucursales).selectpicker('val',data);
         }else{
           jQuery('#'+cmb_sucursales).selectpicker('val',[]);
         }

       }else{
            jQuery('#content_sucursales_permisos').html( select_html );
            //toastr.error( response.data.message, "¡Ningun Registro Encontrado!" );
       }
   }).catch( error => {
       jQuery('#content_sucursales_permisos').html( select_html );
       toastr.error( error, expired );
   });

}

change_sucursales = function(){

    const fields = {
      'id_users'     : jQuery('#cmb_users_permisos').val()
      ,'id_rol'      : jQuery('#cmb_roles_permisos').val()
      ,'id_empresa'  : jQuery('#cmb_empresas_permisos').val()
      ,'id_sucursal' : jQuery('#cmb_sucursal_permisos').val()
    };
    //console.log(fields);return;
    const change =  new ChangeSelect;
    change.change_select( fields );
  }

 get_acciones =  function( id_menu ){

  var url       = domain('actions');
  const fields = {
    'id_users'     : jQuery('#cmb_users_permisos').val()
    ,'id_rol'      : jQuery('#cmb_roles_permisos').val()
    ,'id_empresa'  : jQuery('#cmb_empresas_permisos').val()
    ,'id_sucursal' : jQuery('#cmb_sucursal_permisos').val()
    ,'id_menu'     : id_menu
  };
  var acciones = new ChangeSelect;
  acciones.show_acciones( url,fields);
  
 }
