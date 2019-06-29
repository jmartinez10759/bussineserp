<?php


namespace App\Http\Controllers\SalesOfPoint;

use App\Http\Controllers\MasterController;
use App\SysConcepts;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

class ConceptsController extends MasterController
{


    /**
     * ConceptsController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * @access public
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    /*public function index()
    {
        $data = [
            'page_title' 	          => "Punto de Venta"
            ,'title'  		          => "Ordenes"
        ];
        return $this->_loadView( 'salesOfPoint.orders', $data );
    }*/

    /**
     * This method is for get all data orders by company
     * @access public
     * @return JsonResponse
     */
    /*public function all()
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

    }*/

    /**
     * This method is for insert information in orders
     * @access public
     * @param Request $request [Description]
     * @param SysOrders $orders
     * @param SysProductosModel $products
     * @return JsonResponse
     */
    /*public function store( Request $request, SysOrders $orders, SysProductosModel $products )
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

    }*/

    /**
     * This method is for get information the roles by companies
     * @access public
     * @param int|null $id
     * @param SysConcepts $concepts
     * @return JsonResponse
     */
    public function show( int $id = null, SysConcepts $concepts )
    {
        try {
            $data = $concepts->find($id);
            var_export($data);die();
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
     * This method is for update register the concepts
     * @access public
     * @param Request $request [Description]
     * @param SysConcepts $concepts
     * @return JsonResponse
     */
    public function update( Request $request, SysConcepts $concepts )
    {
        $error = null;
        DB::beginTransaction();
        try {
            $data = array_map(function ($value) use ($concepts){
                $arrayKey = ['created_at','updated_at','products'];
                foreach ($value as $key => $values){
                    if (!in_array($key,$arrayKey)){
                        $data[$key] = $values;
                    }
                }
                $total = $data['quality'] * $data['price'];
                $totalDiscount = $total * $data['discount'] / 100;
                $data['total'] = ($total - $totalDiscount );
                $concept = $concepts->find($data['id']);
                $concept->update($data);
                return $data;
            },$request->all());

            DB::commit();
            $success = true;
        } catch ( \Exception $e) {
            $success = false;
            $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
            DB::rollback();
        }

        if ($success) {
            return new JsonResponse([
                'success'   => TRUE
                ,'data'     => $data
                ,'message'  => self::$message_error
            ],Response::HTTP_OK);
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
     * @param SysConcepts $concepts
     * @return JsonResponse
     */
    public function destroy( int $id = null, SysConcepts $concepts )
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