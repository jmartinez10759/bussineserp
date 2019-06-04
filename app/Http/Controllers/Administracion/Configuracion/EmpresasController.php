<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysPaisModel;
use App\Model\Administracion\Configuracion\SysUsersModel;
use App\Model\Administracion\Configuracion\SysEstadosModel;
use App\Model\Administracion\Configuracion\SysEmpresasModel;
use App\Model\Administracion\Configuracion\SysContactosModel;
use App\Model\Administracion\Configuracion\SysSucursalesModel;
use App\Model\Administracion\Configuracion\SysTipoFactorModel;
use App\Model\Administracion\Configuracion\SysCodigoPostalModel;
use App\Model\Administracion\Configuracion\SysRegimenFiscalModel;
use App\Model\Administracion\Configuracion\SysContactosSistemasModel;
use App\Model\Administracion\Configuracion\SysClaveProdServicioModel;
use App\Model\Administracion\Configuracion\SysEmpresasSucursalesModel;
use App\Model\Administracion\Configuracion\SysServiciosComercialesModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EmpresasController extends MasterController
{
    #se crea las propiedades
    private $_tabla_model;

    public function __construct(){
        parent::__construct();
        $this->_tabla_model = new SysEmpresasModel;
    }
/**
 *Metodo para pintar la vista y cargar la informacion principal del menu
 *@access public
 *@return void
 */
  public function index(){

    if( Session::get('permisos')['GET'] ){
      return view('errors.error');
    }    
    $response_sucursales = SysSucursalesModel::where(['estatus' => 1 ])->groupby('id')->get();

   foreach ($response_sucursales as $respuesta) {
     $id['id'] = $respuesta->id;
     $checkbox = build_actions_icons($id,'id_sucursal= "'.$respuesta->id.'" ','check_sucursales');
     $registros_sucursales[] = [
        $respuesta->id
       ,$respuesta->codigo
       ,$respuesta->sucursal
       ,$checkbox
     ];
   }

   $titulos = [ 'id','Codigo','Sucursal',''];
   $table_sucursales = [
     'titulos'        => $titulos
     ,'registros'     => $registros_sucursales
     ,'id'            => "data_table_sucursales"
   ];


   $data = [
     'page_title'               =>  "Configuración"
     ,'title'                   =>  "Empresas"
     ,'data_table'              =>  "data_table(table)"
     ,'data_table_sucursales'   =>  data_table($table_sucursales)
   ];
    #debuger($data);
    return self::_load_view( 'administracion.configuracion.empresas', $data );
  
  }
  /**
  *Metodo para realizar la consulta por medio de su id
  *@access public
  *@param Request $request [Description]
  *@return void
  */
  public function all( Request $request ){    
   try {
        $response = ( Session::get('id_rol') == 1 )? 
        $this->_tabla_model::with(['contactos','comerciales:id,nombre','codigos:id,codigo_postal','regimenes:id,clave,descripcion'])->orderby('id','desc')->get()
        :$this->_consulta(new SysUsersModel,[],[],['id' => Session::get('id_empresa')],'empresas',['contactos','comerciales:id,nombre','codigos:id,codigo_postal','regimenes:id,clave,descripcion']);

        $data = [
          'response'                 => $response  
          ,'paises'                  => SysPaisModel::get()
          ,'servicio_comercial'      => SysServiciosComercialesModel::get()
          ,'regimen_fiscal'          => SysRegimenFiscalModel::get()
        ];

        return $this->_message_success( 200, $data , self::$message_success );
      } catch (\Exception $e) {
          $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
          return $this->show_error(6, $error, self::$message_error );
      }

  }
 /**
  *Metodo para
  *@access public
  *@param Request $request [Description]
  *@return void
  */
  public function store( Request $request){
       #debuger($request->all());
       $error = null;
          DB::beginTransaction();
          try {
              $string_key_contactos = [ 'contacto','departamento','telefono', 'correo' ];
              $string_data_empresa = [];
              $string_data_contactos = [];
              foreach( $request->all() as $key => $value ){
                  if( in_array( $key, $string_key_contactos) ){
                      if( $key == 'contacto' ){
                          $string_data_contactos['nombre_completo'] = strtoupper($value);
                      }else{
                          if($key != "correo"){
                            $string_data_contactos[$key] = strtoupper($value);
                          }else{
                            $string_data_contactos[$key] = $value;
                          }
                      }
                  };
                  if( !in_array( $key, $string_key_contactos) ){
                      if($key == "logo"){
                        $string_data_empresa[$key] = (trim($value));
                      }else{
                        $string_data_empresa[$key] = strtoupper($value);
                      }
                  };
                  
              }
             $response = $this->_tabla_model::create( $string_data_empresa );
             $response_contactos = SysContactosModel::create($string_data_contactos);
              $data = [
                  'id_empresa'      => $response->id
                  ,'id_contacto'    => $response_contactos->id
              ];
             SysContactosSistemasModel::create($data);   

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
  *Metodo para realizar la consulta por medio de su id
  *@access public
  *@param Request $request [Description]
  *@return void
  */
  public function show( Request $request ){

      try {
        $where = ['id' => $request->id];
        $response = SysEmpresasModel::with( ['contactos' => function($query){
            return $query->where(['sys_contactos.estatus' => 1])->get();
        },'sucursales' => function( $query ){
            return $query->where(['sys_empresas_sucursales.estatus' => 1])->groupby('id_sucursal')->get();
        },'clientes','comerciales:id,nombre','codigos:id,codigo_postal','regimenes:id,clave,descripcion'])
        ->where( $where )->groupby('id')->get();
        return $this->_message_success( 200, $response[0] , self::$message_success );
      } catch (\Exception $e) {
          $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
          return $this->show_error(6, $error, self::$message_error );
      }

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
              $string_key_contactos = [ 'contacto','departamento','telefono', 'correo' ];
              $string_key_empresas = [ 'contacto','departamento','telefono', 'correo','contactos' ];
              $string_data_empresa = [];
              $string_data_contactos = [];
              foreach( $request->all() as $key => $value ){
                  if( in_array( $key, $string_key_contactos) ){
                      if( $key == 'contacto' ){
                          $string_data_contactos['nombre_completo'] = strtoupper($value);
                      }else{
                          if($key != "correo"){
                            $string_data_contactos[$key] = strtoupper($value);
                          }else{
                            $string_data_contactos[$key] = strtolower($value);
                          }
                      }
                  };
                  if( !in_array( $key, $string_key_empresas) ){
                      if($key == "logo"){
                        $string_data_empresa[$key] = (trim($value));
                      }else{
                        $string_data_empresa[$key] = strtoupper($value);
                      }
                  };
                  
              }
           $this->_tabla_model::where(['id' => $request->id] )->update( $string_data_empresa );
          if( count($request->contactos) > 0){
             SysContactosModel::where(['id' => $request->contactos[0]['id'] ])->update($string_data_contactos);
          }else{
              $response_contactos = SysContactosModel::create($string_data_contactos);
              $data = [
                  'id_empresa'      => $request->id
                  ,'id_contacto'    => $response_contactos->id
              ];
             SysContactosSistemasModel::create($data);   
              
          }
          
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
  *Metodo para borrar el registro
  *@access public
  *@param $id [Description]
  *@return void
  */
  public function destroy(Request $request ){
      
      $error = null;
          DB::beginTransaction();
          try {  
              $response = SysEmpresasSucursalesModel::where(['id_empresa' => $request->id])->get(); 
              if( count($response) > 0){
                  for($i = 0; $i < count($response); $i++){
                      SysContactosModel::where(['id' => $response[$i]->id_contacto])->delete();
                  }
              }
              $this->_tabla_model::where(['id' => $request->id])->delete();
              SysEmpresasSucursalesModel::where(['id_empresa' => $request->id])->delete();
              SysContactosSistemasModel::where(['id_empresa' => $request->id])->delete();
          DB::commit();
          $success = true;
          } catch (\Exception $e) {
          $success = false;
          $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
          DB::rollback();
          }

          if ($success) {
          return $this->_message_success( 200, $response , self::$message_success );
          }
          return $this->show_error(6, $error, self::$message_error );

  }
 /**
  * Metodo para seleccionar si es que tiene mas de 1 empresa ese usuario.
  * @access public
  * @return void
  */
  public static function listCompanies()
  {
      $data['titulo'] = "LISTADO DE EMPRESAS";
      $data['titulo_sucusales'] = "LISTADO DE SUCURSALES";
      return view('administracion.configuracion.list_bussines',$data);
  }

  public static function load_empresa(){

        try {
          $response = SysUsersModel::with(['empresas' => function( $query ) {
            return $query->where(['sys_empresas.estatus' => 1])->groupBy('id_users','id','nombre_comercial');
          }])->where(['id' => Session::get('id')])->get();
          foreach ($response as $request ) {
            $empresas = $request->empresas;
          }
          return message(true,$empresas,self::$message_success);

        } catch (Exception $e) {
          return message(false,$e->getMessage(),self::$message_error);
        }
  
  }

    /**
     *Metodo obtener los datos de las sucursales de cada empresa..
     * @access public
     * @param Request $request [Description]
     * @return JsonResponse
     */
    public static function findRelGroups( Request $request )
  {
      $response = [];
        if(is_null($request->get('id_empresa'))){
            return new JsonResponse([
                "success"   => false
                ,"data"     => $response
                ,"message"  => "¡No se encontró ningún Grupo en esta Empresa!"
            ],Response::HTTP_BAD_REQUEST);
        }
      $companies = SysEmpresasModel::with(['sucursales'])->whereIn('id',$request->get("id_empresa"))->get();
        $i = 0;
      foreach ($companies as $company ){
          foreach ($company->sucursales as $groups){
              $response[$i]['groups']  = [
                  'id'            => $groups->id
                  ,'descripcion'  => $company->razon_social." - ".$groups->sucursal
              ];
              $i++;
          }
      }
      return new JsonResponse([
          "success"   => true
          ,"data"     => $response
          ,"message"  => "¡Se cargo correctamente las sucursales!"
      ],Response::HTTP_OK);

  }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function findByUserGroups(Request $request)
    {
      try {
          $users      = SysUsersModel::with('empresas')->whereId($request->userId)->first();
          $companies  = $users->empresas()->with('sucursales')->whereId($request->companyId)->first();
          $groups     = $companies->sucursales()->where(['sys_sucursales.estatus' => true])->get();
          return new JsonResponse([
              "success" => true ,
              "data"    => $groups ,
              "message" => self::$message_success
          ],Response::HTTP_OK);

      } catch ( \Exception $error ) {
          $errors = $error->getMessage()." ".$error->getFile()." ".$error->getLine();
          return new JsonResponse([
              "success" => false ,
              "data"    => $errors ,
              "message" => self::$message_error
          ],Response::HTTP_BAD_REQUEST);
      }
  }
  /**
   * Metodo para insertar los datos de la realcion de empresa sucursal
   * @access public
   * @param Request $request [description]
   * @return array [Description]
   */
  public function store_relacion( Request $request ){
      #se realiza una transaccion
      $response = [];
      $error = null;
      DB::beginTransaction();
      try {
          SysEmpresasSucursalesModel::where( ['id_empresa' => $request->id_empresa] )->delete();
          for ($i=0; $i < count($request->matrix ); $i++) {
              $matrices = explode('|',$request->matrix[$i] );
              $id_sucursal =  $matrices[0];
              $estatus     =  ($matrices[1] === "true")? 1 : 0;
              $data = [
                'id_empresa'    => $request->id_empresa
                ,'id_sucursal'  => $id_sucursal
              ];
              $data['estatus'] = $estatus;
              $response[] = SysEmpresasSucursalesModel::create( $data );

          }
        DB::commit();
        $success = true;
      } catch (\Exception $e) {
          $success = false;
          $error = $e->getMessage();
          DB::rollback();
      }
      if ($success) {
        return $this->_message_success( 200, $response , self::$message_success );
      }
      return $this->show_error(6, $error, self::$message_error );

  }




}
