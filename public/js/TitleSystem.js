let title               = "Registros Correctos";
let success_mgs         = "Registro insertado corretamente.";
let error_mgs           = "Ocurrio un error, Favor de verificar";
let title_error         = "Registros Incorrectos";
let update              = "Registro actualizado corretamente";
let validate            = "Favor de Verificar los campos color Rojo";
let expired             = "Ocurrio un Error, Favor de Verificar";
let session_expired     = "Expiro su sesión, favor de ingresar al portal";
var content_type        = 'application/json';
var csrf_token          = { 'X-CSRF-TOKEN': meta('csrf-token'), 'Content-Type' : content_type };
var _token              = csrf_token[ Object.keys( csrf_token )[0] ];
var params              = {};

