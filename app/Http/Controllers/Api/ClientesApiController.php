<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Api\MasterApiController;
use App\Model\Administracion\Configuracion\SysClientesModel;
use App\Model\Administracion\Configuracion\SysContactosModel;
use App\Model\Administracion\Configuracion\SysEmpresasSecursalesModel;

class ClientesApiController extends MasterApiController
{
  #se crea las propiedades
  private $_id = "id";

  public function __construct(){
      parent::__construct();
  }
  /**
   *Metodo para obtener la vista y cargar los datos
   *@access public
   *@param Request $request [Description]
   *@return void
   */
  public function index( Request $request ){
    return self::validate_permisson($this->_id,[],$request);
  }
  /**
   *Metodo para realizar la consulta por medio de su id
   *@access public
   *@param Request $request [Description]
   *@return void
   */
  public function show( Request $request ){
      //ddebuger($request->all());
      return $this->_message_success( 201,$request->all() );
  }
  /**
   *Metodo para
   *@access public
   *@param Request $request [Description]
   *@return void
   */
  public function store( Request $request ){
      
      $errors = [];
      if( emailValidate($request->correo) == 0){
        $errors[]['correo'] = $request->correo;
      }
      if( $request->razon_social == "" ){
        $errors[]['razon_social'] = $request->razon_social;
      }
      if( validarRFC( $request->rfc_receptor ) == 0){
        $errors[]['rfc'] = $request->rfc_receptor;
      }
      #debuger( $errors );
      if( count( $errors) > 0){
        return $this->show_error(6,$errors);
      }
      
        $error = null;
        DB::beginTransaction();
        try {
            
            $string_key_contactos = [ 'contacto','departamento','telefono', 'correo' ];
            $string_data_clientes = [];
            $string_data_contactos = [];
            foreach( $request->all() as $key => $value ){
                if( in_array( $key, $string_key_contactos) ){
                    if( $key == 'contacto' ){
                        $string_data_contactos['nombre_completo'] = strtoupper($value);
                    }else if( $key == 'correo'){
                        $string_data_contactos[$key] = strtolower( trim($value) );
                    }else{
                        $string_data_contactos[$key] = strtoupper($value);
                    }
                };
                if( !in_array( $key, $string_key_contactos) ){
                    if( !is_array($value)){
                        $string_data_clientes[$key] = strtoupper($value);
                    }
                };
            }
            #debuger($string_data_contactos,false);
            #debuger($string_data_clientes);
            $response = SysClientesModel::create( $string_data_clientes );
            $response_contactos = SysContactosModel::create($string_data_contactos);
            $data = [
                 'id_cuenta'        => 0
                ,'id_empresa'       => 0
                ,'id_sucursal'      => 0
                ,'id_contacto'      => $response_contactos->id
                ,'id_clientes'      => $response->id
                ,'id_proveedores'   => 0
                ,'estatus'          => 1
            ];

           SysEmpresasSecursalesModel::create($data);    
          /*$data = [];
          $keys_upper = ['rfc_receptor','razon_social'];
          $keys_lower = ['correo'];
          foreach( $request->all() as $key => $value ){
            if( in_array($key,$keys_upper)){
                $data[$key] = strtoupper($value);
            }else if(in_array($key,$keys_lower)){
                $data[$key] = strtolower(trim($value));
            }else{
              $data[$key] = $value;  
            }
          }
          $response = SysClientesModel::create( $data );
          if( !$response ){
            return $this->show_error(6, $response);
          }*/
          DB::commit();
          $success = true;
        } catch (\Exception $e) {
            $success = false;
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            DB::rollback();
        }

        if ($success) {
          return $this->_message_success( 201, $response );
        }
        return $this->show_error(6, $error);


  }
  /**
   *Metodo para la actualizacion de los registros
   *@access public
   *@param Request $request [Description]
   *@return void
   */
  public static function update( Request $request){


  }
  /**
   *Metodo para borrar el registro
   *@access public
   *@param Request $request [Description]
   *@return void
   */
  public static function destroy( Request $request ){


  }

}
