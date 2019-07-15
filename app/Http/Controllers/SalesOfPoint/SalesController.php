<?php
/**
 * Created by PHP Storm
 * User : jmartinez
 * Date : 6/07/19
 * Time : 11:09 PM
 */

namespace App\Http\Controllers\SalesOfPoint;

use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysEmpresasModel;
use App\SysBoxes;
use App\SysOrders;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

class SalesController extends MasterController
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
            'page_title' 	              => "Punto de Venta"
            ,'title'  		              => "Pedidos"
        ];
        return $this->_loadView( 'salesOfPoint.sales', $data );
    }

    /**
     * This method is for get all data sales by company
     * @access public
     * @return JsonResponse
     */
    public function all()
    {
        try {
            $data = [
                "sales"     => $this->_salesBelongsCompany() ,
                "users"     => $this->_usersBelongsCompany() ,
            ];
            return new JsonResponse([
                "success" => TRUE ,
                "data"    => $data ,
                "message" => self::$message_success
            ],Response::HTTP_OK);

        } catch ( \Exception $e) {
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            \Log::debug($error);
            return new JsonResponse([
                "success" => FALSE ,
                "data"    => $error ,
                "message" => self::$message_error
            ],Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * This method is for insert information in boxes
     * @access public
     * @param Request $request [Description]
     * @param SysOrders $orders
     * @return JsonResponse
     */
    public function store( Request $request, SysOrders $orders )
    {
        $error = null;
        DB::beginTransaction();
        try {
            $data = array_filter($request->all(), function ($key) use ($request){
                if($key != "groupId" && $key != "companyId" && $key != "userId"){
                    $data[$key] = $request->$key;
                    if ($request->$key == 0){
                        $data[$key] = "0";
                    }
                    return $data;
                }
            },ARRAY_FILTER_USE_KEY);
            $response = $boxes->create($data);
            $box = $boxes->find($response->id);
            if ( isset($request->companyId ) ){
                $box->groups()->attach($request->get("groupId"),[
                    'company_id' => $request->get("companyId") ,
                    'user_id'  => $request->get("userId")
                ]);
            }else{
                $box->groups()->attach([Session::get('group_id')],[
                    'company_id' => Session::get('company_id') ,
                    'user_id'  => $request->get("userId")
                ]);
            }
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
                ,'data'     => $response
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
            $response = $boxes->with('companies','groups','users')->find($id);
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
     * @param SysOrders $orders
     * @return JsonResponse
     */
    public function update( Request $request, SysOrders $orders )
    {
        $error = null;
        DB::beginTransaction();
        try {
            $data = array_filter($request->all(), function ($key) use ($request){
                if($key != "companyId" && $key != "groupId" && $key != "userId"){
                    $data[$key] = $request->$key;
                    if ($request->$key == 0){
                        $data[$key] = "0";
                    }
                    return $data;
                }
            },ARRAY_FILTER_USE_KEY);

            $box = $boxes->find($request->get('id'));
            $box->update($data);
            if ( isset($request->companyId) && $request->companyId){
                $box->groups()->detach();
                $box->groups()->attach($request->get("groupId"),[
                    'company_id' => $request->get("companyId") ,
                    'user_id'  => $request->get("userId")
                ]);
            }

            DB::commit();
            $success = true;
        } catch ( \Exception $e) {
            $success = false;
            $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
            DB::rollback();
        }

        if ($success) {
            return $this->show( $request->get("id"), new SysBoxes );
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
     * @param SysOrders $orders
     * @return JsonResponse
     */
    public function destroy( int $id = null, SysOrders $orders )
    {
        $error = null;
        DB::beginTransaction();
        try {
            $box = $boxes->find($id);
            $box->groups()->detach();
            $box->delete();
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


    public function _salesBelongsCompany()
    {
        $where = "";
        if (Session::get("roles_id") != 1){
            $where .= " AND e.id = ".Session::get('company_id');
        }
        $sql = "SELECT
                   o.id ,
                   e.razon_social ,
                   b.name ,
                   o.comments ,
                   ROUND(o.subtotal,2) AS subtotal ,
                   ROUND(o.iva,2) AS iva ,
                   ROUND(o.total,2) AS total,
                   ROUND(o.swap,2) AS swap,
                   CONCAT(fg.clave,' ',fg.descripcion) AS forma_pago ,
                   CONCAT(mp.clave,' ',mp.descripcion) as metodo_pago ,
                   se.nombre AS status,
                   o.created_at
                FROM companies_boxes cb
                JOIN sys_empresas e ON cb.company_id = e.id
                JOIN boxes b ON cb.box_id = b.id
                JOIN orders o ON o.box_id = b.id
                JOIN sys_formas_pagos fg ON o.payment_form_id = fg.id
                JOIN sys_metodos_pagos mp ON o.payment_method_id = mp.id
                JOIN sys_estatus se ON o.status_id = se.id
                WHERE MONTH(o.created_at ) = 7 AND YEAR(o.created_at) = 2019
                  {$where}
                ORDER BY o.id DESC";
        $response = DB::select($sql);
        \Log::debug($response);die();

    }


}
