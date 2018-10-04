<?php

namespace App\Http\Controllers\Facturacion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysEstatusModel;
use App\Model\Administracion\Configuracion\SysUsersModel;
use App\Model\Administracion\Configuracion\SysClientesModel;
use App\Http\Controllers\Facturacion\FacturacionController;
use App\Model\Administracion\Facturacion\SysParcialidadesFechasModel;

class CargaFacturaController extends MasterController
{
  #se crea las propiedades
  private static $_tabla_model;

  public function __construct(){
      parent::__construct();
      self::$_tabla_model = "";
  }
/**
 *Metodo para obtener la vista y cargar los datos
 *@access public
 *@param Request $request [Description]
 *@return void
 */
  public static function index(){

    if( Session::get('permisos')['GET'] ){
      return view('errors.error');
  	}
    $upload   = (isset(Session::get('permisos')['UPL']) && Session::get('permisos')['UPL'])? "style=display:none;" : "";
    $users    = SysUsersModel::with(['roles' => function($query){
      return $query->where(['sys_users_roles.id_rol' => 2]);
    }])->where('id','!=',Session::get('id'))->where(['estatus' => 1])->get();

    $ejecutivo = [];
    foreach ($users as $ejecutivos) {
        if( count($ejecutivos->roles) > 0){
            $ejecutivo[] = $ejecutivos;
        }
    }
    $select_ejecutivos = dropdown([
      'data'      => $ejecutivo
      ,'value'     => 'id'
      ,'text'      => 'name first_surname second_surname'
      ,'name'      => 'cmb_ejecutivos'
      ,'class'     => 'form-control'
      ,'leyenda'   => 'Seleccione Opción'
      ,'attr'      => 'multiple data-live-search="true"'
    ]);

    $data = [
      'page_title'          =>  "Facturación"
      ,'title'  	        =>  "Ejecutivos"
      ,'buscador'           =>  "table_ejecutivo"
      ,'upload'             =>  $upload
      ,'select_ejecutivos'  =>  $select_ejecutivos
    ];

    return self::_load_view('facturacion.ejecutivos',$data);

  }
/**
 * Metodo para realizar la consulta general de los datos
 * @access public
 * @param Request $request [Description]
 * @return void
 */
  public static function all(){
    
    $ejecutivos = self::reporte_general();
    $total    = 0;
    $pago     = 0;
    $comision = 0;
    foreach ($ejecutivos['cantidades'] as $ejecutivo) {
        $total    += $ejecutivo->total_general;
        $pago     += $ejecutivo->pago_general;
        $comision += $ejecutivo->comision_general;
    }
    $data = [
      'response'          => $ejecutivos['request']
      ,'total_general'    => format_currency($total,2)
      ,'pago_general'     => format_currency($pago,2)
      ,'comision_general' => format_currency($comision,2)
      #,'select_ejecutivos' =>  $select_ejecutivos
    ];
    #ddebuger($data);
    return message(true, $data ,self::$message_success);

 }
/**
 *Metodo para realizar la consulta por medio de su id
 *@access public
 *@param Request $request [Description]
 *@return void
 */
  public static function show( Request $request ){

  try {
    $response = SysUsersModel::with(['facturas' => function( $query ){
        return $query->with(['clientes','estatus' => function( $querys ){
          return $querys->where(['estatus' => 1]);
        }])->orderBy('fecha_factura','desc')->groupBy('sys_users_facturacion.id_factura','sys_users_facturacion.id_users');
      },'roles' => function($query){
        return $query->where(['id' => 2])->orwhere(['perfil' => "ventas"])->get();
      },'clientes' => function($query){
          return $query->with('facturas')->groupBy('id');
      } ])->where(['id'=> $request->id, 'estatus' => 1])->get();
      #ddebuger($response[0]->facturas);
      $data = [
          'total_clientes'    => $response[0]->clientes
          ,'total_facturas'    => $response[0]->facturas
          ,'select_estatus'   =>  SysEstatusModel::where(['estatus' => 1])->get()
      ];
      #ddebuger($data);
    return message(true,$data ,self::$message_success);

  } catch (\Exception $e) {
      return message(false,$e->getMessage(),self::$message_error);
  }


}
/**
 *Metodo para realizar la consulta por medio de su id
 *@access public
 *@param Request $request [Description]
 *@return void
 */
  public static function show_clientes( Request $request ){

      try {
        $clientes = SysClientesModel::with(['facturas' => function($query){
          return $query->with(['clientes','estatus' => function( $querys ){
            return $querys->where(['estatus' => 1]);
          }])->orderBy('fecha_factura','desc')->groupBy('sys_users_facturacion.id_factura','sys_users_facturacion.id_users');

        }])->where(['id'=> $request->id_cliente])->get();
        return message(true, $clientes[0], self::$message_success);

      } catch (\Exception $e) {

          return message(false,$e->getMessage(),"Ocurrio un Error, Favor de verificar");
      }

  }
/**
 *Metodo para
 *@access public
 *@param Request $request [Description]
 *@return void
 */
  public static function store( Request $request){


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
/**
 * Metodo para subir los archivos de xml masivamente
 * @access public
 * @param Request $request [Description]
 * @return void
 */
  public static function upload_masiva( Request $request ){
    #debuger($request->all());
    $files = $request->file('file');
    $response_users = SysUsersModel::with(['roles' => function( $query ){
           return $query->groupBy('sys_users_roles.id_users','sys_users_roles.id_rol');
        },'empresas' => function($query) {
           return $query->where(['sys_empresas.estatus' => 1 ])->groupBy('id_users','id','empresa');
       },'sucursales' => function($query){
          return $query->where(['sys_sucursales.estatus' => 1 ])->groupBy('id_users','id','sucursal');
      }])->where(['id' => $request->id_users ] )->get();
    $usuarios['id']            = $request->id_users;
    $usuarios['id_rol']        = isset($response_users[0]->roles[0]->id)?$response_users[0]->roles[0]->id:0;
    $usuarios['id_empresa']    = isset($response_users[0]->empresas[0]->id)?$response_users[0]->empresas[0]->id:0;
    $usuarios['id_sucursal']   = isset($response_users[0]->sucursales[0]->id)?$response_users[0]->sucursales[0]->id:0;
    $response_factura = [];

    try {
      for ($i=0; $i < count($files) ; $i++) {

          $archivo      	= file_get_contents($files[$i]);
          $name_temp    	= $files[$i]->getClientOriginalName();
          $ext      		  = strtolower($files[$i]->getClientOriginalExtension());
          $type 			    = $files[$i]->getMimeType();
          $carpeta = ( $type == "text/xml" )? "xml/" : "comprobantes/";
          #se manda a llamar para crear
          #$dir = dirname( getcwd() );
          $dir    = public_path();
          $folder = 'upload_file';
          $archivo        = $name_temp;
          $path           = $dir."/".$folder."/".$carpeta;
          $ruta_file      = $path.$archivo;
          $ruta_update    = $folder."/".$carpeta.$archivo;
          #ddebuger($ruta_file);
          File::makeDirectory($path, 0777, true, true);
          $files[$i]->move($path,$archivo);
          #ddebuger($type);
          if( $type == "text/xml" ){
             #se manda a llamar el metodo para retornar y validar el xml con su estructura definida
             $factura = self::_validateXml($ruta_file);
             #$data = $this->_xml->_valida_xsd( $factura, $path_xml );
             #se realiza la inserccion de la factura
             $response_factura[] = FacturacionController::_insert_info( $factura, $usuarios, true );
             #se elimina el archivo que se metio en la base de datos.
             unlink($ruta_file);
          }

      }
      #ddebuger($response_factura);
      return message(true,$response_factura,"Se cargo correctamente los archivos");

    } catch (Exception $e) {
        return message(false,$e->getMessage(),"Ocurrio un error, favor de verificar");
    }

}
/**
 * Metodo para subir los archivos de xml masivamente
 * @access public
 * @param Request $request [Description]
 * @return void
 */
  public static function filters( Request $request){

          $id_ejecutivo = isset($request->ejecutivo)? $request->ejecutivo : [];
          $fecha_inicio = isset($request->fecha_inicio)? $request->fecha_inicio : "";
          $fecha_final  = isset($request->fecha_final)? $request->fecha_final : "";
          $error = null;
          try {
              $filtros = [
                'ejecutivo'      => (count($id_ejecutivo) > 0 )? $id_ejecutivo: []
                ,'fecha_inicio'  => $fecha_inicio
                ,'fecha_final'   => $fecha_final
              ];  
              $filtros['estatus'] = 2;
              $response = self::reporte_general( $filtros );
              $total    = 0;
              $pago     = 0;
              $comision = 0;
              $usuarios = SysUsersModel::with(['roles' => function($query){
                return $query->where(['sys_roles.estatus' => 1, 'sys_roles.id' => 2 ])->get();
              }])->where(['estatus' => 1])->where('id','!=', Session::get('id'))->get();
              $users = [];
              foreach ($usuarios as $usuario ) {
                    if( count($usuario->roles) > 0){
                        $users[] = $usuario;
                    }
              }

              foreach ($response['cantidades'] as $ejecutivo) {
                   $total       += $ejecutivo->total_general;
                   $pago        += $ejecutivo->pago_general;
                   $comision    += $ejecutivo->comision_general;
              }

              $select_ejecutivos = dropdown([
                'data'      => $users
                ,'value'     => 'id'
                ,'text'      => 'name first_surname second_surname'
                ,'name'      => 'cmb_ejecutivos'
                ,'class'     => 'form-control'
                ,'leyenda'   => 'Seleccione Opción'
                ,'attr'      => "multiple"
              ]);
              $datos = [];
              $reporte = [];
              foreach ($response['request'] as $usuario) {
                  $datos[$usuario->id_usuario] = [];
              }
              foreach ($response['request'] as $reportes ) {
                $datos[$reportes->id_usuario][] = $reportes;
              }

              foreach ($datos as $key => $value) {
                  $reporte[] = $value;
              }
              #dd($reporte);
            $data = [
              'response'            => $response['request']
              ,'reportes'           => $reporte
              ,'total_general'      => format_currency($total,2)
              ,'pago_general'       => format_currency($pago,2)
              ,'comision_general'   => format_currency($comision,2)
              ,'select_ejecutivos'  =>  $select_ejecutivos
            ];
             #dd($data['total_facturas']);
            return message(true, $data ,self::$message_success);


          } catch (\Exception $e) {
              $error = $e->getMessage();
              return message( false, $error ,self::$message_error );
          }

  }


}
