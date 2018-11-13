<?php
    namespace App\Http\Controllers\Administracion\Configuracion;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Session;
    use App\Http\Controllers\MasterController;
    use App\Model\Administracion\Configuracion\SysTiposComprobantesModel;

    class TiposComprobantesController extends MasterController
    {
        #se crea las propiedades
        private $_tabla_model;

        public function __construct(){
            parent::__construct();
            $this->_tabla_model = new SysTiposComprobantesModel;
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
            $response = $this->_tabla_model::get();
            #debuger($this->_tabla_model);
            $registros = [];
           $registros_tiposComprobantes = [];
           $permisos = (Session::get('permisos')['PER'] == false)? 'style="display:block" ': 'style="display:none" ';
           foreach ($response as $respuesta) {
             $id['id'] = $respuesta->id;
             $editar = build_acciones_usuario($id,'v-edit_register','Editar','btn btn-primary','fa fa-edit','title="editar" ' );             
             $borrar   = build_buttons(Session::get('permisos')['DEL'],'v-destroy_register('.$respuesta->id.')','Borrar','btn btn-danger','fa fa-trash','title="Borrar"');
             
             $registros[] = [
                $respuesta->id
               ,$respuesta->nombre
               ,$respuesta->descripcion 
               ,($respuesta->estatus == 1)?"ACTIVO":"BAJA"
               ,$editar
               ,$borrar
              ];
           }
           $titulos = [ 'ID','Nombre','Descripcion','Estatus','',''];
           $table = [
             'titulos'          => $titulos
             ,'registros'       => $registros
             ,'id'              => "datatable"
           ];

            $data = [
                "page_title" 	        => "Configuración"
                ,"title"  		        => "Tipo de Comprobantes"
                ,"data_table"  		    => data_table($table)
                ,'titulo_modal'            => "Registro de Tipos de Comprobantes"
                ,'titulo_modal_edit'       => "Actualización de Tipos de Comprobantes"
                
            ];
            return self::_load_view( "administracion.configuracion.tiposcomprobantes",$data );
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
                $where = ['id' => $request->id];
            $response = SysTiposComprobantesModel::where( $where )->groupby('id')->get();

            return $this->_message_success( 201, $response[0] , self::$message_success );
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
                $string_key_tipoComprobantes = [ 'nombre','descripcion','estatus' ];
                $string_data_tiposComprobantes = [];
                foreach( $request->all() as $key => $value ){
                    
                    if( in_array( $key, $string_key_tipoComprobantes) ){
                        $string_data_tiposComprobantes[$key] = $value;
                    };
                    
                }
                // debuger($string_data_tiposComprobantes);
               $response = $this->_tabla_model::create( $string_data_tiposComprobantes );
                

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
                $string_key_tipoComprobantes = [ 'nombre','descripcion','estatus'];
                $string_data_tiposComprobantes = [];
                foreach( $request->all() as $key => $value ){
                    if( in_array( $key, $string_key_tipoComprobantes) ){
                       $string_data_tiposComprobantes[$key] = $value; 
                    }
                    
            }
             $response = $this->_tabla_model::where(['id' => $request->id] )->update( $string_data_tiposComprobantes );

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
                $response = SysTiposComprobantesModel::where(['id' => $request->id])->delete();

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

    }