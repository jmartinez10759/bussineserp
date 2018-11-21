<?php
namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysTasaModel;
use App\Model\Administracion\Configuracion\SysPlanesModel;
use App\Model\Administracion\Configuracion\SysProductosModel;
use App\Model\Administracion\Configuracion\SysTipoFactorModel;
use App\Model\Administracion\Configuracion\SysClientesModel;
use App\Model\Administracion\Configuracion\SysEmpresasModel;
use App\Model\Administracion\Configuracion\SysImpuestoModel;
use App\Model\Administracion\Configuracion\SysPlanesProductosModel;
use App\Model\Administracion\Configuracion\SysUnidadesMedidasModel;
use App\Model\Administracion\Configuracion\SysClaveProdServicioModel;

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
        #$productos = $this->_validate_consulta( new SysProductosModel ,[], [], [], []);
        $productos = $this->_validate_consulta( new SysProductosModel, ['categorias','unidades'], [], ['id' => Session::get('id_empresa')] );
        #debuger($productos[0]->empresas[0]->razon_social);
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
            'titulos' 		   => $titulos_producto
            ,'registros' 	   => $producto
            ,'id' 			   => "datatable_productos"
            ,'class'           => "fixed_header"
        ];

        $data = [
            "page_title" 	        => "Configuración"
            ,"title"  		        => "Planes"
            ,"data_table"  		    => "data_table(table)"
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
           $response = $this->_validate_consulta( $this->_tabla_model, ['unidades'], [], ['id' => Session::get('id_empresa')] );
           #debuger($response);
           $data = [
             'response'             => $response
             ,'empresas'            => SysEmpresasModel::where(['estatus' => 1])->groupby('id')->get()
             ,'unidad_medida'       => SysUnidadesMedidasModel::where(['estatus' => 1])->get()
             ,'servicios'           => SysClaveProdServicioModel::get()
             ,'tipo_factor'         => SysTipoFactorModel::get()
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
                if($key == "logo"){
                  $registros[$key] = ($value);
                }else{
                  $registros[$key] = strtoupper($value);
                }
            }
            $response = $this->_tabla_model::create( $registros );
            $data = [
                'id_empresa'      => Session::get('id_empresa')
                ,'id_sucursal'    => Session::get('id_sucursal')
                ,'id_plan'        => $response->id
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
        #debuger($request->all());
        $error = null;
        DB::beginTransaction();
        try {
            $registros = [];
            $keys = ['created_at','updated_at','unidades'];
            foreach ($request->all() as $key => $value) {
                if( !in_array($key,$keys)){
                    if($key == "logo"){
                      $registros[$key] = ($value);
                    }else{
                      $registros[$key] = strtoupper($value);
                    }
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
            $response = $this->_tabla_model::where(['id' => $request->id])->delete();
            SysPlanesProductosModel::where( ['id_plan' => $request->id ] )->delete();
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
            #debuger($request->all());
           $error = null;
            DB::beginTransaction();
            try {
                $planes = SysPlanesModel::with(['empresas','sucursales'])->where(['id'=> $request->id_plan])->get();
                $where = [
                     'id_empresa' => (Session::get('id_rol') == 1 && isset($planes[0]->empresas[0]) )? $planes[0]->empresas[0]->id : Session::get('id_empresa')
                    ,'id_sucursal' => ( Session::get('id_rol') == 1 && isset($planes[0]->sucursales[0])  )? $planes[0]->sucursales[0]->id:Session::get('id_sucursal')
                    ,'id_plan' => $request->id_plan
                ];
                SysPlanesProductosModel::where( $where )->delete();
                for($i = 0; $i < count($request->matrix); $i++){
                    $matrices = explode('|',$request->matrix[$i]);
                    $id_producto = $matrices[0];
                    $productos = SysProductosModel::with(['empresas','sucursales'])->where(['id' => $id_producto])->get();
                    #debuger($productos[0]->empresas[0]->id);
                    $data = [
                         'id_empresa' => (Session::get('id_rol') == 1 && isset($productos[0]->empresas[0]) )? $productos[0]->empresas[0]->id : Session::get('id_empresa')
                        ,'id_sucursal'=> ( Session::get('id_rol') == 1 && isset($productos[0]->sucursales[0])  )? $productos[0]->sucursales[0]->id:Session::get('id_sucursal')
                        ,'id_plan' => $request->id_plan
                        ,'id_producto' => $id_producto
                    ];
                    $response[] = SysPlanesProductosModel::create($data);
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
    public function display_sucursales( Request $request ){
        try {
            $response = SysEmpresasModel::with(['sucursales' => function($query){
                return $query->where(['sys_sucursales.estatus' => 1, 'sys_empresas_sucursales.estatus' => 1])->groupby('id')->get();
            }])->where(['id' => $request->id_empresa])->get();
            $sucursales = SysPlanesProductosModel::select('id_sucursal')->where($request->all())->get();
            #debuger($sucursales);
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
            #debuger($request->all());
            $where = [
                'id_empresa'   => Session::get('id_empresa')
                ,'id_sucursal' => Session::get('id_sucursal')
            ];
            $response_producto = SysPlanesProductosModel::where($where)->get();
            if( count($response_producto) > 0){
                SysPlanesProductosModel::where($where)->delete();
            }
            SysPlanesProductosModel::where(['id_plan' => $request->id_plan ])->delete();
            $response = [];
            for ($i=0; $i < count($request->matrix) ; $i++) { 
                $matrices = explode('|', $request->matrix[$i] );
                $id_sucursal = $matrices[0];
                #se realiza una consulta si existe un registro.
                $data = [
                    'id_empresa'      => $request->id_empresa
                    ,'id_sucursal'    => $id_sucursal
                    ,'id_plan'        => $request->id_plan
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