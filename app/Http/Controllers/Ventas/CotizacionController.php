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
    use App\Model\Administracion\Configuracion\SysFormasPagosModel;
    use App\Model\Administracion\Configuracion\SysMetodosPagosModel;
    use App\Model\Administracion\Configuracion\SysMonedasModel;
    use App\Model\Administracion\Configuracion\SysProductosModel;
    use App\Model\Administracion\Configuracion\SysPlanesModel;
    use App\Model\Administracion\Configuracion\SysEstatusModel;



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
                 ,'leyenda'   => 'Seleccione Opción'
                 ,'attr'      => 'data-live-search="true" '
                 ,'event'     => 'display_contactos()'                
           ]);

            $formas_pagos = dropdown([
                 'data'       => SysFormasPagosModel::where(['estatus' => 1 ])->orderby('descripcion', 'asc')->get()
                 ,'value'     => 'id'
                 ,'text'      => 'descripcion'
                 ,'name'      => 'cmb_formas_pagos'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opción'
                 ,'attr'      => 'data-live-search="true" '              
           ]);

            $metodos_pagos = dropdown([
                 'data'       => SysMetodosPagosModel::where(['estatus' => 1 ])->orderby('id', 'desc')->get()
                 ,'value'     => 'id'
                 ,'text'      => 'descripcion'
                 ,'name'      => 'cmb_metodos_pagos'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opcion'
                 ,'attr'      => 'data-live-search="true" '               
           ]); 

            $monedas = dropdown([
                 'data'       => SysMonedasModel::where(['estatus' => 1 ])->orderby('descripcion', 'asc')->get()
                 ,'value'     => 'id'
                 ,'text'      => 'descripcion'
                 ,'name'      => 'cmb_monedas'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opción'
                 ,'attr'      => 'data-live-search="true" '                
           ]);

            $productos = dropdown([
                 'data'       => $this->_consulta(new SysProductosModel)
                 ,'value'     => 'id'
                 ,'text'      => 'nombre'
                 ,'name'      => 'cmb_productos'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opción'
                 ,'attr'      => 'data-live-search="true" '   
                 ,'event'     => 'display_productos()'               
           ]);

            $planes = dropdown([
                 'data'       => $this->_consulta(new SysPlanesModel) 
                 ,'value'     => 'id'
                 ,'text'      => 'nombre'
                 ,'name'      => 'cmb_planes'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opción'
                 ,'attr'      => 'data-live-search="true" '   
                 ,'event'     => 'display_planes()'               
           ]);
            /*where(['estatus' => 1 ])->whereIn('id',['94','95','96','97'])->orderby('descripcion', 'asc')->get()*/
            $estatus = dropdown([
                 'data'       => SysEstatusModel::where(['estatus' => 1 ])->orderby('nombre', 'asc')->get()
                 ,'value'     => 'id'
                 ,'text'      => 'nombre'
                 ,'name'      => 'cmb_estatus'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opción'
                 ,'attr'      => 'data-live-search="true" '                
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
                ,'formas_pagos'         => $formas_pagos
                ,'metodos_pagos'        => $metodos_pagos
                ,'monedas'              => $monedas
                ,'productos'            => $productos
                ,'planes'               => $planes
                ,'estatus'              => $estatus
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
                //debuger($request->cotizacion['id_cliente']);
                $cotizaciones = [
                    'codigo'         => isset($request->cotizacion['codigo'])?$request->cotizacion['codigo']:null
                    ,'descripcion'   => isset($request->cotizacion['descripcion'])?$request->cotizacion['descripcion']:0
                    ,'id_cliente'    => isset($request->cotizacion['id_cliente'])?$request->cotizacion['id_cliente']:111
                    ,'id_moneda'     => isset($request->cotizacion['id_moneda'])?$request->cotizacion['id_moneda']:0
                    ,'id_contacto'   => isset($request->cotizacion['id_contacto'])?$request->cotizacion['id_contacto']:0
                    ,'id_metodo_pago'=> isset($request->cotizacion['id_metodo_pago'])?$request->cotizacion['id_metodo_pago']:0
                    ,'id_forma_pago' => isset($request->cotizacion['id_forma_pago'])?$request->cotizacion['id_forma_pago']:0
                    ,'id_estatus'    => isset($request->cotizacion['id_estatus'])?$request->cotizacion['id_estatus']:0
                ];
                //debuger($cotizaciones);

                $datos = SysCotizacionModel::create($cotizaciones);
                $id_user=$datos->id;

                if ($datos == true){
                    debuger(session::all('id'));
                    $datos = [
                    'id_producto'   => isset($request->conceptos['id_producto'])?$request->conceptos['id_producto']:0
                    ,'id_plan'      => isset($request->conceptos['id_plan'])?$request->conceptos['id_plan']:0
                    ,'catidad'      => isset($request->conceptos['cantidad'])?$request->conceptos['cantidad']:null
                    ,'precio'       => isset($request->conceptos['precio'])?$request->conceptos['precio']:null
                    ,'total'        => isset($request->conceptos['total'])?$request->conceptos['total']:null
                ];

                }


            DB::commit();
            $success = true;
            } catch (\Exception $e) {
            $success = false;
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            DB::rollback();
            }

            if ($success) {
            return $this->_message_success( 201, $datos , self::$message_success );
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

          public function getProducto( Request $request ){

            try {
                #debuger($request->input('id'));
                $response = SysProductosModel::where(['estatus' => 1,'id' => $request->input('id')])
                ->orderby('id','asc')
                ->get();
              
            return $this->_message_success( 201, $response[0] , self::$message_success );
            } catch (\Exception $e) {
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            return $this->show_error(6, $error, self::$message_error );
            }

        }

        public function get_planes( Request $request ){

            try {
                #debuger($request->input('id'));
                $response = SysPlanesModel::where(['estatus' => 1,'id' => $request->input('id')])
                ->orderby('id','asc')
                ->get();
              
            return $this->_message_success( 201, $response[0] , self::$message_success );
            } catch (\Exception $e) {
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            return $this->show_error(6, $error, self::$message_error );
            }

        }

    }