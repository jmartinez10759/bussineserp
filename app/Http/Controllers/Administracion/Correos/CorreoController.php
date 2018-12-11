<?php

namespace App\Http\Controllers\Administracion\Correos;

use App\OverhaulinModel; #model de overhaulin
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Correos\SysCorreosModel;
use App\Model\Administracion\Correos\SysEnviadosModel;
use App\Model\Administracion\Correos\SysCategoriasModel;
use App\Model\Administracion\Configuracion\SysEstadosModel;
use App\Model\Administracion\Configuracion\SysUsersModel;
use App\Model\Administracion\Correos\SysUsersCorreosModel;
use App\Model\Administracion\Configuracion\SysRolMenuModel;
use App\Model\Administracion\Correos\SysCategoriasCorreosModel;

class CorreoController extends MasterController
{
    public function __construct(){
        parent::__construct();
    }
    /**
     *Metodo para obtener la vista y cargar los datos
     *@access public
     *@param Request $request [Description]
     *@return void
     */
     public function index(){
        $data = self::page_mail();
        return self::_load_view('administracion.correos.recibidos',$data);
     }
     /**
     *Metodo para obtener la vista y cargar los datos
     *@access public
     *@param Request $request [Description]
     *@return void
     */
     public function all( Request $request){

        try {
          $data = $this->consulta_emails();
          return $this->_message_success( 200, $data , self::$message_success );
        } catch (\Exception $e) {
              $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
              return $this->show_error(6, $error, self::$message_error );
        }

     }
    /**
     *Metodo para realizar la consulta por medio de su id
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function show( Request $request ){
        #$where = ['id' => Session::get('id')];
        $correo = [];
        $where = ['id' => $request->id];
        #actualizo los datos del usuarios
        $response = SysCorreosModel::with('categorias','usuarios')->where($where)->get();
        foreach ($response as $key => $value) {
          $correo = $value;
        }
        if($correo){
          SysCorreosModel::where($where)->update(['estatus_vistos'=>1]);
          return message(true,$correo,"¡Detalles del correo!");
        }
        return message(false,[],'Ocurrio un error, favor de verificar la informacion');

    }
    /**
     *Metodo para
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function store( Request $request ){
      #debuger( $request->all() );
      $error = null;
      DB::beginTransaction();
      try {
          $response_envios = SysUsersModel::with(['empresas','sucursales','roles'])
                                            ->where(['email' => $request->emisor])
                                            ->get();
          #debuger($response_envios);
          $data = [
            'correo'                => $request->emisor
            ,'asunto'               => $request->asunto
            ,'descripcion'          => $request->descripcion
            ,'estatus_enviados'     => 1
            ,'estatus_recibidos'    => 0
            ,'estatus_papelera'     => 0
            ,'estatus_vistos'       => 0
            ,'estatus_destacados'   => 0
            ,'estatus_borradores'   => 0
          ];
          #debuger($data);
          $correo = SysCorreosModel::create($data);
          $datos = [
               'id_users'       => Session::get('id')
              ,'id_rol'         => Session::get('id_rol')
              ,'id_empresa'     => Session::get('id_empresa')
              ,'id_sucursal'    => Session::get('id_sucursal')
              ,'id_correo'      => $correo->id
          ];
          #debuger($datos);
          SysUsersCorreosModel::create($datos);

          if ( isset($response_envios[0])  ) {

            $data['correo'] = Session::get('email');
            $data['estatus_enviados'] = 0;
            $data['estatus_recibidos'] = 1;
            #debuger($data);
            $store_response = SysCorreosModel::create($data);
            $datos['id_users']      = $response_envios[0]->id;
            $datos['id_rol']        = $response_envios[0]->roles[0]->id;
            $datos['id_empresa']    = isset($response_envios[0]->empresas[0])? $response_envios[0]->empresas[0]->id : 0 ;
            $datos['id_sucursal']   = isset($response_envios[0]->sucursales[0])? $response_envios[0]->sucursales[0]->id : 0;
            $datos['id_correo']     = $store_response->id;
            SysUsersCorreosModel::create($datos);

          }
          $envios = [
            'emisor'           =>  $request->emisor
            ,'email'           =>  Session::get('email')
            ,'asunto'          =>  $request->asunto
            ,'descripcion'     =>  $request->descripcion
            ,'nombre_completo' =>  Session::get('name')." ".Session::get('first_surname')." ".Session::get('second_surname')
          ];
            Mail::send('emails.usuario' , $envios, function( $message ) use ( $envios ) {
              $message->to( $envios['emisor'], '' )
                      ->from($envios['email'], $envios['nombre_completo'] )
                      ->subject( $envios['asunto'] );
            });

            DB::commit();
            $success = true;
          } catch (\Exception $e) {
              $success = false;
              $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
              DB::rollback();
          }

          if ($success) {
            return $this->_message_success( 201, $success , self::$message_success );
          }
          return $this->show_error(6, $error, self::$message_error );

    }
    /**
     *Metodo para la actualizacion de los registros
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function update( Request $request){
        #debuger($request->all());
        $error = null;
        DB::beginTransaction();
        try {
           SysCorreosModel::where(['id' => $request->id])->update($request->all());
           $response = SysCorreosModel::where(['id' => $request->id])->get();
        DB::commit();
        $success = true;
        } catch (\Exception $e) {
            $success = false;
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            DB::rollback();
        }

        if ($success) {
          return $this->_message_success( 201, $response , self::$message_success );
        }
        return $this->show_error(6, $error, self::$message_error );

    }
    /**
     *Metodo para borrar el registro
     *@access public
     *@param $id [Description]
     *@return void
     */
    public function destroy( Request $request ){
        debuger($request->all());

    }
    /**
     *Metodo para actualizar el estatus de destacado
     *@access public
     *@param Request $request [Description]
     *@return void
     */
     public function destacados( Request $request){

        $data = ['estatus_destacados' => $request->estatus_destacados];
        $where = ['id' => $request->id];
        $response = self::$_model::update_model($where, $data, new SysCorreosModel);
        if (count($response) > 0 ) {
            return message(true,$response,"Correo destacado correctamente");
        }
        return message(false,[],self::$message_error);

     }
     /**
      *Metodo que actualiza el estatus de papelera
      *@access public
      *@param Request $request [Description]
      *@return void
      */
      public function papelera( Request $request){
          #se realiza una transaccion
          $response = [];
          $error = null;
          DB::beginTransaction();
          try {

            for ($i=0; $i < count($request->matrix); $i++) {
                $matrix = explode('|',$request->matrix[$i]);
                $id_correo = $matrix[0];
                $estatus_papelera =  ($matrix[1])? 1 : 0;
                $response_correo = SysCorreosModel::where(['id' => $id_correo, 'estatus_papelera' => 1])->get();
                if( count($response_correo) > 0 ){
                  $response[] =self::$_model::delete_model(['id' => $id_correo], new SysCorreosModel);
                }else{
                  $response[] =self::$_model::update_model(['id' => $id_correo], ['estatus_papelera' => $estatus_papelera], new SysCorreosModel);
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
              #return redirect()->route('');
            return message(true,$response,"¡Los correos seleccionados pasaron a la papelera!");
          }
          return message( false, $error ,'¡Ocurrio un error, favor de verificar!');

      }





}
