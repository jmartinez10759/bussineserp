<?php
    namespace App\Http\Controllers\Ventas;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Session;
    use App\Http\Controllers\MasterController;
    use App\Model\Ventas\SysCotizacionModel;
    use App\Model\Administracion\Configuracion\SysClientesModel;
    use App\Model\Administracion\Configuracion\SysUsersModel;
    use App\Model\Administracion\Configuracion\SysContactosModel;



    class CotizacionController extends MasterController
    {
        #se crea las propiedades
        private $_tabla_model;

        public function __construct(){
            parent::__construct();
            $this->_tabla_model = new SysCotizacionModel;
        }
        /**
        *Metodo para obtener la vista y cargar los datos
        *@access public
        *@param Request $request [Description]
        *@return void
        */
        public function index(){
            #debuger(session::all());
            $users    = SysUsersModel::with(['roles' => function($query){
                            return $query->where(['sys_users_roles.id_rol' => 2]);
                        },"empresas"])->where('id','=',Session::get('id'))->where(['estatus' => 1])->get();
            #debuger($users);
            $clientes = dropdown([
                 'data'       => SysClientesModel::where(['estatus' => 1 ])->orderby('id', 'desc')->get()
                 ,'value'     => 'id'
                 ,'text'      => 'razon_social rfc_receptor'
                 ,'name'      => 'cmb_clientes'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opcion'
                 ,'attr'      => 'data-live-search="true" '
                 ,'event'     => 'display_contactos()'                
           ]);
            /*$response = SysClientesModel::with(['contactos'])
                ->where(['estatus' => 1,'id' => $request->input('id')])
                ->orderby('id','asc')
                ->get();*/
            
            if( Session::get("permisos")["GET"] ){
              return view("errors.error");
            }
            
            $data = [
                "page_title" 	        => "Ventas"
                ,"title"  		        => "Cotizaciones"
                ,"data_table"           => ""
                ,'iva'                  => Session::get('iva')
                ,'clientes'             => $clientes
            ];
            return self::_load_view( "ventas.cotizacion",$data );
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
        /**
        * Metodo para traer informacion de la empresa cliente
        * @access public
        * @param Request $request [Description]
        * @return void
        */
        public function getbycontactos( Request $request ){

            try {
                $response = SysContactosModel::where(['id' => $request->id])->get();
                #$response = SysClientesModel::all();
            return $this->_message_success( 201, $response[0] , self::$message_success );
            } catch (\Exception $e) {
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            return $this->show_error(6, $error, self::$message_error );
            }

        }
        /**
        * Metodo para traer informacion de la empresa cliente
        * @access public
        * @param Request $request [Description]
        * @return void
        */
        public function getContacto( Request $request ){

            try {
                #debuger($request->input('id'));
                $response = SysClientesModel::with(['contactos'])
                ->where(['estatus' => 1,'id' => $request->input('id')])
                ->orderby('id','asc')
                ->get();
                #debuger($response);
                $contactos = [];
                foreach ($response as $contacto) {
                    $contactos = $contacto->contactos;
                }                
                $contact = dropdown([
                     'data'       => $contactos
                     ,'value'     => 'id'
                     ,'text'      => 'nombre_completo'
                     ,'name'      => 'cmb_contactos'
                     ,'class'     => 'form-control'
                     ,'leyenda'   => 'Seleccione Opcion'
                     ,'attr'      => 'data-live-search="true" '
                     ,'event'      => 'parser_data()'
               ]);
                $data = [
                    'combo_contactos' => $contact
                    ,'rfc' => isset($response[0])? $response[0]->rfc_receptor:""
                    ,'telefono' => isset($response[0])? $response[0]:""
                    ,'correo' => isset($response[0])? $response[0]: ""
                ];
                #$response = SysClientesModel::all();
            return $this->_message_success( 201, $data , self::$message_success );
            } catch (\Exception $e) {
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            return $this->show_error(6, $error, self::$message_error );
            }

        }

    }