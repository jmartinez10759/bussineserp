<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysEstadosModel;
use App\Model\Administracion\Configuracion\SysEmpresasModel;
use App\Model\Administracion\Configuracion\SysClientesModel;
use App\Model\Administracion\Facturacion\SysFacturacionModel;
use App\Model\Administracion\Configuracion\SysContactosModel;
use App\Model\Administracion\Facturacion\SysUsersFacturacionModel;
use App\Model\Administracion\Configuracion\SysEmpresasSucursalesModel;

class ClientesController extends MasterController
{
    #se crea las propiedades
    private $_tabla_model;

    public function __construct(){
        parent::__construct();
        $this->_tabla_model = new SysClientesModel;
    }
    /**
     *Metodo para obtener la vista y cargar los datos
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public static function index(){
        
        if( Session::get('permisos')['GET'] ){
          return view('errors.error');
        }
          $response = SysClientesModel::with(['estados','contactos'])->where(['estatus' => 0])->orderBy('id','desc')->get();
          #debuger($response);
          $response_clientes = SysClientesModel::with(['estados'])->where(['estatus' => 1])->orderBy('id','desc')->get();
            #debuger($response[0]->estados->nombre);
          $registros = [];
          $registros_clientes = [];
          #debuger($permiso_class_destroy);
          $eliminar = (Session::get('permisos')['DEL'] == false)? 'style="display:block" ': 'style="display:none" ';
          $permisos = (Session::get('id_rol') == 1 || Session::get('permisos')['PER'] == false) ? 'style="display:block" ' : 'style="display:none" ';
          foreach ($response as $respuesta) {
            $id['id'] = $respuesta->id;
            $editar = build_acciones_usuario($id,'v-editar','Editar','btn btn-primary','fa fa-edit', 'title="Editar"' );
            $borrar = build_acciones_usuario($id,'v-destroy','Borrar','btn btn-danger','fa fa-trash ','title="Borrar"'.$eliminar);  
            $registros[] = [
              $respuesta->razon_social
              ,$respuesta->rfc_receptor
              ,isset($respuesta->contactos[0])?$respuesta->contactos[0]->nombre_completo: ""
              ,isset($respuesta->contactos[0])?$respuesta->contactos[0]->correo:""
              ,isset($respuesta->estados->nombre)?$respuesta->estados->nombre: ""
              ,isset($respuesta->contactos[0])? $respuesta->contactos[0]->departamento :""
              ,$respuesta->telefono
              ,($respuesta->estatus == 1)?"CLIENTE":"PROSPECTO"
              ,$editar
              ,$borrar
            ];

          }

          foreach ($response_clientes as $respuesta) {
            $id['id'] = $respuesta->id;
            $editar = build_acciones_usuario($id,'v-editar','Editar','btn btn-primary','fa fa-edit', 'title="Editar"' );
            $borrar = build_acciones_usuario($id,'v-destroy','Borrar','btn btn-danger','fa fa-trash ','title="Borrar"'.$eliminar);
            $assign_employes = dropdown([
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
            $registros_clientes[] = [
              $respuesta->razon_social
              ,$respuesta->rfc_receptor
              ,isset($respuesta->contactos[0])?$respuesta->contactos[0]->nombre_completo: ""
              ,isset($respuesta->contactos[0])?$respuesta->contactos[0]->correo:""
              ,isset($respuesta->estados->nombre)?$respuesta->estados->nombre: ""
              ,isset($respuesta->contactos[0])? $respuesta->contactos[0]->departamento :""
              ,$respuesta->telefono
              ,($respuesta->estatus == 1)?"CLIENTE":"PROSPECTO"
              ,$editar
              ,$borrar
              ,$assign_employes
            ];

          }

          $titulos = [
            'RAZÓN SOCIAL'
            ,'RFC'
            ,'CONTACTO'
            ,'CORREO'
            ,'ESTADO'
            ,'DEPARTAMENTO'
            ,'TELEFONO'
            ,'ESTATUS'
            ,''
            ,''
            ,''
          ];
          $table = [
            'titulos' 		    => $titulos
            ,'registros' 	    => $registros
            ,'id' 			    => "datatable"
            ,'class'            => "fixed_header"
          ];

          $table_clientes = [
            'titulos' 		    => $titulos
            ,'registros' 	    => $registros_clientes
            ,'id' 			    => "datatable_clientes"
            ,'class'            => "fixed_header"
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
          $data = [
             'page_title' 	        => "Configuración"
             ,'title'  		        => "Prospectos"
             ,'data_table'  	    => data_table($table)
             ,'data_table_clientes' => data_table($table_clientes)
             ,'estados'             => $estados
             ,'estados_edit'        => $estados_edit
           ];
           #debuger($data);
           return self::_load_view( 'administracion.configuracion.clientes', $data );

    }
    /**
     *Metodo para realizar la consulta por medio de su id
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function show( Request $request ){

        try {        
          $response = SysClientesModel::with(['contactos'])->where(['id' => $request->id_cliente])->get();
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
              $string_key_contactos = [ 'contacto','departamento','telefono', 'correo' ];
                $string_data_clientes = [];
                $string_data_contactos = [];
                foreach( $request->all() as $key => $value ){
                    if( in_array( $key, $string_key_contactos) ){
                        if( $key == 'contacto' ){
                            $string_data_contactos['nombre_completo'] = strtoupper($value);
                        }else if( $key == 'correo'){
                            $string_data_contactos[$key] = strtolower( trim($value) );
                        }else{
                            $string_data_contactos[$key] = strtoupper($value);
                        }
                    };
                    if( !in_array( $key, $string_key_contactos) ){
                        if( !is_array($value)){
                            $string_data_clientes[$key] = strtoupper($value);
                        }
                    };
                }
                $response = $this->_tabla_model::create( $string_data_clientes );
                $response_contactos = SysContactosModel::create($string_data_contactos);
                $data = [
                     'id_cuenta'        => 0
                    ,'id_empresa'       => 0
                    ,'id_sucursal'      => 0
                    ,'id_contacto'      => $response_contactos->id
                    ,'id_clientes'      => $response->id
                    ,'id_proveedores'   => 0
                    ,'estatus'          => 1
                ];
                
               SysEmpresasSecursalesModel::create($data);    
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
        #debuger($request->all());
        $error = null;
          DB::beginTransaction();
          try {
                $string_key_contactos = [ 'contacto','departamento','telefono', 'correo' ];
                $string_key_clientes = [ 'contacto','departamento','telefono', 'correo','created_at','updated_at','contactos','sucursales' ];
                $string_data_clientes = [];
                $string_data_contactos = [];
                foreach( $request->all() as $key => $value ){
                    if( in_array( $key, $string_key_contactos) ){
                        if( $key == 'contacto' ){
                            $string_data_contactos['nombre_completo'] = strtoupper($value);
                        }else if( $key == 'correo'){
                            $string_data_contactos[$key] = strtolower( trim($value) );
                        }else{
                            $string_data_contactos[$key] = strtoupper($value);
                        }
                    };
                    if( !in_array( $key, $string_key_contactos) ){
                        if( !is_array($value)){
                            $string_data_clientes[$key] = strtoupper($value);
                        }
                    };
                    
                }
              #debuger($string_data_contactos);
              #debuger($string_data_clientes);
             $this->_tabla_model::where(['id' => $request->id] )->update( $string_data_clientes );
            if( count($request->contactos) > 0){
               SysContactosModel::where(['id' => $request->contactos[0]['id'] ])->update($string_data_contactos);
            }else{
                $response_contactos = SysContactosModel::create($string_data_contactos);
                $data = [
                     'id_cuenta'        => 0
                    ,'id_empresa'       => 0
                    ,'id_sucursal'      => 0
                    ,'id_contacto'      => $response_contactos->id
                    ,'id_clientes'      => $request->id
                    ,'id_proveedores'   => 0
                    ,'estatus'          => 1
                ];
               SysEmpresasSecursalesModel::create($data);   
                
            }
            DB::commit();
            $success = true;
          } catch (\Exception $e) {
              $success = false;
              $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
              DB::rollback();
          }

          if ($success) {
            return $this->_message_success( 201, $success , self::$message_success );
          }
          return $this->show_error(6, $error, self::$message_error );
        
    }
    /**
     *Metodo para borrar el registro
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function destroy( Request $request ){
        $error = null;
        DB::beginTransaction();
        try {
          $where = ['id' => $request->id_cliente];
          $users_facturas = SysUsersFacturacionModel::where(['id_cliente' => $request->id_cliente])->get();
          $clientes_empresas = SysEmpresasSucursalesModel::where(['id_cliente' => $request->id_cliente])->get(); 
            #debuger($clientes_empresas);
          if( count($users_facturas) > 0){
              foreach ($users_facturas as $tbl_factura) {
                SysFacturacionModel::where(['id' => $tbl_factura->id_factura])->delete();
              }
          }
            if( count($clientes_empresas) > 0){
               foreach ($clientes_empresas as $tbl_clientes) {
                SysContactosModel::where(['id' => $tbl_clientes->id_contacto])->delete();
              } 
            }
          SysClientesModel::where( $where )->delete();
          SysEmpresasSucursalesModel::where(['id_cliente' => $request->id_cliente])->delete();
          DB::commit();
          $success = true;
        } catch (\Exception $e) {
            $success = false;
            $error = $e->getFile()." ".$e->getMessage()." ".$e->getLine();
            DB::rollback();
        }

        if ($success) {
          return $this->_message_success(201,$request->all(),self::$message_success );
        }
        return $this->show_error(6,$error,self::$message_error);

        #return message(true,$request->all(),self::$message_success);
    }
    /**
     * Metodo para borrar el registro
     * @access public
     * @param Request $request [Description]
     * @return void
     */
    public function display_sucursales( Request $request ){
        
        try {
            $response = SysEmpresasModel::with(['sucursales' => function($query){
                return $query->where(['sys_sucursales.estatus' => 1, 'sys_empresas_sucursales.estatus' => 1])->groupby('id')->get();
            }])->where(['id' => $request->id_empresa])->get();
            
            $sucursales = SysEmpresasSucursalesModel::select('id_sucursal')->where($request->all())->get();
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
                'titulos' 		   => $titulos
                ,'registros' 	   => $registros
                ,'id' 			   => "sucursales"
            ];
            $data = [
                'tabla_sucursales'  => data_table($table)
                ,'sucursales'       => $sucursales
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
            $id_contacto = SysClientesModel::with(['contactos'])->where(['id' => $request->id_cliente])->get();
            SysEmpresasSucursalesModel::where(['id_cliente'=> $request->id_cliente])->delete();
            $response = [];
            for ($i=0; $i < count($request->matrix) ; $i++) { 
                $matrices = explode('|', $request->matrix[$i] );
                $id_sucursal = $matrices[0];
                $estatus = ($matrices[1] == true)? 1: 0;
                #se realiza una consulta si existe un registro.
                $data = [
                    'id_cuenta'     => 0
                    ,'id_empresa'   => $request->id_empresa
                    ,'id_sucursal'  => $id_sucursal
                    ,'id_contacto'  => isset($id_contacto[0]->contactos[0])? $id_contacto[0]->contactos[0]->id: 0
                    ,'id_cliente'   => $request->id_cliente
                    ,'id_proveedor' => 0
                    ,'estatus'      => $estatus
                ];
                $response[] = SysEmpresasSucursalesModel::create($data);
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
