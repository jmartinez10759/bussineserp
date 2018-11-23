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


        $response = $this->_tabla_model::with(['contactos','estados'])->get();
           #debuger($response);        
           // $response_proveedores = SysProveedoresModel::where(['estatus' => 1 ])->groupby('id')->get();
           $registros = [];
           $registros_proveedores = [];
           /*$eliminar = (Session::get('permisos')['DEL'] == false)? 'style="display:block" ': 'style="display:none" ';*/
           $permisos = (Session::get('permisos')['PER'] == false)? 'style="display:block" ': 'style="display:none" ';
           foreach ($response as $respuesta) {
             $id['id'] = $respuesta->id;

             $editar = build_acciones_usuario($id,'ng-edit_register','Editar','btn btn-primary','fa fa-edit','title="editar" ' );
             
             $borrar   = build_buttons(Session::get('permisos')['DEL'],'ng-destroy_register('.$respuesta->id.')','Borrar','btn btn-danger','fa fa-trash','title="Borrar"');
             
             $registros[] = [
                $respuesta->id
               ,$respuesta->razon_social
               ,$respuesta->rfc
               ,$respuesta->calle               
               ,isset($respuesta->contactos[0])?$respuesta->contactos[0]->nombre_completo : ""      
               ,isset($respuesta->contactos[0])?$respuesta->contactos[0]->correo : ""      
               ,isset($respuesta->contactos[0])?$respuesta->contactos[0]->telefono : ""      
               ,($respuesta->estatus == 1)?"ACTIVO":"BAJA"
               ,$editar
               ,$borrar
               // ,$proveedores
             ];
           }

           // $titulos = [ 'id','proveedor','RFC','Razón Social','Giro Comercial','Dirección','Contacto','Telefono','Estatus','','',''];
           $titulos = [ 'id','Proveedor','RFC','Direccion','Contacto','Correo','Telefono','Estatus','','',''];
           $table = [
             'titulos'          => $titulos
             ,'registros'       => $registros
             ,'id'              => "datatable"
           ];
          
           #se crea el dropdown
           $paises = dropdown([
                 'data'      => SysPaisModel::get()
                 ,'value'     => 'id'
                 ,'text'      => 'clave descripcion'
                 ,'name'      => 'cmb_pais'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opcion'
                 ,'attr'      => 'data-live-search="true" ng-model="insert.id_country"'
                 ,'event'     => 'ng-select_estado()'
                 ,'selected'  => '151'
           ]);

            $paises_edit =  dropdown([
                 'data'      => SysPaisModel::get()
                 ,'value'     => 'id'
                 ,'text'      => 'clave descripcion'
                 ,'name'      => 'cmb_pais_edit'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opcion'
                 ,'attr'      => 'data-live-search="true" ng-model="update.id_country"'
                 ,'event'     => 'ng-select_estado_edit()'
            ]);

            $regimen_fiscal =  dropdown([
                   'data'       => SysRegimenFiscalModel::get()
                   ,'value'     => 'id'
                   ,'text'      => 'clave descripcion'
                   ,'name'      => 'cmb_regimen_fiscal'
                   ,'class'     => 'form-control'
                   ,'leyenda'   => 'Seleccione Opcion'
                   ,'attr'      => 'data-live-search="true" ng-model="insert.id_regimen_fiscal"'
            ]);

            $regimen_fiscal_edit =  dropdown([
                   'data'       => SysRegimenFiscalModel::get()
                   ,'value'     => 'id'
                   ,'text'      => 'clave descripcion'
                   ,'name'      => 'cmb_regimen_fiscal_edit'
                   ,'class'     => 'form-control'
                   ,'leyenda'   => 'Seleccione Opcion'
                   ,'attr'      => 'data-live-search="true"'
            ]);

            $servicio_comerciales =  dropdown([
                   'data'       => SysClaveProdServicioModel::get()
                   ,'value'     => 'id'
                   ,'text'      => 'clave descripcion'
                   ,'name'      => 'cmb_servicio_comerciales'
                   ,'class'     => 'form-control'
                   ,'leyenda'   => 'Seleccione Opcion'
                   ,'attr'      => 'data-live-search="true" ng-model="insert.id_servicio_comercial"'
            ]);
            
            $servicio_comerciales_edit =  dropdown([
                 'data'       => SysClaveProdServicioModel::get()
                 ,'value'     => 'id'
                 ,'text'      => 'clave descripcion'
                 ,'name'      => 'cmb_servicio_comerciales_edit'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opcion'
                 ,'attr'      => 'data-live-search="true"'
            ]);

                $data = [
             "page_title" 	        => "Configuracion"
             ,"title"  		        => "Proveedores"
             ,"data_table"  		        => data_table($table)
             ,'giro_comercial'          =>  $servicio_comerciales
             ,'giro_comercial_edit'     =>  $servicio_comerciales_edit
             ,'regimen_fiscal'          =>  $regimen_fiscal
             ,'regimen_fiscal_edit'     =>  $regimen_fiscal_edit
             ,'paises'                  =>  $paises
             ,'paises_edit'             =>  $paises_edit
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
                $response = $this->_tabla_model::where([ 'id' => $request->id ])->get();

              return $this->_message_success( 200, $response , self::$message_success );
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
                $where = ['id' => $request->id];
            $response = SysProveedoresModel::with(['contactos','estados'])->where( $where )->groupby('id')->get();
                
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
                            $string_data_contactos['nombre_completo'] = $value;
                        }else{
                            $string_data_contactos[$key] = $value;
                        }
                    };
                    if( !in_array( $key, $string_key_contactos) ){
                        $string_data_proveedor[$key] = $value;
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
                $string_key_proveedores = [ 'rfc','nombre_comercial','razon_social','calle', 'colonia','estatus','municipio','created_at','updated_at','id_codigo','id_estado','id_servicio_comercial','id_regimen_fiscal','id_country' ];
                $string_data_proveedor = [];
                $string_data_contactos = [];
                foreach( $request->all() as $key => $value ){
                    if( in_array( $key, $string_key_contactos) ){
                        if( $key == 'contacto' ){
                            $string_data_contactos['nombre_completo'] = $value;

                        }else{
                            $string_data_contactos[$key] = $value;
                            
                        }
                    };
                    if( in_array( $key, $string_key_proveedores) ){
                       $string_data_proveedor[$key] = $value; 
                       
                    }
                    
            }
            // debuger($string_data_proveedor);
            // echo "string";die();

            // debuger($);

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