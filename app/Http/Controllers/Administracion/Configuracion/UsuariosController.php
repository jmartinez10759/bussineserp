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
     *Metodo para obtener la vista y cargar los datos
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function indexx()
    {
        #debuger(Session::all());
        $response = SysUsersModel::with(['menus' => function ($query) {
            return $query->where(['sys_rol_menu.estatus' => 1, 'sys_rol_menu.id_empresa' => Session::get('id_empresa')])->get();
        }, 'roles' => function ($query) {
            return $query->groupBy('sys_users_roles.id_users', 'sys_users_roles.id_rol');
        }, 'details', 'bitacora']);

        if (Session::get('id_rol') == 1) {
            $response = $response->orderBy('id', 'DESC')->get();
        } else {
            $data = $response->with(['empresas' => function ($query) {
                return $query->where(['id' => Session::get('id_empresa')]);
            }])->where('id', '!=', Session::get('id'))->where('id', '!=', 1)->orderBy('id', 'DESC')->get();
            $response = [];
            foreach ($data as $respuesta) {
                if (count($respuesta->empresas) > 0) {
                    $response[] = $respuesta;
                }
            }
        }
        $eliminar = (Session::get('permisos')['DEL'] == false) ? 'style="display:block" ' : 'style="display:none" ';
        $asignar_permisos = (Session::get('id_rol') == 1 || Session::get('permisos')['PER'] == false) ? 'style="display:block" ' : 'style="display:none" ';

        $registros = [];
        foreach ($response as $respuesta) {
            $id['id'] = $respuesta->id;
            $editar = build_acciones_usuario($id, 'v-editar_register', 'Editar', 'btn btn-primary', 'fa fa-edit', 'title="editar"');
            $borrar = build_acciones_usuario($id, 'v-destroy_register', 'Borrar', 'btn btn-danger', 'fa fa-trash', 'title="borrar"' . $eliminar);
            $permisos = build_acciones_usuario($id, 'v-permisos', 'Permisos', 'btn btn-info', 'fa fa-gears', 'title="Asignar Permisos" ' . $asignar_permisos);
            $registros[] = [
                $respuesta->id,
                $respuesta->name . " " . $respuesta->first_surname . " " . $respuesta->second_surname
                , $respuesta->email, self::_roles($respuesta->roles)
                , (isset($respuesta->bitacora->conect) && $respuesta->bitacora->conect == 1) ? '<span class="label label-success">En Linea</span>' : '<span class="label label-danger">Desconectado</span>'
                , (isset($respuesta->bitacora->time_conected) && $respuesta->bitacora->time_conected !== null) ? $respuesta->bitacora->time_conected : ""
                , (isset($respuesta->bitacora->created_at) && $respuesta->bitacora->created_at !== null) ? $respuesta->bitacora->created_at : ""
                , (isset($respuesta->bitacora->updated_at) && $respuesta->bitacora->updated_at !== null) ? time_fechas($respuesta->bitacora->updated_at, timestamp()) : ""
                , ($respuesta->estatus == 1) ? "ACTIVO" : "BAJA"
                , $editar
                , $permisos
                , $borrar
            ];
        }
        $titulos = [
            'id', 'Nombre Completo', 'Correo', 'Roles', 'Estatus Conexión', 'Tiempo Conexión', 'Fecha Conexión', 'Hace Cuanto', 'Estatus', '', '', ''
        ];
        $table = [
            'titulos' => $titulos, 'registros' => $registros, 'id' => "datatable", 'class' => "fixed_header"
        ];
      #se crea el dropdown
        $roles = dropdown([
            'data'=> (Session::get('id_rol') == 1) ? SysRolesModel::where(['estatus' => 1])->get() : $this->_consulta( new SysRolesModel,[],['estatus' => 1],['id' => Session::get('id_empresa')],false )
            , 'value'     => 'id'
            , 'text'      => 'perfil'
            , 'name'      => 'cmb_roles'
            , 'class'     => 'form-control'
            , 'leyenda'   => 'Seleccione Opcion'
            , 'attr'      => 'data-live-search="true" '
            , 'multiple'  => ''
        ]);

        $roles_edit = dropdown([
            'data'=> (Session::get('id_rol') == 1) ? SysRolesModel::where(['estatus' => 1])->get() : $this->_consulta( new SysRolesModel,[],['estatus' => 1],['id' => Session::get('id_empresa')],false )
            , 'value'     => 'id'
            , 'text'      => 'perfil'
            , 'name'      => 'cmb_roles_edit'
            , 'class'     => 'form-control'
            , 'leyenda'   => 'Seleccione Opcion'
            , 'attr'      => 'data-live-search="true" '
            , 'multiple'  => ''
        ]);

        /*$empresas = dropdown([
            'data' => (Session::get('id_rol') == 1) ? SysEmpresasModel::where(['estatus' => 1])->get() : $this->_consulta_employes(new SysUsersModel)
            , 'value'     => 'id'
            , 'text'      => 'nombre_comercial'
            , 'name'      => 'cmb_empresas'
            , 'class'     => 'form-control'
            , 'leyenda'   => 'Todas las Empresas'
            , 'attr'      => 'data-live-search="true" '
            , 'event'     => 'v-change_empresas("cmb_sucursales","cmb_empresas","div_sucursales")'
            , 'multiple'  => ''
        ]);*/

        /*$empresas_edit = dropdown([
            'data' => (Session::get('id_rol') == 1) ? SysEmpresasModel::where(['estatus' => 1])->get() : $this->_consulta_employes(new SysUsersModel)
            , 'value' => 'id'
            , 'text' => 'nombre_comercial'
            , 'name' => 'cmb_empresas_edit'
            , 'class' => 'form-control'
            , 'leyenda' => 'Todas las Empresas'
            , 'attr' => 'data-live-search="true" '
            , 'event' => 'v-change_empresas("cmb_sucursal_edit","cmb_empresas_edit","div_edit_sucursales")'
            , 'multiple' => ''
        ]);*/

        $data = [
            'page_title' => "Configuracion"
            , 'title' => "Usuarios"
            , 'subtitle' => "Creacion Usuarios"
           /* , 'data_table' => data_table($table)
            , 'select_roles' => $roles, 'select_empresas' => $empresas
            , 'select_empresas_edit' => $empresas_edit
            , 'select_roles_edit' => $roles_edit*/
            , 'titulo_modal' => "Agregar Usuario"
            , 'titulo_modal_edit' => "Actualizar Usuario"
            , 'campo_1' => 'Nombre Completo'
            , 'campo_2' => 'Correo'
            , 'campo_3' => 'Contraseña'
            , 'campo_4' => 'Tipo de Rol'
            , 'campo_5' => 'Estatus'
            , 'campo_6' => 'Empresas'
            , 'campo_7' => 'Sucursales'
        ];
        return self::_load_view('administracion.configuracion.usuarios', $data);

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function index()
    {
        if( Session::get('permisos')['GET'] ){ return view('errors.error');}

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

        return $this->_load_view( 'administracion.configuracion.usuarios', $data );
    }

    /**
     * @return \App\Http\Controllers\json|string
     */
    public function all()
    {
        try {
            $data = [
                'users'         => $this->_verifyRol()
                ,'roles'        => SysRolesModel::whereEstatus(1)->get()
                ,'companies'    => SysEmpresasModel::whereEstatus(1)->get()
                ,'groups'       => SysSucursalesModel::whereEstatus(1)->get()
            ];
            return $this->_message_success(200, $data , self::$message_success);
        } catch (\Exception $e ) {
            $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
            return $this->show_error(6, $error);
        }
    }

    /**
     *This method is for get the data of user
     * @access public
     * @param int|null $userId
     * @return void
     */
    public function show( int $userId = null )
    {
        try {
            $users      = SysUsersModel::with(['menus','roles','empresas','sucursales','details'])->whereId($userId)->first();
            $action     = ( Session::get('id_rol') == 1 ) ? SysAccionesModel::whereEstatus(1)->orderBy('id', 'ASC')->get() : $this->_actionByCompanies(new SysEmpresasModel);
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
            #$companies  = ( Session::get('id_rol') == 1 ) ? SysEmpresasModel::whereEstatus(1)->get() : $this->_userBelongsCompany(new SysUsersModel);
            #$groups     = ( Session::get('id_rol') == 1 ) ? SysSucursalesModel::whereEstatus(1)->get() : $this->_groupsByCompanies(new SysEmpresasModel);
            #$roles      = ( Session::get('id_rol') == 1 ) ? SysRolesModel::whereEstatus(1)->get() : $this->_rolesByCompanies(new SysEmpresasModel);

            $menusByUser       = $users->menus()->where(['sys_rol_menu.estatus'=> true])->groupby('sys_rol_menu.id_menu')->get();
            $companyByUser     = $users->empresas()->where(['sys_empresas.estatus'=> true])->groupby('id')->get();
            $rolesByUser       = $users->roles()->where(['sys_roles.estatus'=> true])->groupby('id')->get();
            $groupsByUser      = $users->sucursales()->where(['sys_sucursales.estatus'=> true])->groupby('id')->get();
            $data = [
                "menus"           => $menuPadre ,
                "action"          => $action ,
                "menusByUser"     => $menusByUser ,
                "companyByUser"   => $companyByUser ,
                "rolesByUser"     => $rolesByUser ,
                "groupsByUser"    => $groupsByUser ,
            ];

            return new JsonResponse([
                "success" => true,
                "data"    => $data,
                "message" => self::_message_success()
            ],Response::HTTP_OK);

/*
            $registros = [];
            $registros_acciones = [];

            foreach ($response_menu as $respuesta) {
                $id['id'] = $respuesta->id;
                $checkbox = build_actions_icons($id, 'id_permisos= "' . $respuesta->id . '" ');
                $checkbox_actions = build_acciones_usuario($id, 'get_acciones', '', 'fancybox btn btn-primary ' . $respuesta->id, 'fa fa-users', 'title="Asignar Permisos" ');
                $registros[] = [
                    $respuesta->id, $respuesta->texto, $respuesta->id_padre, $respuesta->tipo, $checkbox, $checkbox_actions
                ];
            }
            foreach ($response_acciones as $respuesta) {
                $id['id'] = 'actions_' . $respuesta->id;
                $checkbox_actions_permisos = build_actions_icons($id, 'id_actions="' . $respuesta->id . '" ');
                $registros_acciones[] = [
                    $respuesta->clave_corta, $respuesta->descripcion, $checkbox_actions_permisos
                ];

            }
            $titulos = ['id', 'Nombre Modulo', 'Id Padre', 'Tipo', 'Permisos', 'Acciones'];
            $titulos_acciones = ['Tipo Acción', 'Descripción', 'Permiso'];
            $table = ['titulos' => $titulos, 'registros' => $registros, 'id' => "datatable_permisos", 'class' => 'fixed_header'];
            $table_acciones = ['titulos' => $titulos_acciones, 'registros' => $registros_acciones, 'id' => "datatable_acciones", 'class' => 'fixed_header'];

            $data = [];
            foreach ($response as $usuarios) {
                $data = [
                    'id_rol' => ($usuarios->roles), 'id_empresa' => ($usuarios->empresas), 'id_sucursal' => $usuarios->sucursales, 'name' => $usuarios->name, 'first_surname' => $usuarios->first_surname, 'second_surname' => $usuarios->second_surname, 'email' => $usuarios->email, 'estatus' => $usuarios->estatus
                ];
            }
            $data['menus_permisos'] = data_table($table);
            $data['permisos_acciones'] = data_table($table_acciones);*/
          #debuger($data);
          #return message( true,$data,self::$message_success );

        } catch (\Exception $e) {
            $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
            return new JsonResponse([
                "success" => false ,
                "data"    => $error ,
                "message" => self::_message_success()
            ],Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * @param SysMenuModel $menus
     * @param int|null $menuId
     * @return array
     */
    private function _submenus( $menus, int $menuId = null ){
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
     *@access public
     *@param Request $request [Description]
     *@return void
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
                $requestUsers[$key] = sha1($value);
            }
        }
        $nameComplete = parse_name($request->name);
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
        $requestUsers['username']           = $request->username;
        $requestUsers['remember_token']     = str_random(50);
        $requestUsers['api_token']          = str_random(50);
        $requestUsers['estatus']            = true;
        $requestUsers['confirmed']          = true;
        $requestUsers['confirmed_code']     = null;

        $error = null;
        DB::beginTransaction();
        try {
            $usersRegister = SysUsersModel::create($requestUsers);
            for ($i = 0; $i < count($request->id_sucursal); $i++) {
                $data = [
                    'id_users'     => $usersRegister->id
                    ,'id_empresa'  => $this->_empresas($request->id_sucursal[$i])
                    ,'id_sucursal' => $request->id_sucursal[$i]
                ];
                $roles = [$request->id_rol];
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
                ,'menssage' => self::$message_success
            ],Response::HTTP_CREATED);
        }
        return new JsonResponse([
            'success'   => $success
            ,'data'     => $error
            ,'menssage' => self::$message_error
        ],Response::HTTP_BAD_REQUEST);

    }

    /**
     *This method is need for update register of users
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function update( Request $request )
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
                $requestUsers[$key] = sha1($value);
            }
        }
        $nameComplete = parse_name($request->name);
        if (!$nameComplete) {
            return new JsonResponse([
                'success'   => false
                ,'data'     => $nameComplete
                ,'message'  => self::$message_error
            ],Response::HTTP_BAD_REQUEST);
        }
        $requestUsers['name']               = $nameComplete['name'];
        $requestUsers['first_surname']      = $nameComplete['first_surname'];
        $requestUsers['second_surname']     = $nameComplete['second_surname'];
        $requestUsers['username']           = $request->username;
        $requestUsers['remember_token']     = str_random(50);
        $requestUsers['api_token']          = str_random(50);
        $requestUsers['estatus']            = $request->estatus;
        $requestUsers['confirmed']          = true;
        $requestUsers['confirmed_code']     = null;

        $error = null;
        DB::beginTransaction();
        try {
            SysUsersModel::whereId($request->id)->update($requestUsers);
            SysUsersRolesModel::where(['id_users' => $request->id])->delete();
            $sql = "DELETE FROM sys_rol_menu WHERE id_users = ".$request->id;
            $where = "";
            for ($i=0; $i < count($request->id_empresa); $i++) {
                $where .= " AND id_empresa != ".$request->id_empresa[$i];
            }
            $sql .= $where;
            DB::select($sql);
            $response = [];
            for ($i = 0; $i < count($request->id_sucursal); $i++) {
                $data = [
                    'id_users'      => $request->id
                    ,'id_empresa'   => $this->_empresas($request->id_sucursal[$i])
                    ,'id_sucursal'  => $request->id_sucursal[$i]
                ];
                $roles = [$request->id_rol];
                for ($j = 0; $j < count($roles); $j++) {
                    $data['id_rol'] = $roles[$j];
                    $response[] = SysUsersRolesModel::create($data);
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
                'success'   => true
                ,'data'     => $response
                ,'message'  => self::$message_success
            ],Response::HTTP_OK);
        }
        return new JsonResponse([
            'success'   => false
            ,'data'     => $error
            ,'message'  => self::$message_error
        ],Response::HTTP_BAD_REQUEST);
    }

    /**
     *Metodo para borrar el registro
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

    /*private static function _roles($request)
    {
        $roles = (isset($request)) ? $request : [];
        $html = "";
        if (count($roles) > 0) {
            foreach ($roles as $rol) {
                $html .= '<span class="label label-info">' . $rol->perfil . '</span> ';
            }
        }
        return $html;
    }*/

    /**
     *Metodo para obtener las empresas del usuario
     * @access public
     * @param int|null $id_sucursal
     * @return void
     */
    private function _empresas(int $id_sucursal = null )
    {
        $where = ['id_sucursal' => $id_sucursal, 'estatus' => 1];
        $requestCompany= SysEmpresasSucursalesModel::select('id_empresa')->where($where)->first();
        return isset($requestCompany->id_empresa) ? $requestCompany->id_empresa : 0;
    }

    /**
     * This is method is for do query
     * @return SysUsersModel[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function _verifyRol()
    {
        $groupRoles =  function($query){
            return $query->groupBy('sys_users_roles.id_users');
        };
        $groupGroups = function($query){
            return $query->groupBy('sys_users_roles.id_users','sys_users_roles.id_sucursal');
        };
        if( Session::get('id_rol') == 1 ){
            $response = SysUsersModel::with([
                'roles'         => $groupRoles
                ,'sucursales'   => $groupGroups
                ,'bitacora'
                ,'empresas:id,razon_social,nombre_comercial,rfc_emisor'
            ])->orderBy('id','desc')->groupby('id')->get();

        }elseif( Session::get('id_rol') == 3 ){

            $response = SysEmpresasModel::with(['usuarios'])
                                    ->whereId( Session::get('id_empresa') )
                                    ->first()
                                    ->usuarios()->with([
                                        'roles'         => $groupRoles
                                        ,'sucursales'   => $groupGroups
                                        ,'bitacora'
                                        ,'empresas:id,razon_social,nombre_comercial,rfc_emisor'
                                    ])
                                    ->orderBy('id','desc')
                                    ->groupby('id')
                                    ->get();

        }else{
            $response = SysUsersModel::with(['empresas'])
                                    ->whereId( Session::get('id') )->first()
                                    ->empresas()
                                    ->whereId( Session::get('id_empresa') )
                                    ->first()
                                    ->roles()->with(['empresas','sucursales','bitacora'])
                                    ->orderBy('id','desc')
                                    ->groupby('id')
                                    ->get();
        }
        return $response;

    }


}