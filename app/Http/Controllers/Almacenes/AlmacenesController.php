<?php
    namespace App\Http\Controllers\Almacenes;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Session;
    use App\Http\Controllers\MasterController;
    use App\Model\Almacenes\SysAlmacenesModel;
    use App\Model\Almacenes\SysAlmacenesProductosModel;
    use App\Model\Administracion\Configuracion\SysProveedoresModel;
    use App\Model\Administracion\Configuracion\SysUsersModel;
    use App\Model\Administracion\Configuracion\SysEmpresasModel;
    use App\Model\Administracion\Configuracion\SysSucursalesModel;
    use App\Model\Administracion\Configuracion\SysEmpresasSucursalesModel;
    use App\Model\Administracion\Configuracion\SysProductosModel;
    use App\Model\Administracion\Configuracion\SysProveedoresProductosModel;
    use App\Model\Administracion\Configuracion\SysAlmacenesEmpresasModel;

    class AlmacenesController extends MasterController
    {
        #se crea las propiedades
        private $_tabla_model;

        public function __construct(){
            parent::__construct();
            $this->_tabla_model = new SysAlmacenesModel;
        }
        /**
        *Metodo para obtener la vista y cargar los datos
        *@access public
        *@param Request $request [Description]
        *@return void
        */
        public function index(Request $request){

            if( Session::get("permisos")["GET"] ){
              return view("errors.error");
            }
            $productos = $this->_validate_consulta( new SysProductosModel, ['categorias','unidades'], [], ['id' => Session::get('id_empresa')]);
        // debuger($productos[0]->proveedores[0]->nombre_comercial);


        foreach ($productos as $respuesta) {
            $id['id'] = $respuesta->id;
            $checkbox = build_actions_icons($id,'id_producto= "'.$respuesta->id.'" ');
            $producto[] = [
                 (isset($respuesta->empresas[0]) )? $respuesta->empresas[0]->razon_social: ""
                 // ,(isset($respuesta->proveedores[0]) )? $respuesta->proveedores[0]->nombre_comercial: ""
                ,$respuesta->codigo
                ,$respuesta->nombre
                ,format_currency($respuesta->subtotal,2)
                ,format_currency($respuesta->total,2)                   
                ,$checkbox
            ];

        }
        // $titulos_producto = ['Empresa','Proveedor','Clave','Producto', 'SubTotal','Total'];
        $titulos_producto = ['Empresa','Clave','Producto', 'SubTotal','Total'];
            $table_producto = [
                'titulos'          => $titulos_producto
                ,'registros'       => $producto
                ,'id'              => "datatable_productos"
                ,'class'           => "fixed_header"
            ];
            $data = [
                "page_title" 	        => "Almacén"
                ,"title"  		        => "Almacenes"
                ,"data_table"           => "data_table(table)"
                ,"data_table_producto"  => data_table($table_producto)
            ];
            return self::_load_view( "almacenes.almacenes",$data );
        }
        /**
         *Metodo para obtener los datos de manera asicronica.
         *@access public
         *@param Request $request [Description]
         *@return void
         */
        public function all( Request $request ){

            try {
                // $datos['response_almacenes']
                // $response = $this->_tabla_model::with(['empresas'])->orderBy('id','DESC')->get();
                $datos = $this->consulta_almacenes();
                $data = [
                  'almacenes'           => $datos['response_almacenes']
                  ,'empresas'             => SysEmpresasModel::where(['estatus' => 1])->groupby('id')->get()
                ];

              return $this->_message_success( 201, $data , self::$message_success );
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
                $response = SysAlmacenesModel::with(['empresas'])->where(['id' => $request->id])->get();

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
                // $response = $this->_tabla_model::create( $request->all() );
                $string_data_almacen = [];
                
                foreach( $request->all() as $key => $value ){
                    if( !is_array($value)){                            
                        $string_data_almacen[$key] = strtoupper($value);                      
                    };
                    
                }
                
                // debuger($request->all());
                // debuger($string_data_almacen);
            // echo "string";die();
               $response = $this->_tabla_model::create( $string_data_almacen );
               
                $data = [
                 'id_empresa'  =>  Session::get('id_empresa')  
                ,'id_almacen'=> $response->id
                ,'id_sucursal' =>  Session::get('id_sucursal') 
                ];                
                SysAlmacenesEmpresasModel::create($data);

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
                    $string_key_almacenes = [ 'nombre','entradas','salidas', 'estatus' ];
                    $string_data_almacen = [];
                
                foreach( $request->all() as $key => $value ){
                    if( in_array( $key, $string_key_almacenes) ){
                        if( !is_array($value)){                            
                            $string_data_almacen[$key] = strtoupper($value); 
                        }                     
                    };
                    
                }
                    $response = $this->_tabla_model::where(['id' => $request->id] )->update( $string_data_almacen );
                if (Session::get('id_rol') != 1) {
                  $datos['id_empresa']  = Session::get('id_empresa');
                  $datos['id_sucursal'] = Session::get('id_sucursal');
                  SysAlmacenesProductosModel::create($datos); 
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
                    $response = SysAlmacenesEmpresasModel::where(['id_almacen' => $request->id])->get(['id_empresa']); 
            
            $this->_tabla_model::where(['id' => $request->id])->delete();
            SysAlmacenesEmpresasModel::where(['id_almacen' => $request->id])->delete();

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

            public function consulta_almacenes(){


                if( Session::get('id_rol') == 1 ){

                    $response_almacenes = SysAlmacenesModel::with(['empresas','productos'])
                                    ->where(['estatus' => 0])
                                    ->orderBy('id','desc')
                                    ->groupby('id')
                                    ->get();

                  

                }elseif( Session::get('id_rol') == 3 ){
                    $data = SysEmpresasModel::with(['almacenes'])
                    ->where(['id' => Session::get('id_empresa')])            
                    ->get();

                    
                    $response_almacenes = $data[0]->almacenes()
                                    ->with(['empresas'])
                                    ->where(['estatus' => 1])
                                    ->orderBy('id','desc')
                                    ->groupby('id')
                                    ->get();

                }
                                            else{

                    $data = SysUsersModel::with(['empresas'])
                                          ->where(['id' => Session::get('id')])            
                                          ->get();
                    $empresas = $data[0]->empresas()
                                        ->with(['almacenes'])
                                        ->where([ 'id' => Session::get('id_empresa') ])
                                        ->get();
                    
                    $response_almacenes = $empresas[0]->almacenes()
                                            ->with(['empresas'])
                                            ->where(['estatus' => 1])
                                            ->orderBy('id','desc')
                                            ->groupby('id')
                                            ->get();


                }
                
                return [ 'response_almacenes' => $response_almacenes ];

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
                
                $sucursales = SysAlmacenesEmpresasModel::select('id_sucursal')->where($request->all())->get();
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
                SysAlmacenesEmpresasModel::where(['id_almacen' => $request->id_almacen ])->delete();
                $response = [];
                for ($i=0; $i < count($request->matrix) ; $i++) { 
                    $matrices = explode('|', $request->matrix[$i] );
                    $id_sucursal = $matrices[0];
                    #se realiza una consulta si existe un registro.
                    $data = [
                        'id_empresa'      => $request->id_empresa
                        ,'id_sucursal'    => $id_sucursal
                        ,'id_almacen'   => $request->id_almacen

                    ];
                    $response[] = SysAlmacenesEmpresasModel::create($data);
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
         * Metodo para borrar el registro
         * @access public
         * @param Request $request [Description]
         * @return void
         */   
        public function asignar( Request $request ){
            try {
             $response = SysAlmacenesModel::with(['productos','proveedores'])
                                                ->where(['id' => $request->id])
                                                ->get();

             // $response = SysProveedoresModel::with(['productos'])
                                                // ->get();
            
             // debuger($response); 


            return $this->_message_success( 200, $response[0] , self::$message_success );
            } catch (\Exception $e) {
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            return $this->show_error(6, $error, self::$message_error );
            }

        }
        /**
         * Metodo para borrar el registro
         * @access public
         * @param Request $request [Description]
         * @return void
         */ 
        public function asignar_insert( Request $request ){
                #debuger($request->all());
               $error = null;
                DB::beginTransaction();
                try {
                    $response = [];

                    $almacenes = SysAlmacenesModel::with(['productos'])->where(['id'=> $request->id_almacen])->get();
                    debuger($almacenes);
                for($i = 0; $i < count($request->matrix); $i++){
                $matrices = explode('|',$request->matrix[$i]);
                $id_proveedor = $matrices[0];
                $proveedores = SysProveedoresModel::get();
                // debuger($proveedores);

                }
                $where = [
                     'id_producto' => ( isset($almacenes[0]->productos[0]) )? $almacenes[0]->productos[0]->id : ""
                    ,'id_proveedor' => ( isset($proveedores[0])  )? $proveedores[0]->id:""
                    ,'id_almacen' => $request->id_almacen
                    
                ];             
                debuger($where);  

                SysAlmacenesProductosModel::where($where)->delete();

                for($i = 0; $i < count($request->matrix); $i++){
                    $matrices = explode('|',$request->matrix[$i]);
                    $id_producto = $matrices[0];
                    $productos = SysProductosModel::with(['empresas','sucursales'])->where(['id' => $id_producto])->get();
                
                    // debuger($request->matrix);
                    $data = [
                         'id_proveedor' => ( isset($proveedores[0]) )? $proveedores[0]->id:"" 
                            ,'id_almacen' => $request->id_almacen
                            ,'id_producto' =>  ( isset($productos[0]) )? $productos[0]->id:""
                        
                    ];        
                    debuger($data);          

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