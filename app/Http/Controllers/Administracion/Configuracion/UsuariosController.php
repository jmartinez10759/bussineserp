<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
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
    public function index()
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
        #debuger(count($response));
        $eliminar = (Session::get('permisos')['DEL'] == false) ? 'style="display:block" ' : 'style="display:none" ';
        $asignar_permisos = (Session::get('id_rol') == 1 || Session::get('permisos')['PER'] == false) ? 'style="display:block" ' : 'style="display:none" ';

        $registros = [];
        foreach ($response as $respuesta) {
            $id['id'] = $respuesta->id;
            $editar = build_acciones_usuario($id, 'v-editar_register', 'Editar', 'btn btn-primary', 'fa fa-edit', 'title="editar"');
            $borrar = build_acciones_usuario($id, 'v-destroy_register', 'Borrar', 'btn btn-danger', 'fa fa-trash', 'title="borrar"' . $eliminar);
            $permisos = build_acciones_usuario($id, 'v-permisos', 'Permisos', 'btn btn-info', 'fa fa-gears', 'title="Asignar Permisos" ' . $asignar_permisos);
            $registros[] = [
                $respuesta->id, $respuesta->name . " " . $respuesta->first_surname . " " . $respuesta->second_surname, $respuesta->email, self::_roles($respuesta->roles), (isset($respuesta->bitacora->conect) && $respuesta->bitacora->conect == 1) ? '<span class="label label-success">En Linea</span>' : '<span class="label label-danger">Desconectado</span>', (isset($respuesta->bitacora->time_conected) && $respuesta->bitacora->time_conected !== null) ? $respuesta->bitacora->time_conected : "", (isset($respuesta->bitacora->created_at) && $respuesta->bitacora->created_at !== null) ? $respuesta->bitacora->created_at : "", (isset($respuesta->bitacora->updated_at) && $respuesta->bitacora->updated_at !== null) ? time_fechas($respuesta->bitacora->updated_at, timestamp()) : "", ($respuesta->estatus == 1) ? "ACTIVO" : "BAJA", $editar, $permisos, $borrar
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

        $empresas = dropdown([
            'data' => (Session::get('id_rol') == 1) ? SysEmpresasModel::where(['estatus' => 1])->get() : $this->_consulta_employes(new SysUsersModel)
            , 'value'     => 'id'
            , 'text'      => 'nombre_comercial'
            , 'name'      => 'cmb_empresas'
            , 'class'     => 'form-control'
            , 'leyenda'   => 'Todas las Empresas'
            , 'attr'      => 'data-live-search="true" '
            , 'event'     => 'v-change_empresas("cmb_sucursales","cmb_empresas","div_sucursales")'
            , 'multiple'  => ''
        ]);

        $empresas_edit = dropdown([
            'data' => (Session::get('id_rol') == 1) ? SysEmpresasModel::where(['estatus' => 1])->get() : $this->_consulta_employes(new SysUsersModel)
            , 'value' => 'id'
            , 'text' => 'nombre_comercial'
            , 'name' => 'cmb_empresas_edit'
            , 'class' => 'form-control'
            , 'leyenda' => 'Todas las Empresas'
            , 'attr' => 'data-live-search="true" '
            , 'event' => 'v-change_empresas("cmb_sucursal_edit","cmb_empresas_edit","div_edit_sucursales")'
            , 'multiple' => ''
        ]);

        $data = [
            'page_title' => "Configuracion"
            , 'title' => "Usuarios"
            , 'subtitle' => "Creacion Usuarios"
            , 'data_table' => data_table($table)
            , 'select_roles' => $roles, 'select_empresas' => $empresas
            , 'select_empresas_edit' => $empresas_edit
            , 'select_roles_edit' => $roles_edit
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
     *Metodo para realizar la consulta por medio de su id
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function show(Request $request)
    {

        try {
            $response = SysUsersModel::with(['menus' => function ($query) {
                return $query->where(['sys_rol_menu.estatus' => 1, 'sys_rol_menu.id_empresa' => Session::get('id_empresa')])->get();
            }, 'roles' => function ($query) {
                return $query->groupBy('sys_users_roles.id_users', 'sys_users_roles.id_rol');
            }, 'empresas' => function ($query) {
                return $query->where(['sys_empresas.estatus' => 1])->groupby('id');
            }, 'sucursales' => function ($query) {
                return $query->where(['sys_sucursales.estatus' => 1])->groupby('id');
            }, 'details'])->where(['id' => $request->id])->get();
          #debuger($response[0]->empresas);
            $response_menu = (Session::get('id_rol') == 1) ? SysMenuModel::where(['estatus' => 1])->get() : $this->_consulta_menus(new SysUsersModel);
            #debuger($response_menu);
            $response_acciones = SysAccionesModel::where(['estatus' => 1])->orderBy('id', 'ASC')->get();
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
            $data['permisos_acciones'] = data_table($table_acciones);
          #debuger($data);
          #return message( true,$data,self::$message_success );
            return $this->_message_success(201, $data, self::$message_success);
        } catch (\Exception $e) {
            $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
            return $this->show_error(6, $error);
        }

    }
    /**
     *Metodo para
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function store(Request $request)
    {
        $request_users = [];
          #se realiza la validacion si existe el email
        $where['email'] = $request->email;
        $consulta = SysUsersModel::where($where)->get();
        if (count($consulta) > 0) {
            return $this->show_error(3, $consulta, "Registro del usuario existente");
        }
        $claves_users = ['name', 'email'];
        foreach ($request->all() as $key => $value) {
            if (in_array($key, $claves_users)) {
                if ($key == "email") {
                    $request_users[$key] = strtolower($value);
                } else {
                    $request_users[$key] = strtoupper($value);
                }
            }
            if ($key == "password" && $value != false) {
                $request_users[$key] = sha1($value);
            }

        }
        $name_complete = parse_name($request->name);
        if (!$name_complete) {
            return $this->show_error(4, $name_complete, "Favor de Ingresar al menos un apellido");
        }
        $request_users['name'] = $name_complete['name'];
        $request_users['first_surname'] = $name_complete['first_surname'];
        $request_users['second_surname'] = $name_complete['second_surname'];
        $request_users['remember_token'] = str_random(50);
        $request_users['api_token'] = str_random(50);
        $request_users['estatus'] = 1;
        $request_users['confirmed'] = true;
        $request_users['confirmed_code'] = null;
          #se realiza una transaccion
        $error = null;
        DB::beginTransaction();
        try {
            $insert_users = SysUsersModel::create($request_users);
            #se realiza la inserccion de un id_users
            for ($i = 0; $i < count($request->id_sucursal); $i++) {
                #$id_users = $insert_users->id;
                $data = [
                    'id_users'     => $insert_users->id
                    ,'id_empresa'  => self::_empresas($request->id_sucursal[$i])
                    ,'id_sucursal' => $request->id_sucursal[$i]
                ];
                for ($j = 0; $j < count($request->id_rol); $j++) {
                    $data['id_rol'] = $request->id_rol[$j];
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
            return $this->_message_success(201, $success, self::$message_success);
        }
        return $this->show_error(6, $error, self::$message_error);

    }
    /**
     *Metodo para la actualizacion de los registros
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function update(Request $request)
    {
      #debuger($request->all());
        $request_users = [];
        $claves_users = ['name', 'email'];
        foreach ($request->all() as $key => $value) {
            if (in_array($key, $claves_users)) {
                if ($key == "email") {
                    $request_users[$key] = strtolower($value);
                } else {
                    $request_users[$key] = strtoupper($value);
                }
            }
            if ($key == "password" && $value != false) {
                $request_users[$key] = sha1($value);
            }
        }
        $name_complete = parse_name($request->name);
        if (!$name_complete) {
            return $this->show_error(3, $name_complete);
        }
        $request_users['name'] = $name_complete['name'];
        $request_users['first_surname'] = $name_complete['first_surname'];
        $request_users['second_surname'] = $name_complete['second_surname'];
        $request_users['remember_token'] = str_random(50);
        $request_users['api_token'] = str_random(50);
        $request_users['estatus'] = $request->estatus;
        $request_users['confirmed'] = true;
        $request_users['confirmed_code'] = null;
        $where = ['id' => $request->id];
          #se realiza una transaccion
        $error = null;
        DB::beginTransaction();
        try {
            #se realiza la actualizacion.
            SysUsersModel::where($where)->update($request_users);
            #se debe borrar sus roles y empresas para crear unos nuevos.
            SysUsersRolesModel::where(['id_users' => $request->id])->delete();
            #se borran los permisos para las empresas que se quitan.
            $sql = "DELETE FROM sys_rol_menu WHERE id_users = ".$request->id;
            $where = "";
            for ($i=0; $i < count($request->id_empresa); $i++) {
                $where .= " AND id_empresa != ".$request->id_empresa[$i];
            }
            $sql .= $where;
            DB::select($sql);
            for ($i = 0; $i < count($request->id_sucursal); $i++) {
                $data = [
                    'id_users'      => $request->id
                    ,'id_empresa'   => self::_empresas($request->id_sucursal[$i])
                    ,'id_sucursal'  => $request->id_sucursal[$i]
                ];
                for ($j = 0; $j < count($request->id_rol); $j++) {
                    $data['id_rol'] = $request->id_rol[$j];
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
            return $this->_message_success(201, $response, self::$message_success);
        }
        return $this->show_error(3, $error, self::$message_error);

    }
    /**
     *Metodo para borrar el registro
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function destroy(Request $request)
    {
        #se realiza una transaccion
        $error = null;
        DB::beginTransaction();
        try {
          #se borran los registro
            $users_correos = SysCategoriasCorreosModel::where(['id_users' => $request->id])->get();
            $users_facturas = SysUsersFacturacionModel::where(['id_users' => $request->id])->get();
          #debuger($users_facturas);
            $id_correos = [];
            $id_factura = [];
            if (count($users_correos) > 0) {
                foreach ($users_correos as $correos) {
                    $id_correos[] = $correos->id_correo;
                }
                for ($i = 0; $i < count($id_correos); $i++) {
                    SysCorreosModel::where(['id' => $id_correos[$i]])->delete();
                }
            }
            if (count($users_facturas) > 0) {
                foreach ($users_facturas as $facturas) {
                    $id_factura[] = $facturas->id_factura;
                }
                for ($i = 0; $i < count($id_factura); $i++) {
                    SysFacturacionModel::where(['id' => $id_factura[$i]])->delete();
                    SysParcialidadesFechasModel::where(['id_factura' => $id_factura[$i]])->delete();
                }
            }
            SysUsersPermisosModel::where(['id_users' => $request->id])->delete();
            SysRolMenuModel::where(['id_users' => $request->id])->delete();
            SysUsersFacturacionModel::where(['id_users' => $request->id])->delete();
            SysCategoriasCorreosModel::where(['id_users' => $request->id])->delete();
            SysUsersRolesModel::where(['id_users' => $request->id])->delete();
            SysUsersModel::where(['id' => $request->id])->delete();

            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            $success = false;
            $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
            DB::rollback();
        }

        if ($success) {
            return $this->_message_success(201, $success, self::$message_success);
        }
        return $this->show_error(6, $error, self::$message_error);
    }
    /**
     *Metodo para obtener los roles del usuario
     *@access public
     *@param $request [Description]
     *@return void
     */
    private static function _roles($request)
    {
        $roles = (isset($request)) ? $request : [];
        $html = "";
        if (count($roles) > 0) {
            foreach ($roles as $rol) {
                $html .= '<span class="label label-info">' . $rol->perfil . '</span> ';
            }
        }
        return $html;
    }
    /**
     *Metodo para obtener las empresas del usuario
     *@access public
     *@param $request [Description]
     *@return void
     */
    private static function _empresas($id_sucursal)
    {
        $where = ['id_sucursal' => $id_sucursal, 'estatus' => 1];
        $empresa = SysEmpresasSucursalesModel::select('id_empresa')->where($where)->get();
        return isset($empresa[0]->id_empresa) ? $empresa[0]->id_empresa : 0;
    }


}