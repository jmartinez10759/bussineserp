new Vue({
  el: "#vue_permisos",
  created: function () {
    this.consulta_general();
  },
  data: {
    datos: [],
    newKeep: {
      'id_users' : ""
      ,'id_menu' : ""
    },
    fillKeep: {
      'id_menu': ''
      ,'id_rol': ''
    },

  },
  mixins : [mixins],
  methods:{
    consulta_general: function(){

    }
    ,change_roless:function(){

        var url   = domain("permisos");
        var roles = this.fillKeep.id_rol;
        var fields = {
          'id_rol'    : roles
          ,'id_users' : this.newKeep.id_users
        };
        jQuery('input[type="checkbox"]').prop('checked',false);
        if( roles == 0 || !this.newKeep.id_users ){
            toastr.error( "¡Favor de seleccionar una opcion!", "¡Campos Vacios.!" );
            jQuery('#cmb_users').parent().parent().addClass('has-error');
            jQuery('#cmb_users').val('');
            jQuery('#cmb_roles').val('');
            jQuery('input[type="checkbox"]').prop('checked',false);
            return;
        }

        this.show_general(url,fields,function( response ){
          for (var i = 0; i < response.length; i++) {
            if (response[i].estatus == 1) {
                jQuery(`#${response[i].id_menu}`).prop('checked',true);
            }else{
                jQuery(`#${response[i].id_menu}`).prop('checked',false);
            }
          };
        },function(){});

    }
    ,change_usuario: function(){

        var url = domain('permisos/roles');
        var fields = {'id': this.newKeep.id_users};
        jQuery('#cmb_users').parent().removeClass('has-error');
        jQuery('#cmb_roles').attr('disabled',true);
        jQuery('#cmb_empresas').attr('disabled',true);
        jQuery('#cmb_sucursales').attr('disabled',true);
        jQuery('#cmb_users').val('');
        jQuery('#cmb_roles').val('');
        jQuery('#cmb_empresas').val('');
        jQuery('#cmb_sucursales').val('');
        jQuery('input[type="checkbox"]').prop('checked',false);
        if(!this.newKeep.id_users){
          jQuery('#cmb_users').parent().addClass('has-error');
          toastr.error( "¡Favor de seleccionar una opcion!", "¡Campos Vacios.!" );
          return;
        }

        axios.get( url, { params: fields }, csrf_token ).then(response => {
            console.log( response.data.result );
            if( response.data.success == true ){
              jQuery('#roles').html('');
              jQuery('#roles').html(response.data.result);
            }

        }).catch(error => {
            toastr.error( error, expired );
        });

    }
    ,register_permisos: function(){
        //valores para validar la informacion de un input o select
     		let validacion = [ 'cmb_users','cmb_roles' ];
     		if(validacion_fields(validacion) == "error"){return;}

        let id_users      = this.newKeep.id_users;
        let id_rol        = jQuery('#cmb_roles').val();
        let id_empresa    = (jQuery('#cmb_empresas').val())?jQuery('#cmb_empresas').val():"0";
        let id_sucursal   = (jQuery('#cmb_sucursales').val())?jQuery('#cmb_sucursales').val():"0";
        let matrix = [];
     		let conteo = 0;

     		jQuery('input[type="checkbox"]').each(function(){
       			let id          = jQuery(this).attr('id_permisos');
       			let check       = jQuery(`#${id}`).is(':checked');
            if(id != undefined || id == ""){
              matrix[conteo] = `${id}|${check}`;
              conteo++;
            }

     		});
     			console.log(matrix);
     			//return;
    			let fields = {
            'id_users'	    : id_users
    				,'id_rol'		    : id_rol
    				,'id_empresa'		: id_empresa
    				,'id_sucursal'	: id_sucursal
    				,'matrix'		: matrix
            ,'_token'   : _token
     			}
     			let url = domain("permisos/register");
          send_post(fields,url,false,false);

    }
    ,register_acciones: function(){

        let id_users      = jQuery('#cmb_users_permisos').val();
        let id_rol        = jQuery('#cmb_roles_permisos').val();
        let id_empresa    = jQuery('#cmb_empresas_permisos').val();
        let id_sucursal   = jQuery('#cmb_sucursal_permisos').val();
        var matrix    = [];
        var matrix_true = [];
        var i         = 0;
        var j         = 0;
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
          'id_rol'		     : id_rol
          ,'id_users'	     : id_users
          ,'id_menu'	     : id_menu
          ,'id_empresa'	   : id_empresa
          ,'id_sucursal'	 : id_sucursal
          ,'matrix'		     : matrix
          ,'conteo'        : matrix_true.length
          //,'_token'   : _token
        }
        //for (var i in fields) { this.newKeep[i] = fields[i]; };
        let url = domain("permisos/actions");
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
        
        //send_post(fields,url,false,false);

    }
    ,editar: function( keep ){

        this.fillKeep.id_menu = keep;
        var id_menu       = this.fillKeep.id_menu;
        var id_users      = this.newKeep.id_users;
        var id_rol        = jQuery('#cmb_roles').val();
        var id_empresa    = (jQuery('#cmb_empresas').val())?jQuery('#cmb_empresas').val():"0";
        var id_sucursal   = (jQuery('#cmb_sucursales').val())?jQuery('#cmb_sucursales').val():"0";
        var validacion = ['cmb_roles','cmb_users'];
        if(validacion_fields(validacion) == "error"){return;}
        jQuery('input[type="checkbox"]').each(function(){
            var id_actions          = jQuery(this).attr('id_actions');
            if(id_actions != undefined || id_actions == ""){
                jQuery(`#actions_${id_actions}`).prop('checked',false);
            }
        });
        var url       = domain('actions');
        var fields = {
          'id_menu'     : id_menu
          ,'id_users'   : id_users
          ,'id_rol'     : id_rol
          ,'id_empresa'    : id_empresa
          ,'id_sucursal'   : id_sucursal
        }
        this.show_general(url,fields,function( response ){
          console.log(response);
          for (var i = 0; i < response.length; i++) {
            if (response[i].estatus == 1) {
                jQuery(`#actions_${response[i].id_accion}`).prop('checked',true);
            }else{
                jQuery(`#actions_${response[i].id_accion}`).prop('checked',false);
            }
          };
          jQuery('#modal_asignar_acciones').modal('show');
        },function(){});


    }

  }


});

/**
 *Funcion para obtener las empresas
 *{return} {void}
 */
change_roles = function(){

    var url = domain('permisos/empresas');
    var fields = {
      'id_users': jQuery('#cmb_users').val()
      ,'id_rol': jQuery('#cmb_roles').val()
    };
    jQuery('#cmb_roles').parent().removeClass('has-error');
    jQuery('#cmb_empresas').val('');
    jQuery('#cmb_sucursales').val('');
    jQuery('#cmb_empresas').attr('disabled',true);
    jQuery('#cmb_sucursales').attr('disabled',true);

    if( !fields.id_users || !fields.id_rol ){
      toastr.error( "¡Favor de seleccionar una opcion!", "¡Campos Vacios.!" );
      jQuery('#cmb_roles').parent().addClass('has-error');
      jQuery('input[type="checkbox"]').prop('checked',false);
      return;
    }

    axios.get( url, { params: fields }, csrf_token ).then(response => {
        console.log( response.data.result );
        jQuery('#cmb_sucursales').attr('disabled',false);
        jQuery('#cmb_empresas').attr('disabled',false);
        if( response.data.success == true ){
          jQuery('#empresas').html('');
          jQuery('#empresas').html(response.data.result);
        }else{
            //toastr.error( response.data.message, "Ningun Registro Encontrado" );
        }
    }).catch(error => {
        toastr.error( error, expired );
    });

}
/**
 *Funcion para obtener las empresas
 *{return} {void}
 */
change_empresas = function(){

    var url = domain('permisos/sucursales');
    var fields = {
      'id_users'    : jQuery('#cmb_users').val()
      ,'id_rol'     : jQuery('#cmb_roles').val()
      ,'id_empresa' : (jQuery('#cmb_empresas').val() != "" )? jQuery('#cmb_empresas').val(): "0"
    };
    jQuery('#cmb_roles').parent().removeClass('has-error');
    jQuery('input[type="checkbox"]').prop('checked',false);
    if( !fields.id_users || !fields.id_rol || !fields.id_empresa ){
      toastr.error( "¡Favor de seleccionar una opcion!", "¡Campos Vacios.!" );
      jQuery('#cmb_empresas').parent().addClass('has-error');
      jQuery('#cmb_sucursales').attr('disabled',true);
      jQuery('#cmb_sucursales').val('');
      return;
    }

    axios.get( url, { params: fields }, csrf_token ).then(response => {
        console.log( response.data.result );
        if( response.data.success == true ){
          jQuery('#sucursales').html('');
          jQuery('#sucursales').html(response.data.result);
          jQuery('#cmb_sucursales').attr('disabled',false);
        }else{
          //toastr.error( response.data.message, "Ningun Registro Encontrado" );
          //  change_sucursales();
        }
    }).catch(error => {
        toastr.error( error, expired );
    });

}
/**
 *Funcion para obtener las permisos de todos sus menus respectivos.
 *{return} {void}
 */
change_sucursales = function(){

    var url = domain("permisos");
    var fields = {
      'id_users'    : jQuery('#cmb_users').val()
      ,'id_rol'     : jQuery('#cmb_roles').val()
      ,'id_empresa' : (jQuery('#cmb_empresas').val() != "" )? jQuery('#cmb_empresas').val(): "0"
      ,'id_sucursal' : (jQuery('#cmb_sucursales').val() != "" )? jQuery('#cmb_sucursales').val(): "0"
    };
    jQuery('#cmb_sucursales').parent().removeClass('has-error');
    if( !fields.id_users || !fields.id_rol || !fields.id_empresa || !fields.id_sucursal ){
      toastr.error( "¡Favor de seleccionar una opcion!", "¡Campos Vacios.!" );
      jQuery('#cmb_sucursales').parent().addClass('has-error');
      jQuery('#cmb_sucursales').val('');
      jQuery('input[type="checkbox"]').prop('checked',false);
      return;
    }

    axios.get( url, { params: fields }, csrf_token ).then(response => {
        console.log( response.data.result );
        if( response.data.success == true ){

            for (var i = 0; i < response.data.result.length; i++) {
              if (response.data.result[i].estatus == 1) {
                  jQuery(`#${response.data.result[i].id_menu}`).prop('checked',true);
              }else{
                  jQuery(`#${response.data.result[i].id_menu}`).prop('checked',false);
              }
            };

        }else{
          //toastr.error( response.data.message, "Ningun Registro Encontrado" );
          //  change_sucursales();
        }
    }).catch(error => {
        toastr.error( error, expired );
    });

}
