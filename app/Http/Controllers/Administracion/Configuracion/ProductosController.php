<?php
namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysTasaModel;
use App\Model\Administracion\Configuracion\SysUsersModel;
use App\Model\Administracion\Configuracion\SysImpuestoModel;
use App\Model\Administracion\Configuracion\SysEmpresasModel;
use App\Model\Administracion\Configuracion\SysProductosModel;
use App\Model\Administracion\Configuracion\SysTipoFactorModel;
use App\Model\Administracion\Configuracion\SysUnidadesMedidasModel;
use App\Model\Administracion\Configuracion\SysPlanesProductosModel;
use App\Model\Administracion\Configuracion\SysClaveProdServicioModel;
use App\Model\Administracion\Configuracion\SysCategoriasProductosModel;

class ProductosController extends MasterController
{
    private $_tabla_model;

    public function __construct()
    {
        parent::__construct();
        $this->_tabla_model = new SysProductosModel;
    }

    /**
     *Metodo para obtener la vista y cargar los datos
     * @access public
     * @return void
     */
    public function index()
    {
        if( Session::get('permisos')['GET'] ){ return view('errors.error'); }

        $data = [
            'page_title' 	         => "Configuración"
            ,'title'  		         => "Productos"
            ,'data_table'  		     => "data_table(table)"
        ];

        return self::_load_view( "administracion.configuracion.productos",$data );
    }
    /**
     *Method for get all products.
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function all( Request $request )
    {
        var_export($request);die();
        try {
            $response = $this->_queryProducts();
            $data = [
             'response'         => $response
             ,'empresas'        => SysEmpresasModel::where(['estatus' => 1])->groupby('id')->get()
             ,'unidad_medida'   => SysUnidadesMedidasModel::where(['estatus' => 1])->get()
             ,'categorias'      => SysCategoriasProductosModel::where(['estatus' => 1])->get()
             ,'servicios'       => SysClaveProdServicioModel::get()
             ,'tipo_factor'     => SysTipoFactorModel::get()
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
        #debuger($request->all());
        try {
            $response = $this->_tabla_model::with(['servicios:id,clave','categorias','unidades','tasas','impuestos','tipoFactor'])->where(['id' => $request->id])->first();
        return $this->_message_success( 200, $response , self::$message_success );
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
        #debuger($request->all());
        $error = null;
        DB::beginTransaction();
        try {
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
        #debuger($request->all());
        $error = null;
        DB::beginTransaction();
        try {
            $registros = [];
            foreach ($request->all() as $key => $value) {
                if($key == "logo"){
                  $registros[$key] = ($value);
                }else{
                  $registros[$key] = strtoupper($value);
                }
            }
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
             return $this->_message_success( 201, $response[0] , self::$message_success );
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
            SysPlanesProductosModel::where(['id_producto' => $request->id])->delete();
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
                return $query->where(['sys_sucursales.estatus' => 1, 'sys_empresas_sucursales.estatus' => 1])->groupby('id')->get();
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
        #debuger($request->all());
        $error = null;
        DB::beginTransaction();
        try {
            
            $response_producto = SysPlanesProductosModel::where(['id_empresa'   => Session::get('id_empresa') ,'id_sucursal' => Session::get('id_sucursal')] )->get();
            if( count($response_producto) > 0){
                SysPlanesProductosModel::where(['id_empresa'   => Session::get('id_empresa'),'id_sucursal' => Session::get('id_sucursal')])->delete();
            }
            SysPlanesProductosModel::where([
                'id_producto' => $request->id_producto 
                #,'id_empresa'  => $request->id_empresa
            ])->delete();
            $response = [];
            for ($i=0; $i < count($request->matrix) ; $i++) { 
                $matrices = explode('|', $request->matrix[$i] );
                $id_sucursal = $matrices[0];
                #se realiza una consulta si existe un registro.
                $data = [
                    'id_empresa'      => $request->id_empresa
                    ,'id_sucursal'    => $id_sucursal
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

    /**
     * Method for use query Products
     * @access public
     * @return void
     */
    private function _queryProducts()
    {
        var_export(Session::all());die();
        if( Session::get('id_rol') == 1 ){

            $response = SysProductosModel::with(['unidades','categorias','empresas'])
                            ->orderBy('id','desc')
                            ->groupby('id')
                            ->get();

        }elseif( Session::get('id_rol') == 3 ){
            $data = SysEmpresasModel::with(['productos'])
                                    ->where(['id' => Session::get('id_empresa')])            
                                    ->first();

            $response = $data->productos()
                                ->with(['unidades','categorias','empresas'])
                                ->orderBy('id','desc')
                                ->groupby('id')
                                ->get();

        }else{

            $data = SysUsersModel::with(['empresas'])
                                  ->where(['id' => Session::get('id')])            
                                  ->first();
            $company = $data->empresas()
                                ->with(['productos'])
                                ->where([ 'id' => Session::get('id_empresa') ])
                                ->first();
            $response = $company->productos()
                                    ->with(['unidades','categorias','empresas'])
                                    ->orderBy('id','desc')
                                    ->groupby('id')
                                    ->get();

        }
        return $response;

    }



}