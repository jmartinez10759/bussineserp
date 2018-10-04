<?php
    namespace App\Http\Controllers\Administracion\Configuracion;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Session;
    use App\Http\Controllers\MasterController;
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
                    return $query->where([ 'estatus' => 1, 'id' => Session::get('id_empresa') ]);
               }])->orderby('id','desc')->get();
                debuger($response);
               $registros = [];
               $eliminar = (Session::get('permisos')['DEL'] == false)? 'style="display:block" ': 'style="display:none" ';
               foreach ($response as $respuesta) {
                 $id['id'] = $respuesta->id;
                 $editar = build_acciones_usuario($id,'v-edit_register','Editar','btn btn-primary','fa fa-edit');
                 $borrar = build_acciones_usuario($id,'v-destroy_register','Borrar','btn btn-danger','fa fa-trash','title="Borrar" '.$eliminar);
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
                   ,$borrar
                 ];
               }
               $titulos = ['Código','Categoria','Unidad de Medida','Clave','Producto', 'SubTotal','Total','Estatus','','',''];
               $table = [
                 'titulos' 		   => $titulos
                 ,'registros' 	   => $registros
                 ,'id' 			   => "datatable"
                 ,'class'          => "fixed_header"
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