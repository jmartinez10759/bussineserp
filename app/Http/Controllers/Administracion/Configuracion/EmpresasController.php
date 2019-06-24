<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysUsersModel;
use App\Model\Administracion\Configuracion\SysEmpresasModel;
use App\Model\Administracion\Configuracion\SysRegimenFiscalModel;
use App\Model\Administracion\Configuracion\SysServiciosComercialesModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EmpresasController extends MasterController
{
    /**
     * EmpresasController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * This method is used load for view companies
     * @access public
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
      public function index()
      {
           $data = [
             'page_title'               =>  "Configuración"
             ,'title'                   =>  "Empresas"
           ];
           return $this->_loadView( 'administracion.configuracion.empresas', $data );
      }

    /**
     * This method is used for load information data
     * @access public
     * @return JsonResponse
     */
      public function all()
      {
          try {
            $data = [
              'companies'          => $this->_companyBelongsUsers(),
              'tradeService'       => SysServiciosComercialesModel::get() ,
              'taxRegime'          => SysRegimenFiscalModel::get() ,
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
     *This method is used for insert data information
     * @access public
     * @param Request $request [Description]
     * @param SysEmpresasModel $companies
     * @return JsonResponse
     */
      public function store( Request $request, SysEmpresasModel $companies )
      {
          $error = null;
          DB::beginTransaction();
          try {
              $stringKeyContacts = [ 'contacto','departamento','telefono', 'correo' ];
              $stringDataCompany = [];
              $stringDataContact = [];
              foreach( $request->all() as $key => $value ){
                  if( in_array( $key, $stringKeyContacts) ){
                      if( $key == 'contacto' ){
                          $stringDataContact['nombre_completo'] = strtoupper($value);
                      }else{
                          if($key != "correo"){
                              $stringDataContact[$key] = strtoupper($value);
                          }else{
                              $stringDataContact[$key] = strtolower($value);
                          }
                      }
                  };
                  if( !in_array( $key, $stringKeyContacts) && $key != "contacts"){
                      if($key == "logo"){
                          $stringDataCompany[$key] = (trim($value));
                      }else{
                          $stringDataCompany[$key] = strtoupper($value);
                      }
                  };

              }
              $response = $companies->create($stringDataCompany);
              $company = $companies->find($response->id);
              $contacts = $company->contacts()->create($stringDataContact);
              $company->contacts()->sync($contacts->id);

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
                  ,'data'     => $company
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
     * this method is used ger for information by  company id
     * @access public
     * @param int|null $id
     * @param SysEmpresasModel $companies
     * @return JsonResponse
     */
      public function show( int $id = null , SysEmpresasModel $companies )
      {
          try {
              $response = $companies->with("comerciales","postalCode","regimenes","states","countries","contacts" )->find($id);
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
     * This method is used update for register information of companies
     * @access public
     * @param Request $request [Description]
     * @param SysEmpresasModel $companies
     * @return JsonResponse
     */
      public function update( Request $request, SysEmpresasModel $companies )
      {
          $error = null;
          DB::beginTransaction();
          try {
              $stringKeyContacts = [ 'contacto','departamento','telefono', 'correo' ];
              $stringDataCompany = [];
              $stringDataContact = [];
              foreach( $request->all() as $key => $value ){
                  if( in_array( $key, $stringKeyContacts) ){
                      if( $key == 'contacto' ){
                          $stringDataContact['nombre_completo'] = strtoupper($value);
                      }else{
                          if($key != "correo"){
                              $stringDataContact[$key] = strtoupper($value);
                          }else{
                              $stringDataContact[$key] = strtolower($value);
                          }
                      }
                  };
                  if( !in_array( $key, $stringKeyContacts) && $key != "contacts"){
                      if($key == "logo"){
                          $stringDataCompany[$key] = (trim($value));
                      }else{
                          $stringDataCompany[$key] = strtoupper($value);
                      }
                  };

              }
              $companies->whereId($request->get("id"))->update($stringDataCompany);
              $company = $companies->find($request->get("id"));

              if( count($request->get("contacts") ) > 0 ){
                  $company->contacts()->whereId($request->contacts[0]['id'])->update($stringDataContact);
              }else{
                  $contacts = $company->contacts()->create($stringDataContact);
                  $company->contacts()->sync($contacts->id);
              }

            DB::commit();
            $success = true;
          } catch (\Exception $e) {
            $success = false;
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            DB::rollback();
          }

          if ($success) {
              return $this->show( $request->get("id"), new SysEmpresasModel );
          }
          return new JsonResponse([
              'success'   => FALSE
              ,'data'     => $error
              ,'message'  => self::$message_error
          ], Response::HTTP_BAD_REQUEST);

      }

    /**
     * this method is used register delete of company
     * @access public
     * @param int $id [Description]
     * @param SysEmpresasModel $companies
     * @return JsonResponse
     */
    public function destroy(int $id = null, SysEmpresasModel $companies )
    {
        $error = null;
        DB::beginTransaction();
        try {
              $company = $companies->find($id);
              $company->users()->detach();
              $company->menus()->detach();
              $company->permission()->detach();
              $company->contacts()->detach();
              $company->products()->detach();
              $company->groupsCompanies()->detach();
              $company->rolesCompanies()->detach();
              $company->menusCompanies()->detach();
              $company->permissionCompanies()->detach();
              $company->delete();

            DB::commit();
              $success = true;
        } catch (\Exception $e) {
              $success = false;
              $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
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
      * This method is used load for companies
      * @access public
      * @return void
      */
     public function listCompanies()
      {
          $data['titulo'] = "LISTADO DE EMPRESAS";
          $data['titulo_sucusales'] = "LISTADO DE SUCURSALES";
          return view('administracion.configuracion.list_bussines',$data);
      }

    /**
     * @return JsonResponse
     */
    public function loadCompanies()
    {
        try {
          $user = SysUsersModel::find(Session::get('id') );
          $companies = $user->companies()->whereEstatus(TRUE)->groupby("id")->get();
          return new JsonResponse([
              "success" => TRUE ,
              "data"    => $companies ,
              "message" => self::$message_success
          ],Response::HTTP_OK);

        } catch (\Exception $e) {
            $error = $e->getMessage()." ".$e->getFile()." ".$e->getLine();
            return new JsonResponse([
                "success" => TRUE ,
                "data"    => $error ,
                "message" => self::$message_error
            ],Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * This method is used get for the between relations company and group
     * @access public
     * @param Request $request [Description]
     * @return JsonResponse
     */
    public function findRelGroups( Request $request )
    {
        $response = [];
        if(is_null($request->get('id_empresa'))){
            return new JsonResponse([
                "success"   => false
                ,"data"     => $response
                ,"message"  => "¡No se encontró ningún grupo en esta Empresa!"
            ],Response::HTTP_BAD_REQUEST);
        }
        $companies = SysEmpresasModel::with(["groupsCompanies" => function($query){
            return $query->groupBy('sys_companies_groups.group_id');
        }])->whereIn('id',[$request->get("id_empresa")])->get();

        if ( count($companies) > 0){
                $i = 0;
                foreach ($companies as $company ){
                    if (count($company->groupsCompanies) > 0){
                        foreach ($company->groupsCompanies as $groups){
                            $response[$i]['groups']  = [
                                'id'            => $groups->id
                                ,'descripcion'  => $company->razon_social." - ".$groups->sucursal
                            ];
                            $i++;
                        }
                    }
                }
        }
          return new JsonResponse([
              "success"   => true
              ,"data"     => $response
              ,"message"  => "¡Se cargo correctamente los grupos!"
          ],Response::HTTP_OK);

    }

    /**
     * @param Request $request
     * @param SysUsersModel $users
     * @return JsonResponse
     */
    public function findByUserGroups(Request $request, SysUsersModel $users )
    {
      try {
          $user = $users->find($request->get("userId"));
          $groups     = $user->groups()->where([
                "sys_users_pivot.roles_id"      =>  $request->get("rolId") ,
                "sys_users_pivot.company_id"    =>  $request->get("companyId") ,

          ])->groupBy('sys_users_pivot.group_id')->get();

          return new JsonResponse([
              "success" => true ,
              "data"    => $groups ,
              "message" => self::$message_success
          ],Response::HTTP_OK);

      } catch ( \Exception $error ) {
          $errors = $error->getMessage()." ".$error->getFile()." ".$error->getLine();
          return new JsonResponse([
              "success" => false ,
              "data"    => $errors ,
              "message" => self::$message_error
          ],Response::HTTP_BAD_REQUEST);
      }
  }

}
