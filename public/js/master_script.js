
/**
 * Se crea una class maestra para obtener un crud
 * @author Jorge Martinez Quezada.
 */
class MasterController {
 /*constructor( url,fields,methods,headers ){
    return this.method_master( url,fields,methods,headers );
 }*/
/**
 * Se un metodo general donde se pueda utilizar para la conexion a backend
 * @param url {string} {description}
 * @param fields {object} {description}
 * @param url {string} {description}
 * @param methods {string} {es el metodo que se utilizara por http}
 * @param headers {string} {description}
 * @return void {description}
 */
 static method_master(url,fields, methods, headers  ){
     var header = {};
     if( isset(headers) ) {
       for (var i in headers) {
         header[i] = headers[i];
       }
       for (var i in csrf_token) {
         header[i] = csrf_token[i];
       }
     }else{
       header = csrf_token;
     }
     axios.defaults.headers = header;
     var request = [];
     if(methods == "get" || methods == "delete"){
        request = {params: fields}
     }else{request = fields;}
     return axios[methods](url, request );

 }
 /**
 * Se un metodo general donde se pueda utilizar para la conexion a backend
 * @param url {string} {description}
 * @param fields {object} {description}
 * @param methods {string} {es el metodo que se utilizara por http}
 * @param $http {object} {objeto que almacena para hacer el promise}
 * @param headers {string} {description}
 * @return void {description}
 */
 static request_http( url, fields, methods, $http ,headers ){
    loading();
    var config = [];
    config['method']  = methods;
    config['url']     = url;
    config['headers'] = headers;
     if(methods == "get" || methods == "delete" || methods == "GET" || methods == "DELETE"){
        config['params'] = fields;
     }else{ config['data'] = fields; }
    return $http(config);

 }




}
