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
    use App\Model\Administracion\Configuracion\SysServiciosComercialesModel;
    use App\Model\Administracion\Configuracion\SysProveedoresEmpresasModel;
    use App\Model\Administracion\Configuracion\SysEmpresasModel;
    use App\Model\Administracion\Configuracion\SysSucursalesModel;
    use App\Model\Administracion\Configuracion\SysRegimenFiscalModel;
    use App\Model\Administracion\Configuracion\SysEmpresasSucursalesModel;
    use App\Model\Administracion\Configuracion\SysContactosSistemasModel;
    use App\Model\Administracion\Configuracion\SysProveedoresProductosModel;
    use App\Model\Administracion\Configuracion\SysProductosModel;

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
        $productos = $this->_validate_consulta( new SysProductosModel, ['categorias','unidades'], [], ['id' => Session::get('id_empresa')] );
        // debuger($productos[0]->empresas[0]->razon_social);
        foreach ($productos as $respuesta) {
            $id['id'] = $respuesta->id;
            $checkbox = build_actions_icons($id,'id_producto= "'.$respuesta->id.'" ');
            $producto[] = [
                 (isset($respuesta->empresas[0]) )? $respuesta->empresas[0]->razon_social: ""
                ,$respuesta->codigo
                ,$respuesta->nombre
                ,format_currency($respuesta->subtotal,2)
                ,format_currency($respuesta->total,2)                   
                ,$checkbox
            ];

        }
        $titulos_producto = ['Empresa','Clave','Producto', 'SubTotal','Total'];
        $table_producto = [
            'titulos'          => $titulos_producto
            ,'registros'       => $producto
            ,'id'              => "datatable_productos"
            ,'class'           => "fixed_header"
        ];

            $data = [
             "page_title" 	         => "Almacén"
             ,"title"  		         => "Proveedores"
             ,"data_table"           => "data_table(table)"
             ,"data_table_producto"  => data_table($table_producto)
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
                // $response = $this->_tabla_model::with(['estados','contactos:id,nombre_completo,correo,telefono','empresas'])->orderBy('id','DESC')->get();
                $datos = $this->consulta_proveedores();


        $data = [
          'proveedores'           => $datos['response_proveedores']
          ,'empresas'             => SysEmpresasModel::where(['estatus' => 1])->groupby('id')->get()
          ,'paises'               => SysPaisModel::get()
          ,'servicio_comercial'   => SysServiciosComercialesModel::get()
          ,'regimen_fiscal'       => SysRegimenFiscalModel::get()
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
                $response = SysProveedoresModel::with(['contactos','empresas'])->where(['id' => $request->id])->get();
                
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
                
                // debuger($request->all());
            //     debuger($string_data_proveedor);
            // echo "string";die();
               $response = $this->_tabla_model::create( $string_data_proveedor );
               $response_contactos = SysContactosModel::create($string_data_contactos);
                $data = [
                 'id_empresa'  =>  Session::get('id_empresa')  
                ,'id_proveedor'=> $response->id
                ,'id_sucursal' =>  Session::get('id_sucursal') 
                
                ];
                
                SysProveedoresEmpresasModel::create($data);
                $datos['id_contacto'] = $response_contactos->id;   
                $datos['id_proveedor']  = $response->id;   
                SysContactosSistemasModel::create($datos);    

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
                     'id_contacto'     => $response_contactos->id
                    ,'id_proveedor'      => $request->id
                ];
               
                  SysContactosSistemasModel::create($data); 

                  if (Session::get('id_rol') != 1) {
                  $datos['id_empresa']  = Session::get('id_empresa');
                  $datos['id_sucursal'] = Session::get('id_sucursal');
                  SysProveedoresEmpresasModel::create($datos); 
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
    * Metodo para borrar el registro
    * @access public
    * @param Request $request [Description]
    * @return void
    */
    public function destroy( Request $request ){

        $error = null;
        DB::beginTransaction();
        try {
            $response = SysContactosSistemasModel::where(['id_proveedor' => $request->id])->get(['id_contacto']); 
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
    /**
     * Metodo para borrar el registro
     * @access public
     * @param Request $request [Description]
     * @return void
     */
    public function display_sucursales( Request $request ){
        // debuger($request->all());
        try {
            $response = SysEmpresasModel::with(['sucursales' => function($query){
                return $query->where(['sys_sucursales.estatus' => 1])->groupby('id')->get();
            }])->where(['id' => $request->id_empresa])->get();
            
            $sucursales = SysProveedoresEmpresasModel::select('id_sucursal')->where($request->all())->get();
            // debuger($sucursales);
            #se crea la tabla 
            $registros = [];
            foreach ($response[0]->sucursales as $respuesta) {
                $id['id'] = 'sucursal_'.$respuesta->id;
                $icon = build_actions_icons($id, 'id_sucursal="' . $respuesta->id . '" ','sucursal');
                $registros[] = [
                    $respuesta->codigo
                    ,$respuesta->sucursal
                    ,$respuesta->direccion
                    ,($respuesta->estatus == 1)?"ACTIVO":"BAJA"
                    ,$icon
                ];
            }

            $titulos = [ 'Codigo','Sucursal','Direccion', 'Estatus',''];
            $table = [
                'titulos'          => $titulos
                ,'registros'       => $registros
                ,'id'              => "sucursales"
            ];
            $data = [
                'tabla_sucursales'  => data_table($table)
                ,'sucursales'       => $sucursales
            ];
            return $this->_message_success(200, $data, self::$message_success);
        } catch (\Exception $e) {
            $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
            return $this->show_error(6, $error, self::$message_error);
        }

        
    }
    /**
     * Metodo para insertar los permisos de los productos
     * @access public
     * @param Request $request [Description]
     * @return void
     */
    public function register_permisos(Request $request){

        $error = null;
        DB::beginTransaction();
        try { 
           // debuger($request->all());
            SysProveedoresEmpresasModel::where(['id_proveedor' => $request->id_proveedor ])->delete();
            $response = [];
            for ($i=0; $i < count($request->matrix) ; $i++) { 
                $matrices = explode('|', $request->matrix[$i] );
                $id_sucursal = $matrices[0];
                #se realiza una consulta si existe un registro.
                $data = [
                    'id_empresa'      => $request->id_empresa
                    ,'id_sucursal'    => $id_sucursal
                    ,'id_proveedor'   => $request->id_proveedor

                ];
                $response[] = SysProveedoresEmpresasModel::create($data);
                // debuger($response);
            }

            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            $success = false;
            $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
            DB::rollback();
        }

        if ($success) {
            return $this->_message_success(201, $response, self::$message_success);
        }
        return $this->show_error(6, $error, self::$message_error);

    }
     /**
     * Metodo para insertar los permisos de los productos
     * @access public
     * @param Request $request [Description]
     * @return void
     */
    public function consulta_proveedores(){


        if( Session::get('id_rol') == 1 ){

            $response_proveedores = SysProveedoresModel::with(['estados','contactos','empresas','productos'])
                            
                            ->orderBy('id','desc')
                            ->groupby('id')
                            ->get();

          

        }elseif( Session::get('id_rol') == 3 ){
            $data = SysEmpresasModel::with(['proveedores'])
            ->where(['id' => Session::get('id_empresa')])            
            ->get();

            
            $response_proveedores = $data[0]->proveedores()
                                    ->with(['estados','contactos','empresas'])
                                
                                    ->orderBy('id','desc')
                                    ->groupby('id')
                                    ->get();

        }else{

            $data = SysUsersModel::with(['empresas'])
                                  ->where(['id' => Session::get('id')])            
                                  ->get();
            $empresas = $data[0]->empresas()
                                ->with(['proveedores'])
                                ->where([ 'id' => Session::get('id_empresa') ])
                                ->get();
            
            $response_proveedores = $empresas[0]->proveedores()
                                    ->with(['estados','contactos','empresas'])
                                    
                                    ->orderBy('id','desc')
                                    ->groupby('id')
                                    ->get();


        }
        
        return [ 'response_proveedores' => $response_proveedores ];

    }
     /**
     * Metodo para insertar los permisos de los productos
     * @access public
     * @param Request $request [Description]
     * @return void
     */
    public function asignar( Request $request ){
        try {
         $response = SysProveedoresModel::with(['productos'])
                                            ->where(['id' => $request->id])
                                            ->get();
         #$response = $proveedores[0]->productos()->get();

        return $this->_message_success( 200, $response[0] , self::$message_success );
        } catch (\Exception $e) {
        $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
        return $this->show_error(6, $error, self::$message_error );
        }

    }
     /**
     * Metodo para insertar los permisos de los productos
     * @access public
     * @param Request $request [Description]
     * @return void
     */
    public function asignar_insert( Request $request ){            
           $error = null;
            DB::beginTransaction();
            try {
                $response = [];
                $proveedores = SysProveedoresModel::with(['empresas','sucursales'])->where(['id'=> $request->id_proveedor])->get();
                $where = [
                     'id_empresa' => (Session::get('id_rol') == 1 && isset($proveedores[0]->empresas[0]) )? $proveedores[0]->empresas[0]->id : Session::get('id_empresa')
                    ,'id_sucursal' => ( Session::get('id_rol') == 1 && isset($proveedores[0]->sucursales[0])  )? $proveedores[0]->sucursales[0]->id:Session::get('id_sucursal')
                    ,'id_proveedor' => $request->id_proveedor
                    ,'id_rol'  =>  Session::get('id_rol')
                    ,'id_users' =>  Session::get('id')
                ]; 
                // debuger($where);              

                SysProveedoresProductosModel::where( $where )->delete();
                for($i = 0; $i < count($request->matrix); $i++){
                    $matrices = explode('|',$request->matrix[$i]);
                    $id_producto = $matrices[0];
                    $productos = SysProductosModel::with(['proveedores'])->where(['id' => $id_producto])->get();
                
                    debuger($productos);
                    $data = [
                         'id_empresa' => (Session::get('id_rol') == 1 && isset($productos[0]->empresas[0]) )? $productos[0]->empresas[0]->id : Session::get('id_empresa')
                        ,'id_sucursal'=> ( Session::get('id_rol') == 1 && isset($productos[0]->sucursales[0])  )? $productos[0]->sucursales[0]->id:Session::get('id_sucursal')
                        ,'id_proveedor' => $request->id_proveedor
                        ,'id_producto' => $id_producto
                        ,'id_rol'  =>  Session::get('id_rol')
                        ,'id_users' =>  Session::get('id')
                    ];                  

                        $response[] = SysProveedoresProductosModel::create($data);
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

}