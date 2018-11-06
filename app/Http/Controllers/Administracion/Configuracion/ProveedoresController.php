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

        $response = $this->_tabla_model::get();
           #debuger($response);        
           // $response_proveedores = SysProveedoresModel::where(['estatus' => 1 ])->groupby('id')->get();
           $registros = [];
           $registros_proveedores = [];
           /*$eliminar = (Session::get('permisos')['DEL'] == false)? 'style="display:block" ': 'style="display:none" ';*/
           $permisos = (Session::get('permisos')['PER'] == false)? 'style="display:block" ': 'style="display:none" ';
           foreach ($response as $respuesta) {
             $id['id'] = $respuesta->id;
             $editar = build_acciones_usuario($id,'v-editar','Editar','btn btn-primary','fa fa-edit','title="editar" ' );
             $borrar   = build_buttons(Session::get('permisos')['DEL'],'v-destroy($id)','Borrar','btn btn-danger','fa fa-trash','title="Borrar"');
             // $proveedores = build_acciones_usuario($id,'v-proveedores',' Proveedores','btn btn-info','fa fa-building-o','title="Asignar proveedores" '.$permisos );
             $registros[] = [
                $respuesta->id
               ,$respuesta->nombre_comercial
               ,$respuesta->rfc_emisor
               ,$respuesta->razon_social
               ,$respuesta->giro_comercial
               ,$respuesta->direccion
               ,isset($respuesta->contactos[0])?$respuesta->contactos[0]->nombre_completo : ""      
               ,isset($respuesta->contactos[0])?$respuesta->contactos[0]->telefono : ""      
               ,($respuesta->estatus == 1)?"ACTIVO":"BAJA"
               ,$editar
               ,$borrar
               ,$proveedores
             ];
           }

           $titulos = [ 'id','proveedor','RFC','Razón Social','Giro Comercial','Dirección','Contacto','Telefono','Estatus','','',''];
           // $titulos = [ 'id','proveedor','RFC','Razón Social','Giro Comercial','Dirección','Contacto','','',''];
           $table = [
             'titulos'          => $titulos
             ,'registros'       => $registros
             ,'id'              => "datatable"
           ];
          
           #se crea el dropdown
           $estados = dropdown([
                 'data'      => SysEstadosModel::get()
                 ,'value'     => 'id'
                 ,'text'      => 'nombre'
                 ,'name'      => 'cmb_estados'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opcion'
                 ,'attr'      => 'data-live-search="true" '
           ]);
            $estados_edit =  dropdown([
                 'data'      => SysEstadosModel::get()
                 ,'value'     => 'id'
                 ,'text'      => 'nombre'
                 ,'name'      => 'cmb_estados_edit'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opcion'
                 ,'attr'      => 'data-live-search="true" '
            ]);
            $giro_comercial =  dropdown([
                   'data'       => SysClaveProdServicioModel::get()
                   ,'value'     => 'id'
                   ,'text'      => 'clave descripcion'
                   ,'name'      => 'cmb_servicio'
                   ,'class'     => 'form-control'
                   ,'leyenda'   => 'Seleccione Opcion'
                   ,'attr'      => 'data-live-search="true" '
            ]);
            
            $giro_comercial_edit =  dropdown([
                 'data'       => SysClaveProdServicioModel::get()
                 ,'value'     => 'id'
                 ,'text'      => 'clave descripcion'
                 ,'name'      => 'cmb_servicio_edit'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opcion'
                 ,'attr'      => 'data-live-search="true" '
            ]);

           // foreach ($response_proveedores as $respuesta) {
           //   $id['id'] = $respuesta->id;
           //   $checkbox = build_actions_icons($id,'id_proveedor= "'.$respuesta->id.'" ','check_proveedores');
           //   $registros_proveedores[] = [
           //      $respuesta->id
           //     ,$respuesta->codigo
           //     ,$respuesta->sucursal
           //     ,$checkbox
           //   ];
           // }

           // $titulos = [ 'id','Codigo','Proveedor',''];
           // $table_proveedores = [
           //   'titulos'        => $titulos
           //   ,'registros'     => $registros_proveedores
           //   ,'id'            => "data_table_proveedores"
           // ];


                $data = [
             "page_title" 	        => "Configuracion"
             ,"title"  		        => "Proveedores"
             ,"data_table"  		        => data_table($table)
              ,'data_table_proveedores'   =>  ''
             ,'estados'                 =>  $estados
             ,'estados_edit'            =>  $estados_edit
             ,'giro_comercial'          =>  $giro_comercial
             ,'giro_comercial_edit'     =>  $giro_comercial_edit
             ,'titulo_modal'            => "Registro de Proveedor"
             ,'titulo_modal_edit'       => "Actualización de Proveedor"
             ,'campo_1'                 => 'Proveedor'
             ,'campo_2'                 => 'Descripción'
             ,'campo_4'                 => 'RFC'
             ,'campo_5'                 => 'Razón Social'
             ,'campo_3'                 => 'Estatus'
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
                debuger($request->all());
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