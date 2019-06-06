<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysMenuModel;
use App\Model\Administracion\Configuracion\SysRolesModel;
use App\Model\Administracion\Configuracion\SysAccionesModel;
use App\Model\Administracion\Configuracion\SysEmpresasModel;
use App\Model\Administracion\Configuracion\SysUsersModel;
use App\Model\Administracion\Configuracion\SysCorreosModel;
use App\Model\Administracion\Configuracion\SysRolMenuModel;
use App\Model\Administracion\Configuracion\SysUsersRolesModel;
use App\Model\Administracion\Configuracion\SysSucursalesModel;
use App\Model\Administracion\Correos\SysCategoriasCorreosModel;
use App\Model\Administracion\Configuracion\SysUsersPermisosModel;
use App\Model\Administracion\Facturacion\SysFacturacionModel;
use App\Model\Administracion\Configuracion\SysEmpresasSucursalesModel;
use App\Model\Administracion\Facturacion\SysParcialidadesFechasModel;
use App\Model\Administracion\Facturacion\SysUsersFacturacionModel;
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
                'users'         => $this->_usersBelongsCompany( new SysEmpresasModel )
                ,'roles'        => ( Session::get('id_rol') == 1 ) ? SysRolesModel::whereEstatus(1)->get() : $this->_rolesByCompanies(new SysEmpresasModel)
                ,'companies'    => ( Session::get('id_rol') == 1 ) ? SysEmpresasModel::whereEstatus(1)->get() : $this->_userBelongsCompany(new SysUsersModel)
                ,'groups'       => ( Session::get('id_rol') == 1 ) ? SysSucursalesModel::whereEstatus(1)->get() : $this->_groupsByCompanies(new SysEmpresasModel)
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
            $users      = SysUsersModel::with(['menus','roles','empresas','sucursales','details'])->whereId($userId)->first();
            $action     = ( Session::get('id_rol') == 1 ) ? SysAccionesModel::whereEstatus(1)->orderBy('id', 'ASC')->get() : $this->_actionByCompanies(new SysUsersModel);
            $menus      = ( Session::get('id_rol') == 1 ) ? SysMenuModel::whereEstatus(1)->orderBy('orden', 'asc')->get() : $this->_menusByCompanies(new SysUsersModel);
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
            $companyByUser     = $users->empresas()->where(['sys_empresas.estatus'=> TRUE])->groupby('id')->get();
            $rolesByUser       = $users->roles()->where(['sys_roles.estatus'=> TRUE])->groupby('id')->get();
            $groupsByUser      = $users->sucursales()->where(['sys_sucursales.estatus'=> TRUE])->groupby('id')->get();
            $data = [
                "menus"           => $menuPadre ,
                "action"          => $action ,
                "companyByUser"   => $companyByUser ,
                "rolesByUser"     => $rolesByUser ,
                "groupsByUser"    => $groupsByUser ,
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
        $responseUsers = SysUsersModel::whereEmail($request->email)->first();
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
            for ($i = 0; $i < count($request->get("id_sucursal")); $i++) {
                $data = [
                    'id_users'     => $usersRegister->get('id')
                    ,'id_empresa'  => $this->_companies($request->get("id_sucursal")[$i])
                    ,'id_sucursal' => $request->get("id_sucursal")[$i]
                ];
                $roles = [$request->get("id_rol")];
                for ($j = 0; $j < count($roles); $j++) {
                    $data['id_rol'] = $roles[$j];
                    SysUsersRolesModel::create($data);
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
     *This method is need for update register of users
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
            if (Session::get('id_rol') != 1) {
                SysUsersRolesModel::whereIdUsers($request->get('id'))->delete();
                $sql = "DELETE FROM sys_rol_menu WHERE id_users = " . $request->get("id");
                $where = "";
                for ($i = 0; $i < count($request->get('id_empresa')); $i++) {
                    $where .= " AND id_empresa != " . $request->get('id_empresa')[$i];
                }
                $sql .= $where;
                DB::select($sql);
                $response = [];
                for ($i = 0; $i < count($request->get("id_sucursal")); $i++) {
                    $data = [
                        'id_users' => $request->get('id')
                        , 'id_empresa' => $this->_companies($request->get('id_sucursal')[$i])
                        , 'id_sucursal' => $request->get('id_sucursal')[$i]
                    ];
                    $roles = [$request->get('id_rol')];
                    for ($j = 0; $j < count($roles); $j++) {
                        $data['id_rol'] = $roles[$j];
                        $response[] = SysUsersRolesModel::create($data);
                    }
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
                ,'data'     => $userUpdate
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
     * @return JsonResponse
     */
    public function destroy(int $userId = null)
    {
        $error = null;
        DB::beginTransaction();
        try {
            $mailId = [];
            $invoiceId= [];
            $usersMails = SysCategoriasCorreosModel::whereIdUsers($userId)->get();
            $usersInvoice = SysUsersFacturacionModel::whereIdUsers($userId)->get();
            if (count($usersMails) > 0) {
                foreach ($usersMails as $mails) {
                    $mailId[] = $mails->id_correo;
                }
                SysCorreosModel::whereIn('id',$mailId)->delete();
            }
            if (count($usersInvoice) > 0) {
                foreach ($usersInvoice as $invoice) {
                    $invoiceId[] = $invoice->id_factura;
                }
                SysFacturacionModel::whereIn('id',$invoiceId)->delete();
                SysParcialidadesFechasModel::whereIn('id_factura', $invoiceId)->delete();
            }
            SysUsersPermisosModel::whereIdUsers($userId)->delete();
            SysRolMenuModel::whereIdUsers($userId)->delete();
            SysUsersFacturacionModel::whereIdUsers($userId)->delete();
            SysCategoriasCorreosModel::whereIdUsers($userId)->delete();
            SysUsersRolesModel::whereIdUsers($userId)->delete();
            SysUsersModel::whereId($userId)->delete();

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
     *Metodo para obtener las empresas del usuario
     * @access public
     * @param int|null $id_sucursal
     * @return void
     */
    private function _companies(int $id_sucursal = null )
    {
        $where = ['id_sucursal' => $id_sucursal, 'estatus' => 1];
        $requestCompany= SysEmpresasSucursalesModel::select('id_empresa')->where($where)->first();
        return isset($requestCompany->id_empresa) ? $requestCompany->id_empresa : 0;
    }

    /**
     * This is method is for do query
     * @param SysEmpresasModel $companies
     * @return SysUsersModel[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function _usersBelongsCompany( SysEmpresasModel $companies )
    {
        $groupRoles =  function($query){
            return $query->groupBy('sys_users_roles.id_users');
        };
        $groupGroups = function($query){
            return $query->groupBy('sys_users_roles.id_users','sys_users_roles.id_sucursal');
        };

        if( Session::get('id_rol') == 1 ){

            $response = SysUsersModel::with([
                 'bitacora'
                ,'roles'        => $groupRoles
                ,'sucursales'   => $groupGroups
                ,'empresas:id,razon_social,nombre_comercial,rfc_emisor'
            ])->orderBy('id','DESC')->groupby('id')->get();

        }else{
            $response = $companies->with('usuarios')
                                    ->whereId( Session::get('id_empresa') )
                                    ->first()
                                    ->usuarios()->with([
                                        'roles'         => $groupRoles
                                        ,'sucursales'   => $groupGroups
                                        ,'bitacora'
                                        ,'empresas:id,razon_social,nombre_comercial,rfc_emisor'
                                    ])
                                    ->orderBy('id','DESC')
                                    ->groupby('id')
                                    ->get();
        }

        return $response;

    }


}