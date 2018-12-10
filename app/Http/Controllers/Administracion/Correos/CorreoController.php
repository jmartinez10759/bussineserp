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
      debuger( $request->all() );

      
      $error = null;
      DB::beginTransaction();
      try {
          
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




        #se realiza la consulta para obtener los datos del correo a enviar
        $insert_correo_rel = [];
        $datos_envio = SysUsersModel::where(['email' => $request->emisor ])->get();
        $response_envio = SysRolMenuModel::select('id_sucursal','id_empresa')
                                          ->where(['id_users' => isset($datos_envio[0]->id)?$datos_envio[0]->id: ""])
                                          ->groupby('id_sucursal','id_empresa')->get();
        #debuger($datos_envio);
        $envios = $request->all();
        $envios['nombre_completo'] = Session::get('name')." ".Session::get('first_surname')." ".Session::get('second_surname');
        $envios['email'] = Session::get('email');
        #se realiza una transaccion para nsertar en las dos tablas.
        $error = null;
        DB::beginTransaction();
        try {

            list($id_empresa_envia,$id_sucursal_envia)  = [Session::get('id_empresa'),Session::get('id_sucursal')];
            list($envia_enviados,$envia_recibidos) = [1,0];
            #estos son datos del que envia el correo.
            $data = [
              'id_users'        => Session::get('id')
              ,'nombre'         => isset($datos_envio[0])? $datos_envio[0]->name." ".$datos_envio[0]->first_surname : $request->emisor
              ,'correo'         => $request->emisor
              ,'asunto'         => $request->asunto
              ,'descripcion'    => $request->descripcion
              ,'estatus_papelera'     => 0
              ,'estatus_destacados'   => 0
              ,'estatus_borradores'   => 0
              ,'estatus_vistos'       => 1
            ];
            $data['estatus_enviados']   = 1;
            $data['estatus_recibidos']  = 0;
            $data['id_sucursal']  = $id_sucursal_envia;
            $data['id_empresa']   = $id_empresa_envia;
            $insert_email = SysCorreosModel::create($data);
            #debuger($insert_email,false);
            $id_correos = isset( $insert_email->id )?$insert_email->id: false;
            $datos = [
              'id_users'        => Session::get('id')
              ,'id_register'    => 0
              ,'id_sucursal'    => $id_sucursal_envia
              ,'id_empresa'     => $id_empresa_envia
              ,'id_categorias'  => 0
              ,'id_correo'      => $id_correos
            ];
            #debuger($datos);
            SysCategoriasCorreosModel::create($datos);
            if ( sizeof($response_envio) > 0 ) {
                  for ($i=0; $i < count( $response_envio ); $i++) {
                      list($id_empresa_recibe, $id_sucursal_recibe) = [$response_envio[$i]->id_empresa,$response_envio[$i]->id_sucursal];
                      list($recibe_enviados,$recibe_recibidos) = [0,1];
                      $data = [
                        'id_users'        => isset( $datos_envio[0]->id )? $datos_envio[0]->id: false
                        ,'nombre'         => $envios['nombre_completo']
                        ,'correo'         => Session::get('email')
                        ,'asunto'         => $request->asunto
                        ,'descripcion'    => $request->descripcion
                        ,'estatus_papelera'     => 0
                        ,'estatus_destacados'   => 0
                        ,'estatus_borradores'   => 0
                        ,'estatus_vistos'       => 0
                      ];

                      $data['estatus_enviados']   = $recibe_enviados;
                      $data['estatus_recibidos']  = $recibe_recibidos;
                      $data['id_sucursal']  = $id_sucursal_recibe;
                      $data['id_empresa']   = $id_empresa_recibe;
                      #debuger($data,false);
                      $insert_correo = SysCorreosModel::create($data);
                      #debuger($insert_correo->id);
                      $id_correo = isset( $insert_correo->id )?$insert_correo->id: false;
                      $datos = [
                        'id_users'        => isset( $datos_envio[0]->id )? $datos_envio[0]->id: false
                        ,'id_register'    => 0
                        ,'id_sucursal'    => $id_sucursal_recibe
                        ,'id_empresa'     => $id_empresa_recibe
                        ,'id_categorias'  => 0
                        ,'id_correo'      => $id_correo
                      ];
                      SysCategoriasCorreosModel::create($datos);

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
          #envio de correo para validar si existe el correo antes ingresado.
          Mail::send('emails.usuario' , $envios, function( $message ) use ( $envios ) {
            $message->to( $envios['emisor'], '' )
            ->from($envios['email'], $envios['nombre_completo'])
            ->subject($envios['asunto']);
              // if($envios['archivo']){
              //   $message->attach( $files );
              // }

          });
          #debuger($insert_correo);
          return message(true,[], self::$message_success );
          #return message(true,$response,"¡Se cambiaron los Permisos con exito!");
        }
        return message(false,$error, self::$message_error );


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
    public function destroy( $id ){


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
