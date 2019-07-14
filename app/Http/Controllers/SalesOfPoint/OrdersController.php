<?php


namespace App\Http\Controllers\SalesOfPoint;


use App\Facades\Ticket;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysEmpresasModel;
use App\Model\Administracion\Configuracion\SysFormasPagosModel;
use App\Model\Administracion\Configuracion\SysMetodosPagosModel;
use App\Model\Administracion\Configuracion\SysProductosModel;
use App\Model\Administracion\Configuracion\SysUsersModel;
use App\SysOrders;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrdersController extends MasterController
{
    public $ticket;
    /**
     * OrdersController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->ticket = new Ticket("EPSON");
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
                "boxes"             => $this->_boxesBelongsUsers() ,
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
            $order = $orders->find($orderId);
            $logs = $order->boxes->logs()->where('boxes_logs.created_at','LIKE',$this->_today->format("Y-m-d").'%' )->count();
            $order->update([
                'count'     => $logs ,
                'comments'  => $request->get("comments")
            ]);
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
            $this->_updateQuantity(new Request([
                "id"        => $id ,
                "subtotal"  => $subtotal ,
                "iva"       => $iva ,
                "total"     => $total
            ]), $orders);

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
     * This is method used update register and ticket generate
     * @param Request $request
     * @param SysOrders $orders
     * @return JsonResponse
     */
    public function update( Request $request, SysOrders $orders )
    {
        $error = null;
        DB::beginTransaction();
        try {
            $data = [
                'status'            => $request->get("status") ,
                'payment_form_id'   => $request->get("paymentForm") ,
                'payment_method_id' => $request->get("paymentMethod") ,
                'comments'          => $request->get("comments") ,
                'swap'              => $request->get("swap") ,
            ];
            $order = $orders->find($request->get("orderId"));
            $order->update($data);
            $dataPrinter = [];
            foreach ($order->boxes->companies as $company){
                $dataPrinter = [
                    "rfc"               =>  $company->rfc_emisor ,
                    "social_reason"     =>  $company->razon_social ,
                    "logo"              =>  $company->logo ,
                    "address"           =>  $company->calle ,
                    "postal_code"       =>  $company->codigo,
                    "state"             =>  $company->states->estado ,
                    "country"           =>  $company->countries->descripcion
                ];
            }
            $dataPrinter['order']    = $order->id;
            $dataPrinter['caja']     = $order->boxes->name;
            $dataPrinter['cajero']   = ( $order->boxes->logs->count() > 0 ) ? $order->boxes->logs[0]->name." ".$order->boxes->logs[0]->first_surname : "CAJERO";
            $dataPrinter['subtotal'] = $order->subtotal;
            $dataPrinter['iva']      = $order->iva;
            $dataPrinter['total']    = $order->total;
            foreach ($order->concepts as $concept){
                $dataPrinter['concepts'][] = [
                    "code"          => $concept->products->codigo ,
                    "product"       => $concept->products->nombre ,
                    "price"         => $concept->products->total ,
                    "discount"      => $concept->discount ,
                    "quality"       => $concept->quality ,
                    "total"         => $concept->total
                ];
            }
            $ticket = $this->ticket->printer($dataPrinter);
            $path = "";
            if ($ticket['success']){
                $path = $ticket['data'];
            }
            \Log::debug($path);
            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            $success = false;
            $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
            \Log::error($error);
            DB::rollback();
        }

        if ($success) {
            return new JsonResponse([
                'success'   => $success
                ,'data'     => $path
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
     * This method is for update register the orders
     * @access public
     * @param Request $request [Description]
     * @param SysOrders $orders
     * @return JsonResponse
     */
    private function _updateQuantity( Request $request, SysOrders $orders )
    {
        $error = null;
        DB::beginTransaction();
        try {
            $order = $orders->find($request->get("id"));
            $order->update($request->all());
            DB::commit();
            $success = true;
        } catch ( \Exception $e) {
            $success = false;
            $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
            \Log::error($error);
            DB::rollback();
        }

        if ($success) {
            return new JsonResponse([
                'success'   => $success
                ,'data'     => $order
                ,'message'  => self::$message_success
            ],Response::HTTP_OK);
        }
        return new JsonResponse([
            'success'   => $success
            ,'data'     => $error
            ,'message'  => self::$message_error
        ],Response::HTTP_BAD_REQUEST);

    }

    /**
     * This method is for destroy register the rol by companies
     * @access public
     * @param int $id [Description]
     * @param SysOrders $orders
     * @return JsonResponse
     */
    public function destroy( int $id = null, SysOrders $orders )
    {
        $error = null;
        DB::beginTransaction();
        try {
            $order = $orders->find($id);
            $order->concepts()->delete();
            $order->delete();
            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            $success = false;
            $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
            \Log::error($error);
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
     * @return mixed
     */
    public function _boxesBelongsUsers()
    {
        $response = SysUsersModel::find(Session::get('id'))
            ->boxes()->orderBy('id','DESC')->groupby('id')->get();

        return $response;
    }

}
