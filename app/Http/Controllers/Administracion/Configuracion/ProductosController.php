<?php
    namespace App\Http\Controllers\Administracion\Configuracion;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Session;
    use App\Http\Controllers\MasterController;
    use App\Model\Administracion\Configuracion\SysEmpresasModel;
    use App\Model\Administracion\Configuracion\SysProductosModel;
    use App\Model\Administracion\Configuracion\SysPlanesProductosModel;
    use App\Model\Administracion\Configuracion\SysCategoriasProductosModel;
    use App\Model\Administracion\Configuracion\SysUnidadesMedidasModel;

    class ProductosController extends MasterController
    {
        #se crea las propiedades
        private $_tabla_model;

        public function __construct(){
            parent::__construct();
            $this->_tabla_model = new SysProductosModel;
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
            $response = $this->_tabla_model::with(['categorias' => function( $query ){
                    return $query->where(['estatus' => 1])->get();
            },'planes' => function( $query ){
                return $query->where(['estatus' => 1])->get();
            },'almacenes' => function( $query ){
                return $query->where(['estatus' => 1])->get();
            },'unidades' => function($query){
                return $query->where(['estatus' => 1])->get();
            }, 'empresas' => function( $query ){
                if(Session::get('id_rol') != 1){
                    return $query->where([ 'estatus' => 1, 'id' => Session::get('id_empresa') ]);
                }
            }])->orderby('id','desc')->get();
            #debuger($response);
            $eliminar = (Session::get('permisos')['DEL'] == false)? 'style="display:block" ': 'style="display:none" ';
            $permisos = (Session::get('id_rol') == 1 || Session::get('permisos')['PER'] == false) ? 'style="display:block" ' : 'style="display:none" ';
            $registros = [];
            foreach ($response as $respuesta) {
                $id['id'] = $respuesta->id;
                $editar   = build_acciones_usuario($id,'v-edit_register','Editar','btn btn-primary','fa fa-edit');
                $borrar   = build_acciones_usuario($id,'v-destroy_register','Borrar','btn btn-danger','fa fa-trash','title="Borrar" '.$eliminar);
                #$permiso  = build_acciones_usuario($id, 'v-permisos','Permisos','btn btn-info', 'fa fa-gears','title="Asignar Empresa" '.$permisos);
                $permiso = dropdown([
                     'data'      => SysEmpresasModel::where(['estatus' => 1])->get()
                     ,'value'     => 'id'
                     ,'text'      => 'nombre_comercial'
                     ,'name'      => 'cmb_empresas_'. $respuesta->id
                     ,'class'     => 'form-control'
                     ,'selected'  => isset($respuesta->empresas[0] )? $respuesta->empresas[0]->id : 0
                     ,'leyenda'   => 'Seleccione Opcion'
                     ,'attr'      => 'data-live-search="true" '. $permisos
                     ,'event'     => 'display_sucursales('. $respuesta->id .')'
                ]);
                if( count($respuesta->empresas) > 0 || Session::get('id_rol') == 1){
                    $registros[] = [
                         $respuesta->codigo
                        ,isset($respuesta->categoria->nombre)? $respuesta->categoria->nombre :""
                        ,isset($respuesta->unidades->nombre)? $respuesta->unidades->nombre :""
                        ,$respuesta->clave_unidad
                        ,$respuesta->nombre
                        , format_currency($respuesta->subtotal,2)
                        , format_currency($respuesta->total,2)                   
                        ,($respuesta->estatus == 1)?"ACTIVO":"BAJA"
                        ,$editar
                        ,$permiso
                        ,$borrar
                    ];

                }

            }
            $titulos = ['Código','Categoria','Unidad de Medida','Clave','Producto', 'SubTotal','Total','Estatus','','','',''];
            $table = [
                'titulos' 		   => $titulos
                ,'registros' 	   => $registros
                ,'id' 			   => "datatable"
                ,'class'           => "fixed_header"
            ];
            $data = [
                "page_title" 	        => "Configuración"
                ,"title"  		        => "Productos"
                ,"data_table"  		    => data_table($table)
            ];
            return self::_load_view( "administracion.configuracion.productos",$data );
        }
        /**
         *Metodo para obtener los datos de manera asicronica.
         *@access public
         *@param Request $request [Description]
         *@return void
         */
        public function all( Request $request ){

            try {

            $categorias = dropdown([
                    'data'      => SysCategoriasProductosModel::where(['estatus' => 1])->get()
                    ,'value'     => 'id'
                    ,'text'      => 'nombre'
                    ,'name'      => 'cmb_categorias'
                    ,'class'     => 'form-control'
                    ,'leyenda'   => 'Seleccione Opcion'
                    ,'attr'      => 'data-live-search="true" '
            ]);

            $categorias_edit = dropdown([
                     'data'      => SysCategoriasProductosModel::where(['estatus' => 1])->get()
                     ,'value'     => 'id'
                     ,'text'      => 'nombre'
                     ,'name'      => 'cmb_categorias'
                     ,'class'     => 'form-control'
                     ,'leyenda'   => 'Seleccione Opcion'
                     ,'attr'      => 'data-live-search="true" '
               ]);

            $unidades = dropdown([
                     'data'      => SysUnidadesMedidasModel::where(['estatus' => 1])->get()
                     ,'value'     => 'id'
                     ,'text'      => 'clave nombre'
                     ,'name'      => 'cmb_unidades'
                     ,'class'     => 'form-control'
                     ,'leyenda'   => 'Seleccione Opcion'
                     ,'attr'      => 'data-live-search="true" '
               ]);

            $unidades_edit = dropdown([
                     'data'      => SysUnidadesMedidasModel::where(['estatus' => 1])->get()
                     ,'value'     => 'id'
                     ,'text'      => 'clave nombre'
                     ,'name'      => 'cmb_unidades_edit'
                     ,'class'     => 'form-control'
                     ,'leyenda'   => 'Seleccione Opcion'
                     ,'attr'      => 'data-live-search="true" '
               ]);

              $data = [
                  'categorias'          => $categorias
                  ,'categorias_edit'    => $categorias_edit
                   ,'unidades'          => $unidades
                    ,'unidades_edit'    => $unidades_edit
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
                $response = $this->_tabla_model::where(['id' => $request->id])->get();

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
                $registros = [];
                foreach ($request->all() as $key => $value) {
                    $registros[$key] = strtoupper($value);
                }
                $response = $this->_tabla_model::create( $registros );
                $data = [
                    'id_empresa'      => Session::get('id_empresa')
                    ,'id_sucursal'    => Session::get('id_sucursal')
                    ,'id_plan'        => 0
                    ,'id_producto'    => $response->id
                ];
                SysPlanesProductosModel::create($data);
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
                $registros = [];
                foreach ($request->all() as $key => $value) {
                    $registros[$key] = strtoupper($value);
                }
                $response = $this->_tabla_model::where(['id' => $request->id])->update($registros);

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
                $response = $this->_tabla_model::where(['id' => $request->id])->delete();
                SysPlanesProductosModel::where(['id' => $request->id])->delete();
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
            #debuger($request->all());
            try {
                #$sucursales = [];
                $response = SysEmpresasModel::with(['sucursales' => function($query){
                    return $query->where(['sys_sucursales.estatus' => 1, 'sys_empresas_sucursales.estatus' => 1])->get();
                }])->where(['id' => $request->id_empresa])->get();
                $sucursales = SysPlanesProductosModel::select('id_sucursal')->where($request->all())->get();
                #se crea la tabla 
                $registros = [];
                foreach ($response[0]->sucursales as $respuesta) {
                    $id['id'] = $respuesta->id;
                    $icon = build_actions_icons($id, 'id_sucursal="' . $respuesta->id . '" ');
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
                    'titulos' 		   => $titulos
                    ,'registros' 	   => $registros
                    ,'id' 			   => "sucursales"
                    #,'class'           => "fixed_header"
                ];
                $data = [
                    'tabla_sucursales' => data_table($table)
                    ,'sucursales'   => $sucursales
                ];
                return $this->_message_success(201, $data, self::$message_success);
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
            
            $response_producto = SysPlanesProductosModel::where([
                'id_empresa'   => Session::get('id_empresa')
                ,'id_sucursal' => Session::get('id_sucursal')
                #,'id_producto' => $request->id_producto 
                ] )->get();
            if( count($response_producto) > 0){
                SysPlanesProductosModel::where([
                    'id_empresa'   => Session::get('id_empresa')
                    ,'id_sucursal' => Session::get('id_sucursal')
                    #,'id_producto' => $request->id_producto 
                ])->delete();
            }
            SysPlanesProductosModel::where([
                 'id_empresa'   => $request->id_empresa
                ,'id_producto'    => $request->id_producto 
                ])->delete();
            $response = [];
            for ($i=0; $i < count($request->matrix) ; $i++) { 
                $matrices = explode('|', $request->matrix[$i] );
                $id_sucursal = $matrices[0];
                #se realiza una consulta si existe un registro.
                $data = [
                    'id_empresa'      => $request->id_empresa
                    ,'id_sucursal'    => $id_sucursal
                    ,'id_plan'        => 0
                    ,'id_producto'    => $request->id_producto
                ];
                $response[] = SysPlanesProductosModel::create($data);
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



    }