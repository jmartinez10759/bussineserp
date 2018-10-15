<?php
    namespace App\Http\Controllers\Administracion\Configuracion;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Session;
    use App\Http\Controllers\MasterController;
    use App\Model\Administracion\Configuracion\SysCuentasModel;
    use App\Model\Administracion\Configuracion\SysEmpresasModel;
    use App\Model\Administracion\Configuracion\SysCuentasEmpresasModel;

    class CuentasController extends MasterController
    {
        #se crea las propiedades
        private $_tabla_model;

        public function __construct(){
            parent::__construct();
            $this->_tabla_model = new SysCuentasModel;
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
            $response = ( Session::get('id_rol') == 1 )? $this->_tabla_model::with(['empresas','clientes','contactos'])->orderby('id','desc')->get() : $this->_consulta($this->_tabla_model);
            #debuger($response);
            $eliminar = (Session::get('permisos')['DEL'] == false)? 'style="display:block" ': 'style="display:none" ';
            $permisos = (Session::get('id_rol') == 1 || Session::get('permisos')['PER'] == false) ? 'style="display:block" ' : 'style="display:none" ';
            $registros = [];
            foreach ($response as $respuesta) {
                $id['id'] = $respuesta->id;
                $editar   = build_acciones_usuario($id,'v-edit_register','Editar','btn btn-primary','fa fa-edit');
                $borrar   = build_acciones_usuario($id,'v-destroy_register','Borrar','btn btn-danger','fa fa-trash','title="Borrar" '.$eliminar);            
                $registros[] = [
                    $respuesta->nombre_comercial
                    ,$respuesta->giro_comercial
                    ,isset( $respuesta->empresas[0] )?$respuesta->empresas[0]->rfc_emisor: ""
                    ,isset( $respuesta->clientes[0] )?$respuesta->clientes[0]->rfc_receptor: ""
                    ,isset( $respuesta->contactos[0] )?$respuesta->contactos[0]->correo: ""
                    ,($respuesta->estatus == 1)?"ACTIVO":"BAJA"
                    ,$editar
                    ,$borrar
                ];


            }
            $titulos = ['Cuenta','Giro Comercial','RFC Empresa','RFC Cliente','Correo Contacto','Estatus','','',''];
            $table = [
                'titulos' 		   => $titulos
                ,'registros' 	   => $registros
                ,'id' 			   => "datatable"
                ,'class'           => "fixed_header"
            ];
            #se realiza el combo de empresas 
            $cmb_empresas = dropdown([
                'data'      => (Session::get('id_rol') == 1)? SysEmpresasModel::where(['estatus' => 1 ])->get(): SysEmpresasModel::where(['estatus' => 1, 'id' => Session::get('id_empresa') ])->get() 
                ,'value'     => 'id'
                ,'text'      => 'rfc_emisor nombre_comercial'
                ,'name'      => 'cmb_empresas'
                ,'class'     => 'form-control'
                ,'leyenda'   => 'Seleccione Opcion'
                ,'attr'      => 'data-live-search="true" '
                ,'event'     => 'display_clientes()'
            ]);
            
            $data = [
                "page_title" 	        => "Configuración"
                ,"title"  		        => "Cuentas"
                ,"data_table"  		    => data_table($table)
                ,'cmb_empresas'         => $cmb_empresas
            ];
            return self::_load_view( "administracion.configuracion.cuentas",$data );
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
                for($i=0; $i < count($request->clientes); $i++){
                    if( Session::get('id_rol') == 1){
                        SysEmpresasSucursalesModel::where(['id_empresa' => $request->empresa, 'id_cliente' => $request->clientes[$i] ])->delete();
                    }else{
                        SysEmpresasSucursalesModel::where(['id_empresa' => Session::get('id_empresa'), 'id_cliente' => $request->clientes[$i]])->delete();
                    }
                }
                $data_cuenta = [
                    'nombre_comercial'  =>  isset($request->nombre_comercial)?$request->nombre_comercial: ""
                    ,'giro_comercial'   =>  isset($request->giro_comercial)?$request->nombre_comercial: ""
                    ,'estatus'          =>  isset($request->estatus)? $request->estatus : ""
                ];
                $response = $this->_tabla_model::create($data_cuenta);
                for($i=0; $i < count($request->clientes); $i++){
                    $data = [
                      'id_cuenta'      =>   $response->id     
                      ,'id_cliente'    =>   $request->clientes[$i]
                      ,'id_contacto'   =>   $request->contacto
                      ,'id_proveedor'  =>   0
                      ,'estatus'       =>   1
                    ];
                    if( Session::get('id_rol') == 1){
                        $data['id_empresa']  = $request->empresa;
                        $data['id_sucursal'] = $request->sucursal;
                        SysEmpresasSucursalesModel::create($data);
                    }else{
                        $data['id_empresa'] = Session::get('id_empresa');
                        $data['id_sucursal'] = Session::get('id_sucursal');
                        SysEmpresasSucursalesModel::create($data);
                    }
                }
                
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
        *Metodo para realizar la consulta por medio de su id
        *@access public
        *@param Request $request [Description]
        *@return void
        */
        /*public function display_clientes( Request $request ){ 

            try {
                
            return $this->_message_success( 201, $response , self::$message_success );
            } catch (\Exception $e) {
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            return $this->show_error(6, $error, self::$message_error );
            }

        }*/
        
        

    }