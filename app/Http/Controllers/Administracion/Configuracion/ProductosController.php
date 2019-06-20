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
     *This method is used show register of products by id
     * @access public
     * @param Request $request [Description]
     * @param SysProductosModel $products
     * @return JsonResponse
     */
    public function show( Request $request, SysProductosModel $products )
    {
        try {
            $product = $products->find($request->get("id"));
            return new JsonResponse([
                'success'   => TRUE
                ,'data'     => $product
                ,'message'  => self::$message_success
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            return new JsonResponse([
                'success'   => FALSE
                ,'data'     => $error
                ,'message'  => self::$message_error
            ], Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * This method is used for register information products by companies
     * @access public
     * @param Request $request [Description]
     * @param SysProductosModel $products
     * @return JsonResponse
     */
    public function store( Request $request, SysProductosModel $products )
    {
        $error = null;
        DB::beginTransaction();
        try {
            $dataRegister = array_filter($request->all(), function ($key) use ($request){
                if($key != "groupId" && $key != "companyId"){
                    if ($request->$key == 0){
                        $data[$key] = "0";
                    }
                    if ($key == "logo"){
                        $data[$key] = $request->$key;
                    }else{
                        $data[$key] = (is_string($request->$key))? strtoupper($request->$key) : $request->$key;
                    }
                    return $data;
                }
            },ARRAY_FILTER_USE_KEY);

            $insertProduct = $products->create($dataRegister);
            $product = $products->find($insertProduct->id);
            if ( isset($request->groupId ) && isset($request->companyId )){
                $product->groups()->attach($request->get("groupId"),['company_id' => $request->get("companyId")]);
            }else{
                $product->groups()->attach([Session::get('group_id')],['company_id' => Session::get("company_id")]);
            }

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

            $dataRegister = array_filter($request->all(), function ($key) use ($request){
                if($key != "groupId" && $key != "companyId"){
                    if ($request->$key == 0){
                        $data[$key] = "0";
                    }
                    if ($key == "logo"){
                        $data[$key] = $request->$key;
                    }else{
                        $data[$key] = (is_string($request->$key))? strtoupper($request->$key) : $request->$key;
                    }
                    return $data;
                }
            },ARRAY_FILTER_USE_KEY);

            $product = $products->find($request->get("id"));
            $product->update($dataRegister);
            if ( isset($request->groupId) && $request->groupId){
                $product->groups()->detach();
                $product->groups()->attach($request->get("groupId"),['company_id' => $request->get("companyId")]);
            }

            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            $success = false;
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            DB::rollback();
        }

        if ($success) {
           return $this->show(new Request($request->all()), new SysProductosModel );
        }
        return new JsonResponse([
            'success'   => FALSE
            ,'data'     => $error
            ,'message'  => self::$message_error
        ], Response::HTTP_BAD_REQUEST);

    }

    /**
     * This method is used of delete products with relationship
     * @access public
     * @param int|null $productId
     * @param SysProductosModel $products
     * @return JsonResponse
     */
    public function destroy( int $productId = null, SysProductosModel $products  )
    {
        $error = null;
        DB::beginTransaction();
        try {
            $product = $products->find($productId);
            $product->companies()->detach();
            $product->delete();
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
                ,'data'     => []
                ,'message'  => self::$message_success
            ], Response::HTTP_OK);
        }

        return new JsonResponse([
            'success'   => FALSE
            ,'data'     => $error
            ,'message'  => self::$message_error
        ], Response::HTTP_BAD_REQUEST);

    }

}