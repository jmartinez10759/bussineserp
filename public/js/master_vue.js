let title       = "Registros Correctos";
let success_mgs = "Registro insertado corretamente.";
let error_mgs   = "Ocurrio un error, Favor de verificar";
let title_error = "Registros Incorrectos";
let update      = "Registro actualizado corretamente";
let validate    = "Favor de Verificar los campos color Rojo";
let expired     = "Ocurrio un Error, Favor de Verificar";
let session_expired = "Expiro su sesión, favor de ingresar al portal";
//let csrf_token  = { 'X-CSRF-TOKEN': document.getElementsByTagName("META")['3'].content }
//var _method     = 'GET, POST, PATCH, PUT, DELETE, OPTIONS';
var content_type = 'application/json';
//var csrf_token  = { 'X-CSRF-TOKEN': meta('csrf-token'),'Access-Control-Request-Method':_method, 'Content-Type' : content_type };
var csrf_token  = { 'X-CSRF-TOKEN': meta('csrf-token'), 'Content-Type' : content_type };
var _token      = csrf_token[ Object.keys( csrf_token )[0] ];
var params = {};
var mixins = {
    computed:{
      is_actived: function() { return this.pagination.current_page; },
      pages_number: function() {
        if(!this.pagination.to){
          return [];
        }
        var from = this.pagination.current_page - this.offset;
        if(from < 1){
          from = 1;
        }
        var to = from + (this.offset * 2);
        if( to >= this.pagination.last_page ){
           to = this.pagination.last_page;
        }
        var pagesArray = [];
        while( from <= to ){
          pagesArray.push( from );
          from++;
        }
        return pagesArray;
      }
    },
    methods: {

        get_general: function( url, fields ) {
            axios.get( url, { params: fields }, csrf_token ).then(response => {
                console.log( response.data.result );
                if( response.data.success == true ){
                  this.datos = response.data.result;
                }else{
                    //toastr.error( response.data.message, "Ningun Registro Encontrado" );
                }
            }).catch(error => {
                toastr.error( error, expired );
            });

        },
        edit_general: function( obj, modal ) {

            console.log(obj);
            for ( var i in this.fillKeep){
                this.fillKeep[i] = obj[i];
            }
            jQuery(`#${modal}`).modal('show');

        },
        insert_general: function( uri, url, function_success , function_errors ) {
            axios.post(uri, this.newKeep, csrf_token ).then(response => {
                if (response.data.success == true) {
                    this.get_general( url, params, csrf_token );
                    for( var i in this.newKeep ){
                        this.newKeep[i] = "";
                    }
                    jQuery('#create_form').modal('hide');
                    toastr.success( response.data.message , title );
                    function_success( response.data );

                }else{
                    for( var i in this.newKeep ){
                        this.newKeep[i] = "";
                    }
                    toastr.error( response.data.message,title_error );
                    function_errors();
                }


            }).catch(error => {
                toastr.error( error,expired );
            });

        },
        update_general: function( uri, url, modal ) {

            axios.put(uri, this.fillKeep, csrf_token ).then(response => {

                if ( response.data.success == true ) {

                    this.get_general( url, params, csrf_token );
                    for( var i in this.newKeep ){
                        this.newKeep[i] = "";
                    }
                    jQuery('#'+modal).modal('hide');
                    toastr.info( update,title );

                }else{
                    toastr.error( response.data.message,title_error );
                }

            }).catch(error => {
                toastr.error( error, expired );
            });

        },
        delete_general: function( uri ,refresh ,keep ) {
              var url = `${uri}/${keep}`;
              axios.delete(url, params, csrf_token).then(response => { //eliminamos
                    this.get_general(refresh, params, csrf_token ); //listamos
                    toastr.success('Registro eliminado correctamente',title); //mensaje
                }).catch(error => {
                    toastr.error( error, expired );
                });

        },
        validate_form: function(){
            jQuery.each(this.newKeep,function(key, value){
                if (value == "" || value == false) {
                    jQuery(`#${key}`).parent().parent().addClass('has-error');
                    return;
                }
            });

        },
        show_general: function( url, fields, function_success, function_errors){
            axios.get( url, { params: fields }, csrf_token ).then( response => {
                console.log( response.data.result );
                if (response.data.success == true) {
                    //this.function_success(response.data.result);
                    function_success(response.data.result);
                }else{
                    function_errors();
                }
            }).catch(error => {
                toastr.error( error, expired );
            });

        },
        all_register: function( url, fields, propiedad ){

          axios.get( url, { params: fields }, csrf_token ).then( response => {

              if (response.data.success == true) {
                  this[propiedad] = response.data.result;
                  console.log(this[propiedad]);
              }
          }).catch(error => {
              toastr.error( error, expired );
          });

        }

        ,insert_controller:function(url, fields, method  ){
          axios.post(url, fields , csrf_token ).then(response => {
              if (response.data.success == true) {
                  if(isset(method)){
                    this[method]();
                  }
                  toastr.success( response.data.message , title );
              }else{
                  toastr.error( response.data.message,title_error );
              }
          }).catch(error => {
              toastr.error( error,expired );
          });

        }
        ,master_controller(url,fields, headers,methods,_method ){
            var header = isset(headers)? headers: csrf_token;
            axios.defaults.headers = header;
            axios[methods](url, fields ).then( response => {
                if (response.data.success == true) {
                    if(isset(_method)){
                      this[_method]( response.data );
                    }
                    toastr.success( response.data.message , title );
                }else{
                    toastr.error( response.data.message, title_error );
                }
            }).catch(error => {
                toastr.error( error,expired );
            });

        }
        ,reportes_pdf( fields, options ){
            var pdf = new jsPDF( {orientation: 'landscape'});
            var columns  = (isset(fields.columnas))? fields.columnas : [];
            var titulo   = (isset(fields.titulo))? fields.titulo : "";
            var data     = (isset(fields.datos))? fields.datos : {};

            for (var i = 0; i < data.length; i++) {
              pdf.text(20,20,titulo+" "+data[i][0][0]);
              pdf.autoTable( columns,data[i], options );
              pdf.addPage();
            }

            $.fancybox.open({
              'type': 'iframe'
              ,'src': pdf.output('datauristring')
              ,'buttons' : ['share', 'close']
            });
            //pdf.save('Reporte Mensual.pdf');
            //return;

        }
        ,reportes_csv( fields ){

          var columns  = (isset(fields.columnas))? fields.columnas : [];
          var titulo   = (isset(fields.titulo))? fields.titulo : "";
          var datos     = (isset(fields.datos))? fields.datos : {};

          jQuery('#excel').jexcel({
            data:datos
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
        ,format_date( request, format ){
            var d = new Date(request);
            if( format === "yyyy-mm-dd"){
              return d.getFullYear() + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" +  ("0" +(d.getDate())).slice(-2);
            }else{
              return ("0" + d.getDate()).slice(-2) + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" + d.getFullYear();
            }
        }
         ,suma_dias_fecha(fecha1, dias ,format = "yyyy-mm-dd") {
            var Fecha = new Date(fecha1);
            var sFecha = fecha || (Fecha.getDate() + "/" + (Fecha.getMonth() + 1) + "/" + Fecha.getFullYear());
            var sep = sFecha.indexOf('/') != -1 ? '/' : '-';
            var aFecha = sFecha.split(sep);
            var fecha = aFecha[2] + '/' + aFecha[1] + '/' + aFecha[0];
            fecha = new Date(fecha);
            fecha.setDate(fecha.getDate() + parseInt(dias));
            var anno = fecha.getFullYear();
            var mes = fecha.getMonth() + 1;
            var dia = fecha.getDate();
            mes = (mes < 10) ? ("0" + mes) : mes;
            dia = (dia < 10) ? ("0" + dia) : dia;
            var fechaFinal = (format === "yyyy-mm-dd") ? anno + "-" + mes + "-" + dia : dia + "-" + mes + "-" + anno;
            return (fechaFinal);
        }

    }
};

/*

new Vue({
  el: "#vue-general",
  created: function () {
    this.consulta_general();
  },
  data: {
    datos: [],
    newKeep: {

    },
    fillKeep: {

    },

  },
  mixins : [mixins],
  methods:{
    consulta_general: function(){}
  }


});

*/
