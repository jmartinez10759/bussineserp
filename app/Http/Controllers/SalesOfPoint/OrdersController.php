<?php


namespace App\Http\Controllers\SalesOfPoint;


use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysFormasPagosModel;
use App\Model\Administracion\Configuracion\SysMetodosPagosModel;
use App\Model\Administracion\Configuracion\SysProductosModel;
use App\SysConcepts;
use App\SysOrders;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrdersController extends MasterController
{
    /**
     * OrdersController constructor.
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
            if ( !isset($request->orderId) && !$request->orderId){
                $data = [
                    "box_id"            => $request->get("boxId") ,
                    "payment_form_id"   => $request->get("paymentForm") ,
                    "payment_method_id" => $request->get("paymentMethod") ,
                    "status_id"         => $request->get("status") ,
                ];
                $response = $orders->create($data);
                $orderId = $response->id;
            }else{
                $orderId = $request->get("orderId");
            }
            #var_export($orderId);die();
            $order = $orders->find($orderId);
            $order->concepts()->create([
                "order_id"          => $order->id ,
                "product_id"        => $request->get("productId") ,
                "quality"           => 1 ,
                "discount"          => 0 ,
                "price"             => $product->total ,
                "total"             => $product->total
            ]);

            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            $success = false;
            $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
            DB::rollback();
        }

        if ($success) {

            return $this->show($order->id, $orders );
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
            $response = $orders->with(['concepts' => function($query){
                return $query->with('products');
            }])->find($id);
            $subtotal = $response->concepts->sum("total");
            $iva      = $subtotal * 16 / 100;
            $total    = ($iva + $subtotal);
            $data = [
                "order"     => $response ,
                "subtotal"  => number_format($subtotal ,2),
                "iva"       => number_format($iva ,2),
                "total"     => number_format($total,2)
            ];

            return new JsonResponse([
                'success'   => TRUE
                ,'data'     => $data
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

    /**
     * This method is for destroy register the rol by companies
     * @access public
     * @param int $id [Description]
     * @param SysConcepts $concepts
     * @return JsonResponse
     */
    public function destroyConcept( int $id = null, SysConcepts $concepts )
    {
        $error = null;
        DB::beginTransaction();
        try {
            $concept = $concepts->find($id);
            $concept->delete();
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