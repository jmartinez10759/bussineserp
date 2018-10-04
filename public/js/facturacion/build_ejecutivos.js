new Vue({
  el: "#vue-ejecutivos",
  created: function () {
    this.consulta_general();
  },
  data: {
    datos: [],
    newKeep: {

    },
    fillKeep   : {}
    ,ejecutivos : {}
    ,clientes   : {}
    ,facturas   : {}
    ,filtros_ejecutivos: {}
  },
  mixins : [mixins],
  methods:{
    consulta_general(){
      var url = domain('facturacion/ejecutivo');
      var fields = {};
      this.all_register(url,fields,'ejecutivos');
    }
    ,comisiones( cantidad ){
        return "$"+number_format(cantidad,2);
    }
    ,load_files( id_usuario ){
        jQuery('#id_usuario').val(id_usuario);
        $.fancybox.open({
            'type': 'inline'
            ,'src': "#modal_upload"
            ,'buttons' : ['share', 'close']
        });
        var url = domain('facturacion/upload_masiva');
        var fields = { id_users: jQuery('#id_usuario').val() };
        var ids = {
          div_content  : 'div_dropzone_file'
          ,div_dropzone : 'dropzone_xlsx_file'
          ,file_name    : 'file'
        };
        var message = "Dar Clic aquí o arrastrar archivo de factura XML";
        upload_file( fields ,url, message ,null , ids ,'.xml',function( request ){
          if(request.success == true ){
              // $.fancybox.close({
              //     'type': 'inline'
              //     ,'src': "#modal_upload"
              //     ,'buttons' : ['share', 'close']
              // });
              //redirect(domain('facturacion/ejecutivos'));
          }

        });
        //this.consulta_general();

    }
    ,edit_ejecutivo( id_users ){
        //console.log(fields);
        var url = domain('ejecutivos/show');
        var fields = {id:id_users}
        this.all_register(url,fields,'clientes');
        $.fancybox.open({
            type: 'inline'
            ,src: "#modal_clientes"
            ,buttons : ['share', 'close']
        });

    }
    ,details_clientes( id_cliente ){
        var url = domain('ejecutivos/cliente');
        var fields = {id_cliente: id_cliente};
        this.all_register(url,fields,'facturas');
        $.fancybox.open({
            'type': 'inline'
            ,'src': "#modal_facturas_by_cliente"
            ,'buttons' : ['share', 'close']
        });

    }
    ,visualizar( ruta ){
      if( isset( ruta ) && ruta != 0){
        $.fancybox.open({
          'type': 'iframe'
          ,'src': domain(ruta)
          ,'buttons' : ['share', 'close']
        });

      }else{
          toastr.info('Aun no cuenta con comprobante','Visualiza Comprobante');
      }

    }
    ,select_estatus( id_factura ){
        var url = domain('facturacion/estatus');
        var fields = {
          id_factura: id_factura
          ,id_estatus : jQuery('#'+id_factura).val()
        }
        this.insert_controller(url,fields,'consulta_general');

    }
    ,edit_factura( id_factura ){

       var fields = {'id_factura':id_factura };
       var url = domain('facturacion/edit');
       axios.get( url, { params: fields }, csrf_token ).then(response => {
           if( response.data.success == true ){
             console.log( response.data.result );
             var factura = response.data.result.factura[0].serie+"-"+response.data.result.factura[0].folio;
             jQuery('input[name="factura_edit"]').val(factura);
             jQuery('input[name="id_factura_edit"]').val(response.data.result.factura[0].id);
             jQuery('input[name="subtotal_edit"]').val((response.data.result.subtotal));
             jQuery('input[name="total_edit"]').val((response.data.result.total));
             jQuery('#fecha_factura_edit').val(response.data.result.factura[0].fecha_factura);
             jQuery('#cmb_forma_pago_edit').val(response.data.result.factura[0].formas_pagos[0].id);
             jQuery('input[name="rfc_receptor_edit"]').val(response.data.result.factura[0].clientes[0].rfc_receptor);
             jQuery('input[name="razon_social_edit"]').val(response.data.result.factura[0].clientes[0].razon_social);

             jQuery('#comision_edit').val(response.data.result.factura[0].comision);
             jQuery('#total_pago_edit').val(response.data.result.factura[0].pago);
             jQuery('#fecha_pago_edit').val(response.data.result.factura[0].fecha_pago);
             jQuery('#observaciones_edit').val(response.data.result.factura[0].descripcion);
             jQuery('#cmb_forma_pago_edit').attr('disabled', true);
             jQuery('#archivo_edit').val(response.data.result.factura[0].archivo);
             //jQuery('input[name="uuid_edit"]').val(response.data.result.factura[0].uuid);
             jQuery('.subtotal').text( response.data.result.subtotal );
             jQuery('.total').text( response.data.result.total );
             jQuery('.iva').text(response.data.result.iva );
             this.datos = response.data.result.factura[0].conceptos;

             jQuery.fancybox.open({
                   'type': 'inline'
                   ,'src': "#modal_edit_facturas"
                   ,'buttons' : ['share', 'close']
               });

           }else{
               toastr.error( response.data.message, "¡Ningún Registro Encontrado!" );
           }
       }).catch(error => {
           toastr.error( error, expired );
       });

    }
    ,delete_factura ( id_factura ){
        var url = domain('facturacion/borrar');
        var fields = {'id_factura' : id_factura };
        //se manda un mensaje para confirmar si desea eliminar el registro.
        buildSweetAlertOptions( "¿Borrar Registro?", "¿Realmente deseas borrar el registro?", function(){
            axios.get( url, { params: fields }, csrf_token ).then(response => {
                if( response.data.success == true ){
                    redirect(domain('facturacion/ejecutivos'));
                    jQuery.fancybox.close({
                          'type': 'inline'
                          ,'src': "#modal_clientes"
                          ,'buttons' : ['share', 'close']
                      });
                    toastr.success( response.data.message, "¡Proceso Correctamente!" );
                }else{
                    toastr.error( response.data.message, "¡Ocurrio un error en el proceso!" );
                }
            }).catch(error => {
                toastr.error( error, expired );
            });

        }, "warning", true, ['SI','NO'] );


    }
    ,filtros(){
        this.filtros_ejecutivos.fecha_inicio  = jQuery('#fecha_inicio_pago').val();
        this.filtros_ejecutivos.fecha_final   = jQuery('#fecha_final_pago').val();
        this.filtros_ejecutivos.ejecutivo     = jQuery('#cmb_ejecutivos').val();
        var url = domain('ejecutivos/filtros');
        this.all_register(url,this.filtros_ejecutivos,'ejecutivos');
    }
    ,send_masiva( url ){
      redirect(domain(url));
    }
    ,generar_pdf(){

        var registros = this.ejecutivos.response;
        var columns = ["Nombre","RFC","Cliente","N°Factura",'Fecha Pago','Total Comisión','Total Pago','Total Factura'];
        var data = [];
        var reportes= [];
        var count = 0;
        var j = 0;
        for (var i in registros) {
            data[registros[i].id_usuario] = [];
        }
        for (var i in registros) {
            data[registros[i].id_usuario][count] = [
              registros[i].nombre_completo
              //,registros[i].perfil
              ,registros[i].rfc_receptor
              ,registros[i].razon_social
              ,registros[i].factura
              ,(registros[i].fecha_pago !== null)?registros[i].fecha_pago: ""
              ,"$"+number_format(registros[i].comision_general,2)
              ,"$"+number_format(registros[i].pago_general,2)
              ,"$"+number_format(registros[i].total_general,2)
            ];
            count++;
        }
        for ( var i in data) {
            reportes[j] = Object.values(data[i]);
            j++
        }
        var fields = {
            'columnas' : columns
            ,'titulo'  : "REPORTE MENSUAL DE VENTAS DE"
            ,'datos'   :  reportes
        };
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
        this.reportes_pdf(fields,options);

    }
    ,generar_csv(){
      var registros = this.ejecutivos.response;
      var data = [];
      var count = 0;
      for (var i in registros) {
          data[count] = [
            registros[i].nombre_completo
            //,registros[i].perfil
            ,registros[i].rfc_receptor
            ,registros[i].razon_social
            ,registros[i].factura
            ,(registros[i].fecha_pago !== null)?registros[i].fecha_pago: ""
            ,"$"+number_format(registros[i].comision_general,2)
            ,"$"+number_format(registros[i].pago_general,2)
            ,"$"+number_format(registros[i].total_general,2)
          ];
          count++
      }
      var columns = ["Nombre","RFC","Cliente","N°Factura",'Fecha Pago','Total Comisión','Total Pago','Total Factura'];
      var fields = {
        'columnas' : columns
        ,'titulo'  : "REPORTE MENSUAL DE VENTAS BURO LABORAL MEXICO"
        ,'datos'   :  data
      }
      //console.log(fields);return;
      this.reportes_csv( fields );
    }

  }

});
jQuery("#cmb_ejecutivos").selectpicker();
jQuery('.fechas').datepicker( {format: 'yyyy-mm-dd', autoclose: true, language: 'es' });
