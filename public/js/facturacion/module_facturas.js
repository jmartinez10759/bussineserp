var url_insert  = "usuarios/register";
var url_update  = 'usuarios/update';
var url_edit    = 'usuarios/edit';
var url_destroy = "usuarios/destroy";
var redireccion = "usuarios";
var url_all     = "facturacion/all";

new Vue({
  el: "#vue-facturas",
  created: function () {
    this.consulta_general();
  },
  data: {
     datos: []
    ,newKeep: {}
    ,fillKeep: {}
    ,conceptos: { 'total':0,'precio':0 ,'cantidad': 0 }
    ,facturas: {}
    ,resultados: []
    ,cfdi: {}
    ,cantidades : {}
    ,dropdown: {}
    ,fechas_pagos: {}
  },
  mixins : [mixins],
  methods:{
    consulta_general: function(){
      var url = domain( url_all );
      var fields = {};
        var request = MasterController.method_master(url,fields,'get');
        request.then( response => {
           if( response.data.success == true ){
            this.cfdi = response.data.result.total_facturas;
            this.cantidades = response.data.result;
            this.dropdown = response.data.result.select_estatus;
            console.log(this.cfdi);
          }else{
              toastr.error( response.data.message, "¡Ningún Registro Encontrado!" );
          } 
        }).catch( error => {
            toastr.error( error, expired );
        });

    }
    ,edit_factura: function( id_factura ){
       var fields = {'id_factura':id_factura };
       var url = domain('facturacion/edit');
       axios.get( url, { params: fields }, csrf_token ).then(response => {
           if( response.data.success == true ){
             console.log( response.data.result );
             var factura = response.data.result.factura[0].serie+"-"+response.data.result.factura[0].folio;
             var metodo_pagos = response.data.result.factura[0].metodo_pagos[0].id;
             var formas_pagos = response.data.result.factura[0].formas_pagos[0].id;
             var parcialidades = (response.data.result.factura[0].fechas.length > 0 )? response.data.result.factura[0].fechas.length: 2;
             console.log(parcialidades);
             jQuery('input[name="factura_edit"]').val(factura);
             jQuery('input[name="id_factura_edit"]').val(response.data.result.factura[0].id);
             jQuery('input[name="subtotal_edit"]').val((response.data.result.subtotal));
             jQuery('input[name="total_edit"]').val((response.data.result.total));
             jQuery('#fecha_factura_edit').val(response.data.result.factura[0].fecha_factura);
             jQuery('#cmb_forma_pago_edit').val(formas_pagos);
             jQuery('#cmb_metodo_pago_edit').val(metodo_pagos);
             jQuery('input[name="rfc_receptor_edit"]').val(response.data.result.factura[0].clientes[0].rfc_receptor);
             jQuery('input[name="razon_social_edit"]').val(response.data.result.factura[0].clientes[0].razon_social);

             jQuery('#comision_edit').val(response.data.result.factura[0].comision);
             jQuery('#total_pago_edit').val(response.data.result.factura[0].pago);
             jQuery('#fecha_pago_edit').val(response.data.result.factura[0].fecha_pago);
             jQuery('#observaciones_edit').val(response.data.result.factura[0].descripcion);
             jQuery('#cmb_forma_pago_edit').attr('disabled', true);
             jQuery('#cmb_metodo_pago_edit').attr('disabled', true);
             jQuery('#parcialidades_edit').val( parcialidades  );
             jQuery('#archivo_edit').val(response.data.result.factura[0].archivo);

             jQuery('.subtotal').text( response.data.result.subtotal );
             jQuery('.total').text( response.data.result.total );
             jQuery('.iva').text(response.data.result.iva );
             this.datos = response.data.result.factura[0].conceptos;
             if( response.data.result.factura[0].fechas.length > 0 ){
               for (var i in response.data.result.factura[0].fechas) {
                 this.fechas_pagos[i] = { fechas_parcialidades: response.data.result.factura[0].fechas[i].fecha_pago };
               }
             }else{
               this.fechas_pagos = [{ fechas_parcialidades: "" }];
             }
             if( metodo_pagos == 2 ){
                jQuery('#fecha_pago_edit').val( this.fechas_pagos[0].fechas_parcialidades );
             }
             this.select_metodo_pago_edit();
             //this.add_fechas_parcialidades_edit();
             $.fancybox.open({
                   'type': 'inline'
                   ,'src': "#modal_edit_facturas"
                   ,'buttons' : ['share', 'close']
               });
             //toastr.info( response.data.message, "Cargando los registros");
           }else{
               toastr.error( response.data.message, "¡Ningún Registro Encontrado!" );
           }
       }).catch(error => {
           toastr.error( error, expired );
       });

    }
    ,total_concepto: function(){
        var precio = (this.conceptos.precio != "") ? this.conceptos.precio: 0;
        var cantidad = (this.conceptos.cantidad != "") ?this.conceptos.cantidad : 0;
        this.conceptos.total = (precio * cantidad);
        console.log(this.conceptos.total);
    }
    ,comision:function( accion ){
        if( accion == "" || accion == null){
          var comision  = (jQuery('#comision').val());
          var total     = (jQuery('input[name="total"]').val());
          total = total.replace('$',"");
          total = total.replace(',',"");
          var total_pago = ( parseFloat(total - comision) );
          jQuery('#total_pago').val(total_pago.toFixed(4));
        }else{
          var comision  = (jQuery('#comision_edit').val());
          var total     = (jQuery('input[name="total_edit"]').val());
          total = total.replace('$',"");
          total = total.replace(',',"");
          var total_pago = ( parseFloat(total - comision) );
          jQuery('#total_pago_edit').val(total_pago.toFixed(4));
        }
        //var pago      = (jQuery('input[name="pago_edit"]').val());
        // if(pago != total_pago){
        //   toastr.warning("El monto ingresado no concuerda con el total pagado");
        //   return;
        // }
    }
    ,insert_conceptos: function(){
        this.newKeep.fecha_factura  = jQuery('#fecha_factura').val();
        this.newKeep.forma_pago     = jQuery('#cmb_forma_pago').val();
        this.newKeep.id_factura     = jQuery('#id_factura').val();
        this.newKeep.comision       = jQuery('#comision').val();
        this.newKeep.pago           = jQuery('#total_pago').val();
        this.newKeep.metodo_pago    = jQuery('#cmb_metodo_pago').val();
        this.newKeep.fecha_pago     = ( this.newKeep.metodo_pago == 2 )? this.fechas_pagos:[{ fechas_parcialidades: jQuery('#fecha_pago').val()}];
        this.newKeep.archivo        = jQuery('#archivo').val();
        if (this.newKeep.rfc_receptor == "" || this.newKeep.facturas == "") {
          toastr.error('Verificar los campos en asterisco','Verificar Información');
          return;
        }
        // if (this.newKeep.metodo_pago == 2 && this.fechas_pagos.length > 1) {
        //     toastr.error('Favor de agregar fechas de pagos','Verificar Información');
        //     return;
        // }
        var url     = domain('facturacion/insert');
        var refresh = domain('facturacion/edit');
        var fields = {
          'facturas'  : this.newKeep
          ,'conceptos': this.conceptos
        }
        axios.post( url, fields , csrf_token ).then( response => {
            if( response.data.success == true ){
                var id_factura = response.data.result.id_factura;
                this.show( refresh,{ 'id_factura': id_factura } );
                this.consulta_general();
                jQuery('#id_factura').val(id_factura);
                $.fancybox.close({
                    'type': 'inline'
                    ,'src': "#modal_conceptos"
                    ,'buttons' : ['share', 'close']
                });
                for (var i in this.conceptos) {
                   this.conceptos[i] = "";
                }

            }else{
                // for (var i in this.conceptos) {
                //    this.conceptos[i] = "";
                // }
                toastr.error( response.data.message, "¡Verificar Información!" );
            }
        }).catch(error => {
            toastr.error( error, expired );
        });

    }
    ,insert_factura: function(){
        this.newKeep.fecha_factura  = jQuery('#fecha_factura').val();
        this.newKeep.forma_pago     = jQuery('#cmb_forma_pago').val();
        this.newKeep.id_factura     = jQuery('#id_factura').val();
        this.newKeep.comision       = jQuery('#comision').val();
        this.newKeep.pago           = jQuery('#total_pago').val();
        this.newKeep.metodo_pago    = jQuery('#cmb_metodo_pago').val();
        this.newKeep.archivo        = jQuery('#archivo').val();
        this.newKeep.fecha_pago     = ( this.newKeep.metodo_pago == 2 )? this.fechas_pagos:[{ fechas_parcialidades: jQuery('#fecha_pago').val()}];
        this.newKeep.razon_social         = jQuery('input[name="razon_social"]').val();
        this.newKeep.rfc_receptor         = jQuery('#rfc_receptor').val();
        this.newKeep.factura              = jQuery('input[name="factura"]').val();
        this.newKeep.subtotal             = jQuery('input[name="subtotal"]').val();
        this.newKeep.total                = jQuery('input[name="total"]').val();
        this.newKeep.observaciones        = jQuery('#observaciones').val();

        if (this.newKeep.rfc_receptor == "" || this.newKeep.facturas == "") {
            toastr.error('Verificar los campos en asterisco','Verificar Información');
            return;
        }
        // if( this.newKeep.metodo_pago == 2  && this.fechas_pagos.length > 1  ){
        //     toastr.error( "Se debe agregar Fechas de parcialidades ", "¡Verificar Información!" );
        //     return;
        // }
        console.log(this.newKeep);
        var fields = { 'facturas' : this.newKeep };
        var refresh = domain('facturacion/all');
        var url = (this.newKeep.id_factura != "" )? domain('facturacion/update'): domain('facturacion/insert');

        axios.post( url, fields , csrf_token ).then( response => {
            if( response.data.success == true ){

                this.consulta_general();
                for (var i in this.newKeep) {
                   this.newKeep[i] = "";
                }
                clear_values(['id_factura','fecha_factura','cmb_forma_pago','comision','total_pago','fecha_pago','archivo','observaciones']);
                $.fancybox.close({
                    'type': 'inline'
                    ,'src': "#modal_facturas"
                    ,'buttons' : ['share', 'close']
                });

            }else{
                toastr.error( response.data.message, "¡Verificar Información!" );
            }
        }).catch(error => {
            toastr.error( error, expired );
        });


    }
    ,show: function(url,fields){
      axios.get( url, { params: fields }, csrf_token ).then(response => {
          if( response.data.success == true ){
               this.facturas = response.data.result.factura[0];
               this.resultados = response.data.result;
               console.log(this.facturas);
               console.log(this.resultados);
          }else{
              toastr.error( response.data.message, "¡Ningún Registro Encontrado!" );
          }
      }).catch(error => {
          toastr.error( error, expired );
      });


    }
    ,update_factura(){
        this.fillKeep.pago        = jQuery('#total_pago_edit').val();
        this.fillKeep.comision    = jQuery('#comision_edit').val();
        this.fillKeep.descripcion = jQuery('#observaciones_edit').val();
        this.fillKeep.fecha_pago     = ( this.newKeep.metodo_pago == 2 )? this.fechas_pagos:[{ fechas_parcialidades: jQuery('#fecha_pago_edit').val()}];
        this.fillKeep.archivo     = jQuery('#archivo_edit').val();
        this.fillKeep.id_factura  = jQuery('input[name="id_factura_edit"]').val();
        var url = domain('facturacion/actualizar');
        //var refresh = domain('facturacion/all');
        axios.post( url, this.fillKeep , csrf_token ).then(response => {
            if( response.data.success == true ){
              jQuery('#total_pago_edit').val("");
              jQuery('#comision_edit').val("");
              jQuery('#observaciones_edit').val("");
              jQuery('#fecha_pago_edit').val("");
              jQuery('#archivo_edit').val("");
              jQuery('#search_general').val("");
              jQuery('input[name="id_factura_edit"]').val("");
              $.fancybox.close({
                  'type': 'inline'
                  ,'src': "#modal_edit_facturas"
                  ,'buttons' : ['share', 'close']
              });
              //this.consulta_general();
              //setTimeout (redirect(domain('facturacion/facturas')), 5000);
              redirect( domain('facturacion/facturas') );
            }else{
                toastr.error( response.data.message, "¡Ocurrio un Error, Favor de Verificar!" );
            }
        }).catch(error => {
            toastr.error( error, expired );
        });



    }
    ,visualizar: function( ruta ){
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
    ,select_estatus: function( id_factura ){
        var url = domain('facturacion/estatus');
        var fields = {
          id_factura: id_factura
          ,id_estatus : jQuery('#'+id_factura).val()
        }
        this.insert_controller(url,fields);
        //this.consulta_general();
    }
    ,delete_factura :function( id_factura ){
        var url = domain('facturacion/borrar');
        var fields = {'id_factura' : id_factura };
        //se manda un mensaje para confirmar si desea eliminar el registro.
        buildSweetAlertOptions( "¿Borrar Registro?", "¿Realmente deseas borrar el registro?", function(){
            axios.get( url, { params: fields }, csrf_token ).then(response => {
                if( response.data.success == true ){
                    redirect(domain('facturacion/facturas'));
                    toastr.success( response.data.message, "¡Proceso Correctamente!" );
                }else{
                    toastr.error( response.data.message, "¡Ocurrio un error en el proceso!" );
                }
            }).catch(error => {
                toastr.error( error, expired );
            });

        }, "warning", true, ['SI','NO'] );

    }
    ,filtro_fechas() {
          var url = domain('facturacion/filtros');
          var fields = {
              fecha_pago_inicio : jQuery('#fecha_inicio_pago').val()
              ,fecha_final_pago : jQuery('#fecha_final_pago').val()
          };

          if( fields.fecha_pago_inicio == "" || fields.fecha_pago_inicio == null){
               return toastr.error('Establecer una fecha de inicio','Favor de verificar Fecha Inicio');
          }
          axios.get( url, { params: fields }, csrf_token ).then(response => {
              if( response.data.success == true ){
                var facturas = [];
                var j = 0;
                for (var i in response.data.result.total_facturas) {
                    facturas[j] = response.data.result.total_facturas[i].facturas;
                    j++;
                }
                this.cfdi = response.data.result.total_facturas;
                this.cantidades = response.data.result;
                this.dropdown = response.data.result.select_estatus;
                console.log(this.cfdi);
              }else{
                  toastr.error( response.data.message, "¡Ningún Registro Encontrado!" );
              }
          }).catch(error => {
              toastr.error( error, expired );
          });



    }
    ,generar_pdf(){
        var registros = this.cfdi;
        var columns = ["N°Factura", "RFC", "Cliente" ,'Fecha Pago','Comisión','Total Pago','Total Factura'];
        var data = [];
        var count = 0;
        for (var i in registros) {
            data[count] = [
              registros[i].factura
              ,registros[i].rfc_receptor
              ,registros[i].razon_social
              ,registros[i].fecha_pago
              ,registros[i].comision_general
              ,registros[i].pago_general
              ,registros[i].total_general
            ];
            count++
        }
        var fields = {
            'columnas' : columns
            ,'titulo'  : "REPORTE MENSUAL DE VENTAS BURO LABORAL MEXICO"
            ,'datos'   :  [data]
        };
        this.reportes_pdf(fields);

    }
    ,generar_csv(){
      var registros = this.cfdi;
      var data = [];
      var count = 0;
      for (var i in registros) {
          data[count] = [
            registros[i].factura
            ,registros[i].rfc_receptor
            ,registros[i].razon_social
            ,registros[i].fecha_pago
            ,registros[i].comision_general
            ,registros[i].pago_general
            ,registros[i].total_general
          ];
          count++
      }
      var columns = ["N°Factura", "RFC", "Cliente" ,'Fecha Pago','Comisión','Total Pago','Total Factura'];
      jQuery('#excel').jexcel({
        data:data
        ,colHeaders:  columns
        ,colWidths: [ 150, 150, 400, 150,150, 150, 150 ]
        ,csvHeaders:true
        ,tableOverflow:true
        ,tableHeight:'50px'
      });
      $.fancybox.open({
          'type': 'inline'
          ,'src': "#content_excel"
          ,'buttons' : ['share', 'close']
      });

    }
    ,download_excel(){
      jQuery('#excel').jexcel('download');
    }
    ,select_metodo_pago(){
        this.newKeep.metodo_pago = jQuery('#cmb_metodo_pago').val();
        if( this.newKeep.metodo_pago == 2){
          jQuery('#div_fechas_pago').hide();
          jQuery('#div_parcialidades').show();
          jQuery('#txt_fecha_pago').text('Parcialidades');
          jQuery('#fecha_pago').val('');
        }else{
          jQuery('#div_fechas_pago').show();
          jQuery('#div_parcialidades').hide();
          jQuery('#txt_fecha_pago').text('Fecha de Pago');
        }
        jQuery('#parcialidades').val(1);

    }
    ,add_fechas_parcialidades(){
        this.newKeep.parcialidades = jQuery('#parcialidades').val();
        if( this.newKeep.parcialidades > 0 ){
            var html = "";
            var j = 1;
            for (var i = 0; i < this.newKeep.parcialidades; i++) {
                html += '<div class="row">';
                  html += '<label class="control-label col-sm-5" for=""> '+j+' Fecha de Pago</label>';
                    html += '<div class="col-sm-7">';
                        html += '<div class="col-sm-12">';
                            html += '<input type="text" id="fecha_pago_'+j+'" class="form-control fechas" placeholder="" readonly >';
                        html += '</div>';
                    html += '</div>';
                  html += '</div>';
                  html += '<br>';
                  j++;
            }
            jQuery('#content_fechas').html( html );
            var j = 1;
            var count = 0;
            for (var i in this.fechas_pagos) {
               var fecha = this.fechas_pagos[i].fechas_parcialidades;
                jQuery('#fecha_pago_'+j).val(fecha);
              j++;
              count++;
            }
            this.fechas_pagos = [];
            jQuery('.fechas').datepicker( {format: 'yyyy-mm-dd', "autoclose": true, language: 'es' });
            $.fancybox.open({
                'type': 'inline'
                ,'src': "#add_fechas_parcialidades"
                ,'buttons' : ['share', 'close']
            });

        }


    }
    ,fechas_parcialidades(){
       console.log(this.newKeep.parcialidades);
       var j = 1;
       this.fechas_pagos = [];
       for (var i = 0; i < this.newKeep.parcialidades; i++) {
          this.fechas_pagos[i] = { fechas_parcialidades : jQuery('#fecha_pago_'+j).val() };
          j++;
       }

       $.fancybox.close({
           'type': 'inline'
           ,'src': "#add_fechas_parcialidades"
           ,'buttons' : ['share', 'close']
       });

    }
    ,select_metodo_pago_edit(){
        this.newKeep.metodo_pago = jQuery('#cmb_metodo_pago_edit').val();
        if( this.newKeep.metodo_pago == 2){
          jQuery('#div_fechas_pago_edit').hide();
          jQuery('#div_parcialidades_edit').show();
          jQuery('#txt_fecha_pago_edit').text('Parcialidades');
          jQuery('#fecha_pago_edit').val('');
          //jQuery('#parcialidades_edit').val(2);
        }else{
          jQuery('#div_fechas_pago_edit').show();
          jQuery('#div_parcialidades_edit').hide();
          jQuery('#txt_fecha_pago_edit').text('Fecha de Pago');
          jQuery('#parcialidades_edit').val(1);
        }

    }
    ,add_fechas_parcialidades_edit(){
        this.fillKeep.parcialidades = jQuery('#parcialidades_edit').val();
        if( this.fillKeep.parcialidades > 0 ){
            var html = "";
            var j = 1;
            for (var i = 0; i < this.fillKeep.parcialidades; i++) {
                html += '<div class="row">';
                  html += '<label class="control-label col-sm-5" for=""> '+j+' Fecha de Pago</label>';
                    html += '<div class="col-sm-7">';
                        html += '<div class="col-sm-12">';
                            html += '<input type="text" id="fecha_pago_edit_'+j+'" class="form-control fechas" placeholder="" readonly >';
                        html += '</div>';
                    html += '</div>';
                  html += '</div>';
                  html += '<br>';
                  j++;
            }
            jQuery('#content_fechas_edit').html( html );
            var j = 1;
            var count=0;
            for (var i in this.fechas_pagos) {
               var fecha = this.fechas_pagos[i].fechas_parcialidades;
                jQuery('#fecha_pago_edit_'+j).val( fecha );
                j++;
                count++;
            }
            //console.log( jQuery('#fecha_pago_edit_1').val() );
            //this.fechas_pagos = [];
            jQuery('.fechas').datepicker( {format: 'yyyy-mm-dd', "autoclose": true, language: 'es' });
            $.fancybox.open({
                'type': 'inline'
                ,'src': "#add_fechas_parcialidades_edit"
                ,'buttons' : ['share', 'close']
            });

        }


    }
    ,fechas_parcialidades_edit(){
       console.log(this.fillKeep.parcialidades);
       var j = 1;
       this.fechas_pagos = [];
       for (var i = 0; i < this.fillKeep.parcialidades; i++) {
          this.fechas_pagos[i] = { fechas_parcialidades : jQuery('#fecha_pago_edit_'+j).val() };
          j++;
       }

       $.fancybox.close({
           'type': 'inline'
           ,'src': "#add_fechas_parcialidades_edit"
           ,'buttons' : ['share', 'close']
       });

    }
    ,operacion_parcialidades_edit(edit){
        if(isset(edit)){

        }else{

          var parcialidad = jQuery('#parcialidades_edit').val();
          if( parcialidad != ""){
            var total_pagado = 0;
            var total_factura = jQuery('input[name=total_edit]').val();
            total_factura = total_factura.replace('$',"");
            total_factura = total_factura.replace(',',"");
            total_pagado = Math.round(parseFloat(total_factura/parcialidad),2);
            jQuery('#total_pago_edit').val(total_pagado);
          }

        }



    }
  }


});

jQuery('.add').fancybox();
jQuery('.fechas').datepicker( {format: 'yyyy-mm-dd', "autoclose": true, language: 'es' });

 var url = domain('facturacion/upload');
 var fields = {};
 var message = "Dar Clic aquí o arrastrar archivo de factura XML";
 var message2 = "Dar Clic aquí o arrastrar archivo de comprobante";
 var ids = {
    div_content  : 'div_dropzone_file'
   ,div_dropzone : 'dropzone_xlsx_file'
   ,file_name    : 'file'
 };
 var id_div = {
   div_content  : 'div_dropzone_file_edit'
  ,div_dropzone : 'dropzone_xlsx_file_edit'
  ,file_name    : 'file'
};
  upload_file(fields ,url,message,null, ids ,'.xml,.pdf,.txt,jpeg,.jpg,.png',function( request ){
      var request = JSON.parse(request);
      console.log(request);
      if(request.success == true ){

          if( isset(request.result.ruta_file) ){
            jQuery('#archivo').val(request.result.ruta_file);
            return;
          }

          var formas_pago = request.result.factura[0].formas_pagos[0].id;
          var metodo_pagos = request.result.factura[0].metodo_pagos[0].id;

          jQuery('input[name=subtotal]').val(request.result.factura[0].subtotal);
          jQuery('input[name=total]').val(request.result.factura[0].total);
          jQuery('#total_pago').val(request.result.factura[0].total);

          jQuery('input[name=factura]').val(request.result.factura[0].serie+"-"+request.result.factura[0].folio);
          jQuery('#fecha_factura').val(request.result.factura[0].fecha_factura);
          jQuery('#cmb_forma_pago').val(formas_pago);
          jQuery('#cmb_metodo_pago').val(metodo_pagos);
          jQuery('input[name=rfc_receptor]').val(request.result.factura[0].clientes[0].rfc_receptor);
          jQuery('input[name=razon_social]').val(request.result.factura[0].clientes[0].razon_social);
          jQuery('input[name=observaciones]').val(request.result.factura[0].descripcion);

          jQuery('#subtotal').text(request.result.subtotal);
          jQuery('#iva').text(request.result.iva);
          jQuery('#total').text(request.result.total);
          jQuery('#id_factura').val(request.result.factura[0].id);
          if( metodo_pagos == 2){
            jQuery('#div_fechas_pago').hide();
            jQuery('#div_parcialidades').show();
            jQuery('#txt_fecha_pago').text('Parcialidades');
            jQuery('#fecha_pago').val('');
          }else{
            jQuery('#div_fechas_pago').show();
            jQuery('#div_parcialidades').hide();
            jQuery('#txt_fecha_pago').text('Fecha de Pago');
          }
          jQuery('#parcialidades').val(2);

          var campos = ['add_concepto','subtotal','total','factura','fecha_factura','cmb_forma_pago','cmb_metodo_pago','rfc_receptor','razon_social'];
          for (var i = 0; i < campos.length; i++) {
            jQuery('#'+campos[i]).attr('disabled',true);
            jQuery('input[name='+campos[i]+']').attr('disabled',true);
          }
          var cont = 0;
          var data = [];
          for (var i in request.result.factura[0].conceptos) {
            data[cont] = {
              'clave_unidad': request.result.factura[0].conceptos[i].productos.clave_unidad
              ,'cantidad'   : request.result.factura[0].conceptos[i].cantidad
              ,'descripcion': request.result.factura[0].conceptos[i].productos.nombre
              ,'precio'     : request.result.factura[0].conceptos[i].precio
              ,'total'      : request.result.factura[0].conceptos[i].total
            };
            cont++;
          }
          data_table_general(data,'table_conceptos');

      }else{
          toastr.error(request.message,'Ocurrio un error Favor de Verificar');
      }

  });

  upload_file(fields ,url,message2,null,id_div,'.pdf,.txt,jpeg,.jpg,.png',function( request ){
      var request = JSON.parse(request); 
      console.log(request);
       if(request.success == true ){
           if( isset(request.result.ruta_file) ){
             jQuery('#archivo_edit').val(request.result.ruta_file);
             return;
           }
       }else{
         toastr.error(request.message,'Ocurrio un error Favor de Verificar');
       }

   });
