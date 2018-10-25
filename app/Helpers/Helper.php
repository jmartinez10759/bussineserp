<?php


  function checkPermission($name){
      if(Session::has('rol')){
          foreach (Session::get('rol')->permisos as $per)
          {
              if($per->name_holder == $name){
                  return true;
              }
          }
      }
      return false;
  }
 /**
	* Imprime un arreglo formateado para debug
	* y detiene la ejecucion del script
	* @return array $array
	*/
	if(!function_exists('debuger')){
		function debuger($array, $die = true){
			echo '<pre>';
			print_r( $array );
			echo '</pre>';
			if($die){
				die();
			}
		}
	}

  if (!function_exists('ddebuger')) {
     function ddebuger()
      {
        $args = func_get_args();
        call_user_func_array('dump', $args);
        die();
       }
 }

	if(!function_exists('timestamp')){
		function timestamp(){
	    	return date('Y-m-d H:i:s');
	    }
	}

	if(!function_exists('format_decimal')){
		function format_decimal($number=0, $separador=''){
			return number_format($number, 3, '.', $separador);
		}
	}

	if(!function_exists('format_currency')){
		function format_currency($number=0,$decimal=2 ,$sign='$'){
			return $sign.''.number_format($number, $decimal, '.', ',');
		}
	}

	if(!function_exists('format_date_short')){
		function format_date_short($date=false, $sign='-'){
			$fdate = date('Y'.$sign.'m'.$sign.'d', strtotime($date));
			return $fdate;
            #return date_format($fdate,"Y".$sign."m".$sign."d");
		}
	}

	if(!function_exists('format_date_long')){
		function format_date_long($date=false, $sign='-'){
			$fdate = date('Y{$sign}m{$sign}d', strtotime($date));
			return date_format($fdate,"Y{$sign}m{$sign}d H:i:s");
		}
	}

	if(!function_exists('format_date')){
		function format_date($date = false, $sign='-'){
			return date("d".$sign."m".$sign."Y", strtotime($date));
		}
	}

	if(!function_exists('dropdown')){

        function dropdown($params){
            $data       = (isset($params['data']))?$params['data']:'';
            $name       = (isset($params['name']))?$params['name']:'';
            $id         = (isset($params['id']))?$params['id'] : $name;
            $selected   = (isset($params['selected']))?explode(',',$params['selected']):'';
            $value      = (isset($params['value']))?$params['value']:false;
            $text       = (isset($params['text']))?$params['text']:'';
            $text       = explode(" ",$text);
            $class      = (isset($params['class']))?$params['class']:'';
            $disabled   = (isset($params['disabled']))?$params['disabled']:'';
            $requerido  = (isset($params['requerido']))?'data-required="true"':'';
            $multiple   = (isset($params['multiple']))?'multiple':'';
            $attr       = (isset($params['attr']))?$params['attr']:'';
            $title      = (isset($params['title']))?$params['title']:'';
            $leyenda    = (array_key_exists('leyenda' ,$params))?$params['leyenda']: '-----';
            $evento     = isset($params['event'])?explode('-', $params['event'] ): "";
            $event      = (isset($params['event']) && isset($evento[0]) )? 'onchange='.$params['event'] :'';
            $event      = (isset($params['event']) && isset($evento[0]) && $evento[0] == "v")? 'v-on:change='.$evento[1] :$event;
            $event      = (isset($params['event']) && isset($evento[0]) && $evento[0] == "ng")? 'ng-change='.$evento[1] :$event;
            #convierto el arreglo en objeto
            if ( !is_object($data) ) {
                $data = array_to_object($data);
            }
            $select = '';
            if( $data ){
                foreach ($data as $key => $values) {
                    $texto = "";
                    for ($i=0; $i < count($text); $i++) {
                        $parametro = $text[$i];
                        $texto .= $values->$parametro." ";
                    }
                    $option_selected='';
                    if($selected){
                            $option_selected = (in_array($values->$value,$selected))?'selected':'';
                            $select.='<option value="'.$values->$value.'" '.$option_selected.'>'.($texto).'</option>';
                    }else{
                        $select.='<option value="'.$values->$value.'"'.$option_selected.'>'.($texto).'</option>';
                    }
                }
                $opc='<select name="'.$name.'" id="'.$id.'" '.$multiple.' class="chosen-select '.$class.'" '.$event.' data-campo="'.$name.'" '.$requerido.' title="'.$title.'" '.$attr.'>
                        <option value="0" selected>'.$leyenda.'</option>
                        '.$select.'
                      </select>';
            }else{
                $opc='<select name="'.$name.'" id="'.$id.'" '.$multiple.' class="'.$class.'" onchange="'.$event.'">
                        <option value="0" disabled selected>Sin contenido</option>
                      </select>';
            }
            return $opc;

        }

    }

    if(!function_exists('incCss')){
        function incCss($filename){
            #$cadena = '<link href="'.URLPATH.$filename.'" rel="stylesheet" type="text/css">';
            $cadena = '<link href="'.$filename.'" rel="stylesheet" type="text/css">';
            return $cadena;
        }
    }

    if(!function_exists('incJs')){
        function incJs($filename){
            #$cadena = '<script type="text/javascript" src="'.URLPATH.$filename.'"></script>';
            $cadena = '<script type="text/javascript" src="'.$filename.'"></script>';
            return $cadena;
        }
    }

    //Construye una tabla datatable
    if(!function_exists('data_table')){

        function data_table($data = array()){
            $html_result    = '';
            $titulos        = (is_array($data['titulos']))?$data['titulos']:false;
            $registros      = (is_array($data['registros']))?$data['registros']:false;
            $id             = isset($data['id'])? 'id="'.$data['id'].'"' : 'id="datatable"';
            $class          = isset($data['class'])? $data['class'] : '';
            $tbody          = '';
            if($titulos){
                $th = '';
                foreach($titulos as $titulo){$th .= '<th>'.$titulo.'</th>';}
                $thead = '<thead style="background-color: rgb(51, 122, 183); color: rgb(255, 255, 255);"><tr>'.$th.'</tr></thead>';
                $tfoot = '<tfoot><tr>'.$th.'</tr></tfoot>';
            }
            if($registros){
                $tbody = '<tbody>';
                foreach($registros as $registro){
                    #$tbody .= '<tr>';
                    $tbody .= ( in_array('Estatus',$titulos) && !in_array('ACTIVO',$registro) )? '<tr class="danger">': '<tr>';
                    foreach ($registro as $campo){
                        $tbody .= '<td>'.$campo.'</td>';
                    }
                    $tbody .= '</tr>';
                }
                $tbody .= '</tbody>';
            }
            $html_result .= '<table class="table table-striped table-response highlight table-hover '.$class.'" '.$id.'>';
            $html_result .= $thead;
            $html_result .= $tbody;
            $html_result .='</table>';
            return $html_result;

        }
    }

    if(!function_exists('data_table_general')){

        function data_table_general( $data = array(), $keys=false ){

            $html_result    = '';
            $registros      = (is_array($data['registros']))?(object)$data['registros']:false;
            $id             = isset($data['id'])? 'id="'.$data['id'].'"' : 'id = "datatable"';
            $class          = isset($data['class'])? 'class="'.$data['class'].'"' : '';
            $class_thead    = isset($data['class_thead'])? 'class="'.$data['class_thead'].'"' : ' ';
            $class_tr       = isset($data['class_tr'])? 'class="'.$data['class_tr'].'"' : ' ';
            $attr           = isset($data['attr'])? 'class="'.$data['attr'].'"' : ' ';
            $tbody          = '';
            #debug($registros);
            #Se convierte en objeto si es que viene en array
           # $registros = ( is_array( $registros ) )? (object)$registros : $registros;
            #se verifica que si se establecieron titulos
            if( isset($data['titulos']) ){
                    $titulos       = (is_array($data['titulos']))?$data['titulos']:false;
                    $th = '';
                    foreach($titulos as $titulo){$th .= '<th>'.$titulo.'</th>';}
                    $thead = '<thead '.$class_thead.' ><tr>'.$th.'</tr></thead>';
                    $tfoot = '<tfoot><tr>'.$th.'</tr></tfoot>';
            }else
                if( isset( $keys ) ){
                    $th = '';
                    foreach($keys as $titulo){ $th .= '<th>'.$titulo.'</th>';}
                    $thead = '<thead '.$class_thead.' ><tr>'.$th.'</tr></thead>';
                    $tfoot = '<tfoot><tr>'.$th.'</tr></tfoot>';
            }
            if($registros){
                $tbody = '<tbody>';
                foreach($registros as $registro){
                    $tbody .= '<tr '.$class_tr.' '.$attr.'>';
                    #Se valida si es que requiere elegir titulos
                    if ( !empty( $keys) ) {
                        foreach ($keys as $indice => $titulo) {
                            $tbody .= '<td>'.$registro->$indice.'</td>';
                        }
                    }else
                        if ( empty( $keys ) ) {
                            foreach ($registro as $campo){
                                $tbody .= '<td>'.$campo.'</td>';
                            }
                        }
                    $tbody .= '</tr>';
                }
                $tbody .= '</tbody>';
            }
            $html_result .= '<table '.$class.' '.$id.'>';
            $html_result .= $thead;
            $html_result .= $tbody;
            $html_result .='</table>';

            return $html_result;

        }
    }

    if (!function_exists('build_acciones_usuario')) {

        function build_acciones_usuario($u = array(), $event= false, $texto = false, $color = false, $icon = false, $attr = false) {

                $lenguaje   = explode('-',$event);
                $evento     = isset($lenguaje[1])? $lenguaje[1] : $lenguaje[0];
                $event      = (isset($lenguaje[0]))? 'onclick='.$evento."(".$u['id'].")" :'';
                $event      = (isset($lenguaje[0]) && $lenguaje[0] == "v")? 'v-on:click.prevent='.$evento."(".$u['id'].")" :$event;
                $event      = (isset($lenguaje[0]) && $lenguaje[0] == "ng")? 'ng-click='.$evento."(".$u['id'].")" :$event;
                #debuger($event);
                #$event = ($event)? "onclick = ".$event."(".$u['id'].")": false;
                $texto = ($texto)?  $texto:false;
                $color = ($color)?  $color:false;
                $icon =  ($icon)?   $icon:false;
                $attr =  ($attr)?   $attr:false;

                $acciones = '<div class="btn-group">';
                $acciones .= '
                <button type = "button" class="'.$color.'" '.$event.' '.$attr.' >
                    <i class="'.$icon.'"> '.$texto.'</i>
                </button>';
                $acciones .= '</div>';
                return $acciones;
            }

    }

    if (!function_exists('build_acciones')) {

        function build_acciones($u = array(), $event= false, $texto = false, $color = false, $icon = false, $attr = false) {
                $event = ($event)? "onclick = ".$event."(".json_encode($u).")": false;
                $texto = ($texto)?  $texto:false;
                $color = ($color)?  $color:false;
                $icon =  ($icon)?   $icon:false;
                $attr =  ($attr)?   $attr:false;

                $acciones = '<div class="btn-group">';
                $acciones .= '
                <button type = "button" class="'.$color.'" '.$event.' '.$attr.' >
                    <i class="'.$icon.'"> '.$texto.'</i>
                </button>';
                $acciones .= '</div>';
                return $acciones;
            }

    }


    if (!function_exists('convert_object')) {

        function json_to_object ( $json = false ) {

            if ( $json ) {
                return json_decode($json);
            }

        }

    }
/**
 *Funcion que convierte el arreglo  en objecto
 *@param $json [Descrption]
 *@return array
 **/
  if (!function_exists('array_to_object')) {

        function array_to_object ( $array = array() ) {
            if ( is_array( $array ) ) {
                return  json_decode( json_encode($array) );
            }

        }

    }
/**
 *Funcion que convierte el json a arreglo .
 *@param $json [Descrption]
 *@return array
 **/
  if (!function_exists('json_to_array')) {
        function json_to_array ( $json = false ) {
            if ( $json ) {
                return  json_decode( $json, TRUE );
            }
        }
    }
/**
 *Funcion donde se convierte un objeto en arreglo.
 *@param $object [Descrption]
 *@return array
 **/
  if (!function_exists('object_to_array')) {
      function object_to_array ( $object = false ) {
          if ( $object ) {
              return  json_decode( json_encode( $object ), TRUE );
          }
      }
  }
  /**
   *Funcion para la creacion de los iconos en una tabla
   *@param $u      [Descrption]
   *@param $event  [Descrption]
   *@param $icon   [Descrption]
   *@param $attr   [Descrption]
   **/
  if (!function_exists('build_icon')) {

      function build_icon($u = array(), $event= false, $icon = false, $attr = false) {
              $event = ($event)? "onclick = ".$event."(".json_encode($u).")": false;
              $icon =  ($icon)?   $icon:false;
              $attr =  ($attr)?   $attr:false;

              $acciones = '<div class="btn-group" style="cursor: pointer;" '.$event.' '.$attr.' >';
              $acciones .= '<span class ="'.$icon.' element-viatico">';
              $acciones .= '<span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span><span class="path11"></span>';
              $acciones .= '</span>';
              $acciones .= '</div>';
              return $acciones;
          }
  }
  /**
   *Funcion para la creacion de imagenes dentro de un boton
   *@param $u      [Descrption]
   *@param $event  [Descrption]
   *@param $icon   [Descrption]
   *@param $attr   [Descrption]
   **/
  if (!function_exists('build_img')) {
        function build_img($u = array(), $event= false, $icon = false, $attr = false) {
                $event = ($event)? "onclick = ".$event."(".json_encode($u).")": false;
                $icon =  ($icon)?   $icon:false;
                $attr =  ($attr)?   $attr:false;

                $acciones = '<div class="btn-group" style="cursor: pointer;" '.$event.' '.$attr.' >';
                $acciones .= '<img src ="'.asset($icon).'" width="50px" height="40px">';
                $acciones .= '</img>';
                $acciones .= '</div>';
                return $acciones;
            }
  }
  /**
   *Funcion para crear una vista dinamica pero en el proyecto de travel de CPA VISION
   *@param $event      [Descrption]
   *@param $images  [Descrption]
   *@param $titulos   [Descrption]
   **/
  if (!function_exists('build_vista')) {
        function build_vista( $event = array(), $images = array(), $titulos = array() ){
            $html = '';
            $col = 12 / count( $titulos );
            for ($i=0; $i < count($titulos); $i++) {
                #$event = ($event)? "onclick = ".$event[$i]: false;
                $html .= '<div class="col-sm-'.$col.' panel_menu" >';
                    $html .= '<div class="about-item scrollpoint sp-effect1">';
                        $html .= '<p><div onclick="'.$event[$i].'" style="cursor: pointer;"><img src="'.$images[$i].'" alt=""></div></p>';
                        $html .= '<h3 class="font_menu">'.$titulos[$i].'</h3>';
                    $html .= '</div>';
                $html .= '</div>';
            }
            return $html;
        }
    }
  /**
   *Funcion donde se crea un mesaje general
   *@param $success [Description]
   *@param $data [Description]
   *@param $message  [Description]
   */
  if (!function_exists('message')) {
        function message( $success = true,$register = array(), $message = false ){
            $arreglo = [
                'success'   => $success
                ,'result'   => $register
                ,'message'  => $message
            ];
            return json_encode( $arreglo );
        }
    }
  /**
   *Recorre cualquier objeto o arreglo para enviar los datos deseados particular consultas ELOQUENT
   *@access public
   *@param $data instace [Description]
   *@return object
   */
  if (!function_exists('data_march')) {
        function data_march( $data = array() ){
            $response = [];
            $i = 0;
            foreach ($data as $key => $values) {
                foreach ($values->fillable as $key => $value) {
                    if( $values->$value ){
                      $response[$i][$value] = $values->$value;
                    }
                }
                $i++;
            }
            return array_to_object($response);
        }
    }
  /**
   *Verificar si estan correctamente los valores ingresados de la fecha
   *@param $fecha string  [description]
   *@return array
   */
  if (!function_exists('schema_date')) {
        function schema_date( $fecha = false ){
            if ( $fecha ) {
                $fechas = explode("-", $fecha );
                if ( count( $fechas ) == 3 ) {
                    if ( checkdate( $fechas[1],$fechas[2],$fechas[0]) != false ) {
                        return ['success' => true,'message' => "Fecha correcta"];
                    }
                }
                return ['success' => false,'message' => "Fecha incorrecta"];
            }
        }
    }
  /**
   *Realiza un parseo de la ruta si existe un dominio y un nombre del proyecto
   *@access public
   *@return array
   */
  if (!function_exists('domain')) {
        function domain(){
            $http = $_SERVER['REQUEST_SCHEME'];
            $host = $_SERVER['HTTP_HOST'];
            $server_href = $http."://".$host.$_SERVER['REQUEST_URI'];
            if ( $server_href ) {
                $dominio        = explode("/", $server_href );
                $request_uri    = explode("/", $_SERVER['PHP_SELF']);
                $domain         = isset( $dominio[2] )? $dominio[2] : false;
                $public         = (isset($dominio[4]) && $dominio[4] == "public")? $dominio[4] : false;
                $project        = (isset($dominio[3]) ) ? $dominio[3] : false;
                #debuger($request_uri);
                if ( isset( $request_uri[1] ) && $request_uri[1] == 'index.php' || $request_uri[1] == 'server.php' ) {
                    return $http."://".$host."/";
                }
                if ( $public && $project) {
                    return $http."://".$host."/".$project."/".$public."/";

                }
                if ( !$public && $project ) {
                  return $http."://".$host."/".$project."/";

                }

            }

        }

  }
  /**
   *Funcion que obtine el parseo de la url dominio/projecto/url
   *@access public
   *@return array
   */
   if( !function_exists( 'parse_domain') ){
        function parse_domain(){

            $data = [];
            $uri = "";
            $urls = "";
            $http = isset($_SERVER['REQUEST_SCHEME'])? $_SERVER['REQUEST_SCHEME'] : false;
            $host = isset($_SERVER['HTTP_HOST'])? $_SERVER['HTTP_HOST'] : false;
            $php_self = isset($_SERVER['PHP_SELF'])?$_SERVER['PHP_SELF']:false;
            $request_url = isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:false;
            $server_href = $http."://".$host.$request_url;
            $url_navegador = (isset( $_SERVER['HTTP_REFERER'] ))? explode("/",$_SERVER['HTTP_REFERER']): [];    
            #debuger($url_navegador);
            
            if ( $server_href ) {
                $dominio        = explode("/", $server_href );
                $request_uri    = explode("/", $php_self);
                $domain         = ( isset( $dominio[2] ) )? $dominio[2] : false;
                $public         = ( isset( $dominio[4] ) && $dominio[4] == "public")? $dominio[4] : false; 
                if( count($request_uri) == 2 ){
                  $project = false;
                }
                if( count($request_uri) > 2 ){
                    $project = $request_uri[count($request_uri) - 2 ];
                }
                $data['http']     = $http;
                $data['host']     = $host;
                $data['project']  = $project;
                $data['public']   = $public;
                #dd($data);
                $parse_dominio = [$http.":",$host,$project,$public];
                for ($i=0; $i < count($dominio); $i++) {
                    if( !in_array($dominio[$i],$parse_dominio) ){
                        $uri .= "/".$dominio[$i];
                    }
                }
                if( count($url_navegador) > 0){
                    for ($i=0; $i < count($url_navegador); $i++) {
                        if( !in_array($url_navegador[$i],$parse_dominio) ){
                            $urls .= "/".$url_navegador[$i];
                        }
                    }
                    
                }
                if ( isset( $request_uri[1] ) ) {
                    if ($request_uri[1] == 'index.php' || $request_uri[1] == 'server.php') {
                      $data['url'] = $http."://".$host."/";
                    }
                }
                if ( $public && $project) {
                    $data['url'] = $http."://".$host."/".$project."/".$public."/";
                }
                if ( !$public && $project ) {
                    $data['url'] = $http."://".$host."/".$project."/";
                }
                $data['uri']      = $uri;
                $data['urls']     = $urls;
                return array_to_object( $data );

            }

        }
   }
  /**
   *Realiza un parseo de un string
   *@param $name_complete string  [description]
   *@return array
   */
  if (!function_exists('parse_name')) {

      function parse_name( $name_complete ){
        #debuger($name_complete);
        $nombre_completo = explode(" ", $name_complete );
        #debuger(count( $nombre_completo ) );
    		$nombre = "";
    		$apellido = [];
        if ( count( $nombre_completo ) < 2 ) { return false; }

        $count_name = ( count( $nombre_completo ) > 1 && count( $nombre_completo ) < 3 )? count($nombre_completo) - 1 : count($nombre_completo) - 2;

    		for ($i=0; $i < $count_name ; $i++) {
    				$nombre .= $nombre_completo[$i]." ";
    		}
        $j = $count_name;
    		for ($i= count($nombre_completo); $i > $count_name ; $i--) {
    				$apellido [] = $nombre_completo[$j]." ";
    				$j ++;
    		}

        $datos = [
          'name' => trim(strtoupper($nombre))
          ,'first_surname' => isset($apellido[0] ) ? trim(strtoupper($apellido[0])) : ""
          ,'second_surname' => isset($apellido[1] ) ? trim(strtoupper($apellido[1])) : ""
        ];
          return $datos;

      }

   }
 /**
  *crea un checkbox
  *@param $data array  [description]
  *@return array
  */
 if(!function_exists('build_actions_icons')){

     function build_actions_icons( $data = array(), $attr= false, $identificador = false ){
         $id = (isset( $data['id'] ))? $data['id']: false;
         $html = '<div class="material-switch pull-left" id="'.$identificador.'_'.$id.'" >';
           $html .= '<input id="'.$id.'" type="checkbox" '.$attr.' />';
           $html .= '<label for="'.$id.'" class="label-primary"></label>';
         $html .= '</div>';
         $html .= incCss( asset('css/checkbox/checkbox.css') );
         return $html;

     }

 }
 /**
  *funcion para obtener la ip con la que se loguean el usuario.
  *@param $data array  [description]
  *@return array
  */
 if(!function_exists('get_client_ip')){
     function get_client_ip() {
           $ipaddress = '';
           if (getenv('HTTP_CLIENT_IP'))
               $ipaddress = getenv('HTTP_CLIENT_IP');
           else if(getenv('HTTP_X_FORWARDED_FOR'))
               $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
           else if(getenv('HTTP_X_FORWARDED'))
               $ipaddress = getenv('HTTP_X_FORWARDED');
           else if(getenv('HTTP_FORWARDED_FOR'))
               $ipaddress = getenv('HTTP_FORWARDED_FOR');
           else if(getenv('HTTP_FORWARDED'))
              $ipaddress = getenv('HTTP_FORWARDED');
           else if(getenv('REMOTE_ADDR'))
               $ipaddress = getenv('REMOTE_ADDR');
           else
               $ipaddress = 'UNKNOWN';
           return $ipaddress;
      }
 }
 /**
 * Funcion que devuelve un array con los valores:
 * @param os => sistema operativo
 * @param browser => navegador
 * @param version => version del navegador
 */
if(!function_exists('detect')){
    function detect(){
      $browser=array("IE","OPERA","MOZILLA","NETSCAPE","FIREFOX","SAFARI","CHROME");
      $os=array("WIN","MAC","LINUX");
      # definimos unos valores por defecto para el navegador y el sistema operativo
      $info['browser'] = "OTHER";
      $info['os'] = "OTHER";
      # buscamos el navegador con su sistema operativo
      foreach($browser as $parent){
        $s = strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), $parent);
        $f = $s + strlen($parent);
        $version = substr($_SERVER['HTTP_USER_AGENT'], $f, 15);
        $version = preg_replace('/[^0-9,.]/','',$version);
        if ($s){
          $info['browser'] = $parent;
          $info['version'] = $version;
        }
      }
      # obtenemos el sistema operativo
      foreach($os as $val){
        if (strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),$val)!==false)
        $info['os'] = $val;
      }
      $info['user_agent'] = isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']: "";
      # devolvemos el array de valores
      return $info;
    }
}
/**
 *Funcion para calcular la edad con la fecha de nacimiento.
 *@access public
 *@param $fechaInicio string []
 *@param $fechaFin string []
 *@return integer
 */
if(!function_exists('time_fechas')){
 function time_fechas( $fechaInicio, $fechaFin ){
        $fecha1 = new DateTime( $fechaInicio );
        $fecha2 = new DateTime( $fechaFin );
        $fecha = $fecha1->diff( $fecha2) ;
        $tiempo = "";
        //años
        if($fecha->y > 0){
            $tiempo .= $fecha->y;
            if($fecha->y == 1) $tiempo .= " año, "; else $tiempo .= " años, ";
        }
        //meses
        if($fecha->m > 0){
            $tiempo .= $fecha->m;
            if($fecha->m == 1) $tiempo .= " mes, "; else $tiempo .= " meses, ";
        }
        //dias
        if($fecha->d > 0){
            $tiempo .= $fecha->d;
            if($fecha->d == 1) $tiempo .= " día, ";
            else $tiempo .= " días, ";
        }
        //horas
        if($fecha->h > 0){
            $tiempo .= $fecha->h;
            if($fecha->h == 1) $tiempo .= " hora, ";else $tiempo .= " horas, ";
        }
        //minutos
        if($fecha->i > 0){
            $tiempo .= $fecha->i;
            if($fecha->i == 1) $tiempo .= " minuto"; else $tiempo .= " minutos";
        }else if($fecha->i == 0) //segundos
            $tiempo .= $fecha->s." segundos";
        return $tiempo;
    }
}
/**
 *Funcion para calcular la edad con la fecha de nacimiento.
 *@access public
 *@param $fecha_nacimiento string []
 *@return integer
 */
 if(!function_exists('edad')){
     function edad( $fecha_nacimiento ){
         $fecha = new DateTime( $fecha_nacimiento );
         $hoy = new DateTime();
         $annos = $hoy->diff($fecha);
         return $annos->y;
     }
 }
if( !function_exists('validarRFC') ){
 function validarRFC( $rfc ){
    $regex = '/^[a-zA-Z]{3,4}(\d{6})((\D|\d){2,3})?$/';
	  return preg_match($regex, $rfc);
 }

}
if( !function_exists('emailValidate') ){
    function emailValidate ( $email ){
         $regex = '/^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i';
         return preg_match($regex, $email);
     }
}
if( !function_exists('end_key') ){
    function end_key( $array ){
      end( $array );
      return key( $array );
    }
}
