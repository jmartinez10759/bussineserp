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
            #debuger(Session::all());
            $cmb_estatus = dropdown([
                'data'       => SysEstatusModel::wherein('id',[5,4,6])->get()
                ,'value'     => 'id'
                ,'text'      => 'nombre'
                ,'name'      => 'cmb_estatus'
                ,'class'     => 'form-control input-sm'
                ,'leyenda'   => 'Seleccione Opcion'
                ,'attr'      => 'data-live-search="true" '
                ,'event'     => 'filter_estatus()'
            ]);
            
            $cmb_estatus_form = dropdown([
                'data'       => SysEstatusModel::wherein('id',[5,4,6])->get()
                ,'value'     => 'id'
                ,'text'      => 'nombre'
                ,'name'      => 'cmb_estatus_form'
                ,'class'     => 'form-control input-sm'
                ,'leyenda'   => 'Seleccione Opcion'
                ,'attr'      => 'data-live-search="true" disabled'
                ,'selected'  => "6"
            ]);
            
            $cmb_estatus_form_edit = dropdown([
                'data'       => SysEstatusModel::wherein('id',[5,4,6])->get()
                ,'value'     => 'id'
                ,'text'      => 'nombre'
                ,'name'      => 'cmb_estatus_form_edit'
                ,'class'     => 'form-control input-sm'
                ,'leyenda'   => 'Seleccione Opcion'
                ,'attr'      => 'data-live-search="true" disabled'
                ,'selected'  => "6"
            ]);
            
             $cmb_formas_pago = dropdown([
                'data'       => SysFormasPagosModel::where(['estatus' => 1])->get()
                ,'value'     => 'id'
                ,'text'      => 'clave descripcion'
                ,'name'      => 'cmb_formas_pagos'
                ,'class'     => 'form-control input-sm'
                ,'leyenda'   => 'Seleccione Opcion'
                ,'attr'      => 'data-live-search="true" ' 
                ,'selected'  => "1"
            ]);
            
            $cmb_formas_pago_edit = dropdown([
                'data'       => SysFormasPagosModel::where(['estatus' => 1])->get()
                ,'value'     => 'id'
                ,'text'      => 'clave descripcion'
                ,'name'      => 'cmb_formas_pagos_edit'
                ,'class'     => 'form-control input-sm'
                ,'leyenda'   => 'Seleccione Opcion'
                ,'attr'      => 'data-live-search="true" ' 
                ,'selected'  => "1"
            ]);
            
             $cmb_metodos_pago = dropdown([
                'data'       => SysMetodosPagosModel::where(['estatus' => 1])->get()
                ,'value'     => 'id'
                ,'text'      => 'clave descripcion'
                ,'name'      => 'cmb_metodos_pagos'
                ,'class'     => 'form-control input-sm'
                ,'leyenda'   => 'Seleccione Opcion'
                ,'attr'      => 'data-live-search="true" '
                ,'selected'  => "1"
            ]);
            
            $cmb_metodos_pago_edit = dropdown([
                'data'       => SysMetodosPagosModel::where(['estatus' => 1])->get()
                ,'value'     => 'id'
                ,'text'      => 'clave descripcion'
                ,'name'      => 'cmb_metodos_pagos_edit'
                ,'class'     => 'form-control input-sm'
                ,'leyenda'   => 'Seleccione Opcion'
                ,'attr'      => 'data-live-search="true" '
                ,'selected'  => "1"
            ]);
            
            $cmb_monedas = dropdown([
                'data'       => SysMonedasModel::where(['estatus' => 1])->get()
                ,'value'     => 'id'
                ,'text'      => 'nombre descripcion'
                ,'name'      => 'cmb_monedas'
                ,'class'     => 'form-control input-sm'
                ,'leyenda'   => 'Seleccione Opcion'
                ,'attr'      => 'data-live-search="true" '
                ,'selected'  => "100"
            ]);
            
            $cmb_monedas_edit = dropdown([
                'data'       => SysMonedasModel::where(['estatus' => 1])->get()
                ,'value'     => 'id'
                ,'text'      => 'nombre descripcion'
                ,'name'      => 'cmb_monedas_edit'
                ,'class'     => 'form-control input-sm'
                ,'leyenda'   => 'Seleccione Opcion'
                ,'attr'      => 'data-live-search="true" '
                ,'selected'  => "100"
            ]);
            
             $cmb_clientes_edit = dropdown([
                'data'       => $this->_consulta( new SysClientesModel )
                ,'value'     => 'id'
                ,'text'      => 'nombre_comercial'
                ,'name'      => 'cmb_clientes_edit'
                ,'class'     => 'form-control input-sm'
                ,'leyenda'   => 'Seleccione Opcion'
                ,'attr'      => 'data-live-search="true" '
                ,'event'     => 'display_contactos()'
            ]);
            
            $cmb_clientes = dropdown([
                'data'       => $this->_consulta( new SysClientesModel )
                ,'value'     => 'id'
                ,'text'      => 'nombre_comercial'
                ,'name'      => 'cmb_clientes'
                ,'class'     => 'form-control input-sm'
                ,'leyenda'   => 'Seleccione Opcion'
                ,'attr'      => 'data-live-search="true" '
                ,'event'     => 'display_contactos()'
            ]);
            
            $cmb_productos = dropdown([
                'data'       => $this->_consulta( new SysProductosModel )
                ,'value'     => 'id'
                ,'text'      => 'codigo nombre'
                ,'name'      => 'cmb_productos'
                ,'class'     => 'form-control input-sm'
                ,'leyenda'   => 'Seleccione Opcion'
                ,'attr'      => 'data-live-search="true" '
                ,'event'     => 'display_productos()'
            ]);
            
            $cmb_productos_edit = dropdown([
                'data'       => $this->_consulta( new SysProductosModel )
                ,'value'     => 'id'
                ,'text'      => 'codigo nombre'
                ,'name'      => 'cmb_productos_edit'
                ,'class'     => 'form-control input-sm'
                ,'leyenda'   => 'Seleccione Opcion'
                ,'attr'      => 'data-live-search="true" '
                ,'event'     => 'display_productos_edit()'
            ]);
            
            $cmb_planes = dropdown([
                'data'       => $this->_consulta( new SysPlanesModel )
                ,'value'     => 'id'
                ,'text'      => 'codigo nombre'
                ,'name'      => 'cmb_planes'
                ,'class'     => 'form-control input-sm'
                ,'leyenda'   => 'Seleccione Opcion'
                ,'attr'      => 'data-live-search="true" '
                ,'event'     => 'display_planes()'
            ]);
            
            $cmb_planes_edit = dropdown([
                'data'       => $this->_consulta( new SysPlanesModel )
                ,'value'     => 'id'
                ,'text'      => 'codigo nombre'
                ,'name'      => 'cmb_planes_edit'
                ,'class'     => 'form-control input-sm'
                ,'leyenda'   => 'Seleccione Opcion'
                ,'attr'      => 'data-live-search="true" '
                ,'event'     => 'display_planes_edit()'
            ]);
            
            $data = [
                "page_title" 	        => "Ventas"
                ,"title"  		        => "Pedidos"
                ,"cmb_estatus"  		=> $cmb_estatus
                ,"cmb_estatus_form"     => $cmb_estatus_form
                ,"cmb_estatus_form_edit"=> $cmb_estatus_form_edit
                ,"formas_pagos"  		=> $cmb_formas_pago
                ,"formas_pagos_edit"    => $cmb_formas_pago_edit
                ,"metodos_pagos"  		=> $cmb_metodos_pago
                ,"metodos_pagos_edit"  	=> $cmb_metodos_pago_edit
                ,"monedas"  		    => $cmb_monedas
                ,"monedas_edit"  		=> $cmb_monedas_edit
                ,"clientes"  		    => $cmb_clientes
                ,"clientes_edit"  		=> $cmb_clientes_edit
                ,"productos"  		    => $cmb_productos
                ,"productos_edit"  		=> $cmb_productos_edit
                ,"planes"  		        => $cmb_planes
                ,"planes_edit"  		=> $cmb_planes_edit
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
                    $response = $this->_tabla_model::with(['clientes','contactos','usuarios','estatus'])->orderby('id','desc')->get();
                }
                if( Session::get('id_rol') == 3 ){
                    
                    $response = $data = SysEmpresasModel::with(['pedidos' => function($query){
                        return $query->with(['clientes','contactos','usuarios','estatus'])->groupby('id')->orderby('id','desc');
                    }])->where(['id' => Session::get('id_empresa')])->get();
                    $response = $data[0]->pedidos;

                }else if( Session::get('id_rol') != 3 && Session::get('id_rol') != 1){
                    $data = SysUsersModel::with(['pedidos' => function($query){
                        return $query->with(['clientes','contactos','usuarios','estatus'])->orderby('id','desc');
                    }])->where(['id' => Session::get('id')])->get();
                    $response = $data[0]->pedidos;
                }
                #debuger($response);
              return $this->_message_success( 201, $response , self::$message_success );
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
        public function store( Request $request){

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
                #debuger($request->all());
                if ( $request->pedidos['id'] == "" ) {
                    $response_pedido = $this->_tabla_model::create($data);
                }else{
                    $this->_tabla_model::where(['id' => $request->pedidos['id']])->update($request->pedidos);
                    $response_pedido = $this->_tabla_model::where(['id' => $request->pedidos['id']])->get()[0];
                }
                $response_conceptos = SysConceptosPedidosModel::create( $request->conceptos );
                $datos = [
                   'id_users'       => Session::get('id')
                  ,'id_rol'         => Session::get('id_rol')
                  ,'id_empresa'     => Session::get('id_empresa')
                  ,'id_sucursal'    => Session::get('id_sucursal')
                  ,'id_menu'        => 28
                  ,'id_pedido'      => $response_pedido->id
                  ,'id_concepto'    => $response_conceptos->id
                ];
                #debuger($datos);
                SysUsersPedidosModel::create($datos);

            DB::commit();
            $success = true;
            } catch (\Exception $e) {
            $success = false;
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            DB::rollback();
            }

            if ($success) {
            return $this->_message_success( 201, $response_pedido , self::$message_success );
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

    }