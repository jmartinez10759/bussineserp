<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysMenuModel;
use App\Model\Administracion\Configuracion\SysRolesModel;
use App\Model\Administracion\Configuracion\SysUsersModel;
use App\Model\Administracion\Configuracion\SysEmpresasModel;
use App\Model\Administracion\Configuracion\SysAccionesModel;
use App\Model\Administracion\Configuracion\SysSucursalesModel;
use App\Model\Administracion\Configuracion\SysUsersPermisosModel;
use App\Model\Administracion\Configuracion\SysEmpresasSecursalesModel;
use Psy\Util\Json;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PermisosController extends MasterController
{

    public function __construct(){
      parent::__construct();
    }
  /**
   *Metodo para pintar la vista y cargar la informacion principal del menu
   *@access public
   *@return void
   */
    public static function index(){

        $response = SysMenuModel::where(['estatus' => 1])->get();
        $response_acciones = SysAccionesModel::where(['estatus'=> 1])->orderBy('id','ASC')->get();
        $registros = [];
        $registros_acciones = [];

         foreach ($response as $respuesta) {
           $id['id'] = $respuesta->id;
           $checkbox = build_actions_icons($id,'id_permisos= "'.$respuesta->id.'" ');
           $checkbox_actions = build_acciones_usuario($id,'v-editar','','btn btn-primary '.$respuesta->id,'fa fa-users','title="Asignar Permisos"');
           $registros[] = [
              $respuesta->id
             ,$respuesta->texto
             ,$respuesta->id_padre
             ,$respuesta->tipo
             ,$checkbox
             ,$checkbox_actions
           ];
         }
         foreach ($response_acciones as $respuesta) {
           $id['id'] = 'actions_'.$respuesta->id;
           $checkbox_actions_permisos = build_actions_icons($id,'id_actions="'.$respuesta->id.'" ');
           $registros_acciones[] = [
              $respuesta->clave_corta
              ,$respuesta->descripcion
              ,$checkbox_actions_permisos
           ];

         }
         $titulos = ['id','Nombre Modulo','Id Padre','Tipo','Permisos','Acciones'];
         $titulos_acciones = ['Tipo Accion','Descripcion','Permiso'];
         $table = [ 'titulos' => $titulos ,'registros' => $registros ,'id'=> "datatable"];
         $table_acciones = [ 'titulos' => $titulos_acciones ,'registros' => $registros_acciones ,'id'=> "datatable_acciones"];

         $users = dropdown([
           'data'      => SysUsersModel::where(['estatus' => 1])->get()
           ,'value'     => 'id'
           ,'text'      => 'name'
           ,'name'      => 'cmb_users'
           ,'class'     => 'form-control'
           ,'leyenda'   => 'Seleccione Opcion'
           ,'event'     => 'v-change_usuario()'
           ,'attr'      => 'v-model="newKeep.id_users" '
         ]);

         #se crea el dropdown
          $roles = dropdown([
            'data'      => SysRolesModel::where(['estatus' => 1])->get()
            ,'value'     => 'id'
            ,'text'      => 'perfil'
            ,'name'      => 'cmb_roles'
            ,'class'     => 'form-control'
            ,'leyenda'   => 'Seleccione Opcion'
            ,'event'     => 'v-change_roles()'
            ,'attr'      => 'v-model="fillKeep.id_rol" disabled'
          ]);

         $data = [
            'page_title' 	      => "Configuración"
            ,'title'  		      => "Permisos"
            ,'subtitle' 	      => "Creacion de Permisos"
            ,'titulo_modal' 	  => "Asignacion de Acciones"
            ,'data_table'  	    =>  data_table($table)
            ,'data_table_acciones'=>  data_table($table_acciones)
            ,'select_roles'      =>  $roles
            ,'select_users'      =>  $users
            #,'select_empresas'   =>  $empresas
            #,'select_sucursales' =>  $sucursales

          ];
        #debuger($data);
        return self::_load_view( 'administracion.configuracion.permisos', $data );

       }


    /**
     * @param Request $request
     * @param SysUsersModel $users
     * @return JsonResponse
     */
    public function findMenuByUsers( Request $request, SysUsersModel $users )
    {
        try {
            if ( !$request->groupId || $request->groupId == 0 || $request->groupId == null){
                return new JsonResponse([
                    "success"   => false,
                    "data"      => "Groupid no tiene Informacion",
                    "message"   => self::$message_error
                ],Response::HTTP_BAD_REQUEST);
            }
            $user = $users->with('menus')->whereId($request->userId)->first();
            $permission = $user->menus()->where([
                'sys_rol_menu.estatus'      => true ,
                'sys_rol_menu.id_empresa'   => $request->companyId ,
                'sys_rol_menu.id_rol'       => $request->rolesId ,
                'sys_rol_menu.id_sucursal'  => $request->groupId
            ])->groupby('sys_rol_menu.id_menu')->get();

            return new JsonResponse([
                "success"   => true,
                "data"      => ["menusByUser" => $permission],
                "message"   => self::$message_success
            ],Response::HTTP_OK);

        } catch ( \Exception $error ) {
            $errors = $error->getMessage()." ".$error->getFile()." ".$error->getLine();
            return new JsonResponse([
                "success"   => false,
                "data"      => $errors,
                "message"   => self::$message_error
            ],Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * @param Request $request
     * @param SysUsersModel $users
     * @return JsonResponse
     */
    public function findActionsByMenu(Request $request, SysUsersModel $users )
    {

        try {
            $user = $users->with('acciones')->whereId($request->userId)->first();
            $actions = $user->acciones()->where([
                'sys_users_permisos.estatus'      => true ,
                'sys_users_permisos.id_empresa'   => $request->companyId ,
                'sys_users_permisos.id_rol'       => $request->rolesId ,
                'sys_users_permisos.id_sucursal'  => $request->groupId ,
                'sys_users_permisos.id_menu'      => $request->menuId
            ])->groupby('sys_users_permisos.id_accion')->orderby('id','DESC')->get();

            return new JsonResponse([
                "success"   => true ,
                "data"      => ["actionsByUser" => $actions] ,
                "message"   => self::$message_success
            ],Response::HTTP_OK);

        } catch ( \Exception $error ) {
            $errors = $error->getMessage()." ".$error->getFile()." ".$error->getLine();
            return new JsonResponse([
                "success"   => false,
                "data"      => $errors,
                "message"   => self::$message_error
            ],Response::HTTP_BAD_REQUEST);
        }
    }

  /**
   *Metodo donde se crea manda  a llamar los permisos que tiene el usuario con respecto al rol
   *@access public
   *@param Request $request
   *@return void
   */
   public function store( Request $request ){

      $matrix       = $request->matrix;
      $id_rol       = $request->id_rol;
      $id_users     = $request->id_users;
      $id_empresa   = ($request->id_empresa)? $request->id_empresa :0;
      $id_sucursal  = ($request->id_sucursal)? $request->id_sucursal:0;
      #se realiza una transaccion
      $error = null;
      DB::beginTransaction();
      try { 
        $where_delete = [
            'id_users'      => $id_users
            ,'id_rol'       => $id_rol
            ,'id_empresa'   => $id_empresa
            ,'id_sucursal'  => $id_sucursal
        ];
          SysRolMenuModel::where($where_delete)->delete();
        for ($i=0; $i < count( $matrix ) ; $i++) {

            $matrices = explode( '|',$matrix[$i] );
            $where['id_users']      = $id_users;
            $where['id_rol']        = $id_rol;
            $where['id_empresa']    = $id_empresa;
            $where['id_sucursal']   = $id_sucursal;
            $where['id_menu']       = $matrices[0];
            $select = self::$_model::show_model([],$where, new SysRolMenuModel );
            $data['estatus']      = ($matrices[1] === "true")? 1 : 0;
            $data['id_rol']       = $id_rol;
            $data['id_users']     = $id_users;
            $data['id_menu']      = $matrices[0];
            $data['id_empresa']   = $id_empresa;
            $data['id_sucursal']  = $id_sucursal;
            $condicion = [
              'id_users'     => $id_users
              ,'id_rol'       => $id_rol
              ,'id_empresa'   => $id_empresa
              ,'id_sucursal'  => $id_sucursal
              ,'id_menu'      => $matrices[0]];
            $data['id_permiso']   = (data_march(SysUsersPermisosModel::where($condicion)->get()) )? data_march(SysUsersPermisosModel::where($condicion)->get())[0]->id_permiso: 5;
            if( $select ){
              $where = [
                'id_users'      => $id_users
                ,'id_rol'       => $id_rol
                ,'id_empresa'   => $id_empresa
                ,'id_sucursal'  => $id_sucursal
                ,'id_menu'      => $matrices[0]
              ];
               $response[] = self::$_model::update_model( $where, $data, new SysRolMenuModel );
            }else{
               $response[] = SysRolMenuModel::create($data);
            }

        }

        DB::commit();
        $success = true;
      } catch (\Exception $e) {
          $success = false;
          $error = $e->getMessage();
          DB::rollback();
      }
       
       if ($success) {
            return $this->_message_success(201,$success, "¡Se cambiaron los Permisos con exito!" );
          }
          return $this->show_error(6,$error, self::$message_error );
   }

    /**
     * This method is for the creations of permission of actions
     * @access public
     * @param Request $request
     * @param SysUsersPermisosModel $userPermission
     * @return JsonResponse
     */
    public function createAction( Request $request, SysUsersPermisosModel $userPermission )
    {
          $error = null;
          DB::beginTransaction();
          try {
              $dataActions = [];
              foreach ($request->get('actions') as $key => $value){
                  if($key != 0 && $value != false && $value != NULL){
                      $dataActions[] = $key;
                  }
              }
            $userPermission->where([
                "id_empresa"    => $request->get('companyId') ,
                "id_rol"        => $request->get('rolesId'),
                "id_users"      => $request->get('userId'),
                "id_sucursal"   => $request->get('groupId'),
                "id_menu"       => $request->get('menuId')
            ])->delete();

            for ($i=0; $i < count($dataActions) ; $i++) {

                $dataRegister = [
                    "id_empresa"    => $request->get('companyId') ,
                    "id_rol"        => $request->get('rolesId') ,
                    "id_users"      => $request->get('userId') ,
                    "id_sucursal"   => $request->get('groupId'),
                    "id_menu"       => $request->get('menuId') ,
                    "id_accion"     => $dataActions[$i] ,
                    "id_permiso"    => 5 ,
                    "estatus"       => true
                ];
                $userPermission->create($dataRegister);
            }

            DB::commit();
            $success = true;
          } catch (\Exception $e) {
              $success = false;
              $error = $e->getMessage()." ".$e->getFile()." ".$e->getLine();
              DB::rollback();
          }

          if ($success) {
              return $this->findActionsByMenu( new Request($request->all()), new SysUsersModel );
              /*return new JsonResponse([
                  "success" => $success ,
                  "data" => $createActions,
                  "message" => self::$message_success
              ], Response::HTTP_OK);*/
          }
        return new JsonResponse([
            "success"   => $success ,
            "data"      => $error,
            "message"   => self::$message_error
        ], Response::HTTP_BAD_REQUEST);

    }


}
