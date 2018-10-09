<?php
    namespace App\Http\Controllers\Administracion\Configuracion;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Session;
    use App\Http\Controllers\MasterController;
    use App\Model\Administracion\Configuracion\SysPlanesModel;
    use App\Model\Administracion\Configuracion\SysProductosModel;
    use App\Model\Administracion\Configuracion\SysUnidadesMedidasModel;
    use App\Model\Administracion\Configuracion\SysPlanesProductosModel;
    use App\Model\Administracion\Configuracion\SysClientesModel;

    class PlanesController extends MasterController
    {
        #se crea las propiedades
        private $_tabla_model;

        public function __construct(){
            parent::__construct();
            $this->_tabla_model = new SysPlanesModel;
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
            #$cliente = $this->_consulta( new SysClientesModel);
            #debuger( count($cliente) );
            $response = (Session::get('id_rol') == 1 )? $this->_tabla_model::get() : $this->_consulta($this->_tabla_model);
            $productos = ( Session::get('id_rol') == 1 )? SysProductosModel::orderby('id','desc')->get() : $this->_consulta( new SysProductosModel );
            #debuger($productos);
            $eliminar = (Session::get('permisos')['DEL'] == false)? 'style="display:block" ': 'style="display:none" ';
            $permisos = (Session::get('id_rol') == 1 || Session::get('permisos')['PER'] == false) ? 'style="display:block" ' : 'style="display:none" ';
            $registros = [];
            $producto = [];
            foreach ($response as $respuesta) {
                $id['id'] = $respuesta->id;
                $editar   = build_acciones_usuario($id,'v-edit_register','Editar','btn btn-primary','fa fa-edit');
                $borrar   = build_acciones_usuario($id,'v-destroy_register','Borrar','btn btn-danger','fa fa-trash','title="Borrar" '.$eliminar);
                $asing_product   = build_acciones_usuario($id,'asignar_producto','Asignar Producto','btn btn-info','fa fa-cart-plus','title="Borrar" ');
                /*     $permiso = dropdown([
                        'data'      => SysEmpresasModel::where(['estatus' => 1])->get()
                        ,'value'     => 'id'
                        ,'text'      => 'nombre_comercial'
                        ,'name'      => 'cmb_empresas_'. $respuesta->id
                        ,'class'     => 'form-control'
                        ,'selected'  => isset($respuesta->empresas[0] )? $respuesta->empresas[0]->id : 0
                        ,'leyenda'   => 'Seleccione Opcion'
                        ,'attr'      => 'data-live-search="true" '. $permisos
                        ,'event'     => 'display_sucursales('. $respuesta->id .')'
                    ]); */
                if( count($respuesta->empresas) > 0 || Session::get('id_rol') == 1){
                    $registros[] = [
                         $respuesta->codigo
                        ,isset($respuesta->unidades->nombre)? $respuesta->unidades->nombre :""
                        ,$respuesta->clave_unidad
                        ,$respuesta->nombre
                        , format_currency($respuesta->subtotal,2)
                        , format_currency($respuesta->total,2)                   
                        ,($respuesta->estatus == 1)?"ACTIVO":"BAJA"
                        ,$editar
                        ,$asing_product
                        #,$permiso
                        ,$borrar
                    ];

                }

            }
            
            foreach ($productos as $respuesta) {
                $id['id'] = $respuesta->id;
                $checkbox = build_actions_icons($id,'id_producto= "'.$respuesta->id.'" ');
                $producto[] = [
                    $respuesta->clave_unidad
                    ,$respuesta->nombre
                    , format_currency($respuesta->subtotal,2)
                    , format_currency($respuesta->total,2)                   
                    ,$checkbox
                ];

            }
            $titulos_producto = ['Clave','Producto', 'SubTotal','Total'];
            $titulos = ['Código','Unidad de Medida','Clave','Producto', 'SubTotal','Total','Estatus','','','','',''];
            $table = [
                'titulos' 		   => $titulos
                ,'registros' 	   => $registros
                ,'id' 			   => "datatable"
                ,'class'           => "fixed_header"
            ];
            $table_producto = [
                'titulos' 		   => $titulos_producto
                ,'registros' 	   => $producto
                ,'id' 			   => "datatable_productos"
                ,'class'           => "fixed_header"
            ];

            $data = [
                "page_title" 	        => "Configuración"
                ,"title"  		        => "Planes"
                ,"data_table"  		    => data_table($table)
                ,"data_table_producto"  => data_table($table_producto)
            ];
            return self::_load_view( "administracion.configuracion.planes",$data );
        }
        /**
         *Metodo para obtener los datos de manera asicronica.
         *@access public
         *@param Request $request [Description]
         *@return void
         */
        public function all( Request $request ){

            try {

            $unidades = dropdown([
                     'data'      => SysUnidadesMedidasModel::where(['estatus' => 1])->get()
                     ,'value'     => 'id'
                     ,'text'      => 'clave nombre'
                     ,'name'      => 'cmb_unidades'
                     ,'class'     => 'form-control'
                     ,'leyenda'   => 'Seleccione Opcion'
                     ,'attr'      => 'data-live-search="true" '
                     ,'event'     => 'parse_clave()'
               ]);

            $unidades_edit = dropdown([
                     'data'      => SysUnidadesMedidasModel::where(['estatus' => 1])->get()
                     ,'value'     => 'id'
                     ,'text'      => 'clave nombre'
                     ,'name'      => 'cmb_unidades_edit'
                     ,'class'     => 'form-control'
                     ,'leyenda'   => 'Seleccione Opcion'
                     ,'attr'      => 'data-live-search="true" '
                     ,'event'     => 'parse_clave_edit()'
               ]);
                 $data = [
                   'unidades'         => $unidades,
                   'unidades_edit'    => $unidades_edit
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
                $response = $this->_tabla_model::with(['unidades'])->where(['id' => $request->id])->get();
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
                #debuger($request->all());
                $registros = [];
                foreach ($request->all() as $key => $value) {
                    $registros[$key] = strtoupper($value);
                }
                $response = $this->_tabla_model::create( $registros );
                $data = [
                    'id_empresa'      => Session::get('id_empresa')
                    ,'id_sucursal'    => Session::get('id_sucursal')
                    ,'id_plan'        => $response->id
                    ,'id_producto'    => 0
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
                $keys = ['created_at','updated_at','unidades'];
                foreach ($request->all() as $key => $value) {
                    if( !in_array($key,$keys)){
                        $registros[$key] = strtoupper($value);
                    }
                }
                #debuger($registros);
                $this->_tabla_model::where(['id' => $request->id])->update($registros);
                $response = $this->_tabla_model::where(['id' => $request->id])->get();
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
 * Metodo para borrar el registro
 * @access public
 * @param Request $request [Description]
 * @return void
 */  
        
   public function asignar( Request $request ){
            try {
             $response = $this->_tabla_model::with(['productos'])->where(['id' => $request->id])->get();
            return $this->_message_success( 201, $response[0] , self::$message_success );
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
           
       $error = null;
        DB::beginTransaction();
        try {
            
            #SysPlanesProductosModel::where(['id_plan' => $response->id_plan])->delete();
            for($i = 0; $i < count($request->matrix); $i++){
                $matrices = explode('|',$request->matrix[$i]);
                $id_producto = $matrices[0];
                debuger($id_producto);
                $data = [
                     'id_empresa'     => Session::get('id_empresa')
                    ,'id_sucursal'    => Session::get('id_sucursal')
                    ,'id_plan'        => $response->id_plan
                    ,'id_producto'    => $id_producto
                ];
                SysPlanesProductosModel::create($data);
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