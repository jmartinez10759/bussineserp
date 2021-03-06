<?php
    namespace App\Http\Controllers\Administracion\Configuracion;
    use File;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\Session;
    use App\Http\Controllers\MasterController;
    use App\Model\Administracion\Configuracion\SysEstadosModel;
    use App\Model\Administracion\Configuracion\SysCodigoPostalModel;
    use Symfony\Component\HttpFoundation\JsonResponse;

    class CodigoPostalController extends MasterController
    {
        private $_tabla_model;

        public function __construct(){
            parent::__construct();
            $this->_tabla_model = new SysCodigoPostalModel;
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
                "page_title" 	        => "Configuracion"
                ,"title"  		        => "Código Postal"
                ,"data_table"  		    => ""
                ,'script'               => incJs('https://ajax.googleapis.com/ajax/libs/angularjs/1.7.5/angular.min.js')
                ,'script_route'         => incJs('https://ajax.googleapis.com/ajax/libs/angularjs/1.7.5/angular-route.js')
            
            ];
            return self::_load_view( "administracion.configuracion.codigopostal",$data );
        }
        /**
         *Metodo para obtener los datos de manera asicronica.
         *@access public
         *@param Request $request [Description]
         *@return void
         */
        public function all( Request $request ){

            try {
                $response = $this->_tabla_model::orderby('id','DESC')->get();
              return $this->_message_success( 200, $response , self::$message_success );
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
                $response = $this->_tabla_model::where([ 'id' => $request->id ])->get();

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
                $response = SysCodigoPostalModel::where(['id' => $request->id])->delete();

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
        *Metodo para realizar la consulta por medio de su id
        *@access public
        *@param Request $request [Description]
        *@return void
        */
        public function show_clave( Request $request ){
            #debuger($request->all());
            try {
                $estado = SysEstadosModel::select('id','clave')->where(['id' => $request->id])->get();
                $response = $this->_tabla_model::select('id','codigo_postal')->where(['estado' => isset($estado[0])? $estado[0]->clave: 0 ])->get();
                return $this->_message_success( 201, $response , self::$message_success );

            } catch (\Exception $e) {
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            return $this->show_error(6, $error, self::$message_error );
            }

        }

        /**
         * This method is used get for postal code
         * @param int $postalCode
         * @param SysEstadosModel $states
         * @return JsonResponse
         */
        public function getPostalCode( int $postalCode = null, SysEstadosModel $states )
        {
            try {

                if(strlen($postalCode) >= 4 ){
                    $state = $states->with("countries")->where('cp','LIKE', $postalCode.'%')->get();
                    return new JsonResponse([
                        "success" => TRUE ,
                        "data"    => $state,
                        "message" => self::$message_success
                    ],Response::HTTP_OK);
                }

            } catch (\Exception $e) {
                $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
                return new JsonResponse([
                    "success" => FALSE ,
                    "data"    => $error ,
                    "message" => self::$message_error
                ],Response::HTTP_BAD_REQUEST);
            }

        }


    }