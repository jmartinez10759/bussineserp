/**
 *Se crea una class para obtener los datos dentro de los metodos de vue.
 * @author Jorge Martinez Quezada.
 */
class ChangeSelect {
    /**
     *Se crea un constructor para inicializar el metodo
     * @access public
     * @return void
     */
     constructor(){
         this.fillKeep = {}; this.datos= {}; this.fields = {};
     }
     /**
      *Metodo para obtener los resultados de la consulta de los campos seleccionados.
      * @access public
      * @param $data [Description]
      * @return void
      */
     change_select( $data ) {
          for (var i in $data) {
              if( $data[i] == ""){
                 //return {'success': false,'result': i ,'messages': "Ocurrio un error, Favor de verificar"};
                 jQuery('input[type="checkbox"]').prop('checked',false);
                 toastr.error( "Favor de colocar el campo: "+i, "¡Ocurrio un error, Favor de verificar!" );
                 return;
              }
          }
          var url = domain('permisos');
          axios.get( url, { params: $data }, csrf_token ).then( response => {
              if( response.data.success == true ){
                for (var i = 0; i < response.data.result.length; i++) {
                  if (response.data.result[i].estatus == 1) {
                      jQuery(`#${response.data.result[i].id_menu}`).prop('checked',true);
                  }else{
                      jQuery(`#${response.data.result[i].id_menu}`).prop('checked',false);
                  }
                };
              }else{
                jQuery('input[type="checkbox"]').prop('checked',false);
                toastr.warning( response.data.message, "¡Ningun Registro Encontrado!" );
              }
          }).catch( error => {
             toastr.error( error, "¡Ocurrio un error, favor de verificar!" );
          });

     }
     /**
      *Metodo para obtener los resultados de la consulta de los campos seleccionados.
      * @access public
      * @param $data [Description]
      * @return void
      */
      permisos( url, fields ){

        var select_html = '<select class="form-control" disabled>';
            select_html += '<option value="">Seleccione Opcion </option>';
            select_html += '<option value="0">Todas las sucursales </option>';
            select_html += '</select>';

        axios.get( url, { params: fields }, csrf_token ).then(response => {
          jQuery('#content_sucursales_permisos').html( select_html );
            if( response.data.success == true ){
              //console.log(id_users); return;
              this.fillKeep.id      =  fields.id;
              this.fillKeep.name    = `${response.data.result.name} ${response.data.result.first_surname} ${response.data.result.second_surname}`;
              this.fillKeep.email   =  response.data.result.email;
              this.datos.id_empresa =   response.data.result.id_empresa;
              this.datos.id_rol      =  response.data.result.id_rol;
              this.datos.id_sucursal =  response.data.result.id_sucursal;
              this.fillKeep.estatus  = response.data.result.estatus;
                  //se crea un combo dinamico
                  var usuarios = {
                      'data'    : [{'id' : fields.id, 'name': this.fillKeep.name }]
                      ,'text'   : "name"
                      ,'value'  : "id"
                      ,'attr'   : "disabled"
                      ,'name'   : "cmb_users_permisos"
                      ,'class'  : 'form-control'
                      ,'leyenda': 'Seleccione Opcion'
                      ,'selected' : fields.id
                  };

                  if(this.datos.id_empresa.length > 0){
                      var empresa_length =  this.datos.id_empresa
                  }else{
                     var empresa_length = [{'id':0, 'nombre_comercial':"Todas Las Empresas" }];
                  }
                  var empresas = {
                      'data'    : empresa_length
                      ,'text'   : "nombre_comercial"
                      ,'value'  : "id"
                      ,'name'   : "cmb_empresas_permisos"
                      ,'class'  : 'form-control'
                      ,'leyenda': 'Seleccione Opcion'
                      ,'event'  : "change_empresas('cmb_sucursal_permisos','cmb_empresas_permisos','content_sucursales_permisos',[])"
                  };
                  var roles = {
                      'data'    : this.datos.id_rol
                      ,'text'   : "perfil"
                      ,'value'  : "id"
                      ,'name'   : "cmb_roles_permisos"
                      ,'class'  : 'form-control'
                      ,'leyenda': 'Seleccione Opcion'
                  };

                  jQuery('#content_users_permisos').html('');
                  jQuery('#content_users_permisos').html(select_general(usuarios));
                  jQuery('#cmb_users_permisos').selectpicker();

                  jQuery('#content_roles_permisos').html('');
                  jQuery('#content_roles_permisos').html(select_general(roles));
                  jQuery('#cmb_roles_permisos').selectpicker();

                  jQuery('#content_empresas_permisos').html('');
                  jQuery('#content_empresas_permisos').html(select_general(empresas));
                  jQuery('#cmb_empresas_permisos').selectpicker();

                  jQuery('#content_menus_permisos').html(response.data.result.menus_permisos);
                  jQuery('#content_acciones').html(response.data.result.permisos_acciones);

                  $.fancybox.open({
                      	 src  : '#modal_permisos',
                      	 type : 'inline',
                    });
                  //jQuery('#modal_permisos').modal('show');
            }else{
                toastr.error( response.data.message, "¡Ningun Registro Encontrado!" );
            }
        }).catch(error => {
            toastr.error( error, expired );
        });



      }
      /**
       *Metodo para obtener los resultados de la consulta de los campos seleccionados.
       * @access public
       * @param url [Description]
       * @param fields [Description]
       * @return void
       */
      show_acciones( url, fields ){

        var validacion = ['cmb_users_permisos','cmb_roles_permisos','cmb_empresas_permisos','cmb_sucursal_permisos'];
        if(validacion_fields(validacion) == "error"){return;}
        jQuery('input[type="checkbox"]').each(function(){
            var id_actions          = jQuery(this).attr('id_actions');
            if(id_actions != undefined || id_actions == ""){
                jQuery(`#actions_${id_actions}`).prop('checked',false);
            }
        });
        //this.setter('id_menu',fields.id_menu);
        axios.get( url, { params: fields }, csrf_token ).then(response => {
            if( response.data.success == true ){
              jQuery('#inp_menus_permisos').val(fields.id_menu);
              for (var i = 0; i < response.data.result.length; i++) {
                if (response.data.result[i].estatus == 1) {
                    jQuery(`#actions_${response.data.result[i].id_accion}`).prop('checked',true);
                }else{
                    jQuery(`#actions_${response.data.result[i].id_accion}`).prop('checked',false);
                }
              };
              $.fancybox.open({
                	src  : '#modal_asignar_acciones',
                	type : 'inline',
                });
            }else{
                toastr.error( response.data.message, "¡Ningun Registro Encontrado!" );
            }
        }).catch(error => {
            toastr.error( error, expired );
        });

      }
      /**
       *Metodo para insertar los registros de la clase
       * @access public
       * @param nombre [description]
       * @param propiedad [description]
       * @return void
       */
       register_acciones( url ){

         let id_users      = jQuery('#cmb_users_permisos').val();
         let id_rol        = jQuery('#cmb_roles_permisos').val();
         let id_empresa    = jQuery('#cmb_empresas_permisos').val();
         let id_sucursal   = jQuery('#cmb_sucursal_permisos').val();
         let id_menu       = jQuery('#inp_menus_permisos').val();

         var matrix        = [];
         var matrix_true   = [];
         var i             = 0;
         var j             = 0;
         let validacion = ['cmb_users_permisos','cmb_roles_permisos','cmb_empresas_permisos','cmb_sucursal_permisos'];
         if(validacion_fields(validacion) == "error"){return;}

         jQuery('input[type="checkbox"]').each(function(){
             var id_actions          = jQuery(this).attr('id_actions');
             var check_actions       = jQuery(`#actions_${id_actions}`).is(':checked');
             if(id_actions != undefined || id_actions == ""){
               matrix[i] = `${id_actions}|${check_actions}`;
               i++;
             }
             if( check_actions == true ){
                 matrix_true[j] = check_actions;
                 j++
             }

         });
         console.log(matrix);
         //return;
         let fields = {
           'id_rol'		       : id_rol
           ,'id_users'	     : id_users
           ,'id_menu'	       : id_menu
           ,'id_empresa'	   : id_empresa
           ,'id_sucursal'	   : id_sucursal
           ,'matrix'		     : matrix
           ,'conteo'         : matrix_true.length
           //,'_token'   : _token
         }
         //for (var i in fields) { this.newKeep[i] = fields[i]; };
         //let url = domain("permisos/actions");
         //se manda a llamar el methods de vue para insertar la informacion.
         axios.post(url, fields, csrf_token ).then(response => {
             if (response.data.success == true) {
                 //jQuery('#modal_asignar_acciones').modal('hide');
                 $.fancybox.close({
                     src  : '#modal_asignar_acciones',
                     type : 'inline',
                   });
                 jQuery(`.${id_menu}`).addClass(`btn btn-warning ${id_menu}`);
                 toastr.success( response.data.message , title );
             }else{
                 toastr.error( response.data.message,title_error );
             }
         }).catch(error => {
             toastr.error( error,expired );
         });

       }
       /**
        *Metodo para registro de permisos.
        * @access public
        * @param nombre [description]
        * @param propiedad [description]
        * @return void
        */
       register_permisos( url ){

         let id_users      = jQuery('#cmb_users_permisos').val();
         let id_rol        = jQuery('#cmb_roles_permisos').val();
         let id_empresa    = (jQuery('#cmb_empresas_permisos').val())?jQuery('#cmb_empresas_permisos').val():"0";
         let id_sucursal   = (jQuery('#cmb_sucursal_permisos').val())?jQuery('#cmb_sucursal_permisos').val():"0";
         let matrix = [];
         let conteo = 0;

         jQuery('#datatable_permisos input[type="checkbox"]').each(function(){
             let id          = jQuery(this).attr('id_permisos');
             let check       = jQuery(`#${id}`).is(':checked');
             matrix[conteo] = `${id}|${check}`;
             conteo++;
         });
           console.log(matrix);
           //return;
           let fields = {
             'id_users'	        : id_users
             ,'id_rol'		    : id_rol
             ,'id_empresa'		: id_empresa
             ,'id_sucursal'	    : id_sucursal
             ,'matrix'		    : matrix
             ,'_token'          : _token
           }
            var promise = MasterController.method_master(url,fields,"post");
              promise.then( response => {
                  $.fancybox.close({
                       src  : '#modal_permisos',
                       type : 'inline',
                     });
                  toastr.info( response.data.message , title );
              }).catch( error => {
                  if( isset(error.response) && error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                  }
                  console.log(error);
                    toastr.error( error.result , expired );  
              });
          /* axios.post( url, fields, csrf_token ).then(response => {
               if (response.data.success == true) {
                   $.fancybox.close({
                       src  : '#modal_permisos',
                       type : 'inline',
                     });
                   toastr.info( response.data.message , title );
               }else{
                   toastr.error( response.data.message,title_error );
               }
           }).catch(error => {
               toastr.error( error,expired );
           });*/


       }
      /**
       *Metodo para setter las propiedades de la clase
       * @access public
       * @param nombre [description]
       * @param propiedad [description]
       * @return void
       */
      setter( nombre, propiedad ){
          this.fields[nombre] = propiedad;
      }
      /**
       *Metodo para obtener las propiedades de la clase
       * @access public
       * @param nombre [description]
       * @param propiedad [description]
       * @return void
       */
      getter( nombre ){
          return this.fields[nombre];
      }

 }
