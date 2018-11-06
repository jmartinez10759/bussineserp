var url_insert  = "empresas/register";
var url_update  = 'empresas/update';
var url_edit    = 'empresas/edit';
var url_destroy = "empresas/destroy/";
var redireccion = "configuracion/empresas";
var url_relacion  = "empresas/insert_relacion";

new Vue ({
  el: "#vue_empresas",
  created: function () {
    this.consulta_general();
  },
  data: {
    datos: [],
    newKeep: {'estatus' : 1 },
    fillKeep: { 'estatus' : 1 },
    fields: {}
  },
  mixins : [mixins],
  methods:{
    consulta_general(){}
    ,insert(){ 
        var validacion = ['correo','razon_social','rfc_receptor','cmb_estados'];
        if(validacion_fields(validacion) == "error"){return;}
        if( !emailValidate(jQuery('#correo').val()) ){
            jQuery('#correo').parent().parent().addClass('has-error');
            toastr.error("Correo Incorrecto","Ocurrio un error, favior de verificar");
        }
        if( !valida_rfc(jQuery('#rfc_receptor').val()) ){
            jQuery('#rfc_receptor').parent().parent().addClass('has-error');
            toastr.error("RFC Incorrecto","Ocurrio un error, favior de verificar");
        }
        var url = domain( url_insert );
        this.newKeep.id_estado = jQuery('#cmb_estados').val();
        var fields = this.newKeep;
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
    ,destroy( id ){
        var url = domain( url_destroy );
        var fields = {id : id };
         buildSweetAlertOptions("¿Borrar Registro?","¿Realmente desea eliminar el registro?",function(){
          var promise = MasterController.method_master(url,fields,"delete");
          promise.then( response => {
              toastr.success( response.data.message , title );
              redirect( domain(redireccion) );
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
        this.fillKeep.id_estado = jQuery('#cmb_estados_edit').val();
        var fields = this.fillKeep;
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
              //redirect();
          });
          
    }
    ,editar( id ){
        var url = domain( url_edit );
        var fields = {id : id };
        var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
               this.fillKeep = response.data.result;
               this.fillKeep.id = response.data.result.id;
               if( response.data.result.contactos.length > 0 ){
                   this.fillKeep.contacto = response.data.result.contactos[0].nombre_completo;
                   this.fillKeep.departamento = response.data.result.contactos[0].departamento;
                   this.fillKeep.telefono = response.data.result.contactos[0].telefono;
                   this.fillKeep.correo = response.data.result.contactos[0].correo;
               }
               jQuery('#cmb_estados_edit').val(response.data.result.id_estado);
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
    ,sucursales( id_empresa ){
      var url = domain( url_edit );
      var fields = {'id' : id_empresa};
      axios.get( url, { params: fields }, csrf_token ).then(response => {
          if( response.data.success == true ){
              this.fields.id_empresa = id_empresa;
              if( response.data.result.sucursales.length > 0 ){

                    jQuery('input[type="checkbox"]').each(function(){
                      var id_sucursal = jQuery(this).attr('id_sucursal');
                      jQuery('#'+id_sucursal).prop('checked',false);
                    });
                    for (var i in response.data.result.sucursales ) {
                        jQuery('input[type="checkbox"]').each(function(){
                            jQuery('#'+response.data.result.sucursales[i].id).prop('checked',response.data.result.sucursales[i].estatus);
                        });
                    }
              }else{
                jQuery('input[type="checkbox"]').each(function(){
                    var id_sucursal = jQuery(this).attr('id_sucursal');
                    jQuery('#'+id_sucursal).prop('checked',false);
                });

              }

            jQuery('#modal_sucusales_register').modal('show');
          }else{
              toastr.error( response.data.message, "¡Ningun Registro Encontrado!" );
          }
      }).catch(error => {
          toastr.error( error, expired );
      });
    }
    ,insert_sucursales(){
        var id_empresa = this.fields.id_empresa;
        var matrix = [];
        var i = 0;
        jQuery('input[type="checkbox"]').each(function(){
            var id_sucursal = jQuery(this).attr('id_sucursal');
            if( isset(id_sucursal) === true){
              matrix[i] = id_sucursal+'|'+jQuery('#'+id_sucursal).is(':checked');
              i++;
            }

        });
        console.log(matrix);
        var fields = {
          'id_empresa' : id_empresa
          ,'matrix' : matrix
        }
        var url = domain( url_relacion );
        axios.post( url, fields , csrf_token ).then(response => {
            if( response.data.success == true ){
              toastr.info( response.data.message ,"¡Registros Correctos!");
              jQuery('#modal_sucusales_register').modal('hide');
            }else{
                toastr.error( response.data.message, "¡Ningun Registro Encontrado!" );
            }
        }).catch(error => {
            toastr.error( error, expired );
        });


    }
  }


});

jQuery('#cmb_servicio').selectpicker({width:'80%'});
jQuery('#cmb_servicio_edit').selectpicker({width:'80%'});
jQuery('#cmb_estados').selectpicker();
jQuery('#cmb_estados_edit').selectpicker();
