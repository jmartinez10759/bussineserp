<?php


namespace App\Http\Controllers\SalesOfPoint;


use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysEmpresasModel;
use App\Model\Administracion\Configuracion\SysUsersModel;
use App\SysBoxes;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

class BoxesController extends MasterController
{
    /**
     * BoxesController constructor.
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
            ,'title'  		              => "Cajas"
        ];
        return $this->_loadView( 'salesOfPoint.boxes', $data );
    }

    /**
     * This method is for get all data boxes by company
     * @access public
     * @return JsonResponse
     */
    public function all()
    {
        try {
            $data = [
                "boxes"     => $this->_boxesBelongsCompany() ,
                "users"     => $this->_usersBelongsCompany() ,
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
     * This method is for insert information in boxes
     * @access public
     * @param Request $request [Description]
     * @param SysBoxes $boxes
     * @return JsonResponse
     */
    public function store( Request $request, SysBoxes $boxes )
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
     * @param SysBoxes $boxes
     * @return JsonResponse
     */
    public function show( int $id = null, SysBoxes $boxes )
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
     * @param SysBoxes $boxes
     * @return JsonResponse
     */
    public function update( Request $request, SysBoxes $boxes )
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
     * @param SysBoxes $boxes
     * @return JsonResponse
     */
    public function destroy( int $id = null, SysBoxes $boxes )
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

    /**
     * This method is used close box and cut box
     * @param int|null $id
     * @param SysBoxes $boxes
     * @return JsonResponse
     */
    public function boxCut(int $id = null, SysBoxes $boxes)
    {
        try {
            $today = $this->_today->format('Y-m-d');
            $box = $boxes->with(['orders' => function($query) use ($today){
                return $query->where('created_at','LIKE',$today.'%')->get();
            }])->find($id);
            $totalOrder = $box->orders()->sum("total");
            return new JsonResponse([
                'success'   => TRUE
                ,'data'     => $totalOrder
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

}