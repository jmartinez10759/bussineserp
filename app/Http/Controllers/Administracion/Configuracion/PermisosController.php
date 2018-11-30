<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysMenuModel;
use App\Model\Administracion\Configuracion\SysRolesModel;
use App\Model\Administracion\Configuracion\SysUsersModel;
use App\Model\Administracion\Configuracion\SysRolMenuModel;
use App\Model\Administracion\Configuracion\SysEmpresasModel;
use App\Model\Administracion\Configuracion\SysAccionesModel;
use App\Model\Administracion\Configuracion\SysSucursalesModel;
use App\Model\Administracion\Configuracion\SysUsersPermisosModel;
use App\Model\Administracion\Configuracion\SysEmpresasSecursalesModel;

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
    *Metodo donde manda a llamar los permisos que tiene el usuario con respectoa todos sus filtros
    *@access public
    *@param Request $request
    *@return void
    */
    public static function permisos( Request $request ){

        $where = [
          'id_users'        => $request->id_users
          ,'id_rol'         => $request->id_rol
          ,'id_empresa'     => $request->id_empresa
          ,'id_sucursal'    => $request->id_sucursal
        ];
        $permisos = SysRolMenuModel::where( $where )->get();
        if( count($permisos) > 0){
          return message(true,$permisos,"¡Permisos del usuario!");
        }
          return message(false,$permisos,"¡No cuenta con permisos!");


    }
    /**
     *Metodo donde se crea manda a llamar los permisos que tiene el usuario con respecto al rol
     *@access public
     *@param Request $request
     *@return void
     */
     public static function permisos_actions( Request $request){

         $where = [
            'id_users'     => $request->id_users
            ,'id_rol'      => $request->id_rol
            ,'id_empresa'  => $request->id_empresa
            ,'id_sucursal' => $request->id_sucursal
            ,'id_menu'     => $request->id_menu
         ];
         #debuger($where);
         $acciones = SysUsersPermisosModel::where( $where )->get();
         return message(true,$acciones,"¡Acciones del usuario.!");

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
    *Metodo donde se crea manda  a llamar los permisos que tiene el usuario con respecto al rol
    *@access public
    *@param Request $request
    *@return void
    */
    public static function store_actions( Request $request ){
         #debuger($request->all());
          $matrix       = $request->matrix;
          $id_rol       = $request->id_rol;
          $id_users     = $request->id_users;
          $conteo       = $request->conteo;
          $id_menu      = $request->id_menu;
          $id_empresa   = ($request->id_empresa != "")?$request->id_empresa:0;
          $id_sucursal  = ($request->id_sucursal != "" )?$request->id_sucursal:0;
          #SE REALIZA LA CONSULTA PARA OBTENER EL id_permiso
          $count_acciones = count( SysAccionesModel::where(['estatus' => 1])->get() );
          if( $count_acciones == $conteo ){ $id_permiso = 7; }else{ $id_permiso = 5; }
          #se realiza una transaccion
          $error = null;
          DB::beginTransaction();
          try {

            for ($i=0; $i < count( $matrix ) ; $i++) {

                $matrices = explode( '|',$matrix[$i] );
                $where['id_accion']   = $matrices[0];
                $where['id_rol']      = $id_rol;
                $where['id_users']    = $id_users;
                $where['id_menu']     = $id_menu;
                $where['id_empresa']  = $id_empresa;
                $where['id_sucursal'] = $id_sucursal;
                $select = self::$_model::show_model([],$where, new SysUsersPermisosModel );
                #debuger($select);
                $data['estatus']      = ($matrices[1] === "true")? 1 : 0;
                $data['id_rol']       = $id_rol;
                $data['id_users']     = $id_users;
                $data['id_empresa']   = $id_empresa;
                $data['id_sucursal']  = $id_sucursal;
                $data['id_accion']    = $matrices[0];
                $data['id_menu']      = $id_menu;
                $data['id_permiso']   = $id_permiso;
                if( $select ){
                  $where = [
                    'id_rol'        => $id_rol
                    ,'id_users'     => $id_users
                    ,'id_menu'      => $id_menu
                    ,'id_empresa'   => $id_empresa
                    ,'id_sucursal'  => $id_sucursal
                    ,'id_accion'    => $matrices[0]
                  ];
                   $response[] = self::$_model::update_model( $where, $data, new SysUsersPermisosModel );
                }else{
                   $response[] = self::$_model::create_model( [$data], new SysUsersPermisosModel );
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
              #return redirect()->route('configuracion.permisos');
              return message(true,$response,"¡Se cambiaron las acciones con exito!");
          }
          return message( false, $error ,'¡Ocurrio un error, favor de verificar!');

    }


}
