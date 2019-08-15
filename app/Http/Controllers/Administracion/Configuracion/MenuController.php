<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysMenuModel;
use Symfony\Component\HttpFoundation\JsonResponse;

class MenuController extends MasterController
{
    public function __construct()
    {
       parent::__construct();
    }

    /**
     *This method is for load the view in the template
     * @access public
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
     $data = [
            'page_title' 	      => "Configuración"
            ,'title'  		      => "Menus"
            ,'subtitle' 	      => "Creación de Menus"
            ,'titulo_modal'       => "Crear Menú"
            ,'titulo_modal_edit'  => "Actualizar Menus"
            ,'campo_1' 		      => 'Menú'
            ,'campo_2' 		      => 'Tipo'
            ,'campo_3' 		      => 'Menú Padre'
            ,'campo_4' 		      => 'Url'
            ,'campo_5' 		      => 'Icono'
            ,'campo_6' 		      => 'Estatus'
            ,'campo_7' 		      => 'Posición'
        ];
     return $this->_loadView( 'administracion.configuracion.menu', $data );
    }

    /**
     * This method is for get information of the menu belong to company
     * @access public
     * @param int|null $id
     * @param SysMenuModel $menus
     * @return JsonResponse
     */
    public function show( int $id = null , SysMenuModel $menus )
    {
        try {
            $response = $menus->with('companiesMenus')->find($id);
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
     * This method is for get all data menus by company
     * @access public
     * @return JsonResponse
     */
    public function all()
    {
       try {
           $data = [
               "menus"        => $this->_menusBelongsCompany() ,
               "cmbMenus"     => SysMenuModel::whereTipo("PADRE")->get() ,
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
     * This method is for insert information of menus by companies
     * @access public
     * @param Request $request [Description]
     * @param SysMenuModel $menus
     * @return JsonResponse
     */
   public function store( Request $request, SysMenuModel $menus )
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

        $response = $menus->create($data);
        $menu = $menus->find($response->id);
        if ( isset($request->companyId ) && Session::get('roles_id') == 1 ){
            $menu->companiesMenus()->sync($request->get("companyId"));
        }else{
            $menu->companiesMenus()->sync([Session::get('company_id')]);
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
               "success" => TRUE ,
               "data"    => $menu ,
               "message" => self::$message_success
           ],Response::HTTP_CREATED);
       }
       return new JsonResponse([
           "success" => FALSE ,
           "data"    => $error ,
           "message" => self::$message_error
       ],Response::HTTP_BAD_REQUEST);

   }

    /**
     * This method is use for delete register
     * @access public
     * @param int $id [Description]
     * @param SysMenuModel $menus
     * @return JsonResponse
     */
    public function destroy( int $id = null, SysMenuModel $menus )
    {
      $error = null;
      DB::beginTransaction();
      try {
          $menu = $menus->find($id);
          $menu->companiesMenus()->detach($id);
          $menu->companies()->detach($id);
          $menu->delete();
        DB::commit();
        $success = true;

      } catch (\Exception $e) {
        $success = false;
        $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
        DB::rollback();
      }
      if ($success) {
          return new JsonResponse([
              "success" => $success ,
              "data"    =>  $id ,
              "message" => self::$message_success
          ],Response::HTTP_OK);
      }
        return new JsonResponse([
            "success" => $success ,
            "data"    => $error ,
            "message" => self::$message_error
        ],Response::HTTP_BAD_REQUEST);

    }

    /**
     * This method is for assign menus to companies and update register
     * @access public
     * @param Request $request [Description]
     * @param SysMenuModel $menus
     * @return JsonResponse
     */
    public function update( Request $request, SysMenuModel $menus )
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

          $menus->whereId($request->get("id"))->update($data);
          if ( isset($request->companyId) && $request->companyId ){
              $menu = $menus->find($request->get("id"));
              $menu->companiesMenus()->sync($request->get("companyId"));
          }

        DB::commit();
        $success = true;
      } catch (\Exception $e) {
        $success = false;
        $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
        DB::rollback();
      }

      if ($success) {
          return $this->show( $request->get("id"), new SysMenuModel);
      }
        return new JsonResponse([
            "success" => FALSE ,
            "data"    => $error ,
            "message" => self::$message_error
        ],Response::HTTP_BAD_REQUEST);

    }

}
