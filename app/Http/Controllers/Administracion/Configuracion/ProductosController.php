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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProductosController extends MasterController
{

    /**
     * ProductosController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * This method is used load for view
     * @access public
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'page_title' 	         => "Configuración"
            ,'title'  		         => "Productos"
            ,'data_table'  		     => "data_table(table)"
        ];

        return $this->_loadView( "administracion.configuracion.productos",$data );
    }

    /**
     * This Method is used get all products.
     * @access public
     * @return JsonResponse
     */
    public function all()
    {
        try {
            $products = $this->_productsBelongCompany();
            $data = [
             'products'         => $products
             ,'companies'       => SysEmpresasModel::whereEstatus(TRUE)->groupby('id')->get()
             ,'units'           => SysUnidadesMedidasModel::whereEstatus(TRUE)->get()
             ,'categories'      => SysCategoriasProductosModel::whereEstatus(TRUE)->get()
             ,'services'        => SysClaveProdServicioModel::get()
             ,'factorType'      => SysTipoFactorModel::get()
             ,'tasas'           => SysTasaModel::get()
           ];
            return new JsonResponse([
                "success" => TRUE ,
                "data"    => $data ,
                "message" => self::$message_success
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            return new JsonResponse([
                "success" => FALSE ,
                "data"    => $error ,
                "message" => self::$message_error
            ], Response::HTTP_BAD_REQUEST);

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
     * This method is used update information of products
     * @access public
     * @param Request $request [Description]
     * @param SysProductosModel $products
     * @return JsonResponse
     */
    public function update( Request $request, SysProductosModel $products )
    {
        $error = null;
        DB::beginTransaction();
        try {
            $dataRegister = [];
            foreach ($request->all() as $key => $value) {
                if($key == "logo"){
                    $dataRegister[$key] = ($value);
                }else{
                    $dataRegister[$key] = strtoupper($value);
                }
            }
            $products->whereId($request->get("id"))->update($dataRegister);
            $product = $products->find($request->get("id"));

            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            $success = false;
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            DB::rollback();
        }

        if ($success) {
            return new JsonResponse([
                'success'   => TRUE
                ,'data'     => $product
                ,'message'  => self::$message_success
            ], Response::HTTP_OK);
        }
        return new JsonResponse([
            'success'   => FALSE
            ,'data'     => $error
            ,'message'  => self::$message_error
        ], Response::HTTP_BAD_REQUEST);

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
     * this method is used load products by company
     * @access public
     * @return void
     */
    private function _productsBelongCompany()
    {
        if( Session::get('roles_id') == 1 ){

            $response = SysProductosModel::with('units','categories','companies')
                            ->orderBy('id','DESC')
                            ->groupby('id')
                            ->get();
        }else{
            $response = SysEmpresasModel::find(Session::get("company_id"))
                                ->products()
                                ->with('units','categories','companies')
                                ->orderBy('id','DESC')
                                ->groupby('id')
                                ->get();
        }
        return $response;

    }



}