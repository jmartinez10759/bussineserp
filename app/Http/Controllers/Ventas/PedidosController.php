<?php
    namespace App\Http\Controllers\Ventas;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use App\Model\Ventas\SysPedidosModel;
    use Illuminate\Support\Facades\Session;
    use App\Http\Controllers\MasterController;
    use App\Model\Ventas\SysUsersPedidosModel;
    use App\Model\Ventas\SysConceptosPedidosModel;
    use App\Model\Administracion\Configuracion\SysUsersModel;
    use App\Model\Administracion\Configuracion\SysEmpresasModel;
    use App\Model\Administracion\Configuracion\SysPlanesModel;
    use App\Model\Administracion\Configuracion\SysMonedasModel;
    use App\Model\Administracion\Configuracion\SysEstatusModel;
    use App\Model\Administracion\Configuracion\SysClientesModel;
    use App\Model\Administracion\Configuracion\SysFormasPagosModel;
    use App\Model\Administracion\Configuracion\SysMetodosPagosModel;
    use App\Model\Administracion\Configuracion\SysProductosModel;

    class PedidosController extends MasterController
    {
        #se crea las propiedades
        private $_tabla_model;

        public function __construct(){
            parent::__construct();
            $this->_tabla_model = new SysPedidosModel;
        }
        /**
        *Metodo para obtener la vista y cargar los datos
        *@access public
        *@param Request $request [Description]
        *@return void
        */
        public function index(){
            if (Session::get("permisos")["GET"]) {
                return view("errors.error");
            }
            $data = [
                "page_title" 	        => "Ventas"
                ,"title"  		        => "Pedidos"
                ,"iva"  		        => (Session::get('id_rol') != 1 )? Session::get('iva') : 16
            ];
            return self::_load_view( "ventas.pedidos",$data );
        }
        /**
         *Metodo para obtener los datos de manera asicronica.
         *@access public
         *@param Request $request [Description]
         *@return void
         */
        public function all( Request $request ){

            try {
                if( Session::get('id_rol') == 1 ){
                    $response = $this->_tabla_model::with(['clientes','contactos','usuarios','estatus','conceptos'=>function($query){
                        return $query->with(['productos','planes']);
                    }])->orderby('id','desc')->get();
                }
                if( Session::get('id_rol') == 3 ){
                    
                    $response = $data = SysEmpresasModel::with(['pedidos' => function($query){
                        return $query->with(['clientes','contactos','usuarios','estatus','conceptos'=>function($query){
                                                return $query->with(['productos','planes']);
                                            }])->groupby('id')->orderby('id','desc');
                    }])->where(['id' => Session::get('id_empresa')])->get();
                    $response = $data[0]->pedidos;

                }else if( Session::get('id_rol') != 3 && Session::get('id_rol') != 1){
                    $data = SysUsersModel::with(['pedidos' => function($query){
                        return $query->with(['clientes','contactos','usuarios','estatus','conceptos'=>function($query){
                                                return $query->with(['productos','planes']);
                                            }])->groupby('id')->orderby('id','desc');
                    }])->where(['id' => Session::get('id')])->get();
                    $response = $data[0]->pedidos;
                }
                $data = [
                    'response'          => $response
                    ,'estatus'          => SysEstatusModel::wherein('id',[5,4,6])->get()
                    ,'formas_pagos'     => SysFormasPagosModel::where(['estatus' => 1])->get()
                    ,'metodos_pagos'    => SysMetodosPagosModel::where(['estatus' => 1])->get()
                    ,'monedas'          => SysMonedasModel::where(['estatus' => 1])->get()
                    ,'clientes'         => $this->_catalogos_bussines( new SysClientesModel,[],['estatus' => 1],['id' => Session::get('id_empresa')] )
                    ,'productos'        =>  $this->_catalogos_bussines( new SysProductosModel,[],['estatus' => 1],['id' => Session::get('id_empresa')] )
                    ,'planes'           => $this->_catalogos_bussines( new SysPlanesModel, [],['estatus' => 1],['id' => Session::get('id_empresa')] )
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
                },'clientes','contactos'])->where(['id' => $request->id])->get();
                $subtotal  = $response[0]->conceptos->sum('total');
                $iva       = $subtotal * Session::get('iva') / 100;
                $total     = ($subtotal + $iva);
             $data = [
                'pedidos'   => $response[0]
                ,'subtotal' => format_currency($subtotal,2)
                ,'iva'      => format_currency($iva,2)
                ,'total'    => format_currency($total,2)
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
        *Metodo para
        *@access public
        *@param Request $request [Description]
        *@return void
        */
        public function store( Request $request ){
            #debuger($request->all());
            $error = null;
            DB::beginTransaction();
            try {
                #debuger($request->conceptos);
                $data = [];
                $key_value = ['id'];
                foreach ($request->pedidos as $key => $value) {
                    if( !in_array($key, $key_value)){
                        $data[$key] = strtoupper($value);
                    }
                }

                if ( !isset($request->pedidos['id']) ) {
                    $data['id_cotizacion'] = ( isset($request->pedidos['id_cotizacion']) )? $request->pedidos['id_cotizacion'] : 0;
                    $response_pedido = $this->_tabla_model::create($data);

                }if(isset($request->pedidos['id']) && $request->pedidos['id'] != null){
                    $this->_tabla_model::where(['id' => $request->pedidos['id']])->update($data);
                    $response_pedido = $this->_tabla_model::with(['conceptos'])->where(['id' => $request->pedidos['id']])->get()[0];
                }
                for ($i=0; $i < count($request->conceptos); $i++) {

                    $response_conceptos = SysConceptosPedidosModel::create( $request->conceptos[$i] );
                    $datos = [
                       'id_users'       => Session::get('id')
                      ,'id_rol'         => Session::get('id_rol')
                      ,'id_empresa'     => Session::get('id_empresa')
                      ,'id_sucursal'    => Session::get('id_sucursal')
                      ,'id_menu'        => 28
                      ,'id_pedido'      => $response_pedido->id
                      ,'id_concepto'    => $response_conceptos->id
                    ];
                    SysUsersPedidosModel::create($datos);
                    
                }

            DB::commit();
            $success = true;
            } catch (\Exception $e) {
            $success = false;
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            DB::rollback();
            }

            if ($success) {
                return $this->show(new Request(['id' => $response_pedido->id]));
            }
            return $this->show_error(6, $error, self::$message_error );


        }
        /**
        *Metodo para la actualizacion de los registros
        *@access public
        *@param Request $request [Description]
        *@return void
        */
        public function update( Request $request ){

            $error = null;
            DB::beginTransaction();
            try {
                $data = [];
                $key_value = ['id'];
                foreach ($request->pedidos as $key => $value) {
                    if( !in_array($key, $key_value)){
                        $data[$key] = strtoupper($value);
                    }
                } 
                $data['subtotal'] = str_replace(",", "", $data['subtotal']); 
                $data['iva']      = str_replace(",", "", $data['iva']);
                $data['total']    = str_replace(",", "", $data['total']);
                $this->_tabla_model::where(['id' => $request->pedidos['id']])->update($data);
                $response = $this->_tabla_model::where(['id' => $request->pedidos['id']])->get()[0];
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
                $conceptos =  SysUsersPedidosModel::where(['id_pedido' => $request->id])->get();
                for ($i=0; $i < count($conceptos); $i++) { 
                    SysConceptosPedidosModel::where(['id' => $conceptos[$i]->id_concepto])->delete();
                }
                SysUsersPedidosModel::where(['id_pedido' => $request->id])->delete();

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
        public function destroy_conceptos( Request $request ){

            $error = null;
            DB::beginTransaction();
            try {
                $response = SysConceptosPedidosModel::where(['id' => $request->id])->delete();
                SysUsersPedidosModel::where(['id_concepto' => $request->id])->delete();
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



    }