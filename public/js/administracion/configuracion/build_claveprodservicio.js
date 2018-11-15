var url_insert  = "claveprodservicio/register";
var url_update   = "claveprodservicio/update";
var url_edit     = "claveprodservicio/edit";
var url_destroy  = "claveprodservicio/destroy";
var url_all      = "claveprodservicio/all";
var redireccion  = "configuracion/claveprodservicio";

new Vue({
  el: "#vue-claveprodservicio",
  created: function () {
    this.consulta_general();
  },
  data: {
    datos: [],
    insert: {},
    update: {},
    edit: {},
    fields: {},
    claveprodservicio: {},


  },
  mixins : [mixins],
  methods:{
    consulta_general(){
        var url = domain( url_all );
        var fields = {};
        var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
          this.datos = response.data.result;
          this.claveprodservicio =  response.data.result;
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
    ,generar_pdf(){
          var registros = this.claveprodservicio;
          var columns = ['Clave','Descripcion','IVA Trasladado','IEPS Trasladado','Similares'];
          var data = [];
          var reportes= [];
          var count = 0;
          var j = 0;
          for (var i in registros) {
              data[registros[i].id] = [];
          }
          for (var i in registros) {
              data[count] = [
                // registros[i].id
                registros[i].clave
                ,registros[i].descripcion
                ,registros[i].iva_trasladado
                ,registros[i].ieps_trasladado
                ,registros[i].similares
              ];
              count++;
          }
          // console.log(data);
          for ( var i in data) {
              reportes[j] = Object.values(data[i]);
              j++
          }
          var fields = {
              'columnas' : columns
              ,'titulo'  : "ninguno"
              ,'datos'   :  data
          };
          // console.log(fields);
          var options ={
              // Styling
              theme: 'striped', // 'striped', 'grid' or 'plain'
              styles: {
                columnWidth: 34, // 'auto', 'wrap' or a number
                overflow: 'linebreak', // visible, hidden, ellipsize or linebreak
                //cellPadding: 2, // a number, array or object (see margin below)
              },
              headerStyles: {},
              bodyStyles: {},
              alternateRowStyles: {},
              columnStyles: {},

              // Properties
              startY: false, // false (indicates margin top value) or a number
              margin: {top: 30}, // a number, array or object
              pageBreak: 'auto', // 'auto', 'avoid' or 'always'
              tableWidth: 'auto', // 'auto', 'wrap' or a number,
              showHeader: 'firstPage', // 'everyPage', 'firstPage', 'never',
              tableLineColor: 200, // number, array (see color section below)
              tableLineWidth: 0,

              // Hooks
              createdHeaderCell: function (cell, data) {},
              createdCell: function (cell, data) {},
              drawHeaderRow: function (row, data) {},
              drawRow: function (row, data) {},
              drawHeaderCell: function (cell, data) {},
              drawCell: function (cell, data) {},
              addPageContent: function (data) {}
           };
           var pdf = new jsPDF( {orientation: 'landscape'});
           for (var i = 0; i < fields.datos.length; i++) {
              pdf.text(20,20,fields.titulo);
              // console.log(fields.datos);return;
              pdf.autoTable( fields.columnas,fields.datos, options );
              pdf.addPage();
            }

            $.fancybox.open({
              'type': 'iframe'
              ,'src': pdf.output('datauristring')
              ,'buttons' : ['share', 'close']
            });

          this.reportes_pdf(fields,options);
    
    }  
  }

});