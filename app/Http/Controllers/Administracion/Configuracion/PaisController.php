<?php
    namespace App\Http\Controllers\Administracion\Configuracion;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Session;
    use App\Http\Controllers\MasterController;
    use App\Model\Administracion\Configuracion\SysPaisModel;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Response;

    class PaisController extends MasterController
    {
        private $_tabla_model;

        public function __construct(){
            parent::__construct();
            $this->_tabla_model = new SysPaisModel;
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
                "page_title" 	        => "Configuración"
                ,"title"  		        => "Paises"
                ,"data_table"  		    => ""
            ];
            return self::_load_view( "administracion.configuracion.pais",$data );
        }
        /**
         *Metodo para obtener los datos de manera asicronica.
         *@access public
         *@param Request $request [Description]
         *@return void
         */
        public function all( Request $request ){
            // debuger($request->all());
            try {
                $response = $this->_tabla_model::orderby('id','DESC')->get();
              return $this->_message_success( 200, $response , self::$message_success );
            } catch (\Exception $e) {
                $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
                return $this->show_error(6, $error, self::$message_error );
            }

        }

    /**
     * This method is used get for data information countries
     * @access public
     * @param int|null $id
     * @param SysPaisModel $countries
     * @return JsonResponse
     */
    public function show( int $id = null, SysPaisModel $countries )
    {
        try {
            $country = $countries->with("estados")->find($id);
            return new JsonResponse([
                "success" => TRUE ,
                "data"    => $country ,
                "message" => self::$message_success
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            return new JsonResponse([
                "success" => FALSE ,
                "data"    => $error ,
                "message" => self::$message_error
            ], Response::HTTP_BAD_REQUEST);
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
                #debuger($request->all());
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
                
                $string_key_estados = [ 'clave','nombre','country_id' ];
                $string_key_paises = [ 'descripcion','formato_codigo_postal','formato_registro','validacion_registro','agrupaciones','created_at','updated_at','clave'  ];
                $string_data_pais = [];
                $string_data_estado = [];
                foreach( $request->all() as $key => $value ){
                    
                    if( in_array( $key, $string_key_paises) ){
                       $string_data_pais[$key] = $value; 
                    }
                    
            }
            // debuger($string_data_pais);

               $response = $this->_tabla_model::where(['id' => $request->id] )->update( $string_data_pais );

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
                $response = SysPaisModel::where(['id' => $request->id])->delete();
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