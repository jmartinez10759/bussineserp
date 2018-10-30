<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;

class BuildController extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build:mvc {file} {--config}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea la estructura con la que se trabaja en los proyectos actuales';

    protected $file;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct( Filesystem $file )
    {
        parent::__construct();
        $this->file = $file;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        $config = $this->option('config');
        $files = $this->argument('file');
        $this->line('Instalando el Controller ... ');
        $this->line('Instalando el Modelo ... ');
        $file = explode('/',$files);
            if( count($file) > 0){
                end($file);
                $modelo = str_replace($file[key($file)],'',$files)."Sys".str_replace('Controller','',$file[key($file)])."Model";  
                $namespace = "App\Http\Controllers\\".str_replace('/','\\', str_replace($file[key($file)],'',$files) );
                $namespace = substr($namespace,0,-1);
                $namespace_model = "App\Model\\".str_replace('/','\\', str_replace($file[key($file)],'',$files) );
                $namespace_model = substr($namespace_model,0,-1);
                $controller = $file[key($file)];
                $vista = strtolower(str_replace('Controller','',$controller));
                $ruta_script = substr( strtolower( str_replace($file[key($file)],'',$files) ),0,-1);
                $ruta_views  = substr( strtolower( str_replace($file[key($file)],'',$files) ),0,-1);
                #dd($ruta_script);
                $models = "Sys".str_replace('Controller','',$controller)."Model";
            }
        if(!$config){
            $data = $this->struct_controller($controller,$models,'', '', '', $vista);
            $data_model = $this->struct_modelo($models);
            $this->struct_upload( $models, str_replace('Controller','',$controller) );
            $this->info("Configurando Controller Development/$controller ...");
            $this->info("Configurando Model Development/$models ...");
            $this->info("Configurando Upload UploadController ...");
            $this->call('make:controller', ['name' => "Development/".$controller ]);
            $this->call('make:model', ['name' => "Model/Development/".$models ]);
            file_put_contents("app/Http/Controllers/Development/".$controller.".php",$data);
            file_put_contents("app/Model/Development/".$models.".php",$data_model);
            $this->struct_upload( $models, str_replace('Controller','',$controller) );
            $this->struct_view(str_replace('Controller','',$controller));
            $this->struct_js(str_replace('Controller','',$controller));
        }else{
            $ruta_controller = "app/Http/Controllers/".$files.".php";
            $ruta_modelo = "App\Model\\".str_replace('/','\\',$modelo).";";
            $ruta_modelos = "app/Model/".$modelo.".php";
            $data = $this->struct_controller($controller,$models,$ruta_modelo,$namespace,$ruta_views,$vista);            
            $data_model = $this->struct_modelo($models,$namespace_model);
            $this->info("Configurando Controller $files ..."); 
            $this->info("Configurando Model $modelo ...");           
            $this->call('make:controller', ['name' => $files ]);
            $this->call('make:model', ['name' => "Model/".$modelo ]);
            file_put_contents( $ruta_controller, $data );
            file_put_contents( $ruta_modelos, $data_model );
            $this->struct_upload( $models, str_replace('Controller','',$controller), $ruta_modelo );
            $this->struct_view(str_replace('Controller','',$controller),$ruta_views);
            $this->struct_js(str_replace('Controller','',$controller), $ruta_script);
            
        }

    }
    /**
     * crea la estructura del controlador.
     *
     * @return mixed
     */
    public function struct_controller( $controller, $modelo, $ruta_modelo =false , $namespace =false, $ruta_vistas = false, $vista =false ){
        $namespace = (isset($namespace) && $namespace)? $namespace: 'App\Http\Controllers\Development';
        $ruta_modelo = (isset($ruta_modelo) && $ruta_modelo)? $ruta_modelo: 'App\Model\Development\\'.$modelo.';';
        $ruta_vista = (isset($ruta_vistas) && $ruta_vistas != "" )? 'resources/views/'.$ruta_vistas."/".strtolower($vista).".blade.php" : 'resources/views/development/'.strtolower($vista).".blade.php";
        $vistas = str_replace('resources/views/','',$ruta_vista);
        $vistas = str_replace('.blade.php','',$vistas);
        $vistas = str_replace('/','.',$vistas);
    $struct = 
'<?php
    namespace '.$namespace.';

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Session;
    use App\Http\Controllers\MasterController;
    use '.$ruta_modelo.'

    class '.$controller.' extends MasterController
    {
        #se crea las propiedades
        private $_tabla_model;

        public function __construct(){
            parent::__construct();
            $this->_tabla_model = new '.$modelo.';
        }
        /**
        *Metodo para obtener la vista y cargar los datos
        *@access public
        *@param Request $request [Description]
        *@return void
        */
        public function index(){
            if( Session::get("permisos")["GET"] ){
              return view("errors.error");
            }
            
            $data = [
                "page_title" 	        => ""
                ,"title"  		        => ""
                ,"data_table"  		    => ""
            ];
            return self::_load_view( "'.$vistas.'",$data );
        }
        /**
         *Metodo para obtener los datos de manera asicronica.
         *@access public
         *@param Request $request [Description]
         *@return void
         */
        public function all( Request $request ){

            try {


              return $this->_message_success( 201, $response , self::$message_success );
            } catch (\Exception $e) {
                $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
                return $this->show_error(6, $error, self::$message_error );
            }

        }
        /**
        *Metodo para realizar la consulta por medio de su id
        *@access public
        *@param Request $request [Description]
        *@return void
        */
        public function show( Request $request ){

            try {


            return $this->_message_success( 201, $response , self::$message_success );
            } catch (\Exception $e) {
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            return $this->show_error(6, $error, self::$message_error );
            }

        }
        /**
        *Metodo para
        *@access public
        *@param Request $request [Description]
        *@return void
        */
        public function store( Request $request){

            $error = null;
            DB::beginTransaction();
            try {


            DB::commit();
            $success = true;
            } catch (\Exception $e) {
            $success = false;
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            DB::rollback();
            }

            if ($success) {
            return $this->_message_success( 201, $response , self::$message_success );
            }
            return $this->show_error(6, $error, self::$message_error );


        }
        /**
        *Metodo para la actualizacion de los registros
        *@access public
        *@param Request $request [Description]
        *@return void
        */
        public function update( Request $request){

            $error = null;
            DB::beginTransaction();
            try {


            DB::commit();
            $success = true;
            } catch (\Exception $e) {
            $success = false;
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            DB::rollback();
            }

            if ($success) {
            return $this->_message_success( 201, $response , self::$message_success );
            }
            return $this->show_error(6, $error, self::$message_error );

        }
        /**
        * Metodo para borrar el registro
        * @access public
        * @param Request $request [Description]
        * @return void
        */
        public function destroy( Request $request ){

            $error = null;
            DB::beginTransaction();
            try {


            DB::commit();
            $success = true;
            } catch (\Exception $e) {
            $success = false;
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            DB::rollback();
            }

            if ($success) {
            return $this->_message_success( 201, $response , self::$message_success );
            }
            return $this->show_error(6, $error, self::$message_error );

        }

    }';
        return $struct;
        
    }
    /**
     * Crea la estructura del modelo a trabajar.
     *
     * @return mixed
     */
    public function struct_modelo( $modelo, $namespace_model =false ){
        $namespace_model = (isset($namespace_model) && $namespace_model)? $namespace_model: 'App\Model\Development';
    $struct = 
'<?php

namespace '.$namespace_model.';

use Illuminate\Database\Eloquent\Model;

class '.$modelo.' extends Model
{
      public $table = "";
      public $fillable = [];
}';
        return $struct;
        
    }
    /**
     * Crea la estructura del archivo de subida de archivo.
     *
     * @return mixed
     */
    public function struct_upload( $modelo, $name_ruta, $ruta_modelo = false ){
    
        $archivo = "app/Http/Controllers/Administracion/Configuracion/UploadController.php";
        $ruta_modelo = (isset($ruta_modelo) && $ruta_modelo )? $ruta_modelo."\n\n" : " App\Model\Development\\".$modelo.";\n\n";
        #dd($ruta_modelo);
        $abrir = fopen($archivo,'r+');
        $contenido = fread($abrir,filesize($archivo));
        fclose($abrir);
        $contenido = explode("\n",$contenido);        
        for($i = 0; $i < count($contenido); $i++){
            if( $i > 34 && $contenido[$i] == ""){
                $contenido[$i] = "use ".$ruta_modelo;
                break;
            }
        }
        for($i = 0; $i < count($contenido); $i++){
            if( $i > 106 && $contenido[$i] == "" ){
                $contenido[$i] = '               case "'.ucwords( strtolower($name_ruta) ).'": 
                $this->_tabla_model = new '.$modelo.'; 
            break;'."\n";
                break;
            }
        }
        $contenido = implode(PHP_EOL,$contenido);
        #dd($contenido);
        $abrir = fopen($archivo,'w');
        fwrite($abrir,$contenido);
        fclose( $abrir);
           
    }
    /**
     * Crea la estructura de la vista blade con su nombre y la estructura a emplear.
     *
     * @return mixed
     */
    public function struct_view( $vista, $ruta_vistas = false){
        $ruta_vista = (isset($ruta_vistas) && $ruta_vistas != "" )? 'resources/views/'.$ruta_vistas."/".strtolower($vista).".blade.php" : 'resources/views/development/'.strtolower($vista).".blade.php";
        $ruta_vista_edit = (isset($ruta_vistas) && $ruta_vistas != "")? 'resources/views/'.$ruta_vistas."/".strtolower($vista)."_edit.blade.php" : 'resources/views/development/'.strtolower($vista)."_edit.blade.php";
        $ruta_script =  (isset($ruta_vistas) && $ruta_vistas != "")? $ruta_vistas."/build_".strtolower($vista).".js" : 'development/build_'.strtolower($vista).".js";
        #dd($ruta_vista,$ruta_vista_edit);
        $vista_edicion = str_replace('resources/views/','',$ruta_vista_edit);
        $vista_edicion = str_replace('.blade.php','',$vista_edicion);
        $vista_edicion = str_replace('/','.',$vista_edicion);
        $ruta_directorio = (isset($ruta_vistas) && $ruta_vistas != "" )? 'resources/views/'.$ruta_vistas.'/' : 'resources/views/development/';
        if( !file_exists($ruta_directorio)){
             mkdir($ruta_directorio, 0777, true);
        }
        if( !file_exists($ruta_vista) && !file_exists($ruta_vista_edit) ){
            fopen($ruta_vista,"w+");
            fopen($ruta_vista_edit,"w+");
        }
        $data = 
'@extends(\'layouts.template.app\')
@section(\'content\')
@push(\'styles\')
@endpush
<div id="vue-'.strtolower($vista).'">
    {!! $data_table !!}
    @include(\''.$vista_edicion.'\')
    {!! $seccion_reportes !!}
</div>
@stop
@push(\'scripts\')
<script type="text/javascript" src="{{asset(\'js/'.$ruta_script.'\')}}"></script>
@endpush';
        $data_edit = 
'<div class="" id="modal_add_register" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Titulo modales </h3>
            </div>
            <div class="modal-body">
                
                
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary" v-on:click.prevent="insert_register()"><i class="fa fa-save"></i> Registrar </button> 
                </div>
            </div>

        </div>
    </div>
</div>';
            file_put_contents($ruta_vista,$data);
            file_put_contents($ruta_vista_edit,$data_edit);
    }
    /**
     * Crea la estructura del js para ptrabajar con el crud de cada archivo.
     *
     * @return mixed
     */
    public function struct_js( $vista, $ruta_js = false ){
        $ruta_script = (isset($ruta_js) && $ruta_js != "" )? 'public/js/'.$ruta_js."/build_".strtolower($vista).".js" : 'public/js/development/build_'.strtolower($vista).".js";
        $ruta_directorio = (isset($ruta_js) && $ruta_js != "" )? 'public/js/'.$ruta_js.'/' : 'public/js/development/';
        if( !file_exists($ruta_directorio)){
             mkdir($ruta_directorio, 0777, true);
        }
        if( !file_exists($ruta_script) ){
            fopen($ruta_script,"w+");
        }
$data = 
'var url_insert  = "'.strtolower($vista).'/register";
var url_update   = "'.strtolower($vista).'/update";
var url_edit     = "'.strtolower($vista).'/edit";
var url_destroy  = "'.strtolower($vista).'/destroy";
var url_all      = "'.strtolower($vista).'/all";
var redireccion  = "configuracion/'.strtolower($vista).'";

new Vue({
  el: "#vue-'.strtolower($vista).'",
  created: function () {
    this.consulta_general();
  },
  data: {
    datos: [],
    insert: {},
    update: {},
    edit: {},
    fields: {},

  },
  mixins : [mixins],
  methods:{
    consulta_general(){
        var url = domain( url_all );
        var fields = {};
        var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
          
              
          }).catch( error => {
              if( isset(error.response) && error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
                console.error(error);
                toastr.error( error.result , expired );
          });
    }
    ,insert_register(){
        var url = domain( url_insert );
        var fields = {};
        var promise = MasterController.method_master(url,fields,"post");
          promise.then( response => {
          
              toastr.success( response.data.message , title );
              
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
        var fields = {};
        var promise = MasterController.method_master(url,fields,"put");
          promise.then( response => {
          
              toastr.success( response.data.message , title );
              
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
          
              toastr.success( response.data.message , title );
              
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
    
    
  }


});'; 
        file_put_contents($ruta_script,$data);
        
        
        
    }
    
}
