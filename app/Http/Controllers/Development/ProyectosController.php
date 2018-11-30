<?php
    namespace App\Http\Controllers\Development;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Session;
    use App\Http\Controllers\MasterController;
    use App\Model\Development\SysProyectosModel;
    use App\Model\Administracion\Configuracion\SysClientesModel;
    use App\Model\Administracion\Configuracion\SysEstatusModel;

    class ProyectosController extends MasterController
    {
        #se crea las propiedades
        private $_tabla_model;

        public function __construct(){
            parent::__construct();
            $this->_tabla_model = new SysProyectosModel;
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
            
            $data = [
                "page_title" 	        => "Proyectos"
                ,"title"  		        => "Listado"
                ,"data_table"  		    => ""
            ];
            return self::_load_view( "development.proyectos",$data );
        }
        /**
         *Metodo para obtener los datos de manera asicronica.
         *@access public
         *@param Request $request [Description]
         *@return void
         */
        public function all( Request $request ){

            try {
                
            $response = SysProyectosModel::where('sys_users_projects.id_empresa', 1)
                ->leftJoin('sys_projects'   ,'sys_projects.id'  ,'=','sys_users_projects.id_proyecto')
                ->leftJoin('sys_tasks'      ,'sys_tasks.id'     ,'=','sys_users_projects.id_tarea')
                ->select(
                    'sys_users_projects.id_proyecto'
                    ,'sys_users_projects.id_tarea'
                    ,'sys_projects.titulo'
                    ,'sys_projects.descripcion'
                    ,'sys_projects.fecha_cierre'
                    ,'sys_projects.id_cliente'
                    ,'sys_projects.id_estatus'
                    ,'sys_tasks.titulo as task_titulo'
                    ,'sys_tasks.descripcion as task_desc'
                )
                ->get();

                $data = [
                    "response"      => $response
                    ,"clientes"     => $this->_consulta(new SysClientesModel)
                    ,"estatus"      => SysEstatusModel::where(['estatus' => 1 ])->whereIn('id',['4','5','6'])->orderby('nombre', 'asc')->get()
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
                $response = SysProyectosModel::create($request->all());

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