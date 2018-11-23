<?php
    namespace App\Http\Controllers\Administracion\Configuracion;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Session;
    use App\Http\Controllers\MasterController;
    use App\Model\Administracion\Configuracion\SysTasaModel;
    use App\Model\Administracion\Configuracion\SysTipoFactorModel;

    class TasaController extends MasterController
    {
        #se crea las propiedades
        private $_tabla_model;

        public function __construct(){
            parent::__construct();
            $this->_tabla_model = new SysTasaModel;
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
               ,$respuesta->clave
               ,$respuesta->factor
               ,$respuesta->rango
               ,$respuesta->valor_minimo
               ,$respuesta->valor_maximo       
                
               ,$editar
               ,$borrar
              ];
           }    
           $titulos = [ 'ID','Clave','Factor','Rango','Valor Maximo','Valor Minimo','',''];
           $table = [
             'titulos'          => $titulos
             ,'registros'       => $registros
             ,'id'              => "datatable"
             ,'class' => "fixed_header"
           ];        
            $data = [
                "page_title" 	        => "Configuración"
                ,"title"  		        => "Tasa"
                ,"data_table"  		    => data_table($table)
                ,'titulo_modal'            => "Registro de Tasas"
                ,'titulo_modal_edit'       => "Actualización de Tasas"
            ];
            return self::_load_view( "administracion.configuracion.tasa",$data );
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
            $response = SysTasaModel::where( $where )->groupby('id')->get();

            return $this->_message_success( 200, $response[0] , self::$message_success );
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
                 $response = $this->_tabla_model::create( $request->all() );

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
                 $response = $this->_tabla_model::where(['id' => $request->id] )->update( $request->all() );

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
                $response = SysTasaModel::where(['id' => $request->id])->delete();


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
     * Metodo para consultar la tasa con la clave de tipo factor
     * @access public
     * @param Request $request [Description]
     * @return void
     */
    public function factor_tasa( Request $request ){
        try {
            $where = ['id' => $request->id];
            $tipo_factor = SysTipoFactorModel::select('clave')->where($where)->get();
            $response = $this->_tabla_model::where( ['factor' => $tipo_factor[0]->clave] )->groupby('id')->get();
        return $this->_message_success( 200, $response , self::$message_success );
        } catch (\Exception $e) {
        $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
        return $this->show_error(6, $error, self::$message_error );
        }

    }




    }