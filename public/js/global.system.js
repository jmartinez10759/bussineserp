/**
 *@author Jorge Martinez Quezada
 *@Creacion de funciones en js globales para utilizarlas.
 */

if (detectIE()) {
    // window.location.replace("error-ie");
}
$().ready(function () {

});

/**
 *Se crea una funcion para debuger la ejecucion del front
 *@access {public}
 *@param {element} [description]
 *@return {json}
 */
debuger = function (element) {

    var salida = "";
    for (var p in element) {
        salida += p + ": " + element[p];
    }
    alert(JSON.stringify(element));
    console.log(element);
    alert(salida);
    return;

}

function debug(arra) {
    alert(dump_var(arra));
}

function dump_var(arr, level) {
    // Explota un array y regres su estructura
    // Uso: alert(dump_var(array));
    var dumped_text = "";
    if (!level) level = 0;
    //The padding given at the beginning of the line.
    var level_padding = "";
    for (var j = 0; j < level + 1; j++) level_padding += "    ";
    if (typeof (arr) == 'object') { //Array/Hashes/Objects
        for (var item in arr) {
            var value = arr[item];
            if (typeof (value) == 'object') { //If it is an array,
                dumped_text += level_padding + "'" + item + "' ...\n";
                dumped_text += dump_var(value, level + 1);
            } else {
                dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
            }
        }
    } else { //Stings/Chars/Numbers etc.
        dumped_text = "===>" + arr + "<===(" + typeof (arr) + ")";
    }
    return dumped_text;
}

function formData(selector, template) {
    /**
     * Descripcion:  Crea un objeto recuperando los valores ingresados en los campos INPUT
     * Comentario:   Los elementos html deben estar dentro de un mismo <div> y tiene que
     *               tener el atributo:data-campo="[nombre_campo]"
     * Ejemplo:      <div id="formulario"><input id="id_orden" type="hidden" data-campo="id_orden" value="{id_orden}" /></div>
     *               <script> var objData = formData('#formulario'); </script>
     * @author:      Jorge Martinez
     */
    var data = template ? template : {}; // Valores predeterminados - Opcional
    var c, f, r, v, m, $e, $elements = jQuery(selector).find("input, select, textarea");
    for (var i = 0; i < $elements.length; i++) {
        $e = jQuery($elements[i]);
        // alert($elements[i]['id']);
        f = $e.data("campo");
        r = $e.attr("required") ? true : false;
        // validación de que exista un elemento

        if (!f) continue;

        // Recolección datos por tipo de elemento
        v = undefined;
        switch ($e[0].nodeName.toUpperCase()) {
            case "LABEL":
                v = $e.text();
                break;
            case "INPUT":
                var type = $e.attr("type").toUpperCase();
                if (type == "TEXT" || type == "HIDDEN" || type == "PASSWORD") {
                    v = jQuery.trim($e.val());
                } else if (type == "CHECKBOX") {
                    v = $e.prop("checked");
                } else if (type == "RADIO") {
                    if ($e.prop("checked")) {
                        v = $e.val();
                        // alert($e.prop("id"));
                    }
                } else if ($e.datepicker) {
                    v = $e.datepicker("getDate");
                } else {
                    v = jQuery.trim($e.val());
                }
                break;
            case "TEXTAREA":
            default:
                v = jQuery.trim($e.val());
        }

        // Guarda el valor en el objeto
        if (r && (v == undefined || v == "")) {

            m = $e.data("mensaje");
            if (m)
                alert(m);
            else
                alert("Es necesario especificar un valor para el campo \"" + f + "\".");
            $e.focus();
            return null;
        } else if (v != undefined) {
            data[i] = v;
            data[f] = v;
        }


    } // next
    return data;
}
/**
 *Función que devuelve una repuesta de la peticion solicitada por GET, POST
 * @param request {object} Objeto de petición
 * @param response {object} Objeto de respuesta HTTP
 * @example
 * @param callback recide el data
 * @param pathUrl recide el controller o URL
 * @param type recide POST, GET
 * @param dataquery recibe los parametros que seran enviados por get o post
 * @returns {json} Obtiene la respuesta de la peticion solicitada
 * GET / HTTP 1.1 POST / HTT 1.1
 * EJEMPLO:
    requestAjaxSend('prueba/ejemplo', {id:1}, function(data){
        console.log(data);
    }, false, false, false, false,  'GET', 'html');
 */
function requestAjaxSend(pathUrl, data, success, beforeSend, error, complete, done, type, dataType, async) {

    var dataType = dataType ? dataType : 'json',
        type = type ? type : 'POST',
        beforeSend = beforeSend ? beforeSend : function () {},
        error = error ? error : function () {},
        complete = complete ? complete : function (xhr) {
            //check_status_xhr(xhr.status);
        },
        done = done ? done : function () {},
        async = async ?async :true;
    return $.ajax({
        async: async,
        type: type,
        url: pathUrl,
        data: data,
        dataType: dataType,
        beforeSend: function (b) {
            beforeSend(b);
        },
        success: function (data) {
            //check_session(data);
            success(data);
        },
        error: function (e) {
            error(e);
        },
        complete: function (c) {
            complete(c);
        },
        done: function () {
            done();
        }
    });

}
/**
 * Verifica la sesion del usuario
 * @param  {json} data respuesta de una llamada ajax
 * @return {void}
 */
function check_session(data) {
    if (data.session_destroy) {
        swal({
            title: sessionLang['title'],
            text: sessionLang['content'],
            timer: 5000,
            showConfirmButton: true,
            confirmButtonText: generalLang['aceptar']
        }).then(
            function (acept) {
                location.href = 'inicio';
            },
            function (dismiss) {
                location.href = 'inicio';
            }
        );
    }
}
/**
 *    // Envío de valores vía POST a una URL
 *    // var objData = 'simple';
 *    // var objData = new Array;    objData.push('arrelgo1'); objData.push('arrelgo2');
 *    // var objData = {id: 1, name: 'oscar', value: 'valores'};
 */
function send_post(data, url, target, debug) {
    if (data && url) {
        var elements, keys = false;
        var n = Math.floor((Math.random() * 100) + 1); //1 al 100
        target = (!target) ? '_self' : target;
        // Crea formulario
        var form = document.createElement("form");
        form.setAttribute("id", "frm-" + n);
        form.setAttribute("method", "post");
        form.setAttribute("action", url);
        form.setAttribute("target", target);
        // Contruccion de inputs
        if (data.constructor === String || data.constructor === Number) {
            // Simple: un solo dato - String
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("id", "id");
            hiddenField.setAttribute("name", "id");
            hiddenField.setAttribute("value", data);
            form.appendChild(hiddenField);
        } else if (data.constructor === Array) {
            // Array: arreglo simple - ['1','2','n']
            elements = data.length;
            var hiddenField = new Array;
            for (var i = 0; i < elements; i++) {
                hiddenField[i] = document.createElement("input");
                hiddenField[i].setAttribute("type", "hidden");
                hiddenField[i].setAttribute("id", "input-" + i);
                hiddenField[i].setAttribute("name", "input-" + i);
                hiddenField[i].setAttribute("value", data[i]);
                form.appendChild(hiddenField[i]);
            }
        } else if (data.constructor === Object) {
            // Object: arreglo asociativo - {id: 1, name: 'oscar', value: 'valores'}
            elements = Object.keys(data).length;
            keys = Object.keys(data);
            var hiddenField = new Array;
            for (var i = 0; i < elements; i++) {
                hiddenField[i] = document.createElement("input");
                hiddenField[i].setAttribute("type", "hidden");
                hiddenField[i].setAttribute("id", keys[i]);
                hiddenField[i].setAttribute("name", keys[i]);
                hiddenField[i].setAttribute("value", data[keys[i]]);
                form.appendChild(hiddenField[i]);
            }
        }
        document.body.appendChild(form); //Muestra formulario en el documento
        if (debug) {
            return false;
        } else {
            form.submit(); //Envía datos a URL
        }
    } else {
        return false;
    }

}
/**
 * Redirecciona a la url recibida
 * @param  {txt} uri recibida
 * @return {void}
 */
function redirect(url) {
    url = (url) ? url : '';    
    if(url){
        location.href = url;
       }else{
         setTimeout('location.reload(true)', 1200 );
           //setTimeout('redirect( domain("/") )',1500);
       }

}
/**
 * Valida formulario usando jquery.validate
 * @param  {idObj} ID del DOM HTML
 * @param  {rules} Objeto JSON con relgas de validación
 * @param  {messages} Objeto JSON con mensajes para cada regla
 * @return {void}
 */
function frmValidate(idObj, rules, messages) {
    // Mensajes
    var messages_default = {
        required: validatorLang['required'],
        remote: validatorLang['remote'],
        email: validatorLang['email'],
        url: validatorLang['url'],
        date: validatorLang['date'],
        dateISO: validatorLang['dateISO'],
        number: validatorLang['number'],
        digits: validatorLang['digits'],
        creditcard: validatorLang['creditcard'],
        equalTo: validatorLang['equalTo'],
        accept: validatorLang['accept'],
        maxlength: validatorLang['maxlength'],
        minlength: validatorLang['minlength'],
        rangelength: validatorLang['rangelength'],
        range: validatorLang['range'],
        max: validatorLang['max'],
        min: validatorLang['min']
    };
    jQuery.extend(jQuery.validator.messages, messages_default);
    if (!messages) messages = messages_default;
    // Selects
    // jQuery.validator.setDefaults({ ignore: ":hidden:not(select)" });
    // Inicializa
    jQuery(idObj).validate({
        ignore: '.ignore, .select2-input',
        rules: rules,
        messages: messages,
        errorElement: 'div',
        errorPlacement: function (error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
        }
    });

}
// MODALES
/**
 *Funcion para construir un modal
 *@param string uri [description]
 *@return void
 */
function buildModal(uri) {
    if (uri) {
        $.ajax({
            type: "POST",
            url: uri,
            dataType: 'json',
            data: {},
            success: function (data) {
                if (data.success) {
                    jQuery("#modal-custom").empty();
                    jQuery("#modal-custom").append(data.modal);
                    $('#' + data.id).openModal();
                }
            }
        });
    }
}

function buildModalTimeout(uri, timeout) {
    if (uri) {
        timeout = (!timeout) ? 2000 : timeout;
        jQuery.ajax({
            type: "POST",
            url: uri,
            dataType: 'json',
            data: {},
            success: function (data) {
                if (data.success) {
                    jQuery("#modal-custom").empty();
                    jQuery("#modal-custom").append(data.modal);
                    jQuery('#' + data.id).openModal();
                    setTimeout(function () {
                        jQuery('#' + data.id).closeModal();
                    }, timeout);
                    setTimeout(function () {
                        jQuery("#modal-custom").empty();
                    }, timeout + 1000);
                }
            }
        });
    }
}
// Fin MODALES
/**
 * Contruye una notificación toast
 * @param  {string} mensaje mensaje de la notificacion
 * @param  {sring} clase   clase de la notifiacion
 * @param  {int} tiempo  tiempo en mili segundos de duracion
 * @return {void}
 */
function buildToast(mensaje, clase, tiempo, completeCallBack) {
    mensaje = mensaje ? mensaje : 'Toast';
    tiempo = tiempo ? tiempo : 5000;
    callback = completeCallBack ? completeCallBack : function () {};
    clase = clase ? clase : 'green';
    Materialize.toast(mensaje, tiempo, clase, callback);

}
/**
 *Funcion para construir el sweetalert
 *@param {titulo} [type][description]
 *@param {mensaje} [type][description]
 *@param {clase} [type][description]
 */
function buildSweetAlert(titulo, mensaje, clase, tiempo) {
    var timer = (tiempo) ? tiempo : "";
    swal(
        titulo,
        mensaje,
        clase,
        timer
    );
}
/**
 *Funcion para construir el sweetalert
 *@param {titulo} [type][description]
 *@param {mensaje} [type][description]
 *@param {clase} [type][description]
 */
function pnotify(titulo, mensaje, clase) {
    new PNotify({
        title: titulo,
        text: mensaje,
        type: clase
    });
}
/**
 *Funcion
 *@param {titulo} [type][description]
 *@param {mensaje} [type][description]
 *@param {success} [type][description]
 *@return void
 */
function buildSweetAlertOptions(titulo, mensaje, success, type_message, status_cancel_button, buttonText) {

    /*swal({
          title: titulo,
          text: mensaje,
          type: type_message,
          showCancelButton: status_cancel_button,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: buttonText[0],
          cancelButtonText: buttonText[1],
          confirmButtonClass: "btn btn-info",
          cancelButtonClass: 'btn btn-danger',
          buttonsStyling: false,
          allowOutsideClick: false,
          closeOnConfirm: true,
          closeOnCancel: true
    }).then(function () {
        success();
    }, function (dismiss) {
        if (dismiss === 'cancel') {

        }
    });*/

    swal({
            title: titulo,
            text: mensaje,
            type: type_message,
            showCancelButton: status_cancel_button,
            confirmButtonClass: "btn btn-info",
            confirmButtonText: buttonText[0],
            cancelButtonText: buttonText[1],
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {
                success();
            } else {}

        });

}
/**
 * Carga de selects
 * @param  {strin} url    [URL del servidor]
 * @param  {int} id     [id del elemento]
 * @param  {String} load   [#id del elemento donde se carga]
 * @param  {String} select [id del select cargado]
 * @return {Void}
 * var url = 'entidades/get_entidades',
        load = 'load-entidades',
        select = 'id_entidad';
    loadItemSelect(url, id_pais, load, select);
 */
var loadItemSelect = function (url, data, load, select) {
    console.log('#' + select);
    requestAjaxSend(url, data, function (data) {
        $('#' + load).html(data);
        $('#' + select).material_select();
    }, function () {
        $('#' + load).html('<div class="progress"><div class="indeterminate"></div></div>');
    });
}
/**
 * Carga de selects dependientes
 * @param  {strin} url    [URL del servidor]
 * @param  {object} data     [variables en objeto]
 * @param  {String} load   [#id del elemento donde se carga]
 * @param  {String} select [id del select cargado]
 * @return {Void}
 * var  url = 'entidades/get_entidades',
        data = {id_opcion: 1, id_cliente: 1},
        load = 'load-entidades',
        select = 'id_entidad';
    loadItemSelect(url, data, load, select);
 */
var loadFormSelect = function (url, data, load, idselect) {
    requestAjaxSend(url, data, function (select) {
        $('#' + load).html(select);
        $('#' + idselect).material_select();
    }, function () {
        $('#' + load).html('<div class="progress"><div class="indeterminate"></div></div>');
    });
}

/**
 * funcion para resetear los select dependientes cargados de un formulario
 * @param {object} data identificador del select para resetear
 * @example valor del objeto data
 * data = [{0:'select.sede'},{0:select#tipo_empleado}]
 */
var reset_select_dependientes = function (data) {
    $(data).each(function (key, obj) {
        $(obj[0] + ' option').each(function (index, option) {
            if (index > 0) {
                $(this).remove();
            }
        });
        $(obj[0]).prop('selectedIndex', 0); //Sets the first option as selected
        $(obj[0]).material_select();
    });
}

var getIdsMenu = function (name) {
    var ids_menus = [];
    $('input[name=' + name + ']:checked').each(function () {
        ids_menus.push($(this).val());
    });
    return ids_menus;
}
/**
 *Detección de iExplorer
 *@return integer [description]
 */
function detectIE() {
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf('MSIE ');
    if (msie > 0) {
        // IE 10 or older => return version number
        return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
    }
    var trident = ua.indexOf('Trident/');
    if (trident > 0) {
        // IE 11 => return version number
        var rv = ua.indexOf('rv:');
        return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
    }
    // var edge = ua.indexOf('Edge/');
    // if (edge > 0) {
    //    // IE 12 => return version number
    //    return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
    // }
    // other browser
    return false;
}

function selects_requeridos(formulario) {
    var items_vacios = 0;
    var padre = (formulario) ? '#' + formulario + ' ' : '';

    jQuery(padre + " .requerido").each(function () {
        if (jQuery(this).prop('tagName') == 'SELECT') {
            var attr = $(this).attr('multiple');
            if (typeof attr !== typeof undefined && attr !== false) {
                if (!jQuery.trim(jQuery("[name='" + jQuery(this).attr('name') + "'] option")).length > 0) {
                    items_vacios++;
                    ids = jQuery(this).attr('name') + '|' + ids;
                }
                if (!jQuery.trim(jQuery("[name='" + jQuery(this).attr('name') + "'] option:selected")).length > 0) {
                    items_vacios++;
                    ids = jQuery(this).attr('name') + '|' + ids;
                }
            } else {
                var select = jQuery("select[name='" + jQuery(this).attr('name') + "'] option:selected");
                var select_empty = jQuery("select[name='" + jQuery(this).attr('name') + "']");
                var select_focus = jQuery("select[name='" + jQuery(this).attr('name') + "']").closest('div');
                var name = jQuery(this).attr('name');

                var msg = '<div id="' + name + '-error" class="error-select"> ' + formValidateLang.required + '</div>';
                if (!select.val()) {

                    select_focus.focus();
                    $('#' + name + '-error').remove();
                    select_focus.append(msg);
                    select_empty.change(function () {
                        $('#' + name + '-error').remove();
                    });
                    items_vacios++
                }
            }

        }
    });
    return items_vacios;
}


function values_enteros(formulario) {
    var padre = (formulario) ? '#' + formulario + ' ' : '';
    var enteros = true;

    jQuery(padre + " .digit").each(function () {
        var name = $(this).attr('name');
        var msg = '<div id="' + name + '-error-input" class="error-select"> ' + formValidateLang.digits + '</div>';
        if (isInt(jQuery(this).val())) {} else {
            var name = $(this).attr('name');
            var item = $(this).closest('div');
            $('#' + name + '-error-input').remove();
            item.append(msg);
            $(this).focus(function (event) {
                $('#' + name + '-error-input').remove();
            });
            enteros = false;
        }
    });
    return enteros;
}
/**
 * Comprueba si un valor es de tipo entero
 * @return {Boolean}   [devuelve true si es entero, false si no lo es]
 */
function isInt(x) {
    var y = parseInt(x, 10);
    return !isNaN(y) && x == y && x.toString() == y.toString();
}
/**
 *Funcion para la carga de los estilos de la tabla de bootstraps
 *@param id [description]
 *@return void
 */
function initDataTable(id) {
    jQuery('#' + id).DataTable({
        /*fnInitComplete: function(a, t) {
                var l = jQuery(this).parents(".dataTables_wrapper").eq(0);
                l.find(".dataTables_length").addClass("input-field"), l.find(".dataTables_length label select").prependTo(l.find(".dataTables_length")), l.find(".dataTables_length select").material_select(), l.find(".dataTables_filter").addClass("input-field"), l.find(".dataTables_filter").addClass("without-search-bar"), l.find(".dataTables_filter label input").prependTo(l.find(".dataTables_filter"))
            },*/
        "language": {
            "lengthMenu": "Mostrar _MENU_",

            "zeroRecords": "Sin Registros",
            "info": "Página _PAGE_ de _PAGES_",
            "infoEmpty": "Sin Registros",
            "infoFiltered": "(Resultado de _MAX_ registros)",
            'search': 'Búsqueda'
        },
        "searching": true,
        "scrollX": false,
        "responsive": true,
        "details": true,
        "dom": "<'row no-gutter'\t<'col s12 m2'l>\t<'col s12 offset-m6 m4'f>><''tr><'row no-gutter'\t<'col s12 m4'i>\t<'col s12 m8'p>>",
        "iDisplayLength": 10,
        "bFilter": false,
        "aaSorting": [[0, "asc"]],
        fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            /*if ( aData[0] % 2 == 1 ){
                jQuery('td', nRow).css('background-color', '#ffffff');
            }else {
                jQuery('td', nRow).css('background-color', '#eeeeee');
            }
            jQuery('td', nRow).css('border-left', '1px solid #dddddd');
            jQuery('td', nRow).css('font-size', '12px');*/
        }
    });

}
/**
 * checa el status http de la petición, por default se mandan mensajes de errores del
 * status 500 error del servidor
 * @param  {[type]} status      [description]
 * @param  {[type]} title       [description]
 * @param  {[type]} text        [description]
 * @param  {[type]} type        [description]
 * @param  {[type]} showMessage [description]
 * @param  {[type]} accept      [description]
 * @param  {[type]} dismiss     [description]
 * @return {[type]}             [description]
 */
function check_status_xhr(status, title, text, type, accept) {
    var showMessage = false,
        title = title ? title : generalLang['error'],
        text = text ? text : xhrStatusLang['error500Msg'],
        type = type ? type : 'error',
        accept = accept ? accept : function () {};
    switch (status) {
        case 500:
            showMessage = true;
            break;
    }
    if (showMessage) {
        swal({
            title: title,
            text: text,
            showConfirmButton: true,
            confirmButtonText: generalLang['aceptar'],
            type: type,
            allowOutsideClick: false
        }).then(
            function (a) {
                accept(a);
            },
            function (d) {

            }
        );
    }

}
/**
 * Funcion para validar los campos que se requieren
 * @param array validacion [description]
 * @return void
 */
function validacion_fields(validacion) {
    if (typeof validacion == "object") {
        for (var i = 0; i < validacion.length; i++) {
            var valores = jQuery('#' + validacion[i]).val();
            //if (valores == "" || valores == 0 || valores == "null") {
            if (valores == "" || valores == "null") {
                jQuery('#' + validacion[i]).parent().parent().addClass('has-error');
                toastr.error('Favor de verificar los campos de color rojo!', title);
                // pnotify('Campos Vacios','Favor de verificar los campos de color rojo!','error');
                return 'error';
            } else {
                jQuery('#' + validacion[i]).parent().parent().removeClass('has-error');
            }
        };
    }
}
function validacion_select(validacion) {
    if (typeof validacion == "object") {
        for (var i = 0; i < validacion.length; i++) {
            var valores = jQuery('#' + validacion[i]).val();
            if (valores == "" || valores == 0 || valores == "null") {
            //if (valores == "" || valores == "null") {
                jQuery('#' + validacion[i]).parent().parent().addClass('has-error');
                toastr.error('Favor de verificar los campos de color rojo!', title);
                // pnotify('Campos Vacios','Favor de verificar los campos de color rojo!','error');
                return 'error';
            } else {
                jQuery('#' + validacion[i]).parent().parent().removeClass('has-error');
            }
        };
    }
}
/**
 *Funcion para cargar los valores de cada campo
 *@param json data [description]
 *@return void
 */
function get_values(json) {
    $.each(json, function (key, values) {
        $('#' + key).val(values);
    });
}
/**
 *Funcion para cargar los valores de cada campo
 *@param array arreglo [description]
 *@return void
 */
function clear_values_input(arreglo) {
    for (var i = 0; i < arreglo.length; i++) {
        $('#' + arreglo[i]).val('');
        $('.' + arreglo[i]).val('');
    }
}
function clear_values_select( arreglo ) {
    for (var i = 0; i < arreglo.length; i++) {
        $('#' + arreglo[i]).val(0);
        $('.' + arreglo[i]).val(0);
        
        $('#' + arreglo[i]).selectpicker('val',[0]);
        $('#' + arreglo[i]).selectpicker('val',[0]);
    }
}
/**
 *Funcion para la carga de archivos al servidor por medio de dropzone
 *@param id [type] [description]
 *@param url [type][description]
 *@param maxfile [type][description]
 *@param type_file [type][description]
 *@param methods [type][description]
 *@return void
 */
upload_file = function (fields, path_url, messages, maxfile, ids, type_file, methods) {
    var message = (messages != "") ? messages : "Dar Clic aquí o arrastrar archivo";
    jQuery('#modal_dialog').css('width', '60%');
    Dropzone.autoDiscover = false;
    jQuery('#' + ids['div_content']).html('<div class="dropzone" id="' + ids['div_dropzone'] + '" height="20px"><div class="fallback"><input name="' + ids['file_name'] + '" type="file" multiple/></div></div>').ready(function () {
        var jsonResponse;
        jQuery("#" + ids['div_dropzone']).dropzone({
            uploadMultiple: true,
            url: path_url,
            maxFiles: maxfile,
            paramName: "file",
            //timeout: 180000, /*milliseconds*/
            //maxFilesize: 256,
            createImageThumbnails: true,
            acceptedFiles: type_file,
            dictDefaultMessage: message,
            dictFallbackMessage: "No se pudo subir el archivo, favor de verificar",
            dictFileTooBig: "Archivo demasiado grande, intente cargar otro archivo",
            dictInvalidFileType: "Archivo incorrecto",
            dictResponseError: "No se pudo subir el archivo, favor de verificar",
            dictCancelUpload: "Eliminar",
            dictCancelUploadConfirmation: "¿Deseas Cancelar el Archivo?",
            dictRemoveFile: "Eliminar Archivo",
            dictMaxFilesExceeded: "No se puede subir mas archivos de los permitidos",
            params: fields,
            headers: {
                'usuario': jQuery('#id_usuario').val(),
                'token': jQuery('#token').val(),
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            dictRemoveFile: true,
            addRemoveLinks: true,
            success: function (data, datos) {
//                var jsonRequest = JSON.parse(datos);
//                   if (jsonRequest.success === true) {
//                        toastr.success( jsonRequest.message, '¡Archivo Cargado!' );
//                   }else{
//                        toastr.error( jsonRequest.message, '¡No se Cargo Correctamente!' );
//                   }
                methods(datos);

            },
            accept: function (file, done) {
                if (file.name == "imagen.jpg") {
                    done("Archivo Incorrecto");
                } else {
                    done();
                }
            },
            sending: function (parmt1, parmt2, data) {
                //data.append('datos', params );
                //$('.loader').show();
                //$('#dropzone_div').hide();
            },
            init: function () {
                // this.on("complete", function(file) {
                //     //this.removeAllFiles(true);
                // });
            },
            complete: function (data) {
                console.log(data);
                if (data.status == 'error') {
                    toastr.error('No se cargo correctamente el archivo');
                }
                //this.removeAllFiles(true);
                //pnotify('Archivo Cargado.!','El archivo seleccionado se cargo con exito','success');
                /* swal(
                  'Archivo Cargado Correctamente.!',
                  datos.response.mgs,
                  'success'
                );*/
            }

        });

    });

}
/**
 *Funcion para crear la descarga del layout en general
 *@param [type] [description]
 *@param [type] [description]
 *@return void
 */
function download_layout_general(url, data) {
    var fields = {
        'data': data
    };
    send_post(fields, url, false, false);
}
/**
 *Funcion para crear la descarga del pdf en general
 *@param [type] [description]
 *@param [type] [description]
 *@return void
 */
function download_pdf_general(url, data, success) {
    var fields = {
        'data': data
    };
    //send_post(fields,url,false,false);
    requestAjaxSend(url, fields, function (mgs) {
        success(mgs);
    });
}
/**
 *Funcion para contar los dias trancurridos
 *@param fecha1
 *@param fecha2
 *@return date
 */
restaFechas = function (fecha1, fecha2) {
    var aFecha1 = fecha1.split('-');
    var aFecha2 = fecha2.split('-');
    /*formato de aaaa/mm/dd */
    var fFecha1 = Date.UTC(aFecha1[2], aFecha1[1] - 1, aFecha1[0]);
    var fFecha2 = Date.UTC(aFecha2[2], aFecha2[1] - 1, aFecha2[0]);
    var dif = fFecha2 - fFecha1;
    var dias = Math.floor(dif / (1000 * 60 * 60 * 24));
    return dias;
}
suma_dias_fecha = function (fecha1, dias) {
    var fecha = new Date(fecha1);
    var dias = (dias) ? dias : 2; // Número de días a agregar
    var fecha_actual = fecha.setDate(fecha.getDate() + dias);
    return fecha_actual;
}
/**
 *Funcion para contar los dias trancurridos
 *@param fecha1
 *@param fecha2
 *@return date
 */
convert_date = function (fecha) {
    var fechas = fecha.split('-');
    var anio = fechas[0];
    var mes = fechas[1];
    var dia = fechas[2];
    var fnew = dia + "-" + mes + "-" + anio;
    return fnew;
}
/**
 *Funcion para validar si las fecha inicial es menor a la final
 *@param fecha1 [description]
 *@param fecha2 [description]
 *@return json
 */
validate_date = function (fecha1, fecha2) {
    var fecha_inicial = new Date(fecha1);
    var fecha_fin = new Date(fecha2);
    if (fecha2 < fecha1) {
        return false;
    } else {
        return true;
    }
}
/**
 *Function creada para la creacion de LocalStorage y SessionStorage
 *@param
 *@return object
 */
$myLocalStorage = (function () {
    var name = null;
    return {
        set: function (k, value) {
            localStorage.setItem(k, JSON.stringify(value));
        },
        get: function (k) {
            var data = localStorage[k];

            if (data === undefined) throw 'Clave No Localizada';

            return JSON.parse(data);
        },
        remove: function (k) {
            localStorage.removeItem(k);
        }
    };
})();
/**
 *Funcion para generar una cadena en un arreglo de varios registros
 *@access public
 *@param table [description]
 *@param identificador [description]
 *@return array[description]
 */
table_matrix = function (table, identificador) {
    var matrix = [];
    var conteo = 0;
    $('#' + table + ' tbody').find('tr').each(function () {
        var response = "";
        response += $(this).attr(identificador) + "|";
        $(this).find('td').each(function () {
            console.log($(this).text());
            response += $(this).text() + "|";
        });
        matrix[conteo] = response;
        conteo++;
    });
    return matrix;
}
/**
 *Se accesde a los metas de html para otener el contenido.
 *@access {{public}}
 *@param {{name}}
 *@return {{@content}}
 */
meta = function (name) {
    var ruta_general = document.getElementsByTagName("META");
    var content = "";
    for (var i = 0; i < ruta_general.length; i++) {
        if (ruta_general[i].name == name) {
            content = ruta_general[i].content;
        }
    }
    return content;
}
/**
 *Funcion para obtener el dominio actual.
 *@access public
 *@param table [description]
 *@param identificador [description]
 *@return array[description]
 */
domain = function (url) {
    //var path_url = window.location.origin+window.location.pathname+"/"+url;
    var ruta_general = document.getElementsByTagName("META");
    var content = "";
    for (var i = 0; i < ruta_general.length; i++) {
        if (ruta_general[i].name == 'ruta-general') {
            content = ruta_general[i].content;
        }
    }
    var meta = content.split('/');
    var ruta = window.location.href.split("/");
    var http = window.location.protocol;
    var host = window.location.host;
    var public = (typeof ruta[4] != "undefined" && ruta[4] == "public") ? ruta[4] + "/" : "";
    var project = (typeof ruta[3] != "undefined") ? ruta[3] + "/" : "";

    if (typeof meta[1] != "undefined" && meta[1] == "index.php" || meta[1] == "server.php") {
        //console.log(http+"//"+host+"/"+url);return;
        return http + "//" + host + "/" + url;
    }
    if (public && project) {
        //console.log(http+"//"+host+"/"+project+public+url);return;
        return http + "//" + host + "/" + project + public + url;
    }
    if (public == "" && project) {
        //console.log(http+"//"+host+"/"+project+url);return;
        return http + "//" + host + "/" + project + url;
    }
}
/**
 *Funcion para generar una tabla dinamica por medio de un json.
 *@access public
 *@param json [description]
 *@param id_table [description]
 *@return html[description]
 */
data_table_general = function (json, id_table) {
    var tbody = '';
    $.each(json, function (key, value) {
        tbody += '<tr>';
        $.each(value, function (keys, values) {
            tbody += `<td class="text-center">${values}</td>`;
        });
        tbody += '</tr>';
    });
    $(`#${id_table} tbody`).html('');
    $(`#${id_table} tbody`).html(tbody);
}
/**
 *Funcion para la carga de registros
 *return void
 */
loader_msj = function () {
    $('#loader-msj').show();
    $('#container-views').hide();
}
/**
 *Funcion para ocultar el mensaje generado.
 *@return void
 */
loader_hide_msj = function () {
    $('#container-views').show();
    $('#loader-msj').hide();
}
/**
 *Funcion para dar formato a un numero
 *@param amount
 *@param decimals
 *@return numeber
 */
number_format = function (amount, decimals) {
    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto
    decimals = decimals || 0; // por si la variable no fue fue pasada
    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0)
        return parseFloat(0).toFixed(decimals);
    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);
    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;
    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');
    return amount_parts.join('.');
}
/**
 *Funcion de Jquery donde impide utilizar letras en campos de numero
 *@param array [description]
 *@return
 */
function numerico($this) {
    $this.value = ($this.value + '').replace(/[^0-9]/g, '');
}
/**
 *Funcion de jquery para colocar un valor predeterminado
 *@param
 */
function value_inputs(object) {
    $(object).val('');
}
/**
 *Metodo para mostrar y/o ocultar secciones
 *@param mostrar [descritption]
 *@param ocultar [description]
 *@return void
 */
function mostrar_elements(mostrar, ocultar) {
    for (var i = 0; i < mostrar.length; i++) {
        //$('#'+mostrar[i]).toggle('slow');
        $('#' + mostrar[i]).show('slow');
        $('.' + mostrar[i]).show('slow');
    }
    for (var i = 0; i < ocultar.length; i++) {
        console.log(ocultar[i]);
        //$('#'+ocultar[i]).toggle('slow');
        $('#' + ocultar[i]).hide('slow');
        $('.' + ocultar[i]).hide('slow');
    }
}
/**
 *Metodo para mostrar y/o ocultar secciones
 *@param mostrar [descritption]
 *@param ocultar [description]
 *@return void
 */
function toggle_mostrar(identificador) {

    for (var i = 0; i < identificador.length; i++) {
        $('#' + identificador[i]).toggle('slow');
        $('.' + identificador[i]).toggle('slow');

    }

}
/**
 *Funcion que valida si el dato es mayor a un numero y agrega un indice
 *@return indice
 */
addZero = function (i) {
    return (i < 10) ? '0' + i : i;
}
/**
 * Funcion para obtener la fecha y horas
 * @return date fecha[descripcion]
 */
get_actual_fulldate = function (sign = '-', sign_hrs = ":") {
    var d = new Date();
    var day = addZero(d.getDate());
    var month = addZero(d.getMonth() + 1);
    var year = addZero(d.getFullYear());
    var h = addZero(d.getHours());
    var m = addZero(d.getMinutes());
    var s = addZero(d.getSeconds());
    return day + sign + month + sign + year + " (" + h + sign_hrs + m + sign_hrs + s + ")";
}
/**
 *Funcion para obtener las horas
 *@return date fecha[descripcion]
 */
get_actual_hour = function (sign = ':') {
    var d = new Date();
    var h = addZero(d.getHours());
    var m = addZero(d.getMinutes());
    var s = addZero(d.getSeconds());
    return h + sign + m + sign + s;
}
/**
 *Funcion para obtener la fecha
 *@return date fecha[descripcion]
 */
get_actual_date = function (sign, format) {

    sign = (!sign) ? "-" : sign;
    var d = new Date();
    var day = addZero(d.getDate());
    var month = addZero(d.getMonth() + 1);
    var year = addZero(d.getFullYear());
    if (format) {
        return year + sign + month + sign + day;
    } else {
        return day + sign + month + sign + year;
    }

}
/**
 *Funcion para la validacion de numero de seguro social
 *@params {{ nss }} {{ description }}
 *@return {{ void }}
 */
nssValido = function (nss) {
    const re = /^(\d{2})(\d{2})(\d{2})\d{5}$/,
        validado = nss.match(re);
    if (!validado) // 11 dígitos y subdelegación válida?
        return false;
    const subDeleg = parseInt(validado[1], 10),
        anno = new Date().getFullYear() % 100;
    var annoAlta = parseInt(validado[2], 10),
        annoNac = parseInt(validado[3], 10);
    //Comparar años (excepto que no tenga año de nacimiento)
    if (subDeleg != 97) {
        if (annoAlta <= anno) annoAlta += 100;
        if (annoNac <= anno) annoNac += 100;
        if (annoNac > annoAlta)
            return false; // Err: se dio de alta antes de nacer!
    }
    return luhn(nss);
}
/**
 *Funcion para dividir la parte del NSS
 *@param {{nss}} {{Description}}
 *@return {{void}}
 */
luhn = function (nss) {
    var suma = 0,
        par = false,
        digito;
    for (var i = nss.length - 1; i >= 0; i--) {
        var digito = parseInt(nss.charAt(i), 10);
        if (par)
            if ((digito *= 2) > 9)
                digito -= 9;
        par = !par;
        suma += digito;
    }
    return (suma % 10) == 0;
}
/**
 *Funcion para validar la curp ingresada
 *{{@param}} {{curp}}
 *{{@return}} {{void}}
 */
curpValida = function (curp) {
    var re = /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/,
        validado = curp.match(re);
    if (!validado) //Coincide con el formato general?
        return false;
    //Validar que coincida el dígito verificador
    function digitoVerificador(curp17) {
        //Fuente https://consultas.curp.gob.mx/CurpSP/
        var diccionario = "0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ",
            lngSuma = 0.0,
            lngDigito = 0.0;
        for (var i = 0; i < 17; i++)
            lngSuma = lngSuma + diccionario.indexOf(curp17.charAt(i)) * (18 - i);
        lngDigito = 10 - lngSuma % 10;
        if (lngDigito == 10) return 0;
        return lngDigito;
    }
    if (validado[2] != digitoVerificador(validado[1]))
        return false;
    return true; //Validado
}
/**
 *Funcion que se encarga de validar el email. correspondiente.
 *{{@param}} {{ email }}
 *{{@return}} {{ void }}
 */
emailValidate = function (email) {
    const re = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
    var valido = email.match(re);
    if (!valido) {
        return false
    }
    return true;
}
/**
 *Se crea una funcion de autocomplete
 *{{ @param }} {{ @inp }}
 *{{ @param }} {{ @arr }}
 *{{return }}
 */
autocomplete = function (inp, arr) {
    /*the autocomplete function takes two arguments,
    the text field element and an array of possible autocompleted values:*/
    var currentFocus;
    var inp = document.getElementById(inp);
    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function (e) {
        var a, b, i, val = this.value;
        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) {
            return false;
        }
        currentFocus = -1;
        /*create a DIV element that will contain the items (values):*/
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);
        /*for each item in the array...*/
        for (i = 0; i < arr.length; i++) {
            /*check if the item starts with the same letters as the text field value:*/
            if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                /*create a DIV element for each matching element:*/
                b = document.createElement("DIV");
                /*make the matching letters bold:*/
                b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                b.innerHTML += arr[i].substr(val.length);
                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener("click", function (e) {
                    /*insert the value for the autocomplete text field:*/
                    inp.value = this.getElementsByTagName("input")[0].value;
                    /*close the list of autocompleted values,
                    (or any other open lists of autocompleted values:*/
                    closeAllLists();
                });
                a.appendChild(b);
            }
        }

    });
    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function (e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
            /*If the arrow DOWN key is pressed,
            increase the currentFocus variable:*/
            currentFocus++;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 38) { //up
            /*If the arrow UP key is pressed,
            decrease the currentFocus variable:*/
            currentFocus--;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 13) {
            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            e.preventDefault();
            if (currentFocus > -1) {
                /*and simulate a click on the "active" item:*/
                if (x) x[currentFocus].click();
            }
        }

    });

    function addActive(x) {
        /*a function to classify an item as "active":*/
        if (!x) return false;
        /*start by removing the "active" class on all items:*/
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (x.length - 1);
        /*add class "autocomplete-active":*/
        x[currentFocus].classList.add("autocomplete-active");

    }

    function removeActive(x) {
        /*a function to remove the "active" class from all autocomplete items:*/
        for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
        }

    }

    function closeAllLists(elmnt) {
        /*close all autocomplete lists in the document,
        except the one passed as an argument:*/
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }

    }
    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });

}
/**
 *Funcion para conveertir mayusculas y/o minusculas
 *{{ @param }} {{ @string }}
 *{{ @param }} {{ @type }}
 *{{return }}
 */
// convert_letters = function( string, type ){
//     if (type == "UPPER") {
//         return string.toUpperCase();
//     }
//     if (type == "LOWER") {
//         return string.toLowerCase();
//     }
// }
/**
 *Funcion para verificar si existe el dato
 *{{ @param }} {{ @string }}
 *{{ @param }} {{ @type }}
 *{{return }}
 */
isset = function (str) {
    try {
        if (typeof ((str)) != 'undefined')
            if ((str) != null)
                if ((str) != "")
                    return true;
    } catch (e) {}
    return false;
}
/**
 * ChangeType
 * Changes the default type of an element in another given one
 *
 * Related: passUnmask
 *
 * @see     passUnmask
 * @param   {object}    ele     The jQuery element that will be changed.
 * @param   {string}    type    The new type for the input selected.
 * @return  {object}
 */
changeType = function (ele, type) {
    if (ele.prop('type') === type) {
        return ele;
    }
    try {
        return ele.prop('type', type); //Stupid IE security will not allow this
    } catch (e) {
        // Try re-creating the element (yep... this sucks)
        // jQuery has no html() method for the element, so we have to put into a div first
        var html = $('<div>').append(ele.clone()).html(),
            regex = /type=(")?([^"\s]+)(")?/, //matches type=text or type="text"
            //If no match, we add the type attribute to the end; otherwise, we replace
            tmp = $(html.match(regex) === null ?
                html.replace('>', ' type="' + type + '">') :
                html.replace(regex, 'type="' + type + '"')),
            events,
            cb;
        //Copy data from old element
        tmp.data('type', ele.data('type'));
        events = ele.data('events');
        cb = function (events) {
            return function () {
                //Bind all prior events
                for (var i in events) {
                    var y = events[i];
                    for (var j in y) {
                        tmp.bind(i, y[j].handler);
                    }
                }
            };
        }(events);

        ele.replaceWith(tmp);
        setTimeout(cb, 10); // Wait a bit to call function

        return tmp;
    }
}
/**
 * passUnmask
 * Reveals a password input changing its type to text.
 *
 * @return  void
 */
passUnmask = function (input, obj) {
    $(input).each(function () {
        var $self = $(this);
        //changeType( $self, $self.attr( 'type' ) === 'password' ? 'text' : 'password' );
        changeTypes($self, obj);
    });

};
/**
 * changeTypes
 * Reveals a password input changing its type to text.
 * @return  void
 */
changeTypes = function (self, obj) {
    var $this = self;
    if ($this.attr('type') === "password") {
        jQuery(obj).mousedown(function () {
            $this.attr('type', 'text');
        });

    } else {
        jQuery(obj).mouseup(function () {
            $this.attr('type', 'password');
        });
    }

}
/**
 * Funcion para crear combos por medio de JavaScript
 * @param fields [description]
 * @return  void
 */
select_general = function (fields) {

    var attr = (isset(fields['attr'])) ? fields['attr'] : "";
    var name = (isset(fields['name'])) ? fields['name'] : "";
    var data = (isset(fields['data'])) ? fields['data'] : [];
    var text = (isset(fields['text'])) ? fields['text'] : "";
    var clase = (isset(fields['class'])) ? fields['class'] : "";
    var leyenda = (isset(fields['leyenda'])) ? fields['leyenda'] : "";
    var value = (isset(fields['value'])) ? fields['value'] : "";
    var selected = (isset(fields['selected'])) ? fields['selected'] : "";
    var requerido = (isset(fields['requerido'])) ? 'data-required="true"' : '';
    var evento = (isset(fields['event'])) ? fields['event'].split('-') : "";
    var eventt = (isset(fields['event']) && isset(evento[0])) ? 'onchange=' + fields['event'] : '';
    var eventt = (isset(fields['event']) && isset(evento[0]) && evento[0] == "v") ? 'v-on:change=' + evento[1] : eventt;
    var eventt = (isset(fields['event']) && isset(evento[0]) && evento[0] == "ng") ? 'ng-change=' + evento[1] : eventt;

    var select = '';
    var opt = '';
    if (data.length > 0) {
        for (var i in data) {

            var option_selected = '';
            if (selected) {
                option_selected = (data[i][value] == selected) ? 'selected' : '';
                select += '<option value="' + data[i][value] + '" ' + option_selected + '>' + (data[i][text]) + '</option>';
            } else {
                select += '<option value="' + data[i][value] + '" ' + option_selected + '>' + (data[i][text]) + '</option>';
            }
        }
        opt += '<select name="' + name + '" id="' + name + '" class="chosen-select ' + clase + '" ' + eventt + ' data-campo="' + name + '" ' + requerido + ' title="' + title + '" ' + attr + '>';
        opt += '<option value="" selected>' + leyenda + '</option>';
        opt += select;
        opt += '</select>';
    } else {
        opt += '<select name="' + name + '" id="' + id + '" class="chosen-select ' + clase + '" ' + eventt + '">';
        opt += '<option value="" disabled selected>Sin contenido</option>'
        opt += '</select>';
    }

    return opt;
}
/**
 * BUSCADOR GENERAL DE UNA TABLA BASICO
 * @param $this object [description]
 * @param identificador string [description]
 * @return void
 */
buscador_general = function ($this, identificador) {

    _this = $this;
    jQuery.each(jQuery(identificador + " tbody>tr"), function () {
        if (jQuery(this).text().toLowerCase().indexOf(jQuery(_this).val().toLowerCase()) === -1)
            jQuery(this).hide();
        else
            jQuery(this).show();

    });

}
/**
 * ABRE UN MODAL CON FANCYBOX.
 * @param identificador string [description]
 * @return void
 */
register_modal_general = function (identificador, modal) {
    if (modal) {
        jQuery(identificador).modal('show');
    } else {
        jQuery.fancybox.open({
            'type': 'inline',
            'src': identificador,
            'modal': true,
        });

    }
}
/**
 * Actualiza la notificacion que llegan de los portales.
 * @param id_notify string [description]
 * @return void
 */
update_notify = function (id_notify) {
    var url = domain('api/sistema/token');
    var fields = {
        'email': "jorge.martinez@burolaboralmexico.com"
    };
    var response = MasterController.method_master(url, fields, 'post');
    response.then(response => {
        var headers = {
            'usuario': response.data.result[0].email,
            'token': response.data.result[0].api_token
        };
        var uri = domain('api/sistema/notification');
        var data = {
            'id': id_notify,
            'estatus': 0
        };
        var response_notify = MasterController.method_master(uri, data, 'put', headers);
        response_notify.then(response => {
            redirect(domain('configuracion/clientes'));
        }).catch(error => {
            toastr.error(error, "Ocurrio un Error");
        });

    }).catch(error => {
        toastr.error(error, "Ocurrio un Error");
    });

}

function upload_files_general() {

    var url = domain('upload/catalogos');
    var fields = {};
    var mensaje = "Dar Clic aquí o arrastrar archivo";
    var div = {
        div_content: 'div_upload_catalogo',
        div_dropzone: 'dropzone_xlsx_file',
        file_name: 'file'
    };
    var num_files = null;
    jQuery.fancybox.open({
        'type': 'inline',
        'src': "#seccion_upload",
        'buttons': ['share', 'close']
    });

    upload_file(fields, url, mensaje, num_files, div, '.csv,.xls,.xlsx', function (response) {
        if( response.success == true){
            jQuery.fancybox.close({
                'type': 'inline',
                'src': "#seccion_upload",
                'buttons': ['share', 'cerrar']
            });
            redirect(window.location.href);   
        }else{
            toastr.error(response.message, "Ocurrio un Error");
        }
    });

}

function valida_rfc( rfc ) {
	var str_correcta;
	str_correcta = rfc;	
	if ( rfc.length == 12 ){
	   var valid = '^(([A-Z]|[a-z]){3})([0-9]{6})((([A-Z]|[a-z]|[0-9]){3}))';
	}else{
	   var valid = '^(([A-Z]|[a-z]|\s){1})(([A-Z]|[a-z]){3})([0-9]{6})((([A-Z]|[a-z]|[0-9]){3}))';
	}
	var validRfc=new RegExp( valid );
	var matchArray=str_correcta.match(validRfc);
	if (matchArray==null) { return false; } else{ return true; }
	
}

function data_table( data ){
    var html_result    = '';
    var titulos        = isset(data['titulos']) ? data['titulos'] :false;
    var registros      = isset(data['registros'])?data['registros']:false;
    var id             = isset(data['id'])? 'id="'+data['id']+'"' : 'id="datatable"';
    var $class         = isset(data['class'])? data['class'] : '';
    var tbody          = '';
    if(titulos){
        var th = '';
        for( var i in titulos){
            th += '<th>'+titulos[i]+'</th>';
        }
        var thead = '<thead style="background-color: rgb(51, 122, 183); color: rgb(255, 255, 255);"><tr>'+th+'</tr></thead>';
        var tfoot = '<tfoot><tr>'+th+'</tr></tfoot>';
    }            
    if(registros){
        tbody = '<tbody>';
        for(var i in registros){
            tbody += '<tr>';
            //tbody += ( in_array('Estatus',$titulos) && !in_array('ACTIVO',$registro) )? '<tr class="danger">': '<tr>';
            for (var j in registros[i]){
                tbody += '<td>'+registros[i][j]+'</td>';
            }
            tbody += '</tr>';
        }
        tbody += '</tbody>';
    }
    html_result += '<table class="table table-striped table-response highlight table-hover '+$class+'" '+id+'>';
    html_result += thead;
    html_result += tbody;
    html_result +='</table>';
    return html_result;
}

