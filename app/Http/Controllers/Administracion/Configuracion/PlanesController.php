<?php
    namespace App\Http\Controllers\Administracion\Configuracion;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Session;
    use App\Http\Controllers\MasterController;
    use App\Model\Administracion\Configuracion\SysPlanesModel;

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
            $response = $this->_tabla_model::orderby('id','desc')->get();
            if( Session::get('id_rol') != 1 ){
                $data = $response->with(['empresas' => function($query){
                    return $query->where(['estatus' => 1, 'id' => Session::get('id_empresa')]);
                }])->get();
            }
            
            $eliminar = (Session::get('permisos')['DEL'] == false)? 'style="display:block" ': 'style="display:none" ';
            $permisos = (Session::get('id_rol') == 1 || Session::get('permisos')['PER'] == false) ? 'style="display:block" ' : 'style="display:none" ';
            $registros = [];
            foreach ($response as $respuesta) {
                $id['id'] = $respuesta->id;
                $editar   = build_acciones_usuario($id,'v-edit_register','Editar','btn btn-primary','fa fa-edit');
                $borrar   = build_acciones_usuario($id,'v-destroy_register','Borrar','btn btn-danger','fa fa-trash','title="Borrar" '.$eliminar);
                $asing_product   = build_acciones_usuario($id,'v-asignar_producto','Asignar Producto','btn btn-info','fa fa-trash','title="Borrar" '.$permisos);
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
                        ,$asing_product
                        ,$permiso
                        ,$borrar
                    ];

                }

            }
            $titulos = ['Código','Unidad de Medida','Clave','Producto', 'SubTotal','Total','Estatus','','','','',''];
            $table = [
                'titulos' 		   => $titulos
                ,'registros' 	   => $registros
                ,'id' 			   => "datatable"
                ,'class'           => "fixed_header"
            ];


            $data = [
                "page_title" 	        => "Configuración"
                ,"title"  		        => "Planes"
                ,"data_table"  		    => data_table($table)
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

    }