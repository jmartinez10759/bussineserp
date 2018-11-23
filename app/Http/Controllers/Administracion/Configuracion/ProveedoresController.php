<?php
    namespace App\Http\Controllers\Administracion\Configuracion;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Session;
    use App\Http\Controllers\MasterController;
    use App\Model\Administracion\Configuracion\SysProveedoresModel;
    use App\Model\Administracion\Configuracion\SysUsersModel;
    use App\Model\Administracion\Configuracion\SysPaisModel;
    use App\Model\Administracion\Configuracion\SysEstadosModel;
    use App\Model\Administracion\Configuracion\SysContactosModel;
    use App\Model\Administracion\Configuracion\SysClaveProdServicioModel;
    use App\Model\Administracion\Configuracion\SysProveedoresEmpresasModel;
    use App\Model\Administracion\Configuracion\SysEmpresasModel;
    use App\Model\Administracion\Configuracion\SysSucursalesModel;
    use App\Model\Administracion\Configuracion\SysRegimenFiscalModel;
    


    class ProveedoresController extends MasterController
    {
        #se crea las propiedades
        private $_tabla_model;

        public function __construct(){
            parent::__construct();
            $this->_tabla_model = new SysProveedoresModel;
        }
        /**
        *Metodo para obtener la vista y cargar los datos
        *@access public
        *@param Request $request [Description]
        *@return void
        */
        public function index(){
        if( Session::get('permisos')['GET'] ){
          return view('errors.error');
        }        
                $data = [
             "page_title" 	        => "Almacén"
             ,"title"  		        => "Proveedores"
           ];
                
                return self::_load_view( "administracion.configuracion.proveedores",$data );
        }
        /**
         *Metodo para obtener los datos de manera asicronica.
         *@access public
         *@param Request $request [Description]
         *@return void
         */
        public function all( Request $request ){

            try {
                // $response = $this->_tabla_model::where([ 'id' => $request->id ])->get();
                $response = $this->_tabla_model::with(['estados','contactos'])->orderBy('id')->get();
        $data = [
          'proveedores'            => $response
          ,'paises'               => SysPaisModel::get()
          ,'servicio_comercial'   => SysClaveProdServicioModel::get()
          ,'regimen_fiscal'             => SysRegimenFiscalModel::get()
        ];


              return $this->_message_success( 200, $data , self::$message_success );
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
                $response = SysProveedoresModel::with(['contactos'])->where(['id' => $request->id])->get();
                
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
            // debuger($request->all());
            $error = null;
            DB::beginTransaction();
            try {
                $string_key_contactos = [ 'contacto','telefono','departamento','correo' ];
                $string_data_proveedor = [];
                $string_data_contactos = [];
                foreach( $request->all() as $key => $value ){
                    if( in_array( $key, $string_key_contactos) ){
                        if( $key == 'contacto' ){
                            $string_data_contactos['nombre_completo'] = strtoupper($value);
                        }else if( $key == 'correo'){
                            $string_data_contactos[$key] = $value;
                        }else{
                            $string_data_contactos[$key] = strtoupper($value);
                        }
                    };
                    if( !in_array( $key, $string_key_contactos) ){
                      if( !is_array($value)){
                            if($key == "logo"){
                              $string_data_proveedor[$key] = (trim($value));
                            }else{
                        $string_data_proveedor[$key] = strtoupper($value);
                            }
                      }
                    };
                    
                }
                
                // debuger($string_data_proveedor);
               $response = $this->_tabla_model::create( $string_data_proveedor );
               $response_contactos = SysContactosModel::create($string_data_contactos);
                $data = [
                     'id_empresa' => session::get('id_empresa')
                    ,'id_proveedor' => $response->id
                    ,'id_sucursal' => session::get('id_sucursal')
                    ,'id_contacto' => $response_contactos->id
                ];
                
               SysProveedoresEmpresasModel::create($data);    

                // debuger($request->all());
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
                $string_key_contactos = [ 'contacto','departamento','telefono', 'correo' ];
                $string_key_proveedores = [ 'rfc','nombre_comercial','razon_social','calle', 'colonia','logo','estatus','municipio','created_at','updated_at','id_codigo','id_estado','id_servicio_comercial','id_regimen_fiscal','id_country' ];
                $string_data_proveedor = [];
                $string_data_contactos = [];
                foreach( $request->all() as $key => $value ){
                    if( in_array( $key, $string_key_contactos) ){
                        if( $key == 'contacto' ){
                            $string_data_contactos['nombre_completo'] = strtoupper($value);
                        }else if( $key == 'correo'){
                            $string_data_contactos[$key] = $value;
                        }else{
                            $string_data_contactos[$key] = strtoupper($value);
                            
                        }
                    };
                    if( in_array( $key, $string_key_proveedores) ){
                      if( !is_array($value)){
                            if($key == "logo"){
                              $string_data_proveedor[$key] = (trim($value));
                            }else{
                        $string_data_proveedor[$key] = strtoupper($value)   ;
                            }
                      } 
                    };
                    
            }
            // debuger($string_data_proveedor);
            // echo "string";die();

             $response = $this->_tabla_model::where(['id' => $request->id] )->update( $string_data_proveedor );
            if( count($request->contactos) > 0){
               SysContactosModel::where(['id' => $request->contactos[0]['id'] ])->update($string_data_contactos);
            }else{
                $response_contactos = SysContactosModel::create($string_data_contactos);
                $data = [
                     'id_empresa' => session::get('id_empresa')
                    ,'id_proveedor' => $response->id
                    ,'id_sucursal' => session::get('id_sucursal')
                    ,'id_contacto' => $response_contactos->id
                ];
            SysProveedoresEmpresasModel::create($data);   
                
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
        * Metodo para borrar el registro
        * @access public
        * @param Request $request [Description]
        * @return void
        */
        public function destroy( Request $request ){

            $error = null;
            DB::beginTransaction();
            try {
                // debuger($request->all());
                $response = SysProveedoresEmpresasModel::where(['id_proveedor' => $request->id])->get(); 
                if( count($response) > 0){
                    for($i = 0; $i < count($response); $i++){
                        SysContactosModel::where(['id' => $response[$i]->id_contacto])->delete();
                    }
                }
                $this->_tabla_model::where(['id' => $request->id])->delete();
                SysProveedoresEmpresasModel::where(['id_proveedor' => $request->id])->delete();

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