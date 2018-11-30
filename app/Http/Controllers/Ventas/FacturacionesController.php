<?php
namespace App\Http\Controllers\Ventas;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Ventas\SysPedidosModel;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Ventas\SysFacturacionesModel;
use App\Model\Ventas\SysConceptosFacturacionesModel;
use App\Model\Ventas\SysUsersFacturacionesModel;
use App\Model\Administracion\Configuracion\SysUsersModel;
use App\Model\Administracion\Configuracion\SysPlanesModel;
use App\Model\Administracion\Configuracion\SysMonedasModel;
use App\Model\Administracion\Configuracion\SysEstatusModel;
use App\Model\Administracion\Configuracion\SysClientesModel;
use App\Model\Administracion\Configuracion\SysEmpresasModel;
use App\Model\Administracion\Configuracion\SysProductosModel;
use App\Model\Administracion\Configuracion\SysFormasPagosModel;
use App\Model\Administracion\Configuracion\SysMetodosPagosModel;
use App\Model\Administracion\Configuracion\SysTiposComprobantesModel;

class FacturacionesController extends MasterController
{
    #se crea las propiedades
    private $_tabla_model;

    public function __construct(){
        parent::__construct();
        $this->_tabla_model = new SysFacturacionesModel;
    }
    /**
    *Metodo para obtener la vista y cargar los datos
    *@access public
    *@param Request $request [Description]
    *@return void
    */
    public function index(){

        if( Session::get("permisos")["GET"] ){
          return view("errors.error");
        }
        
       if (Session::get("permisos")["GET"]) {
            return view("errors.error");
        }
        $data = [
            "page_title"   => "Ventas"
            ,"title"       => "Facturación"
            ,"iva"         => (Session::get('id_rol') != 1 )? Session::get('iva') : 16
        ];
        return self::_load_view( "ventas.facturaciones",$data );
    
    }
    /**
     *Metodo para obtener los datos de manera asicronica.
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function all( Request $request ){

        try {
            $response = $this->_consulta_facturas( $request );
            $data = [
                'response'          => $response
                ,'total_pedidos'    => count($response)
                ,'estatus'          => SysEstatusModel::wherein('id',[4,6,8])->get()
                ,'formas_pagos'     => SysFormasPagosModel::where(['estatus' => 1])->get()
                ,'metodos_pagos'    => SysMetodosPagosModel::where(['estatus' => 1])->get()
                ,'monedas'          => SysMonedasModel::where(['estatus' => 1])->get()
                ,'tipo_comprobante' => SysTiposComprobantesModel::where(['estatus' => 1])->get()
                ,'clientes'         => $this->_catalogos_bussines( new SysClientesModel,[],['estatus' => 1],['id' => Session::get('id_empresa')] )
                ,'productos'        =>  $this->_catalogos_bussines( new SysProductosModel,[],['estatus' => 1],['id' => Session::get('id_empresa')] )
                ,'planes'           => $this->_catalogos_bussines( new SysPlanesModel, [],['estatus' => 1],['id' => Session::get('id_empresa')] )
                ,'usuarios'         => $this->_catalogos_bussines( new SysUsersModel, [],['estatus' => 1],['id' => Session::get('id_empresa')] )
            ];
            #debuger($response);
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

        try {
             $response = $this->_tabla_model::with(['conceptos'=>function($query){
                    return $query->with(['productos','planes']);
                },'clientes','contactos','empresas' => function($query){
                    return $query->groupBy('id_facturacion');
                },'formaspagos','metodospagos','usuarios'])->where(['id' => $request->id])->get();
                $subtotal  = $response[0]->conceptos->sum('total');
                $iva       = $subtotal * Session::get('iva') / 100;
                $total     = ($subtotal + $iva);
             $data = [
                'request'    => $response[0]
                ,'subtotal'  => format_currency($subtotal,2)
                ,'iva'       => format_currency($iva,2)
                ,'total'     => format_currency($total,2)
                ,'subtotal_' => number_format($subtotal,2)
                ,'iva_'      => number_format($iva,2)
                ,'total_'    => number_format($total,2)
             ];
        return $this->_message_success( 200, $data , self::$message_success );
        } catch (\Exception $e) {
        $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
        return $this->show_error(6, $error, self::$message_error );
        }

    }
   /**
    *Metodo para insertar los datos de las facturas
    *@access public
    *@param Request $request [Description]
    *@return void
    */
    public function store( Request $request){
        #debuger($request->all());
        $error = null;
        DB::beginTransaction();
        try {
            #debuger($request->conceptos);
            $data = [];
            $key_value = ['id'];
            foreach ($request->factura as $key => $value) {
                if( !in_array($key, $key_value)){
                    $data[$key] = strtoupper($value);
                }
            }

            if ( !isset($request->factura['id']) ) {
                $data['id_pedidos'] = ( isset($request->factura['id_pedidos']) )? $request->factura['id_pedidos'] : 0;
                $data['serie']      = "A";
                $response_factura = $this->_tabla_model::create($data);
            }if(isset($request->factura['id']) && $request->factura['id'] != null){
                $this->_tabla_model::where(['id' => $request->factura['id']])->update($data);
                $response_factura = $this->_tabla_model::with(['conceptos'])->where(['id' => $request->factura['id']])->get()[0];
            }
            #debuger($response_factura);
            for ($i=0; $i < count($request->conceptos); $i++) {

                $response_conceptos = SysConceptosFacturacionesModel::create( $request->conceptos[$i] );
                $datos = [
                   'id_users'       => Session::get('id')
                  ,'id_rol'         => Session::get('id_rol')
                  ,'id_empresa'     => Session::get('id_empresa')
                  ,'id_sucursal'    => Session::get('id_sucursal')
                  ,'id_menu'        => 28
                  ,'id_facturacion' => $response_factura->id
                  ,'id_concepto'    => $response_conceptos->id
                ];
                SysUsersFacturacionesModel::create($datos);
                
            }

        DB::commit();
        $success = true;
        } catch (\Exception $e) {
        $success = false;
        $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
        DB::rollback();
        }

        if ($success) {
            return $this->show(new Request(['id' => $response_factura->id]));
        }
        return $this->show_error(6, $error, self::$message_error );

    }
    /**
    *Metodo para
    *@access public
    *@param Request $request [Description]
    *@return void
    */
    public function create( Request $request ){
        #debuger($request->all());
        $error = null;
        DB::beginTransaction();
        try {
            $response = $this->_tabla_model::with(['conceptos'])->where(['id_pedidos' => $request->id])->get();
            if( count($response) == 0 ){

                $data = [
                    'serie'                         => "A"
                    ,'descripcion'                  => $request->descripcion
                    ,'iva'                          => $request->iva
                    ,'subtotal'                     => $request->subtotal
                    ,'total'                        => $request->total
                    ,'id_pedidos'                   => $request->id
                    ,'id_cliente'                   => $request->id_cliente
                    ,'id_moneda'                    => $request->id_moneda
                    #,'id_tipo_comprobante'         => 1
                    ,'id_contacto'                  => $request->id_contacto
                    ,'id_forma_pago'                => $request->id_forma_pago
                    ,'id_metodo_pago'               => $request->id_metodo_pago
                    ,'id_estatus'                   => 6
                ];
                $facturacion = $this->_tabla_model::create($data);
                SysFacturacionesModel::where(['id' => $facturacion->id])->update(['folio' => $facturacion->id]);
                $pedidos_conceptos = SysPedidosModel::with(['conceptos'])->where(['id' => $request->id])->get();
                foreach ($pedidos_conceptos[0]->conceptos as $conceptos) {
                    $data_conceptos = [
                        'id_producto'   => ($conceptos->id_producto != null )? $conceptos->id_producto: null
                        ,'id_plan'      => ($conceptos->id_plan != null)? $conceptos->id_plan : null
                        ,'cantidad'     => $conceptos->cantidad
                        ,'precio'       => $conceptos->precio
                        ,'total'        => $conceptos->total
                    ];
                    $response_conceptos = SysConceptosFacturacionesModel::create( $data_conceptos );
                    $data_pivot = [
                        'id_users'              => Session::get('id')
                        ,'id_rol'               => Session::get('id_rol')
                        ,'id_empresa'           => Session::get('id_empresa')
                        ,'id_sucursal'          => Session::get('id_sucursal')
                        ,'id_menu'              => 28
                        ,'id_facturacion'       => $facturacion->id
                        ,'id_concepto'          => $response_conceptos->id
                    ];
                    SysUsersFacturacionesModel::create($data_pivot);
                }
                $response = SysFacturacionesModel::with(['conceptos'])->where(['id' => $facturacion->id ])->get();

            }

        DB::commit();
        $success = true;
        } catch (\Exception $e) {
        $success = false;
        $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
        DB::rollback();
        }

        if ($success) {
        return $this->_message_success( 201, $response[0] , self::$message_success );
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
            $data = [];
            $key_value = ['id'];
            foreach ($request->factura as $key => $value) {
                if( !in_array($key, $key_value)){
                    $data[$key] = strtoupper($value);
                }
            } 
            $data['subtotal'] = str_replace(",", "", $data['subtotal']); 
            $data['iva']      = str_replace(",", "", $data['iva']);
            $data['total']    = str_replace(",", "", $data['total']);
            $this->_tabla_model::where(['id' => $request->factura['id']])->update($data);
            #$response = $this->_tabla_model::where(['id' => $request->pedidos['id']])->get()[0];
        DB::commit();
        $success = true;
        } catch (\Exception $e) {
        $success = false;
        $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
        DB::rollback();
        }

        if ($success) {
            return $this->show(new Request(['id' => $request->factura['id']]));
            #return $this->_message_success( 201, $response , self::$message_success );
        }
            return $this->show_error(6, $error, self::$message_error );

    }
    /**
    * Metodo para borrar el registro
    * @access public
    * @param Request $request [Description]
    * @return void
    */
    public function destroy( Request $request ){

        $error = null;
        DB::beginTransaction();
        try {
            $response = $this->_tabla_model::where(['id' => $request->id])->delete();
            $conceptos =  SysUsersFacturacionesModel::where(['id_facturacion' => $request->id])->get();
            for ($i=0; $i < count($conceptos); $i++) { 
                SysConceptosFacturacionesModel::where(['id' => $conceptos[$i]->id_concepto])->delete();
            }
            SysUsersFacturacionesModel::where(['id_facturacion' => $request->id])->delete();
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
    * Metodo para borrar el registro de conceptos
    * @access public
    * @param Request $request [Description]
    * @return void
    */
    public function destroy_conceptos( Request $request ){

        $error = null;
        DB::beginTransaction();
        try {
            $response = SysConceptosFacturacionesModel::where(['id' => $request->id])->delete();
            SysUsersFacturacionesModel::where(['id_concepto' => $request->id])->delete();
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
    *Metodo para la actualizacion del estatus
    *@access public
    *@param Request $request [Description]
    *@return void
    */
    public function estatus( Request $request ){
        
        $error = null;
        DB::beginTransaction();
        try {
            $response = $this->_tabla_model::where(['id' => $request->id])->update(['id_estatus' => $request->id_estatus]);
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
    * Metodo para borrar el registro de conceptos
    * @access public
    * @param Request $request [Description]
    * @return void
    */
   private function _consulta_facturas( $request ){
        #debuger($request->all());
        if( Session::get('id_rol') == 1 ){

            $data = $this->_tabla_model::with([
                'clientes'
                ,'contactos'
                ,'usuarios' => function( $query ) use ($request){
                    if (isset($request->usuario)) {
                        $data = $query->where(['id' => $request->usuario ]);
                    }else{
                        $data = $query;
                    }
                    return $data->groupBy('id_facturacion')->get();
                }
                ,'estatus'
                ,'conceptos' =>function($query){
                    return $query->with(['productos','planes']);
                },'empresas' => function($query){
                    return $query->groupBy('id_facturacion');
                }]);
            if( isset( $request->mes ) && $request->mes != 13 ){
                $response = $data->whereMonth('created_at','=', $request->mes );
            }
            if( !isset( $request->mes ) ){
                $response = $data->whereMonth('created_at','=', date('m') );
            }

            if( !isset( $request->anio ) ){
                $response = $data->whereYear('created_at','=', date('Y') );
            }
            if( isset( $request->anio ) ){
                $response = $data->whereYear('created_at','=', $request->anio );
            }
            $response = $data->orderby('id','desc')->get();
            $datos = [];
            foreach ($response as $respuesta) {
                if ( count($respuesta->usuarios) > 0 ){
                    $datos[] = $respuesta;
                }
            }
            return $datos;

        }
        if( Session::get('id_rol') == 3 ){
            
            $data = SysEmpresasModel::with([
                'facturaciones' => function($query) use ( $request ){
                    $data = $query->with([
                        'clientes'
                        ,'contactos'
                        ,'usuarios'  => function($query) use ($request){
                            if (isset($request->usuario)) {
                                $data = $query->where(['id' => $request->usuario ]);
                            }else{
                                $data = $query;
                            }
                            return $data->groupBy('id_facturacion')->get();
                        }
                        ,'estatus'
                        ,'conceptos' =>function($query){
                            return $query->with(['productos','planes']);
                        },'empresas' => function($query){
                             return $query->where(['id' => Session::get('id_empresa')])->groupBy('id_facturacion');
                        }]);
                    if( isset( $request->mes ) && $request->mes != 13 ){
                        $response = $data->whereMonth('sys_facturaciones.created_at','=', $request->mes );
                    }
                    if( !isset( $request->mes ) ){
                        $response = $data->whereMonth('sys_facturaciones.created_at','=', date('m') );
                    }
                    if( !isset( $request->anio ) ){
                        $response = $data->whereYear('sys_facturaciones.created_at','=', date('Y') );
                    }
                    if( isset( $request->anio ) ){
                        $response = $data->whereYear('sys_facturaciones.created_at','=', $request->anio );
                    }
                    return $response->groupby('id')->orderby('id','desc')->get();
                }])
            ->where(['id' => Session::get('id_empresa')])
            ->get();
            $datos = [];
            foreach ($data[0]->facturaciones as $respuesta) {
                if ( count($respuesta->usuarios) > 0 ){
                    $datos[] = $respuesta;
                }
            }
            
            return $datos;
            #return $data[0]->pedidos;

        }else if( Session::get('id_rol') != 3 && Session::get('id_rol') != 1){

            $data = SysUsersModel::with([
                'facturaciones' => function($query) use ($request){
                    $data = $query->with([
                        'clientes'
                        ,'contactos'
                        ,'usuarios'  => function($query) use ($request){
                            return $query->groupBy('id_facturacion');
                        }
                        ,'estatus'
                        ,'conceptos' =>function($query){
                            return $query->with(['productos','planes']);
                        },'empresas' => function($query) {
                             return $query->where(['id' => Session::get('id_empresa')])->groupBy('id_facturacion');
                        }]);
                    if( isset( $request->mes ) && $request->mes != 13 ){
                        $response = $data->whereMonth('sys_facturaciones.created_at','=', $request->mes );
                    }
                    if( !isset( $request->mes ) ){
                        $response = $data->whereMonth('sys_facturaciones.created_at','=', date('m') );
                    }
                    if( !isset( $request->anio ) ){
                        $response = $data->whereYear('sys_facturaciones.created_at','=', date('Y') );
                    }
                    if( isset( $request->anio ) ){
                        $response = $data->whereYear('sys_facturaciones.created_at','=', $request->anio );
                    }
                    return $response->groupby('id')->orderby('id','desc')->get();
                }])
            ->where(['id' => Session::get('id')])
            ->get();
            $datos = [];
            foreach ($data[0]->facturaciones as $respuesta) {
                if ( count($respuesta->empresas) > 0 ){
                    $datos[] = $respuesta;
                }
            }
            return $datos;
        
        }
        
        
   }



}