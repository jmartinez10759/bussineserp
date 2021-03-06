<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use App\Model\Administracion\Configuracion\SysSucursalesModel;
use App\SysPermission;
use App\SysUsersPivot;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysMenuModel;
use App\Model\Administracion\Configuracion\SysUsersModel;
use Symfony\Component\HttpFoundation\JsonResponse;


class UsuariosController extends MasterController
{

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function index()
    {
        $data = [
            'page_title'            => "Configuracion"
            , 'title'               => "Usuarios"
            , 'subtitle'            => "Creacion Usuarios"
            , 'titulo_modal'        => "Agregar Usuario"
            , 'titulo_modal_edit'   => "Actualizar Usuario"
            , 'campo_1'             => 'Nombre Completo'
            , 'campo_2'             => 'Correo'
            , 'campo_3'             => 'Contraseña'
            , 'campo_4'             => 'Tipo de Rol'
            , 'campo_5'             => 'Estatus'
            , 'campo_6'             => 'Empresas'
            , 'campo_7'             => 'Sucursales'
            , 'campo_8'             => 'UserName'
        ];
        return $this->_loadView( 'administracion.configuracion.usuarios', $data );
    }

    /**
     * This method is for get information of the users
     * @return JsonResponse
     */
    public function all()
    {
        try {
            $data = [
                'users'         => $this->_usersBelongsCompany()
                ,'roles'        => $this->_rolesBelongsCompany()
                ,'companies'    => $this->_companyBelongsUsers()
                #,'groups'       => $this->_groupsBelongsCompanies()
            ];

            return new JsonResponse([
                "success" => TRUE ,
                "data"    => $data ,
                "message" => self::$message_success
            ],Response::HTTP_OK);

        } catch (\Exception $e ) {
            $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
            return new JsonResponse([
                "success" => FALSE ,
                "data"    => $error ,
                "message" => self::$message_error
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * This method is for get the data of user
     * @access public
     * @param int|null $userId
     * @return JsonResponse
     */
    public function show( int $userId = null )
    {
        try {
            $users      = SysUsersModel::find($userId);
            $action     = ( Session::get('roles_id') == 1 ) ? SysPermission::whereStatus(TRUE)->orderBy('id', 'ASC')->get() : $this->_actionByCompanies(new SysUsersModel);
            $menus      = $this->_menusBelongsCompany();
            $menuPadre = [];
            foreach ($menus as $menu ){
                if ($menu->tipo == "PADRE"){
                    $menuPadre[] = [
                        'id'        => $menu->id
                        ,'texto'    => $menu->texto
                        ,'submenus' => $this->_submenus($menus, $menu->id)
                    ];
                }
            }
            $companyByUser     = $users->companies()->whereEstatus(TRUE)->groupby('id')->get();
            $rolesByUser       = $users->roles()->whereEstatus(TRUE)->groupby('id')->get();
            $data = [
                "menus"           => $menuPadre ,
                "action"          => $action ,
                "companyByUser"   => $companyByUser ,
                "rolesByUser"     => $rolesByUser ,
            ];

            return new JsonResponse([
                "success" => TRUE,
                "data"    => $data,
                "message" => self::$message_success
            ],Response::HTTP_OK);

        } catch (\Exception $e) {
            $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
            return new JsonResponse([
                "success" => false ,
                "data"    => $error ,
                "message" => self::$message_error
            ],Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * @param SysMenuModel $menus
     * @param int|null $menuId
     * @return array
     */
    private function _submenus( $menus, int $menuId = null )
    {
        $submenus = [];
        foreach ($menus as $menu){
            if ($menu->id_padre == $menuId){
                $submenus[] = [
                    'id'    => $menu->id
                    ,'texto' => $menu->texto
                ];
            }
        }
        return $submenus;
    }

    /**
     *It's method is for register the users
     * @access public
     * @param Request $request [Description]
     * @return JsonResponse
     */
    public function store( Request $request )
    {
        $requestUsers = [];
        $responseUsers = SysUsersModel::whereEmail($request->get("email"))->first();
        if ($responseUsers) {
            return new JsonResponse([
                'success'   => false
                ,'data'     => $responseUsers
                ,'menssage' => "¡Registro del usuario existente!"
            ],Response::HTTP_BAD_REQUEST);
        }
        $keysUsers = ['name', 'email'];
        foreach ($request->all() as $key => $value) {
            if (in_array($key, $keysUsers)) {
                if ($key == "email") {
                    $requestUsers[$key] = strtolower($value);
                } else {
                    $requestUsers[$key] = strtoupper($value);
                }
            }
            if ($key == "password" && $value != false) {
                $requestUsers[$key] = bcrypt($value);
            }
        }
        $nameComplete = parse_name($request->get("name"));
        if (!$nameComplete) {
            return new JsonResponse([
                'success'   => false
                ,'data'     => $nameComplete
                ,'menssage' => "¡Favor de Ingresar al menos un apellido!"
            ],Response::HTTP_BAD_REQUEST);
        }
        $requestUsers['name']               = $nameComplete['name'];
        $requestUsers['first_surname']      = $nameComplete['first_surname'];
        $requestUsers['second_surname']     = $nameComplete['second_surname'];
        $requestUsers['username']           = $request->get("username");
        $requestUsers['remember_token']     = str_random(50);
        $requestUsers['api_token']          = str_random(50);
        $requestUsers['estatus']            = TRUE;
        $requestUsers['confirmed']          = TRUE;
        $requestUsers['confirmed_code']     = NULL;

        $error = null;
        DB::beginTransaction();
        try {
            $usersRegister = SysUsersModel::create($requestUsers);
            $group = (isset($request->id_sucursal))? count($request->get('id_sucursal')) : 0;
            $begin = (count($request->get("id_empresa")) >= $group )
                        ? count($request->get("id_empresa"))
                        : count($request->get("id_sucursal"));
            for ($i=0; $i < $begin ; $i++){
                $data = [
                    "user_id"       =>  $usersRegister->id ,
                    "roles_id"      =>  $request->get("id_rol") ,
                    "company_id"    =>  $request->get("id_empresa")[$i] ,
                    "group_id"      =>  isset($request->get('id_sucursal')[$i])? $request->get('id_sucursal')[$i]: 0
                ];
                SysUsersPivot::insert($data);
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
                ,'data'     => $usersRegister
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
     * This method is used for register update of users
     * @access public
     * @param Request $request [Description]
     * @param SysUsersModel $users
     * @return JsonResponse
     */
    public function update( Request $request, SysUsersModel $users )
    {
        $requestUsers = [];
        $keysUsers = ['name', 'email'];
        foreach ($request->all() as $key => $value) {
            if (in_array($key, $keysUsers )) {
                if ($key == "email") {
                    $requestUsers[$key] = strtolower($value);
                } else {
                    $requestUsers[$key] = strtoupper($value);
                }
            }
            if ($key == "password" && $value != false) {
                $requestUsers[$key] = bcrypt($value);
            }
        }
        $nameComplete = parse_name($request->get("name"));
        if (!$nameComplete) {
            return new JsonResponse([
                'success'   => FALSE
                ,'data'     => $nameComplete
                ,'message'  => self::$message_error
            ],Response::HTTP_BAD_REQUEST);
        }
        $requestUsers['name']               = $nameComplete['name'];
        $requestUsers['first_surname']      = $nameComplete['first_surname'];
        $requestUsers['second_surname']     = $nameComplete['second_surname'];
        $requestUsers['username']           = $request->get("username");
        $requestUsers['remember_token']     = str_random(50);
        $requestUsers['api_token']          = str_random(50);
        $requestUsers['estatus']            = $request->get("estatus");
        $requestUsers['confirmed']          = TRUE;
        $requestUsers['confirmed_code']     = NULL;

        $error = null;
        DB::beginTransaction();
        try {
            $users->whereId($request->get("id"))->update($requestUsers);
            $user = $users->find($request->get("id"));
            if($request->get("id_rol") != 1 ){
                $user->roles()->detach($request->get('id_rol'));
                $user->groups()->detach($request->get('id_sucursal'));
                $user->companies()->detach($request->get('id_empresa'));
                for ($i = 0; $i < count($request->get('id_sucursal'));$i++){
                    $data = [
                        "user_id"       =>  $request->get("id") ,
                        "roles_id"      =>  $request->get("id_rol") ,
                        "company_id"    =>  $this->_getCompany($request->get('id_sucursal')[$i]),
                        "group_id"      =>  $request->get('id_sucursal')[$i]
                    ];
                    SysUsersPivot::insert($data);
                }

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
                ,'data'     => $user
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
     * This method is for destroy the register of user
     * @access public
     * @param int|null $userId
     * @param SysUsersModel $users
     * @return JsonResponse
     */
    public function destroy(int $userId = null, SysUsersModel $users )
    {
        $error = null;
        DB::beginTransaction();
        try {
            $user = $users->find($userId);
            $user->roles()->detach();
            $user->delete();
            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            $success = false;
            $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
            DB::rollback();
        }

        if ($success) {
            return new JsonResponse([
                'success' => $success
                ,'data'   => $userId
                ,'message' => self::$message_success
            ],Response::HTTP_CREATED);

        }
        return new JsonResponse([
            'success' => $success
            ,'data'   => $error
            ,'message' => self::$message_error
        ],Response::HTTP_BAD_REQUEST);
    }

    /**
     * This method is used get for company by group id
     * @access public
     * @param int|null $groupId
     * @return int
     */
    private function _getCompany(int $groupId = null )
    {
        $group = SysSucursalesModel::find($groupId);
        $company = $group->companiesGroups()->where([
            "sys_companies_groups.group_id" =>  $groupId
        ])->whereEstatus(TRUE)->first();
        return isset($company->id) ? $company->id : 0;
    }

}