<?php


namespace App\Http\Controllers\SalesOfPoint;


use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysFormasPagosModel;
use App\Model\Administracion\Configuracion\SysMetodosPagosModel;
use App\Model\Administracion\Configuracion\SysProductosModel;
use App\SysBoxes;
use App\SysOrders;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrdersController extends MasterController
{

    /**
     * SalesController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * @access public
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'page_title' 	          => "Punto de Venta"
            ,'title'  		          => "Ordenes"
        ];
        return $this->_loadView( 'salesOfPoint.orders', $data );
    }

    /**
     * This method is for get all data orders by company
     * @access public
     * @return JsonResponse
     */
    public function all()
    {
        try {
            $data = [
                "boxes"             => $this->_boxesBelongsCompany() ,
                "products"          => $this->_productsBelongCompany() ,
                "paymentMethod"     => SysMetodosPagosModel::whereEstatus(true)->get() ,
                "paymentForm"       => SysFormasPagosModel::whereEstatus(true)->get()
            ];
            return new JsonResponse([
                "success" => TRUE ,
                "data"    => $data ,
                "message" => self::$message_success
            ],Response::HTTP_OK);

        } catch ( \Exception $e) {
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            return new JsonResponse([
                "success" => FALSE ,
                "data"    => $error ,
                "message" => self::$message_error
            ],Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * This method is for insert information in orders
     * @access public
     * @param Request $request [Description]
     * @param SysOrders $orders
     * @param SysProductosModel $products
     * @return JsonResponse
     */
    public function store( Request $request, SysOrders $orders, SysProductosModel $products )
    {

        $error = null;
        DB::beginTransaction();
        try {

            $product = $products->find($request->get("productId"));

            $data = [
                "box_id"            => $request->get("boxId") ,
                "product_id"        => $request->get("productId") ,
                "payment_form_id"   => $request->get("paymentForm") ,
                "payment_method_id" => $request->get("paymentMethod") ,
                "status_id"         => $request->get("status") ,
                "quality"           => 1 ,
                "discount"          => 0 ,
                "whole"             => $product->total
            ];
            $response = $orders->create($data);
            $order = $orders->with("products")->find($response->id);
            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            $success = false;
            $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
            DB::rollback();
        }

        if ($success) {
            return new JsonResponse([
                'success'   => $success
                ,'data'     => $order
                ,'message' => self::$message_success
            ],Response::HTTP_CREATED);
        }
        return new JsonResponse([
            'success'   => $success
            ,'data'     => $error
            ,'message' => self::$message_error
        ],Response::HTTP_BAD_REQUEST);

    }

    /**
     * This method is for get information the roles by companies
     * @access public
     * @param int|null $id
     * @param SysOrders $orders
     * @return JsonResponse
     */
    public function show( int $id = null, SysOrders $orders )
    {
        try {
            $response = $orders->with('companiesRoles','groupsRoles')->find($id);
            return new JsonResponse([
                'success'   => TRUE
                ,'data'     => $response
                ,'message'  => self::$message_success
            ],Response::HTTP_OK);

        } catch (\Exception $e) {
            $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
            return new JsonResponse([
                'success'   => FALSE
                ,'data'     => $error
                ,'message'  => self::$message_error
            ],Response::HTTP_BAD_REQUEST);

        }

    }

    /**
     * This method is for update register the roles
     * @access public
     * @param Request $request [Description]
     * @param SysRolesModel $roles
     * @return JsonResponse
     */
    public function update( Request $request, SysRolesModel $roles )
    {
        $error = null;
        DB::beginTransaction();
        try {
            $data = array_filter($request->all(), function ($key) use ($request){
                if($key != "companyId"){
                    $data[$key] = $request->$key;
                    if ($request->$key == 0){
                        $data[$key] = "0";
                    }
                    return $data;
                }
            },ARRAY_FILTER_USE_KEY);

            $roles->whereId($request->get('id'))->update($data);
            if ( isset($request->companyId) && $request->companyId){
                $rol = $roles->find($request->get('id'));
                $rol->companiesRoles()->sync($request->get("companyId"));
            }

            DB::commit();
            $success = true;
        } catch ( \Exception $e) {
            $success = false;
            $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
            DB::rollback();
        }

        if ($success) {
            return $this->show( $request->get("id"), new SysRolesModel );
        }
        return new JsonResponse([
            'success'   => FALSE
            ,'data'     => $error
            ,'message'  => self::$message_error
        ],Response::HTTP_BAD_REQUEST);

    }

    /**
     * This method is for destroy register the rol by companies
     * @access public
     * @param int $id [Description]
     * @param SysRolesModel $roles
     * @return JsonResponse
     */
    public function destroy( int $id = null, SysRolesModel $roles )
    {
        $error = null;
        DB::beginTransaction();
        try {
            $rol = $roles->find($id);
            $rol->companiesRoles()->detach();
            $rol->companies()->detach();
            $rol->delete();
            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            $success = false;
            $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
            DB::rollback();
        }

        if ($success) {
            return new JsonResponse([
                'success'   => $success
                ,'data'     => []
                ,'message' => self::$message_success
            ],Response::HTTP_OK);
        }
        return new JsonResponse([
            'success'   => $success
            ,'data'     => $error
            ,'message' => self::$message_error
        ],Response::HTTP_BAD_REQUEST);

    }

}