<?php

namespace App\Http\Controllers\Facturacion;

use PDF;
use TCPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysUsersModel;
use App\Model\Administracion\Configuracion\SysEstatusModel;
use App\Model\Administracion\Facturacion\SysConceptosModel;
use App\Model\Administracion\Configuracion\SysClientesModel;
use App\Model\Administracion\Facturacion\SysFacturacionModel;
use App\Model\Administracion\Configuracion\SysProductosModel;
use App\Model\Administracion\Configuracion\SysFormasPagosModel;
use App\Model\Administracion\Configuracion\SysMetodosPagosModel;
use App\Model\Administracion\Facturacion\SysUsersFacturacionModel;
use App\Model\Administracion\Facturacion\SysParcialidadesFechasModel;

class FacturacionController extends MasterController
{
    #se crea las propiedades
    private static $_tabla_model;

    public function __construct(){
        parent::__construct();
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

          $select_forma_pago = dropdown([
                'data'      => SysFormasPagosModel::where(['estatus' => 1])->get()
                ,'value'     => 'id'
                ,'text'      => 'clave descripcion'
                ,'name'      => 'cmb_forma_pago'
                ,'class'     => 'form-control'
                ,'leyenda'   => 'Seleccione Opción'
              ]);

          $select_forma_pago_edit = dropdown([
            'data'      => SysFormasPagosModel::where(['estatus' => 1])->get()
            ,'value'     => 'id'
            ,'text'      => 'clave descripcion'
            ,'name'      => 'cmb_forma_pago_edit'
            ,'class'     => 'form-control'
            ,'leyenda'   => 'Seleccione Opción'
          ]);

          $select_metodo_pago = dropdown([
            'data'      => SysMetodosPagosModel::where(['estatus' => 1])->get()
            ,'value'     => 'id'
            ,'text'      => 'clave descripcion'
            ,'name'      => 'cmb_metodo_pago'
            ,'class'     => 'form-control'
            ,'leyenda'   => 'Seleccione Opción'
            ,'event'    => 'v-select_metodo_pago()'
          ]);

          $select_metodo_pago_edit = dropdown([
            'data'      => SysMetodosPagosModel::where(['estatus' => 1])->get()
            ,'value'     => 'id'
            ,'text'      => 'clave descripcion'
            ,'name'      => 'cmb_metodo_pago_edit'
            ,'class'     => 'form-control'
            ,'leyenda'   => 'Seleccione Opción'
            ,'event'    => 'v-select_metodo_pago_edit()'
          ]);

          $data = [
                'page_title'                =>  "Facturación"
                ,'title'  	                =>  "Factura"
                ,'subtitle'                 =>  "Todas las Facturas"
                ,'select_forma_pago'        =>  $select_forma_pago
                ,'select_forma_pago_edit'   =>  $select_forma_pago_edit
                ,'select_metodo_pago'       =>  $select_metodo_pago
                ,'select_metodo_pago_edit'  =>  $select_metodo_pago_edit
                ,'agregar'                  => "modal_facturas"
                ,'buscador'                 => "table_general_facturas"
            ];

    	return self::_load_view('facturacion.facturacion',$data);

    }
    /**
     * Metodo para realizar la consulta general de los datos
     * @access public
     * @param Request $request [Description]
     * @return void
     */
     public static function all(){

        $total    = 0;
        $pago     = 0;
        $comision = 0;
        $filtros = ['ejecutivo' => [ Session::get('id') ]];
        $facturacion = self::reporte_general($filtros);
        foreach ($facturacion['cantidades'] as $ejecutivo) {
             $total       += $ejecutivo->total_general;
             $pago        += $ejecutivo->pago_general;
             $comision    += $ejecutivo->comision_general;
        }
        $data = [
          'total_facturas'    => $facturacion['request']
          ,'total_general'    => format_currency($total,2)
          ,'pago_general'     => format_currency($pago,2)
          ,'comision_general' => format_currency($comision,2)
          ,'select_estatus'   => SysEstatusModel::where(['estatus' => 1])->get()
        ];
        #ddebuger( $data );
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
            $response = SysFacturacionModel::with(['conceptos' => function( $query ){
              return $query->with(['productos' => function($querys){
                  return $querys->where(['estatus' => 1]);
              }]);
            },'clientes','formasPagos','metodoPagos','fechas'])->where(['id' => $request->id_factura])->get();
            #ddebuger($response->fechas);
            $subtotal  = $response[0]->conceptos->sum('total');
            $iva       = $subtotal * .16;
            $total     = ($subtotal * 1.16);
            $data = [
              'factura'   => $response
              ,'subtotal' => format_currency($subtotal,2)
              ,'iva'      => format_currency($iva,2)
              ,'total'    => format_currency($total,2)
            ];
            #ddebuger($data);
            return message(true, $data ,self::$message_success);

        } catch (\Exception $e) {
            $error = $e->getMessage();
            return message(false,$error,self::$message_error);
        }

    }
  /**
   * Metodo para
   * @access public
   * @param Request $request [Description]
   * @return void
   */
    public static function store( Request $request){

      try {

        $data = [
          'fecha'           => $request->facturas['fecha_factura']
          ,'total'          => isset($request->facturas['total'])?$request->facturas['total']:0
          ,'subTotal'       => isset($request->facturas['subtotal'])?$request->facturas['subtotal']:0
          ,'metodo_pago'    => isset($request->facturas['metodo_pago'])?$request->facturas['metodo_pago']:1
          ,'forma_pago'     => isset($request->facturas['forma_pago'])?$request->facturas['forma_pago']:1
          ,'rfc_receptor'   => isset($request->facturas['rfc_receptor'])?$request->facturas['rfc_receptor']:null
          ,'razon_social'   => isset($request->facturas['razon_social'])?$request->facturas['razon_social']:null
          ,'serie'          => explode('-',$request->facturas['factura'])[0]
          ,'folio'          => explode('-',$request->facturas['factura'])[1]
          ,'uuid'           => isset($request->facturas['uuid'])?$request->facturas['uuid']:null
          ,'fecha_pago'     => isset($request->facturas['fecha_pago'])?$request->facturas['fecha_pago']:null
          ,'pago'           => isset($request->facturas['pago'])?$request->facturas['pago']:null
          ,'descripcion'    => isset($request->facturas['descripcion'])?$request->facturas['descripcion']:null
          ,'comision'       => isset($request->facturas['comision'])?$request->facturas['comision']:null
          ,'archivo'        => isset($request->facturas['archivo'])?$request->facturas['archivo']:null
          ,'conceptos'      => [[
              'cantidad'   => isset($request->conceptos['cantidad'])?$request->conceptos['cantidad']:null
              ,'clave'     => isset($request->conceptos['codigo'])?$request->conceptos['codigo']:null
              ,'servicio'  => ""
              ,'nombre'    => isset($request->conceptos['descripcion'])?$request->conceptos['descripcion']:null
              ,'precio'    => isset($request->conceptos['precio'])?$request->conceptos['precio']:0
              ,'total'    =>  isset($request->conceptos['total'])?$request->conceptos['total']:0
            ]]
          ];
          #ddebuger($data);
          #se realiza una consulta para Verificar si existe un registro
          if( $request->facturas['id_factura'] == "" || $request->facturas['id_factura'] == null){
            $facturas = SysFacturacionModel::where(['serie' => $data['serie'], 'folio' => $data['folio']])->get();
            if( count($facturas) > 0){
              return message(false,$facturas,"No puedes realizar la acción, ya existe este registro");
            }else{
              $id_factura = self::_insert_info( $data );
            }


          }else{
            $data['id_factura'] = $request->facturas['id_factura'];
              #ddebuger($data);
              $id_factura = self::_insert_datos( $data );
          }
          return message($id_factura['success'],['id_factura' => $id_factura['result']],$id_factura['message']);

      } catch (\Exception $error) {

        return message(false ,$error->getMessage() , "Ocurrio un error, favor de verificar");

      }

    }
  /**
   * Metodo para la actualizacion de los registros
   * @access public
   * @param Request $request [Description]
   * @return void
   */
    public static function update( Request $request ){

          $data = [
              'fecha'           => isset($request->facturas['fecha_factura'])? $request->facturas['fecha_factura']:null
              ,'total'          => isset($request->facturas['total'])? $request->facturas['total']:null
              ,'subTotal'       => isset($request->facturas['subtotal'])? $request->facturas['subtotal']:null
              ,'metodo_pago'    => isset($request->facturas['metodo_pago'])?$request->facturas['metodo_pago']:1
              ,'forma_pago'     => isset($request->facturas['forma_pago'])?$request->facturas['forma_pago']:null
              ,'rfc_receptor'   => isset($request->facturas['rfc_receptor'])?$request->facturas['rfc_receptor']:null
              ,'razon_social'   => isset($request->facturas['razon_social'])?$request->facturas['razon_social']:null
              ,'serie'          => explode('-',$request->facturas['factura'])[0]
              ,'folio'          => explode('-',$request->facturas['factura'])[1]
              ,'uuid'           => isset($request->facturas['uuid'])?$request->facturas['uuid']:null
              ,'fecha_pago'     => isset($request->facturas['fecha_pago'])?$request->facturas['fecha_pago']:null
              ,'pago'           => isset($request->facturas['pago'])?$request->facturas['pago']:null
              ,'comision'       => isset($request->facturas['comision'])?$request->facturas['comision']:null
              ,'descripcion'    => isset($request->facturas['descripcion'])?$request->facturas['descripcion']:null
              ,'archivo'        => isset($request->facturas['archivo'])?$request->facturas['archivo']:null
          ];
          #ddebuger($data);
          $error = null;
          DB::beginTransaction();
          try {

            if( $request->facturas['id_factura'] != null){

              $cliente_select    = SysUsersFacturacionModel::select('id_cliente')->where(['id_factura' => $request->facturas['id_factura']])->groupBy('id_cliente')->get();
              $data_factura_update = [
                'fecha_factura'     => $data['fecha']
                ,'total'            => $data['total']
                ,'subTotal'         => $data['subTotal']
                ,'serie'            => $data['serie']
                ,'folio'            => $data['folio']
                ,'uuid'             => $data['uuid']
                #,'fecha_pago'       => $data['fecha_pago']
                ,'pago'             => $data['pago']
                ,'comision'         => $data['comision']
                ,'descripcion'      => $data['descripcion']
                ,'archivo'          => $data['archivo']
              ];
              $data_cliente_update = [
                'rfc_receptor'   => $data['rfc_receptor']
                ,'razon_social'  => $data['razon_social']
              ];
              $data_users_factura = [
                'id_forma_pago' => $data['forma_pago']
                ,'id_cliente'   => isset($cliente_select[0])?$cliente_select[0]->id_cliente: 0
              ];
              #ddebuger($cliente_select[0]);
              $facturas_update   = SysFacturacionModel::where(['id' => $request->facturas['id_factura']])->update($data_factura_update);
              $clientes_update   = SysClientesModel::where(['id' => $cliente_select[0]->id_cliente])->update($data_cliente_update);
              $factura_usuarios  = SysUsersFacturacionModel::where(['id_factura' => $request->facturas['id_factura'] ])->update($data_users_factura);
              SysParcialidadesFechasModel::where(['id_factura' => $request->facturas['id_factura'] ] )->delete();
              foreach ($data['fecha_pago'] as $fecha_pago) {
                  $data_fecha_pago = [
                    'id_factura'   => isset($request->facturas['id_factura'])?$request->facturas['id_factura']:0
                    ,'fecha_pago'   => $fecha_pago['fechas_parcialidades']
                    ,'estatus'      => 1
                  ];
                  SysParcialidadesFechasModel::create( $data_fecha_pago );
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
            return ['success' => $success,'result' => $facturas_update,'message' => self::$message_success ];
          }
          return ['success' => false, 'result' => $error, 'message' => self::$message_error ];


    }
  /**
   * Metodo para la actualizacion de los registros
   * @access public
   * @param Request $request [Description]
   * @return void
   */
   public static function actualizar( Request $request ){
        try {
          $data = [
            #,'fecha_pago'   => $request->fecha_pago
            'pago'          => $request->pago
            ,'comision'     => $request->comision
            ,'descripcion'  => $request->descripcion
            ,'archivo'      => $request->archivo
          ];
          #ddebuger($request->all());
          $factura_update = SysFacturacionModel::where(['id' => $request->id_factura])->update( $data );
          $delete_fechas_pago = SysParcialidadesFechasModel::where(['id_factura' => $request->id_factura])->delete();
          foreach ($request->fecha_pago as $fechas_pagos) {
              $data_fechas_pagos = [
                 'id_factura'   => $request->id_factura
                ,'fecha_pago'   => $fechas_pagos['fechas_parcialidades']
                ,'estatus'      => 1
              ];
              SysParcialidadesFechasModel::create( $data_fechas_pagos );
          }
          $factura = SysFacturacionModel::where(['id' => $request->id_factura])->get();
          return message(true, $factura, "Se actualizo correctamente el registro");
        } catch (\Exception $e) {
            return message(false, $e->getMessage(), "Se actualizo correctamente el registro");
        }


   }
   /**
    * Metodo para los filtros por fechas.
    * @access public
    * @param Request $request [Description]
    * @return void
    */
   public static function filtros( Request $request ){
      $error = null;
      try {
        $fecha_pago_inicio = ($request->fecha_pago_inicio)? $request->fecha_pago_inicio: "";
        $fecha_pago_final = ($request->fecha_final_pago)? $request->fecha_final_pago: "";

        $filtros = [
          'fecha_inicio' => $fecha_pago_inicio
          ,'fecha_final' => $fecha_pago_final
          ,'ejecutivo' => [Session::get('id')]
        ];
        $facturacion = self::reporte_general($filtros);
        $total    = 0;
        $pago     = 0;
        $comision = 0;
        foreach ($facturacion['cantidades'] as $ejecutivo) {
             $total       += $ejecutivo->total_general;
             $pago        += $ejecutivo->pago_general;
             $comision    += $ejecutivo->comision_general;
        }

        $data = [
          'total_facturas'    => $facturacion['request']
          ,'total_general'    => format_currency($total,2)
          ,'pago_general'     => format_currency($pago,2)
          ,'comision_general' => format_currency($comision,2)
          ,'select_estatus'   => SysEstatusModel::where(['estatus' => 1])->get()
        ];
         #dd($data['total_facturas']);
        return message(true, $data ,self::$message_success);


      } catch (\Exception $e) {
          $error = $e->getMessage();
          return message( false, $error ,self::$message_error );
      }

   }
   /**
    * Metodo para la actualizacion de los registros del estatus
    * @access public
    * @param Request $request [Description]
    * @return void
    */
    public static function update_estatus( Request $request){

        try {
          $data = [ 'id_estatus' => $request->id_estatus ];
          $factura_update = SysFacturacionModel::where(['id' => $request->id_factura])->update( $data );
          $factura = SysFacturacionModel::where(['id' => $request->id_factura])->get();
          return message(true, $factura, "Se actualizo correctamente el registro");
        } catch (\Exception $e) {
            return message(false, $e->getMessage(), "Ocurrio un error, favor de verificar");
        }

    }
  /**
   *Metodo para borrar el registro
   *@access public
   *@param Request $request [Description]
   *@return void
   */
   public static function destroy( Request $request ){

    $error = null;
    DB::beginTransaction();
    try {
        $select_factura = SysUsersFacturacionModel::select('id_concepto')->where(['id_factura' => $request->id_factura])->get();
        #ddebuger($select_factura);
        for ($i=0; $i < count($select_factura); $i++) {
            $where = [ 'id' => $select_factura[$i]->id_concepto ];
            SysConceptosModel::where( $where )->delete();
        }
        SysUsersFacturacionModel::where(['id_factura' => $request->id_factura])->delete();
        SysFacturacionModel::where(['id' => $request->id_factura])->delete();
        SysParcialidadesFechasModel::where(['id_factura' => $request->id_factura])->delete();

      DB::commit();
      $success = true;
    } catch (\Exception $e) {
        $success = false;
        $error = $e->getMessage()." ".$e->getLine();
        DB::rollback();
    }

    if ($success) {
      return message( true, $success, self::$message_success );
    }
    return message( false, $error, self::$message_error );

   }
  /**
   * Metodo para subir los archivos de xml y factura
   * @access public
   * @param Request $request [Description]
   * @return void
   */
   public static function upload( Request $request ){
        #ddebuger($request->all());
        $files = $request->file('file');
        try {
	        #$response_detalles = DetailCandidateModel::where([ 'id_users' => Session::get('id') ])->get();
	        for ($i=0; $i < count($files) ; $i++) {
	            $archivo      	= file_get_contents($files[$i]);
	            $name_temp    	= $files[$i]->getClientOriginalName();
	            $ext      		  = strtolower($files[$i]->getClientOriginalExtension());
              $type 			    = $files[$i]->getMimeType();
              $carpeta = ( $type == "text/xml" )? "xml/" : "comprobantes/";
	            #se manda a llamar para crear
	            #$dir = dirname( getcwd() );
              $dir  = public_path();
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
                 #ddebuger($factura);
	               #$data = $this->_xml->_valida_xsd( $factura, $path_xml );
                 #se realiza la inserccion de la factura
                 $response_factura = self::_insert_info( $factura );
                 unlink($ruta_file);
                 $data = ['id_factura' =>  $response_factura['result'] ];
                 $request = new Request($data);
                 if( $request->id_factura != null || $request->id_factura != "" ){
                   return self::show( $request );
                 }
	               return message(false,$response_factura['result'],$response_factura['message']);
	            }else{
                  return message(true,['ruta_file' => $ruta_update],"Se cargo correctamente el Archivo");
              }



	        }
        } catch (Exception $e) {
             echo $e->getMessage();
        }

    }
  /**
   * Se crea un metodo para generar un pdf con una platilla.
   * @access protected
   * @param $xml_path [Description]
   * @return onject []
   */
    public static function _download_pdf( Request $request ){

        $dir = public_path()."/upload/pdf";
        $name = "reporte";
        $ruta = $dir."/".$name.".pdf";
         PDF::SetTitle('Reporte');
         PDF::AddPage();
         #PDF::Write(0, $request->rfc);
         $ruta_plantilla = public_path().'/img/cv.jpg';
         PDF::Image($ruta_plantilla, 0, 4, 210, 297, '', '', '', false, 300, '', false, false, 0);
         PDF::SetFont('times','A',9);
         PDF::Cell(0, 0, "JORGE MARTINEZ QUEZADA", 0, 1, 'L', 0, '', 0);
         PDF::Cell(8);
         PDF::Cell(0, 5, "28", 0, 1, 'L', 0, '', 0);
         PDF::ln(11);
         PDF::Cell(0, 0, $request->rfc, 0, 1, 'C', 0, '', 0);
         PDF::Cell(0, 0, $request->rfc, 0, 1, 'C', 0, '', 0);
         PDF::Cell(0, 0, $request->rfc, 0, 1, 'C', 0, '', 0);
         PDF::ln(0);
         PDF::Cell(0, 0, $request->pago, 0, 1, 'C', 0, '', 1);
         PDF::Output($ruta, 'F');
         PDF::reset();
         return message(true,['ruta'=> "upload/pdf/".$name.".pdf"],self::$message_success);

    }
  /**
   * Metodo para la inserccion de los datos cuando se agrega un XML.
   * @access public
   * @param array $data [description]
   * @return void
   */
   public static function _insert_info( $data, $usuarios = [] ,$masiva = false  ){
     #se realiza una transaccion
     $error = null;
     DB::beginTransaction();
     try {
       #$facturas = SysFacturacionModel::where(['uuid' => $data['uuid']])->get();
       $facturas = SysFacturacionModel::where(['serie' => $data['serie'], 'folio' => $data['folio']])->get();
       if( count($facturas) > 0 ){
          return [ 'success' => false, 'result' => null,'message' => "Ya existe el registro que intenta ingresar" ];
       }
       #ddebuger($facturas);
       #se realiza consulta para clientes
       $clientes = SysClientesModel::where(['rfc_receptor' => $data['rfc_receptor']])->get();
       $data_cliente = [
         'rfc_receptor'      => $data['rfc_receptor']
         ,'calle'            => null
         ,'numero_exterior'  => null
         ,'colonia'          => null
         ,'municipio'        => null
         ,'cp'               => null
         ,'id_estado'        => 1
         ,'pais'             => null
         ,'correo'           => null
         ,'razon_social'     => $data['razon_social']
         ,'telefono'         => null
       ];
       if( count($clientes) < 1 ){
          $clientes = SysClientesModel::create($data_cliente);
       }
       #ddebuger($clientes);
       $data_factura = [
          #'id_cliente'          => isset($clientes->id)? $clientes->id : $clientes[0]->id
         'id_estatus'          => 1
         ,'fecha_factura'       => format_date_short( $data['fecha'] )
         ,'serie'               => $data['serie']
         ,'folio'               => $data['folio']
         ,'uuid'                => $data['uuid']
         ,'iva'                 => $data['subTotal'] * .16
         ,'subtotal'            => $data['subTotal']
         ,'total'               => $data['total']
         ,'pago'                => isset($data['pago'])? $data['pago']: 0
         ,'fecha_pago'          => isset($data['fecha_pago'])?:0
         ,'fecha_estimada'      => 0
         ,'descripcion'         => isset($data['descripcion'])? $data['descripcion'] :0
         ,'comision'            => isset($data['comision'])? $data['comision'] :0
         ,'archivo'             => isset($data['archivo'])? $data['archivo'] :0
       ];
       $factura = SysFacturacionModel::create( $data_factura );
       #se realiza la inserccion de los datos en la tabla de fechas.
       if( isset($data['fecha_pago']) ){

         SysParcialidadesFechasModel::where(['id_factura' => $factura->id ] )->delete();
         foreach ($data['fecha_pago'] as $fecha_pago) {
           $data_fecha_pago = [
             'id_factura'   => isset($factura->id)?$factura->id:0
             ,'fecha_pago'   => $fecha_pago['fechas_parcialidades']
             ,'estatus'      => 1
           ];
           SysParcialidadesFechasModel::create( $data_fecha_pago );

         }

       }

       for ($i=0; $i < count($data['conceptos']); $i++) {
            $where = [
              'clave_unidad' => isset($data['conceptos'][$i]['clave'])? $data['conceptos'][$i]['clave'] :"CLAVE"
              ,'descripcion' => isset($data['conceptos'][$i]['nombre'])? $data['conceptos'][$i]['nombre'] :"NOMBRE"
            ];
           $productos = SysProductosModel::where( $where )->get();
           $data_productos = [
             'id_categoria'               => 1
             ,'clave_producto_servicio'   => isset($data['conceptos'][$i]['servicio'])?$data['conceptos'][$i]['servicio']:0
             ,'clave_unidad'              => isset($data['conceptos'][$i]['clave'])? $data['conceptos'][$i]['clave'] :"CLAVE"
             ,'nombre'                    => isset($data['conceptos'][$i]['nombre'])? $data['conceptos'][$i]['nombre'] :"NOMBRE"
             ,'descripcion'               => ""
             ,'estatus'                   => 1
           ];
           if( count($productos) < 1){
              $productos = SysProductosModel::create($data_productos);
           }
           $data_conceptos = [
             #'id_factura'    =>   $factura->id
             'id_producto'    =>  $productos->id
             ,'cantidad'      =>  isset($data['conceptos'][$i]['cantidad'])?$data['conceptos'][$i]['cantidad'] :0
             ,'precio'        =>  isset($data['conceptos'][$i]['precio'])?$data['conceptos'][$i]['precio'] :0
             ,'total'         =>  isset($data['conceptos'][$i]['total'])?$data['conceptos'][$i]['total'] : $data['conceptos'][$i]['cantidad'] * $data['conceptos'][$i]['precio']
           ];
           #debuger( $data_conceptos );
           $conceptos[] = SysConceptosModel::create( $data_conceptos );

       }
       #ddebuger($clientes->id);
       for ($i=0; $i < count( $conceptos ); $i++) {
         $formas_pago = SysFormasPagosModel::where(['clave'  => $data['forma_pago'] ] )->orwhere(['id' => $data['forma_pago']])->get();
         $metodo_pago = SysMetodosPagosModel::where(['clave' => $data['metodo_pago'] ] )->orwhere(['id' => $data['metodo_pago']])->get();

         if( $masiva ){

           $data_relacion = [
             'id_users'         => isset($usuarios['id'])?$usuarios['id']:0
             ,'id_rol'          => isset($usuarios['id_rol'])?$usuarios['id_rol']:0
             ,'id_empresa'      => isset($usuarios['id_empresa'])?$usuarios['id_empresa']:0
             ,'id_sucursal'     => isset($usuarios['id_sucursal'])?$usuarios['id_sucursal']:0
             ,'id_cliente'      => isset($clientes->id)? $clientes->id : $clientes[0]->id
             ,'id_factura'      => isset($factura->id)?$factura->id:0
             ,'id_metodo_pago'  => isset($metodo_pago[0]->id)? $metodo_pago[0]->id: 1
             ,'id_concepto'     => isset( $conceptos[$i]->id )? $conceptos[$i]->id :0
           ];
           #debuger($data_relacion);
         }else{

           $data_relacion = [
             'id_users'         => Session::get('id')
             ,'id_rol'          => Session::get('id_rol')
             ,'id_empresa'      => Session::get('id_empresa')
             ,'id_sucursal'     => Session::get('id_sucursal')
             ,'id_cliente'      => isset($clientes->id)? $clientes->id : $clientes[0]->id
             ,'id_factura'      => isset($factura->id)?$factura->id:0
             ,'id_metodo_pago'  => isset($metodo_pago[0]->id)? $metodo_pago[0]->id: 1
             ,'id_concepto'     => isset( $conceptos[$i]->id )? $conceptos[$i]->id :0
           ];

         }

          for ($j=0; $j < count($formas_pago); $j++) {
            $data_relacion['id_forma_pago']   = $formas_pago[$j]->id;
            $response_rel[] = SysUsersFacturacionModel::create( $data_relacion );
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
       return ['success' => $success,'result' => $factura->id,'message' => self::$message_success ];
     }
     return ['success' => false, 'result' => $error, 'message' => self::$message_error ];

   }
 /**
  * Metodo para insertar datos por el usuario..
  * @access protected
  * @param array $request [description]
  * @return void
  */
  protected static function _insert_datos( $data ){
    #ddebuger($data);
    $error = null;
    DB::beginTransaction();
    try {

        $clientes = SysClientesModel::where(['rfc_receptor' => $data['rfc_receptor']])->get();
        $data_cliente = [
          'rfc_receptor'      => $data['rfc_receptor']
          ,'calle'            => null
          ,'numero_exterior'  => null
          ,'colonia'          => null
          ,'municipio'        => null
          ,'cp'               => null
          ,'id_estado'        => 1
          ,'pais'             => null
          ,'correo'           => null
          ,'razon_social'     => $data['razon_social']
          ,'telefono'         => null
        ];
        if( count($clientes) < 1 ){
           $clientes = SysClientesModel::create($data_cliente);
        }
        #ddebuger($data['conceptos']);
        for ($i=0; $i < count($data['conceptos']); $i++) {
             $where = [
               'clave_unidad' => isset($data['conceptos'][$i]['clave'])? $data['conceptos'][$i]['clave'] :"CLAVE"
               ,'descripcion' => isset($data['conceptos'][$i]['nombre'])? $data['conceptos'][$i]['nombre'] :"NOMBRE"
             ];
            $productos = SysProductosModel::where( $where )->get();
            $data_productos = [
              'id_categoria'               => 1
              ,'clave_producto_servicio'   => isset($data['conceptos'][$i]['servicio'])?$data['conceptos'][$i]['servicio']:0
              ,'clave_unidad'              => isset($data['conceptos'][$i]['clave'])? $data['conceptos'][$i]['clave'] :"CLAVE"
              ,'nombre'                    => isset($data['conceptos'][$i]['nombre'])? $data['conceptos'][$i]['nombre'] :"NOMBRE"
              ,'descripcion'               => ""
              ,'estatus'                   => 1
            ];
            if( count($productos) < 1){
               $productos = SysProductosModel::create($data_productos);
            }
            $data_conceptos = [
              'id_producto'    =>  $productos->id
              ,'cantidad'      =>  $data['conceptos'][$i]['cantidad']
              ,'precio'        =>  $data['conceptos'][$i]['precio']
              ,'total'         =>  $data['conceptos'][$i]['total']
            ];
            #ddebuger( $data_conceptos );
            $conceptos[] = SysConceptosModel::create( $data_conceptos );

        }
        #ddebuger($conceptos);
        if( isset($data['fecha_pago']) ){

            SysParcialidadesFechasModel::where( ['id_factura' => $data['id_factura'] ] )->delete();
            foreach ($data['fecha_pago'] as $fecha_pago) {
                $data_fecha_pago = [
                  'id_factura'   => isset($data['id_factura'])?$data['id_factura']:0
                  ,'fecha_pago'   => $fecha_pago['fechas_parcialidades']
                  ,'estatus'      => 1
                ];
                SysParcialidadesFechasModel::create( $data_fecha_pago );
            }
        }
        #dd($delete_fechas);
        for ($i=0; $i < count( $conceptos ); $i++) {
          $formas_pago = SysFormasPagosModel::where(['clave'  => $data['forma_pago'] ] )->orwhere(['id' => $data['forma_pago']])->get();
          $metodo_pago = SysMetodosPagosModel::where(['clave' => $data['metodo_pago'] ] )->orwhere(['id' => $data['metodo_pago']])->get();

          $data_relacion = [
            'id_users'         => Session::get('id')
            ,'id_rol'          => Session::get('id_rol')
            ,'id_empresa'      => Session::get('id_empresa')
            ,'id_sucursal'     => Session::get('id_sucursal')
            ,'id_cliente'      => isset($clientes->id)? $clientes->id : $clientes[0]->id
            ,'id_factura'      => $data['id_factura']
            ,'id_metodo_pago'  => isset($metodo_pago[0]->id)? $metodo_pago[0]->id: 1
            ,'id_concepto'     => $conceptos[$i]->id
          ];

           for ($j=0; $j < count($formas_pago); $j++) {
             $data_relacion['id_forma_pago']   = $formas_pago[$j]->id;
             $response_rel[] = SysUsersFacturacionModel::create( $data_relacion );
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
        return ['success' => $success,'result' => $data['id_factura'],'message' => self::$message_success ];
      }
      return ['success' => false, 'result' => $error, 'message' => self::$message_error ];

  }
  /**
   * Metodo para insertar datos de la factura.
   * @access protected
   * @param array $request [description]
   * @return void
   */
  protected static function _insert_factura( $data ){

     #se realiza una transaccion
     $error = null;
     DB::beginTransaction();
     try {
       #$facturas = SysFacturacionModel::where(['uuid' => $data['uuid']])->get();
       $facturas = SysFacturacionModel::where(['serie' => $data['serie'], 'folio' => $data['folio']])->get();
       if( count($facturas) > 0 ){
          return [ 'success' => false, 'result' => [],'message' => "Ya existe el registro que intenta ingresar" ];
       }
       #ddebuger($facturas);
       #se realiza consulta para clientes
       $clientes = SysClientesModel::where(['rfc_receptor' => $data['rfc_receptor']])->get();
       $data_cliente = [
         'rfc_receptor'      => $data['rfc_receptor']
         ,'calle'            => null
         ,'numero_exterior'  => null
         ,'colonia'          => null
         ,'municipio'        => null
         ,'cp'               => null
         ,'id_estado'        => 1
         ,'pais'             => null
         ,'correo'           => null
         ,'razon_social'     => $data['razon_social']
         ,'telefono'         => null
       ];
       if( count($clientes) < 1 ){
          $clientes = SysClientesModel::create($data_cliente);
       }
       #ddebuger($clientes);
       $data_factura = [
          'id_cliente'          => isset($clientes->id)? $clientes->id : $clientes[0]->id
         ,'id_estatus'          => 1
         ,'fecha_factura'       => format_date_short( $data['fecha'] )
         ,'serie'               => $data['serie']
         ,'folio'               => $data['folio']
         ,'uuid'                => $data['uuid']
         ,'iva'                 => $data['subTotal'] * .16
         ,'subtotal'            => $data['subTotal']
         ,'total'               => $data['total']
         ,'pago'                => 0
         ,'fecha_pago'          => 0
         ,'fecha_estimada'      => 0
       ];
       $factura = SysFacturacionModel::create( $data_factura );
       #ddebuger($factura);
       for ($i=0; $i < count($data['conceptos']); $i++) {
            $where = [
              'clave_unidad' => isset($data['conceptos'][$i]['clave'])? $data['conceptos'][$i]['clave'] :"CLAVE"
              ,'descripcion' => isset($data['conceptos'][$i]['nombre'])? $data['conceptos'][$i]['nombre'] :"NOMBRE"
            ];
           $productos = SysProductosModel::where( $where )->get();
           $data_productos = [
             'id_categoria'               => 1
             ,'clave_producto_servicio'   => isset($data['conceptos'][$i]['servicio'])?$data['conceptos'][$i]['servicio']:0
             ,'clave_unidad'              => isset($data['conceptos'][$i]['clave'])? $data['conceptos'][$i]['clave'] :"CLAVE"
             ,'nombre'                    => isset($data['conceptos'][$i]['nombre'])? $data['conceptos'][$i]['nombre'] :"NOMBRE"
             ,'descripcion'               => ""
             ,'estatus'                   => 1
           ];
           if( count($productos) < 1){
              $productos = SysProductosModel::create($data_productos);
           }
           $data_conceptos = [
             #'id_factura'    =>   $factura->id
             'id_producto'    =>  $productos->id
             ,'cantidad'      =>  $data['conceptos'][$i]['cantidad']
             ,'precio'        =>  $data['conceptos'][$i]['precio']
             ,'total'         =>  $data['conceptos'][$i]['total']
           ];
           #debuger( $data_conceptos );
           $conceptos[] = SysConceptosModel::create( $data_conceptos );

       }


       for ($i=0; $i < count( $conceptos ); $i++) {
         $formas_pago = SysFormasPagosModel::where(['clave'  => $data['forma_pago'] ] )->orwhere(['id' => $data['forma_pago']])->get();
         $metodo_pago = SysMetodosPagosModel::where(['clave' => $data['metodo_pago'] ] )->orwhere(['id' => $data['metodo_pago']])->get();

         $data_relacion = [
           'id_users'         => Session::get('id')
           ,'id_rol'          => Session::get('id_rol')
           ,'id_empresa'      => Session::get('id_empresa')
           ,'id_sucursal'     => Session::get('id_sucursal')
           ,'id_factura'      => $factura->id
           ,'id_metodo_pago'  => isset($metodo_pago[0]->id)? $metodo_pago[0]->id: 1
           ,'id_concepto'     => $conceptos[$i]->id
         ];

          for ($j=0; $j < count($formas_pago); $j++) {
            $data_relacion['id_forma_pago']   = $formas_pago[$j]->id;
            $response_rel[] = SysUsersFacturacionModel::create( $data_relacion );
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
       return ['success' => $success,'result' => $factura->id,'message' => self::$message_success ];
     }
     return ['success' => false, 'result' => $error, 'message' => self::$message_error ];


   }



}
