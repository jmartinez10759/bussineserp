<?php

namespace App\Http\Controllers\Api;

use App\Model\MasterModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Administracion\Configuracion\SysUsersModel;

class TokenApiController extends MasterApiController
{

    private $_id = "id";
    /**
     *Se genera un constructor para inicializar todas sus propiedades de la clase padre
     *@access public
     */
    public function __construct(){
    	parent::__construct();
    	$this->_model = new SysUsersModel;
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request ){
        #se manda a llamar el metodo para hacer la validacion de los permisos.
        #return self::validate_permisson($this->_id,[],$request);
        switch ($_SERVER['REQUEST_METHOD']) {
          case 'GET':
              return $this->show_error(3);
            break;
            case 'POST':
               return $this->token( new Request( $request->all() ) );
              break;
              case 'PUT':
                return $this->update( new Request( $request->all() ) );
                break;
                case 'DELETE':
                  // code...
                  break;

        }

    }
    /**
     *Metodo para obtener todos los registros de los proyectos
     *@access public
     *@return json
     */
    public function all(){

        $response = ( $this->master::show_model([],[], $this->_model ) )? $this->_message_success(200, $this->master::show_model([],[], $this->_model ) ) :$this->show_error(4);
        return $response;

    }
    /**
     * Display the specified resource.
     *
     * @param  array  $datos [manda el email solicitado para obtener el token de ese usuario]
     * @return \Illuminate\Http\Response
     */
    public function token( Request $request ){
        #dd($request->email);
        $email = (isset( $request->email ) && $request->email != "")? $request->email : null;
        $token = (isset( $request->api_token ) && $request->api_token != "")? $request->api_token : null;
        $datos = [];
        if( $email == null && $token == null ){
           return $this->show_error(3);
        }
        if( $token != null ){
          $datos['api_token'] = $token;
        }
        $datos['email'] = $email;
        $datos['estatus'] = 1;
        $response = SysUsersModel::select('id','email','remember_token','api_token')->where( $datos )->get();
        if ( count($response) > 0 ) {
            #dd($response);
            return $this->_message_success(200,$response);
        }
          return $this->show_error(1);

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request ){

        $email = (isset( $request->email ) && $request->email != "")? $request->email : null;
        if( $email != null){
            $response_update = SysUsersModel::where(['email' => $email])->update(['api_token' => str_random(50)]);
            if($response_update){
              $response = SysUsersModel::select('id','email','remember_token','api_token')->where(['email'=> $email])->get();
              return $this->_message_success(202,$response);
            }
            return $this->show_error(3);
        }
        return $this->show_error(3);
        // if( isset( $request->data['email'] ) && $request->data['email'] != null ){
        //
        //     $where = ['email' => $request->data['email'] ];
        //     $response = MasterModel::update_model($where, ['api_token' => str_random(50)], $this->_model );
        //     if ( $response) {
        //         return $this->_message_success(202,$response);
        //     }
        //
        // }
        //
        // return $this->show_error(3);

    }

}
