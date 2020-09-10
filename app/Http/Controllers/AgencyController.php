<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

class AgencyController extends MasterController
{

    /**
     * @var Request
     */
    private $_request;

    public function __construct(Request $request)
    {
        parent::__construct();
        $this->_request = $request;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'page_title' 	          => "Agenda de citas"
            ,'title'  		          => "Agenda"
        ];
        return $this->_loadView( 'agency.agency', $data );
    }

    /**
     * @return JsonResponse
     */
    public function all()
    {
        try {
            $data['month']  =  date("m");
            $data['year']   =  date("Y");
            $where = "";
            if (Session::get("roles_id") != 1){
                $where .= " e.id = ".Session::get('company_id')." AND ss.id = ".Session::get('group_id');
            }
            $sql = "SELECT
                    o.id ,
                    e.razon_social ,
                    CONCAT(ss.codigo,' ',ss.sucursal) AS grupo ,
                    b.name ,
                    o.comments ,
                    o.file_path ,
                    CONCAT(u.name,' ',u.first_surname,' ',u.second_surname) AS full_name ,
                    CONCAT(su.name,' ',su.first_surname,' ',su.second_surname) AS kitchen ,
                    ROUND(o.subtotal,2) AS subtotal ,
                    ROUND(o.iva,2) AS iva ,
                    ROUND(o.total,2) AS total,
                    ROUND(o.swap,2) AS swap,
                    CONCAT(fg.clave,' ',fg.descripcion) AS forma_pago ,
                    CONCAT(mp.clave,' ',mp.descripcion) as metodo_pago ,
                    se.id AS status_id,
                    se.nombre AS status,
                    o.created_at
                FROM companies_boxes cb
                     JOIN sys_empresas e ON cb.company_id = e.id
                     JOIN sys_sucursales ss ON cb.group_id= ss.id
                     JOIN sys_users u ON cb.user_id = u.id
                     JOIN boxes b ON cb.box_id = b.id
                     JOIN orders o ON o.box_id = b.id
                     LEFT JOIN sys_users su ON o.user_id = su.id
                     JOIN sys_formas_pagos fg ON o.payment_form_id = fg.id
                     JOIN sys_metodos_pagos mp ON o.payment_method_id = mp.id
                     JOIN sys_estatus se ON o.status_id = se.id
                WHERE 
                     MONTH(o.created_at ) = {$data['month']} AND YEAR(o.created_at) = {$data['year']}
                  {$where}
                ORDER BY o.id DESC";
            $data = DB::select($sql);

            return \response()->json([
                "success" => TRUE ,
                "data"    => $data ,
                "message" => self::$message_success
            ],Response::HTTP_OK);

        } catch ( \Exception $e) {
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            \Log::debug($error);
            return \response()->json([
                "success" => FALSE ,
                "data"    => $error ,
                "message" => self::$message_error
            ],Response::HTTP_BAD_REQUEST);
        }

    }
}
