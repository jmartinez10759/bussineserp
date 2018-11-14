var url_insert  = "productos/register";
var url_update   = "productos/update";
var url_edit     = "productos/edit";
var url_destroy  = "productos/destroy";
var url_all      = "productos/all";
var redireccion  = "configuracion/productos";
var url_display         = "productos/display_sucursales";
var url_insert_permisos = "productos/register_permisos";
var url_unidades        = 'unidadesmedidas/edit';

/*new Vue({
  el: "#vue-productos",
  created: function () {
    this.consulta_general();
  },
  data: {
    datos: [],
    insert: {
        clave_unidad: ""
        ,subtotal: 0
        ,iva    : 0 
        ,total  : 0
        ,stock  : 0
        ,estatus  : 1
    },
    update: {
        estatus: 1
    },
    edit: {},
    fields: {},
    permisos: {},
    sucursales: {},

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
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
          });
    }
    ,insert_register(){

        this.insert.id_unidadmedida = jQuery('#cmb_unidades').val();
        this.insert.id_categoria = jQuery('#cmb_categorias').val();
        this.insert.descripcion = jQuery('#descripcion').val();
        this.insert.clave_unidad  = jQuery('#clave').val();
        var url = domain( url_insert );
        var fields = this.insert;
        var promise = MasterController.method_master(url,fields,"post");
          promise.then( response => {
               $.fancybox.close({
                   'type': 'inline',
                   'src': "#modal_add_register",
                   'buttons': ['share', 'close']
               });
              toastr.success( response.data.message , title );
              redirect( domain( redireccion ));
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
    ,update_register(){
        this.update.id_unidadmedida = jQuery('#cmb_unidades_edit').val();
        this.update.id_categoria = jQuery('#cmb_categorias_edit').val();
        this.update.descripcion = jQuery('#descripcion_edit').val();
        this.update.clave_unidad  = jQuery('#clave_edit').val();
        var url = domain( url_update );
        var fields = this.update;
        var promise = MasterController.method_master(url,fields,"put");
          promise.then( response => {
               $.fancybox.close({
                   'type': 'inline',
                   'src': "#modal_edit_register",
                   'buttons': ['share', 'close']
               });
              toastr.success( response.data.message , title );
              redirect( domain( redireccion ));
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
    ,edit_register( id ){
        var url = domain( url_edit );
        var fields = {id : id };
        var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
              this.update = response.data.result;
              jQuery('#descripcion_edit').val(response.data.result.descripcion);
              jQuery('#cmb_unidades_edit').val(response.data.result.id_unidadmedida);
              jQuery('#cmb_categorias_edit').val(response.data.result.id_categoria);
              $.fancybox.open({
                  'type': 'inline',
                  'src': "#modal_edit_register",
                  'buttons': ['share', 'close']
              });
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
    ,destroy_register( id ){
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
    },
    total_concepto(){
        var iva = (this.insert.iva) ? this.insert.iva : 0;
        var subtotal = (this.insert.subtotal) ? this.insert.subtotal : 0;
        var impuesto = parseFloat( subtotal * iva / 100);
        this.insert.total = parseFloat(parseFloat( subtotal ) + parseFloat(impuesto)).toFixed(2);
        console.log(this.insert.total);
    },
    total_concepto_edit() {
        var iva = (this.update.iva) ? this.update.iva : 0;
        var subtotal = (this.update.subtotal) ? this.update.subtotal : 0;
        var impuesto = parseFloat(subtotal * iva / 100);
        this.update.total = parseFloat(parseFloat(subtotal) + parseFloat(impuesto)).toFixed(2);
        console.log(this.update.total);
    },
    display_sucursales(id) {
        this.permisos.id_producto = id;
        this.permisos.id_empresa = jQuery('#cmb_empresas_' + id).val();
        var url = domain( url_display );
        var fields = this.permisos;
        var promise = MasterController.method_master(url, fields, "get");
        promise.then(response => {
            this.sucursales = response.data.result;
            
            jQuery.fancybox.open({
                'type': 'inline',
                'src': "#permisos",
                'buttons': ['share', 'close']
            });
            for (var i = 0; i < this.sucursales.sucursales.length; i++) {
                console.log(this.sucursales.sucursales[i].id_sucursal);
                jQuery('#'+this.sucursales.sucursales[i].id_sucursal).prop('checked', true);
            };
        }).catch(error => {
            if (error.response.status == 419) {
                toastr.error(session_expired);
                redirect(domain("/"));
                return;
            }
            toastr.error(error.response.data.message, expired);
            
        }); 
    },
    insert_permisos(){
        var matrix = [];
        var i = 0;
        jQuery('#sucursal_empresa input[type="checkbox"]').each(function () {
            if (jQuery(this).is(':checked') == true) {
                var id = jQuery(this).attr('id');
                matrix[i] = `${id}|${jQuery(this).is(':checked')}`;
                i++;
            }
        });
        var url = domain(url_insert_permisos);
        var fields = {
            'matrix' : matrix
            , 'id_empresa': jQuery('#id_empresa').val()
            , 'id_producto': jQuery('#id_producto').val()
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
});*/

var app = angular.module('ng-productos', ["ngRoute"]);
app.config(function( $routeProvider, $locationProvider ) {
    $routeProvider
    .when("/register", {
        controller : "PruebasController",
        template : "<h1>Rayos esto necesita un template</h1>",
    })
    .when("/london", {
        template : "<h1> Bienvenidos 2</h1>",
        //controller : "londonCtrl"
    })
    .when("/paris", {
        templateUrl : "paris.htm",
        controller : "parisCtrl"
    });
    $locationProvider.html5Mode(true); //activamos el modo HTML5
});
app.controller('ProductosController', function( $scope, $http, $location ) {
    /*se declaran las propiedades dentro del controller*/
    $scope.constructor = function(){
        $scope.datos  = [];
        $scope.insert = { 
           estatus: "1"
          ,id_servicio_comercial: "0" 
        };
        $scope.update = {};
        $scope.edit   = {};
        $scope.fields = {};
        $scope.consulta_general();
    }

    $scope.consulta_general = function(){
        var url = domain( url_all );
        var fields = {};
        MasterController.request_http(url,fields,'get',$http, false )
        .then(function(response){
            $scope.datos = response.data.result;
        }).catch(function(error){
            if( isset(error.response) && error.response.status == 419 ){
                  toastr.error( session_expired ); 
                  redirect(domain("/"));
                  return;
              }
              console.error(error);
              toastr.error( error.message , expired );
        });
    }
    
    $scope.insert_register = function(){
        var validacion = ['cmb_empresas','cmb_sucursales'];
        if(validacion_fields(validacion) == "error"){return;}
        $scope.insert.empresa     = jQuery('#cmb_empresas').val();
        $scope.insert.sucursal    = jQuery('#cmb_sucursales').val();
        $scope.insert.clientes    = jQuery('#cmb_clientes_asignados').val();
        $scope.insert.contacto    = jQuery('#cmb_contactos').val();
        $scope.insert.id_cliente  = jQuery('#cmb_clientes').val();
        $scope.insert.id_servicio = jQuery('#cmb_servicios').val();
        var url = domain( url_insert );
        var fields = $scope.insert;
        MasterController.request_http(url,fields,'post',$http, false )
        .then(function( response ){
            toastr.success( response.data.message , title );
            $scope.insert = {};
            var values = ['cmb_empresas','cmb_sucursales','cmb_clientes_asignados','cmb_contactos','cmb_clientes','cmb_servicios'];
            $scope.constructor();
            clear_values_select(values);
            jQuery.fancybox.close({
                'type'      : 'inline'
                ,'src'      : "#modal_add_register"
                ,'modal'    : true
                ,'width'    : 900
                ,'height'   : 400
                ,'autoSize' : false
            });
        }).catch(function( error ){
            if( isset(error.response) && error.response.status == 419 ){
                  toastr.error( session_expired ); 
                  redirect(domain("/"));
                  return;
              }
              console.error( error );
              toastr.error( error.data.result , expired );
        });
    }

    $scope.update_register = function(){

      var validacion = ['cmb_empresas_edit','cmb_sucursales_edit'];
        if(validacion_fields(validacion) == "error"){return;}
        $scope.update             = $scope.edit;
        $scope.update.empresa     = jQuery('#cmb_empresas_edit').val();
        $scope.update.sucursal    = jQuery('#cmb_sucursales_edit').val();
        $scope.update.clientes    = jQuery('#cmb_clientes_asignados_edit').val();
        $scope.update.contacto    = jQuery('#cmb_contactos_edit').val();
        $scope.update.id_cliente  = jQuery('#cmb_clientes_edit').val();
        $scope.update.id_servicio = jQuery('#cmb_servicios_edit').val();
        $scope.update.estatus     = jQuery('#cmb_estatus_edit').val();
      var url = domain( url_update );
      var fields = $scope.update;
      MasterController.request_http(url,fields,'put',$http, false )
      .then(function( response ){
          toastr.info( response.data.message , title );
          jQuery.fancybox.close({
                'type'      : 'inline'
                ,'src'      : "#modal_edit_register"
                ,'modal'    : true
                ,'width'    : 900
                ,'height'   : 400
                ,'autoSize' : false
            });
          $scope.constructor();
      }).catch(function( error ){
          if( isset(error.response) && error.response.status == 419 ){
                toastr.error( session_expired ); 
                redirect(domain("/"));
                return;
            }
            console.error( error );
            toastr.error( error.result , expired );
      });
    }

    $scope.edit_register = function( id ){
      var url = domain( url_edit );
      var fields = {id : id };
      MasterController.request_http(url,fields,'get',$http, false )
        .then(function( response ){
          $scope.edit = response.data.result;           
          jQuery('#cmb_empresas_edit').selectpicker('val',[$scope.edit.empresas[0].id]);
          jQuery('#cmb_estatus_edit').val($scope.edit.estatus);
          jQuery('#cmb_servicios_edit').val($scope.edit.id_servicio);
          var clientes = [];
          var j = 0;
          if($scope.edit.clientes.length > 0){
            for (var i in $scope.edit.clientes) {
              clientes[j] = $scope.edit.clientes[i].id;
              j++;
            }
          }
          display_clientes_edit( $scope.edit.sucursales[0].id, clientes , $scope.edit.id_cliente, $scope.edit.contactos[0].id);
          jQuery.fancybox.open({
              'type'      : 'inline'
              ,'src'      : "#modal_edit_register"
              ,'modal'    : true
          });

        }).catch(function( error ){
            if( isset(error.response) && error.response.status == 419 ){
                  toastr.error( session_expired ); 
                  redirect(domain("/"));
                  return;
              }
              console.error( error );
              toastr.error( error , expired );
        });
    }

    $scope.destroy_register = function( id ){

      var url = domain( url_destroy );
      var fields = {id : id };
      buildSweetAlertOptions("¿Borrar Registro?","¿Realmente desea eliminar el registro?",function(){
        MasterController.request_http(url,fields,'delete',$http, false )
        .then(function( response ){
            toastr.success( response.data.message , title );
            $scope.constructor();
        }).catch(function( error ){
            if( isset(error.response) && error.response.status == 419 ){
                  toastr.error( session_expired ); 
                  redirect(domain("/"));
                  return;
              }
              console.error( error );
              toastr.error( error.data.result , expired );
        });
          
      },"warning",true,["SI","NO"]);  
    }
});

function display_sucursales(id) {
     var id_empresa = jQuery('#cmb_empresas_' + id).val();
     var id_producto = id;
     var url = domain(url_display);
     var fields = {
         id_empresa : id_empresa
         ,id_producto: id_producto
        };
        jQuery('#id_producto').val(id);
        jQuery('#id_empresa').val(id_empresa);
     var promise = MasterController.method_master(url, fields, "get");
     promise.then(response => {
            jQuery('#sucursal_empresa').html(response.data.result.tabla_sucursales);
         jQuery.fancybox.open({
             'type': 'inline',
             'src': "#permisos",
             'buttons': ['share', 'close']
         });
         for (var i = 0; i < response.data.result.sucursales.length; i++) {
             console.log(response.data.result.sucursales[i].id_sucursal);
             jQuery(`#${response.data.result.sucursales[i].id_sucursal}`).prop('checked', true);
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
/*function parse_clave(){
   var url = domain( url_unidades );
    var fields = {id : jQuery('#cmb_unidades').val() };
    var promise = MasterController.method_master(url,fields,"get");
      promise.then( response => {
          var clave = response.data.result.clave
          jQuery('#clave').val(clave);
      }).catch( error => {
          if( error.response.status == 419 ){
                toastr.error( session_expired ); 
                redirect(domain("/"));
                return;
            }
          toastr.error( error.response.data.message , expired );

      });
    
}

function parse_clave_edit(){
    var url = domain( url_unidades );
    var fields = {id : jQuery('#cmb_unidades_edit').val() };
    var promise = MasterController.method_master(url,fields,"get");
      promise.then( response => {
         var clave = response.data.result.clave
          jQuery('#clave_edit').val(clave);
      }).catch( error => {
          if( error.response.status == 419 ){
                toastr.error( session_expired ); 
                redirect(domain("/"));
                return;
            }
          toastr.error( error.response.data.message , expired );

      });

}*/

// jQuery('#cmb_categorias').selectpicker();
// jQuery('#cmb_categorias_edit').selectpicker();
// jQuery('#cmb_unidades_edit').selectpicker();
//jQuery('#cmb_empresas').selectpicker();
//jQuery('#cmb_servicio').selectpicker();
jQuery('#cmb_servicio').chosen();
jQuery('#cmb_categorias').chosen();
jQuery('#cmb_unidades').chosen();