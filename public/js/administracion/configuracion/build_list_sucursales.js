//new Vue({
//  el: "#vue-sucursales",
//  created: function () {
//    this.consulta_general();
//  },
//  data: {
//    datos: [],
//    newKeep: {
//
//    },
//    fillKeep: {
//
//    },
//
//  },
//  mixins : [mixins],
//  methods:{
//    consulta_general: function(){
//        var data_table = $myLocalStorage.get('data_table');
//        jQuery('#table_sucursales').html('');
//        jQuery('#table_sucursales').html(data_table);
//    }
//    ,portal: function( id_sucursal ){
//          return new SucursalController( id_sucursal );
//    }
//  }
//});
//
//
//class SucursalController{
//
//  constructor( id_sucursal ){
//      return this.portal( id_sucursal );
//  }
//  /**
//   *Se crea un metodo para obtener la sucursal e ingresar al portal.
//   * @access public
//   * @param id_sucursal [descripcion]
//   * @return void
//   */
//   portal( id_sucursal ){
//
//     let url = domain('portal');
//     let fields = {'id_sucursal': id_sucursal};
//     axios.get(url, fields, csrf_token ).then(response => {
//         if (response.data.success == true) {
//           console.log(response.result);return;
//           //redirect( domain( response.result.ruta ) );
//         }else{
//             toastr.error( response.data.message, title_error );
//         }
//     }).catch(error => {
//         toastr.error( error,expired );
//     });
//
//
//   }
//}
