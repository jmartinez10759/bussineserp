var url_insert  = "clientes/register";
var url_update  = 'clientes/update';
var url_edit    = 'clientes/edit';
var url_destroy = "clientes/destroy";
var redireccion = "configuracion/clientes";
var url_display = "clientes/display_sucursales";
var url_insert_permisos = "clientes/register_permisos";

new Vue({
  el: "#vue-clientes",
  created: function () {
    this.consulta_general();
  },
  data: {
    datos: []
    ,register: {}
    ,update: {}
    ,edit: {}
  },
  mixins : [mixins],
  methods:{
    consulta_general(){}
    ,destroy( id_cliente ){
      var url = domain(url_destroy);
      var fields = {id_cliente: id_cliente};
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
    ,register_cliente(){
        var validacion = ['correo','razon_social','rfc_receptor'];
        if(validacion_fields(validacion) == "error"){return;}
        if( !emailValidate(jQuery('#correo').val()) ){
            jQuery('#correo').parent().parent().addClass('has-error');
            toastr.error("Correo Incorrecto","Ocurrio un error, favior de verificar");
            return;
        }
        if( !valida_rfc(jQuery('#rfc_receptor').val()) ){
            jQuery('#rfc_receptor').parent().addClass('has-error');
            toastr.error("RFC Incorrecto","Ocurrio un error, favior de verificar");
            return;
        }
        this.register.id_estado = jQuery('#cmb_estados').val();
        this.register.estatus = 0;
        var url = domain(url_insert);
        var fields = this.register;
        var response = MasterController.method_master(url,fields,'post');
          response.then( response => {
              toastr.success( response.data.message , title );
              redirect(domain(redireccion));
          }).catch(error => {
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
              //redirect();
          });
        
    }
    ,editar( id_cliente ){
          var url = domain(url_edit);
          var fields = {id_cliente: id_cliente};
          var respuestas = MasterController.method_master(url,fields,'get');
          respuestas.then( response => {
              this.edit = response.data.result;
              if(response.data.result.contactos.length > 0){
                  this.edit.contacto     = response.data.result.contactos[0].nombre_completo
                  this.edit.departamento = response.data.result.contactos[0].departamento
                  this.edit.telefono     = response.data.result.contactos[0].telefono
                  this.edit.correo       = response.data.result.contactos[0].correo
              }
              console.log(this.edit);
              jQuery('#cmb_estados_edit').selectpicker('val',[this.edit.id_estado]);
              jQuery('#cmb_estatus_edit').val(this.edit.estatus);
               jQuery.fancybox.open({
                   'type': 'inline'
                   ,'src': "#modal_edit_register"
                   ,'buttons' : ['share', 'close']
               });
              
          }).catch(error => {
              toastr.error( error , expired );
          });

    }
    ,update_cliente(){
        var validacion = ['correo_edit','razon_social_edit','rfc_receptor_edit'];
        if(validacion_fields(validacion) == "error"){return;}
        if( !emailValidate(jQuery('#correo_edit').val()) ){
            jQuery('#correo_edit').parent().parent().addClass('has-error');
            toastr.error("Correo Incorrecto","Ocurrio un error, favor de verificar");
            return;
        }
        if( !valida_rfc(jQuery('#rfc_receptor_edit').val()) ){
            jQuery('#rfc_receptor_edit').parent().parent().addClass('has-error');
            toastr.error("RFC Incorrecto","Ocurrio un error, favor de verificar");
            return;
        }
          var url = domain( url_update );
          this.edit.estatus = jQuery('#cmb_estatus_edit').val();
          this.edit.id_estado =jQuery('#cmb_estados_edit').val();
          
          var request = MasterController.method_master(url,this.edit,'put');
          request.then( response => {
              toastr.info( response.data.message , title );
                jQuery.fancybox.close({
                   'type': 'inline'
                   ,'src': "#modal_edit_register"
                   ,'buttons' : ['share', 'close']
               }); 
              //jQuery("#vue-clientes").load("#prospectos > *");
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
      }
    ,insert_permisos(){
        var matrix = [];
        var i = 0;
        jQuery('#sucursales input[type="checkbox"]').each(function () {
            if (jQuery(this).is(':checked') == true) {
                var id = jQuery(this).attr('id_sucursal');
                matrix[i] = `${id}|${jQuery(this).is(':checked')}`;
                i++;
            }
        });
        var url = domain(url_insert_permisos);
        var fields = {
            'matrix' : matrix
            , 'id_empresa': jQuery('#id_empresa').val()
            , 'id_cliente': jQuery('#id_cliente').val()
        }
        var promise = MasterController.method_master(url, fields, "post");
        promise.then(response => {
            this.sucursales = response.data.result;
            jQuery.fancybox.close({
                'type': 'inline',
                'src': "#permisos",
                'buttons': ['share', 'close']
            });
        }).catch(error => {
            if (error.response.status == 419) {
                toastr.error(session_expired);
                redirect(domain("/"));
                return;
            }
            toastr.error(error.response.data.message, expired);

        });

        

    }
  }


});


jQuery('#cmb_estados').selectpicker();
jQuery('#cmb_estados_edit').selectpicker();
jQuery('#clientes_tabs').click(function(){
   jQuery('#search_general').removeAttr('onkeyup');
   jQuery('#search_general').attr("onkeyup","buscador_general(this,'#datatable_clientes')");
   jQuery('#search_general').val("");
   jQuery('#search_general').keyup();
});
jQuery('#prospectos_tabs').click(function(){
   jQuery('#search_general').removeAttr('onkeyup');
   jQuery('#search_general').attr("onkeyup","buscador_general(this,'#datatable')");
   jQuery('#search_general').val("");
   jQuery('#search_general').keyup();
});


function display_sucursales(id) {
    
     var id_empresa = jQuery('#cmb_empresas_' + id).val();
     var url = domain(url_display);
     var fields = { 
         id_empresa : id_empresa
         ,id_cliente : id
     };
        jQuery('#id_cliente').val(id);
        jQuery('#id_empresa').val(id_empresa);
     var promise = MasterController.method_master(url, fields, "get");
     promise.then(response => {
         jQuery('#sucursal_empresa').html(response.data.result.tabla_sucursales);
         
         jQuery.fancybox.open({
             'type': 'inline',
             'src':  "#permisos",
             'buttons': ['share', 'close']
         });
         for (var i = 0; i < response.data.result.sucursales.length; i++) {
             console.log(response.data.result.sucursales[i].id_sucursal);
             jQuery(`#sucursal_${response.data.result.sucursales[i].id_sucursal}`).prop('checked', true);
         };
     }).catch(error => {
         if (error.response.status == 419) {
             toastr.error(session_expired);
             redirect(domain("/"));
             return;
         }
         toastr.error(error.response.data.message, expired);

     });

}

