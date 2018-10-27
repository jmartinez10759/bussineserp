<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysUsersModel;
use App\Model\Administracion\Configuracion\SysPerfilUsersModel;

class PerfilUsersController extends MasterController
{
    #se crea las propiedades
    private static $_tabla_model;

    public function __construct(){
        parent::__construct();
        self::$_tabla_model = "SysUsersModel";
    }
    /**
     *Metodo para obtener la vista y cargar los datos
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function index(){
        if( Session::get('permisos')['GET'] ){
          return view('errors.error');
        }

        $data['page_title'] = "Perfil";
        $data['title']      = "Detalles";
        $data['subtitle']   = "Detalles Usuarios";

        return self::_load_view('administracion.configuracion.perfil',$data );
    }
    /**
     *Metodo para realizar la consulta por medio de su id
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function show( Request $request ){

      #ddebuger($request->all());
      $where = [ 'id' => Session::get('id') ];
      $perfil = SysUsersModel::with('details','skills')->where($where)->get();
      $data = [];
      foreach ($perfil as $perfiles) {
        #debuger($perfiles);
        $data['name']          = $perfiles->name." ".$perfiles->first_surname." ".$perfiles->second_surname;
        $data['email']           = $perfiles->email;
        $data['puesto']          = isset($perfiles->details->puesto)? $perfiles->details->puesto : "";
        $data['experiencia']     = isset($perfiles->details->experiencia)? $perfiles->details->experiencia : "";
        $data['notas']           = isset($perfiles->details->notas)? $perfiles->details->notas : "";
        $data['direccion']       = isset($perfiles->details->direccion)? $perfiles->details->direccion : "";
        $data['genero']          = (isset($perfiles->details->genero) ) ? $perfiles->details->genero : "Masculino";
        $data['estado_civil']    = (isset($perfiles->details->estado_civil) ) ? $perfiles->details->estado_civil : "soltero";
        $data['telefono']        = (isset($perfiles->details->telefono)) ? $perfiles->details->telefono : "";
        $data['foto']            = (isset($perfiles->details->foto) && $perfiles->details->foto != "") ? $perfiles->details->foto : asset('img/profile/profile.png');
        $data['skills']          = $perfiles->skills;

      }
      $data['page_title'] = "Perfil";
      $data['title']      = "Detalles";
      $data['subtitle']   = "Detalles Usuarios";
      #ddebuger($data);
      return message(true,$data,"¡Se cargo correctamente los datos.!");

    }
    /**
     *Metodo para
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function store( Request $request ){

        $keys = ['foto','skills','page_title','title','subtitle','name','email','contraseña'];
        $keys_users = ['name','email','contraseña'];
        $data_details = [];
        $data_users = [];
        foreach ($request->all() as $key => $value) {
          if ( !in_array($key,$keys) ) {
              $data_details[$key] = $value;
          }
          if( in_array($key,$keys_users) ){
              if( $key == "name"){
                  $data_users = parse_name($value);
              }elseif($key == "contraseña"){
                $data_users['password'] = sha1($value);
              }else{
                $data_users[$key] = $value;
              }

          }
        }
        #dd($data_users);
        #se realiza una transaccion
        $error = null;
        DB::beginTransaction();
        try {

          SysUsersModel::where(['id' => Session::get('id')])->update($data_users);
          $where = ['id' => Session::get('id')];
          $perfil = SysUsersModel::with('details','skills')->where($where)->get();
          $details = [];
          foreach ($perfil as $detalles) {
                  $data_details['id_users'] = Session::get('id');
              if($detalles->details == null ){
                  #debuger($data);
                  $details = SysPerfilUsersModel::create( $data_details );
              }else{
                  $details = SysPerfilUsersModel::where(['id_users' => Session::get('id')])->update($data_details);
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
            return message(true,$details,"¡Usuario Actualizado correctamente!");
        }
        return message( false, $error ,'¡Ocurrio un error, favor de verificar!');

    }
    /**
     *Metodo para la actualizacion de los registros
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function update( Request $request){


    }
    /**
     *Metodo para borrar el registro
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function destroy( Request $request ){


    }
    /**
     *Metodo subir imagen e insertarlo en la base de datos
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function upload( Request $request ){
        #metodo que convierte el archivo en cadena para poder insertarlo a la base de datos.
        $file = self::upload_file($request,true);
        $where = ['id' => Session::get('id')];
        $perfil = SysUsersModel::with('details','skills')->where($where)->get();
        $details = [];
        foreach ($perfil as $detalles) {
                $data['id_users'] = Session::get('id');
                $data['foto'] = $file['file'][0];
                #debuger(base64_decode($data['foto'][1]) );
            if($detalles->details == null ){
                #debuger($data);
                $details = SysPerfilUsersModel::create( $data );
            }else{
                $details = SysPerfilUsersModel::where(['id_users' => Session::get('id')])->update($data);
            }
        }

        return message(true,$details, "Se cargo correctamente la imagen");


    }



}
