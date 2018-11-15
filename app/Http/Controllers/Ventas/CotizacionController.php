<?php
    namespace App\Http\Controllers\Ventas;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Session;
    use App\Http\Controllers\MasterController;
    use App\Model\Ventas\SysCotizacionModel;
    use App\Model\Ventas\SysConceptosCotizacionesModel;
    use App\Model\Ventas\SysUsersCotizacionesModel;
    use App\Model\Administracion\Configuracion\SysClientesModel;
    use App\Model\Administracion\Configuracion\SysUsersModel;
    use App\Model\Administracion\Configuracion\SysContactosModel;
    use App\Model\Administracion\Configuracion\SysFormasPagosModel;
    use App\Model\Administracion\Configuracion\SysMetodosPagosModel;
    use App\Model\Administracion\Configuracion\SysMonedasModel;
    use App\Model\Administracion\Configuracion\SysProductosModel;
    use App\Model\Administracion\Configuracion\SysPlanesModel;
    use App\Model\Administracion\Configuracion\SysEstatusModel;
    use App\Model\Ventas\SysPedidosModel;
    use App\Model\Ventas\SysUsersPedidosModel;
    use App\Model\Ventas\SysConceptosPedidosModel;
    use Illuminate\Support\Facades\Mail;
    use PDF;



    class CotizacionController extends MasterController
    {
        #se crea las propiedades
        private $_tabla_model;

        public function __construct(){
            parent::__construct();
            $this->_tabla_model = new SysCotizacionModel;
        }
        /**
        *Metodo para obtener la vista y cargar los datos
        *@access public
        *@param Request $request [Description]
        *@return void
        */
        public function index(){
            #debuger(session::all());
            $users    = SysUsersModel::with(['roles' => function($query){
                            return $query->where(['sys_users_roles.id_rol' => 2]);
                        },"empresas"])->where('id','=',Session::get('id'))->where(['estatus' => 1])->get();
            #debuger($users);
            $clientes = dropdown([
                 'data'       => $this->_consulta(new SysClientesModel)
                 ,'value'     => 'id'
                 ,'text'      => 'razon_social'
                 ,'name'      => 'cmb_clientes'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opción'
                 ,'attr'      => 'data-live-search="true" '
                 ,'event'     => 'display_contactos()'                
           ]);

            $formas_pagos = dropdown([
                 'data'       => SysFormasPagosModel::where(['estatus' => 1 ])->orderby('descripcion', 'asc')->get()
                 ,'value'     => 'id'
                 ,'text'      => 'descripcion'
                 ,'name'      => 'cmb_formas_pagos'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opción'
                 ,'attr'      => 'data-live-search="true" '              
           ]);

            $metodos_pagos = dropdown([
                 'data'       => SysMetodosPagosModel::where(['estatus' => 1 ])->orderby('id', 'desc')->get()
                 ,'value'     => 'id'
                 ,'text'      => 'descripcion'
                 ,'name'      => 'cmb_metodos_pagos'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opción'
                 ,'attr'      => 'data-live-search="true" '               
           ]); 

            $monedas = dropdown([
                 'data'       => SysMonedasModel::where(['estatus' => 1 ])->whereIn('id',['100','101','150','149'])->orderby('descripcion', 'asc')->get()
                 ,'value'     => 'id'
                 ,'text'      => 'nombre descripcion'
                 ,'name'      => 'cmb_monedas'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opción'
                 ,'attr'      => 'data-live-search="true" '                
           ]);

            $productos = dropdown([
                 'data'       => $this->_consulta(new SysProductosModel)
                 ,'value'     => 'id'
                 ,'text'      => 'nombre'
                 ,'name'      => 'cmb_productos'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opción'
                 ,'attr'      => 'data-live-search="true" '   
                 ,'event'     => 'display_productos()'               
           ]);

            $planes = dropdown([
                 'data'       => $this->_consulta(new SysPlanesModel) 
                 ,'value'     => 'id'
                 ,'text'      => 'nombre'
                 ,'name'      => 'cmb_planes'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opción'
                 ,'attr'      => 'data-live-search="true" '   
                 ,'event'     => 'display_planes()'               
           ]);
            /*where(['estatus' => 1 ])->whereIn('id',['94','95','96','97'])->orderby('descripcion', 'asc')->get()*/
            $estatus = dropdown([
                 'data'       => SysEstatusModel::where(['estatus' => 1 ])->orderby('nombre', 'asc')->get()
                 ,'value'     => 'id'
                 ,'text'      => 'nombre'
                 ,'name'      => 'cmb_estatus'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opción'
                 ,'attr'      => 'data-live-search="true" '                
           ]);

            $estatus_inicio = dropdown([
                 'data'       => SysEstatusModel::where(['estatus' => 1 ])->orderby('nombre', 'asc')->get()
                 ,'value'     => 'id'
                 ,'text'      => 'nombre'
                 ,'name'      => 'cmb_estatus_inicio'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opción'
                 ,'attr'      => 'data-live-search="true" ' 
                 ,'event'     => 'display_estatus_select()'               
           ]);

            /* Editar*/
            $clientes_edit = dropdown([
                 'data'       => $this->_consulta(new SysClientesModel)
                 ,'value'     => 'id'
                 ,'text'      => 'razon_social rfc_receptor'
                 ,'name'      => 'cmb_clientes_edit'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opción'
                 ,'attr'      => 'data-live-search="true" '
                 ,'event'     => 'display_contactos_edit()'                
           ]);

            $formas_pagos_edit = dropdown([
                 'data'       => SysFormasPagosModel::where(['estatus' => 1 ])->orderby('descripcion', 'asc')->get()
                 ,'value'     => 'id'
                 ,'text'      => 'descripcion'
                 ,'name'      => 'cmb_formas_pagos_edit'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opción'
                 ,'attr'      => 'data-live-search="true" '              
           ]);

            $metodos_pagos_edit = dropdown([
                 'data'       => SysMetodosPagosModel::where(['estatus' => 1 ])->orderby('id', 'desc')->get()
                 ,'value'     => 'id'
                 ,'text'      => 'descripcion'
                 ,'name'      => 'cmb_metodos_pagos_edit'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opción'
                 ,'attr'      => 'data-live-search="true" '               
           ]); 

            $monedas_edit = dropdown([
                 'data'       => SysMonedasModel::where(['estatus' => 1 ])->whereIn('id',['100','101','150','149'])->orderby('descripcion', 'asc')->get()
                 ,'value'     => 'id'
                 ,'text'      => 'nombre descripcion'
                 ,'name'      => 'cmb_monedas_edit'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opción'
                 ,'attr'      => 'data-live-search="true" '                
           ]);

            $productos_edit = dropdown([
                 'data'       => $this->_consulta(new SysProductosModel)
                 ,'value'     => 'id'
                 ,'text'      => 'nombre'
                 ,'name'      => 'cmb_productos_edit'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opción'
                 ,'attr'      => 'data-live-search="true" '   
                 ,'event'     => 'display_productos_edit()'               
           ]);

            $planes_edit = dropdown([
                 'data'       => $this->_consulta(new SysPlanesModel) 
                 ,'value'     => 'id'
                 ,'text'      => 'nombre'
                 ,'name'      => 'cmb_planes_edit'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opción'
                 ,'attr'      => 'data-live-search="true" '   
                 ,'event'     => 'display_planes_edit()'               
           ]);
            /*where(['estatus' => 1 ])->whereIn('id',['94','95','96','97'])->orderby('descripcion', 'asc')->get()*/
            $estatus_edit = dropdown([
                 'data'       => SysEstatusModel::where(['estatus' => 1 ])->whereIn('id',['4','5','6'])->orderby('nombre', 'asc')->get()
                 ,'value'     => 'id'
                 ,'text'      => 'nombre'
                 ,'name'      => 'cmb_estatus_edit'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opción'
                 ,'attr'      => 'data-live-search="true" '                
           ]);
            /*$response = SysClientesModel::with(['contactos'])
                ->where(['estatus' => 1,'id' => $request->input('id')])
                ->orderby('id','asc')
                ->get();*/
            
            if( Session::get("permisos")["GET"] ){
              return view("errors.error");
            }
            
            $data = [
                "page_title" 	        => "Ventas"
                ,"title"  		        => "Cotizaciones"
                ,"data_table"           => ""
                ,'iva'                  => Session::get('iva')
                ,'clientes'             => $clientes
                ,'formas_pagos'         => $formas_pagos
                ,'metodos_pagos'        => $metodos_pagos
                ,'monedas'              => $monedas
                ,'productos'            => $productos
                ,'planes'               => $planes
                ,'estatus'              => $estatus
                ,'estatus_inicio'       => $estatus_inicio
                ,'clientes_edit'        => $clientes_edit
                ,'formas_pagos_edit'    => $formas_pagos_edit
                ,'metodos_pagos_edit'   => $metodos_pagos_edit
                ,'monedas_edit'         => $monedas_edit
                ,'productos_edit'       => $productos_edit
                ,'planes_edit'          => $planes_edit
                ,'estatus_edit'         => $estatus_edit
            ];
            return self::_load_view( "ventas.cotizacion",$data );
        }
        /**
         *Metodo para obtener los datos de manera asicronica.
         *@access public
         *@param Request $request [Description]
         *@return void
         */
        public function all( Request $request ){

            try {
                /*Consulta por id cotizacion agregar cotizacion*/
                $where = ($request->id == "") ? 'WHERE sys_cotizaciones.id = 0' : 'WHERE sys_cotizaciones.id = '.$request->id;

                /*Consulta general de las cotizaciones*/
                if(Session::get('id_rol') == 1){
                    $where_general = '';
                }if(Session::get('id_rol') == 3){
                    $where_general = 'WHERE sys_users_cotizaciones.id_empresa = '.Session::get('id_empresa');
                }else if(Session::get('id_rol') != 3 && Session::get('id_rol') != 1){
                    $where_general = 'WHERE sys_users_cotizaciones.id_users = '.Session::get('id') .' AND sys_users_cotizaciones.id_empresa = '.Session::get('id_empresa');
                }

                $group_by_general = 'GROUP BY sys_users_cotizaciones.id_cotizacion';

                $orderBy = 'order by sys_users_cotizaciones.id_cotizacion desc';

                $sql = "SELECT sys_users_cotizaciones.id_cotizacion
                        ,sys_users_cotizaciones.id_concepto
                        ,sys_cotizaciones.codigo
                        ,sys_productos.descripcion as prod_desc
                        ,sys_planes.descripcion
                        ,sys_conceptos_cotizaciones.cantidad
                        ,sys_conceptos_cotizaciones.precio
                        ,sys_conceptos_cotizaciones.total
                        ,sys_productos.codigo as cod_productos,sys_planes.codigo as cod_planes
                        FROM sys_users_cotizaciones
                        inner join sys_cotizaciones on sys_cotizaciones.id = sys_users_cotizaciones.id_cotizacion
                        inner join sys_conceptos_cotizaciones on sys_conceptos_cotizaciones.id = sys_users_cotizaciones.id_concepto
                        left join sys_productos on sys_productos.id = sys_conceptos_cotizaciones.id_producto
                        left join sys_planes on sys_planes.id = sys_conceptos_cotizaciones.id_plan ".$where;

                $tol = "SELECT sys_cotizaciones.iva,sys_cotizaciones.subtotal,sys_cotizaciones.total as total_conc
                        FROM sys_users_cotizaciones
                        inner join sys_cotizaciones on sys_cotizaciones.id = sys_users_cotizaciones.id_cotizacion
                        inner join sys_conceptos_cotizaciones on sys_conceptos_cotizaciones.id = sys_users_cotizaciones.id_concepto
                        left join sys_productos on sys_productos.id = sys_conceptos_cotizaciones.id_producto
                        left join sys_planes on sys_planes.id = sys_conceptos_cotizaciones.id_plan ".$where.' '."group by sys_cotizaciones.id";

                $sql_general = "SELECT sys_users_cotizaciones.id_cotizacion,sys_users_cotizaciones.id_concepto,
                                   CONCAT(sys_users.name,' ',sys_users.first_surname) as vendedor,
                                   sys_cotizaciones.codigo,DATE_FORMAT(sys_cotizaciones.created_at, '%Y-%m-%d') as created_at,
                                   sys_contactos.nombre_completo,
                                   sys_clientes.nombre_comercial,
                                   sys_cotizaciones.id_estatus,
                                   sys_estatus.nombre,
                                   sys_conceptos_cotizaciones.cantidad,sys_conceptos_cotizaciones.precio,sys_conceptos_cotizaciones.total,
                                   sys_cotizaciones.iva,sys_cotizaciones.subtotal,sys_cotizaciones.total as total_conc
                                 FROM sys_users_cotizaciones
                                 inner join sys_cotizaciones on sys_cotizaciones.id = sys_users_cotizaciones.id_cotizacion
                                 left join  sys_clientes on sys_clientes.id = sys_cotizaciones.id_cliente
                                 left join  sys_contactos on sys_contactos.id = sys_cotizaciones.id_contacto
                                 left join  sys_estatus on sys_estatus.id = sys_cotizaciones.id_estatus
                                 inner join sys_conceptos_cotizaciones on sys_conceptos_cotizaciones.id = sys_users_cotizaciones.id_concepto
                                 left join sys_productos on sys_productos.id = sys_conceptos_cotizaciones.id_producto
                                 left join sys_planes on sys_planes.id = sys_conceptos_cotizaciones.id_plan
                                 left join sys_users on sys_users.id = sys_users_cotizaciones.id_users ".$where_general.' '.$group_by_general.' '.$orderBy;


                $concep = DB::select($sql);
                $cotiz_general = DB::select($sql_general);
                $total = DB::select($tol);

                if($request->id == ''){
                    $totales = [];
                }elseif(count($total) >= 1){
                    $subtotal = $total[0]->subtotal;
                    $iv = Session::get('iva') / 100;
                    $iva = $subtotal * $iv;

                    $totales = [
                         'iva'          => format_currency($iva,2)
                        ,'subtotal'     => format_currency($subtotal,2)
                        ,'total'        => format_currency($subtotal + $iva,2)
                        ,'iva_'         => number_format($iva,2)
                        ,'subtotal_'    => number_format($subtotal,2)
                        ,'total_'       => number_format($subtotal + $iva,2)
                    ];
                }else{
                    $totales = [];
                }

                $response = [
                    'concep'            => $concep
                    ,'cotiz_general'    => $cotiz_general
                    ,'totales'          => $totales
                ];
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
                $coti = "SELECT sys_users_cotizaciones.id_cotizacion,sys_users_cotizaciones.id_concepto,
                       sys_cotizaciones.codigo,
                       sys_cotizaciones.id,sys_cotizaciones.descripcion as des_cot,sys_cotizaciones.id_cliente,
                       sys_cotizaciones.id_moneda,sys_cotizaciones.id_contacto,sys_cotizaciones.id_metodo_pago,
                       sys_cotizaciones.id_forma_pago,sys_cotizaciones.id_estatus,
                       sys_cotizaciones.iva,sys_cotizaciones.subtotal,sys_cotizaciones.total as total_conc
             FROM sys_users_cotizaciones
             inner join sys_cotizaciones on sys_cotizaciones.id = sys_users_cotizaciones.id_cotizacion
             inner join sys_conceptos_cotizaciones on sys_conceptos_cotizaciones.id = sys_users_cotizaciones.id_concepto
             left join sys_productos on sys_productos.id = sys_conceptos_cotizaciones.id_producto
             left join sys_planes on sys_planes.id = sys_conceptos_cotizaciones.id_plan where sys_cotizaciones.id =".$request->id.' '."GROUP BY sys_users_cotizaciones.id_cotizacion";

                $conc = "SELECT sys_users_cotizaciones.id_cotizacion,sys_users_cotizaciones.id_concepto,
                       sys_cotizaciones.codigo,sys_cotizaciones.created_at,sys_productos.descripcion as prod_desc,sys_planes.descripcion,
                       sys_conceptos_cotizaciones.cantidad,sys_conceptos_cotizaciones.precio,sys_conceptos_cotizaciones.total,
                       sys_cotizaciones.id,sys_cotizaciones.descripcion as des_cot,sys_cotizaciones.id_cliente
             FROM sys_users_cotizaciones
             inner join sys_cotizaciones on sys_cotizaciones.id = sys_users_cotizaciones.id_cotizacion
             inner join sys_conceptos_cotizaciones on sys_conceptos_cotizaciones.id = sys_users_cotizaciones.id_concepto
             left join sys_productos on sys_productos.id = sys_conceptos_cotizaciones.id_producto
             left join sys_planes on sys_planes.id = sys_conceptos_cotizaciones.id_plan where sys_cotizaciones.id =".$request->id;

                $concep = DB::select($coti);
                $conceptos = DB::select($conc);
                
                $subtotal = $concep[0]->total_conc;
                $iv = Session::get('iva') / 100;
                $iva = $subtotal * $iv;

                $totales = [
                     'iva'          => format_currency($iva,2)
                    ,'subtotal'     => format_currency($subtotal,2)
                    ,'total'        => format_currency($subtotal + $iva,2)
                    ,'iva_'         => number_format($iva,2)
                    ,'subtotal_'    => number_format($subtotal,2)
                    ,'total_'       => number_format($subtotal + $iva,2)
                ];

                $response = [
                    'cotizacion'    => $concep
                    ,'conceptos'    => $conceptos
                    ,'totales'      => $totales
                ];
                
            return $this->_message_success( 201, $response , self::$message_success );
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
                //debuger($request->cotizacion['Total']['iva']);
                
                $cotizaciones = [
                    'codigo'         => isset($request->cotizacion['codigo'])?$request->cotizacion['codigo']:null
                    ,'descripcion'   => isset($request->cotizacion['descripcion'])?$request->cotizacion['descripcion']:0
                    ,'id_cliente'    => isset($request->cotizacion['id_cliente'])?$request->cotizacion['id_cliente']:111
                    ,'id_moneda'     => isset($request->cotizacion['id_moneda'])?$request->cotizacion['id_moneda']:0
                    ,'id_contacto'   => isset($request->cotizacion['id_contacto'])?$request->cotizacion['id_contacto']:0
                    ,'id_metodo_pago'=> isset($request->cotizacion['id_metodo_pago'])?$request->cotizacion['id_metodo_pago']:0
                    ,'id_forma_pago' => isset($request->cotizacion['id_forma_pago'])?$request->cotizacion['id_forma_pago']:0
                    ,'id_estatus'    => isset($request->cotizacion['id_estatus'])?$request->cotizacion['id_estatus']:0
                ];
                //debuger($cotizaciones);

                //$cotizacion = SysCotizacionModel::create($cotizaciones);
                
                $conceptos_cotizaciones = [
                    'id_producto'   => isset($request->conceptos['id_producto'])?$request->conceptos['id_producto']:0
                    ,'id_plan'      => isset($request->conceptos['id_plan'])?$request->conceptos['id_plan']:0
                    ,'cantidad'     => isset($request->conceptos['cantidad'])?$request->conceptos['cantidad']:3
                    ,'precio'       => isset($request->conceptos['precio'])?$request->conceptos['precio']:0
                    ,'total'        => isset($request->conceptos['total'])?$request->conceptos['total']:0
                ];

                $subtotal = $conceptos_cotizaciones['total'];
                $iv = Session::get('iva') / 100;
                $iva = $subtotal * $iv;

                $totales = [
                     'iva'          => $this->truncarDecimales($iva,2)
                    ,'subtotal'      => $this->truncarDecimales($subtotal,2)
                    ,'total'        => $this->truncarDecimales($subtotal + $iva,2)
                ];
                
                //$sys_conceptos = SysConceptosCotizacionesModel::create($conceptos_cotizaciones);
                
                $id = $request->cotizacion['id_concep_producto'];
                //debuger($id);
                if($id == "" || $id == null){
                    $cotizacion = SysCotizacionModel::create($cotizaciones);
                    SysCotizacionModel::where('id',$cotizacion->id)->update($totales);
                    $sys_conceptos = SysConceptosCotizacionesModel::create($conceptos_cotizaciones);

                       $user_co = [
                    'id_users'           => Session::get('id')
                    ,'id_rol'            => Session::get('id_rol')
                    ,'id_empresa'        => Session::get('id_empresa')
                    ,'id_sucursal'       => Session::get('id_sucursal')
                    ,'id_menu'           => 27
                    ,'id_cotizacion'     => $cotizacion->id
                    ,'id_concepto'       => $sys_conceptos->id
                    ];
                    SysUsersCotizacionesModel::create($user_co);

                } elseif($request->cotizacion['upd'] == 0) {
                    $cotizacion                 = SysCotizacionModel::FindOrFail($id);
                    $subtotal = $conceptos_cotizaciones['total'] + $cotizacion->subtotal;
                    $iv = Session::get('iva') / 100;
                    $iva = $subtotal * $iv;
                    
                    $cotizacion->codigo         = $request->cotizacion['codigo'];
                    $cotizacion->descripcion    = $request->cotizacion['descripcion'];
                    $cotizacion->id_cliente     = $request->cotizacion['id_cliente'];
                    $cotizacion->id_moneda      = $request->cotizacion['id_moneda'];
                    $cotizacion->id_contacto    = $request->cotizacion['id_contacto'];
                    $cotizacion->id_metodo_pago = $request->cotizacion['id_metodo_pago'];
                    $cotizacion->id_forma_pago  = $request->cotizacion['id_forma_pago'];
                    $cotizacion->id_estatus     = $request->cotizacion['id_estatus'];
                    $cotizacion->iva            = $this->truncarDecimales($iva,2);
                    $cotizacion->subtotal       = $this->truncarDecimales($subtotal,2);
                    $cotizacion->total          = $this->truncarDecimales($subtotal + $iva,2);
                    $cotizacion->save();
                    /*SysCotizacionModel::where()->update();
                    $cotizacion = SysCotizacionModel::where(['id' => $id])->get();
*/
                    //debuger($cotizacion);
                    $sys_conceptos = SysConceptosCotizacionesModel::create($conceptos_cotizaciones);
                    $user_co = [
                    'id_users'           => Session::get('id')
                    ,'id_rol'            => Session::get('id_rol')
                    ,'id_empresa'        => Session::get('id_empresa')
                    ,'id_sucursal'       => Session::get('id_sucursal')
                    ,'id_menu'           => 27
                    ,'id_cotizacion'     => $cotizacion->id
                    ,'id_concepto'       => $sys_conceptos->id
                    ];
                    SysUsersCotizacionesModel::create($user_co);
                }elseif($request->cotizacion['id_estatus'] == 5) {
                    
                    $cotizacion                 = SysCotizacionModel::FindOrFail($id);
                    $subtotal = $conceptos_cotizaciones['total'] + $cotizacion->subtotal;
                    $iv = Session::get('iva') / 100;
                    $iva = $subtotal * $iv;
                    
                    $cotizacion->codigo         = $request->cotizacion['codigo'];
                    $cotizacion->descripcion    = $request->cotizacion['descripcion'];
                    $cotizacion->id_cliente     = $request->cotizacion['id_cliente'];
                    $cotizacion->id_moneda      = $request->cotizacion['id_moneda'];
                    $cotizacion->id_contacto    = $request->cotizacion['id_contacto'];
                    $cotizacion->id_metodo_pago = $request->cotizacion['id_metodo_pago'];
                    $cotizacion->id_forma_pago  = $request->cotizacion['id_forma_pago'];
                    $cotizacion->id_estatus     = $request->cotizacion['id_estatus'];
                    $cotizacion->iva            = $this->truncarDecimales($iva,2);
                    $cotizacion->subtotal       = $this->truncarDecimales($subtotal,2);
                    $cotizacion->total          = $this->truncarDecimales($subtotal + $iva,2);
                    $cotizacion->save();
                    
                    $data = [
                        'codigo'         => $request->cotizacion['id_concep_producto']
                        ,'descripcion'   => isset($request->cotizacion['descripcion'])?$request->cotizacion['descripcion']:0
                        ,'iva'           =>  $this->truncarDecimales($iva,2)
                        ,'subtotal'      =>  $this->truncarDecimales($subtotal,2)
                        ,'total'         =>  $this->truncarDecimales($subtotal + $iva,2)
                        ,'id_cotizacion' =>  $request->cotizacion['id_concep_producto']
                        ,'id_cliente'    => isset($request->cotizacion['id_cliente'])?$request->cotizacion['id_cliente']:111
                        ,'id_moneda'     => isset($request->cotizacion['id_moneda'])?$request->cotizacion['id_moneda']:0
                        ,'id_contacto'   => isset($request->cotizacion['id_contacto'])?$request->cotizacion['id_contacto']:0
                        ,'id_metodo_pago'=> isset($request->cotizacion['id_metodo_pago'])?$request->cotizacion['id_metodo_pago']:0
                        ,'id_forma_pago' => isset($request->cotizacion['id_forma_pago'])?$request->cotizacion['id_forma_pago']:0
                        ,'id_estatus'    => 6

                    ];
                    ///Valido si existe id_cotizacion en la tabla syspedidos, si existe solo hace update, si no inserta
                    $p = SysPedidosModel::where('id_cotizacion', $id)->get();
                    if($p->isEmpty()){
                        $id_pedido = SysPedidosModel::create($data);
                    }else{
                        $id_pedido = SysPedidosModel::where('id_cotizacion',$id)->update($data);
                          
                        $idd = SysUsersPedidosModel::select('id_concepto')->where('id_pedido',$p[0]['id'])->get();
                        //debuger($idd);
                        foreach ($idd as $valuee) {
                            $v=    $valuee->id_concepto;
                            SysConceptosPedidosModel::where(['id' => $v])->delete();
                        }
            
                        SysUsersPedidosModel::where('id_pedido',$p[0]['id'])->delete();

                    }
                    //$id_pedido =SysPedidosModel::create($data);
                    //Obtengo los datos con el id_cotizacion y barro los id_concepto
                    $user_cot = SysUsersCotizacionesModel::where(['id_cotizacion' => $request->cotizacion['id_concep_producto']])->get();
                    $id_conc = [];
                        foreach($user_cot as $key){
                            $id_conc[] = $key->id_concepto; 
                        }
                    //debuger($id_conc);  //Obtengo los datos con el id_concepto  en la tabla conceptos coti y los barro para insertar
                    $id_concep = SysConceptosCotizacionesModel::whereIn('id', $id_conc)->get();
                    //debuger($id_concep);
                    
                    foreach($id_concep as $concp){

                         $data = 
                         [
                             'id_producto' => $concp->id_producto
                             ,'id_plan' => $concp->id_plan
                             ,'cantidad' => $concp->cantidad
                             ,'precio' => $concp->precio
                             ,'total' => $concp->total
                            
                         ];
                         $ins = SysConceptosPedidosModel::create($data);
                         $id_user_pe = 
                            [
                                'id_users'      => Session::get('id')
                                ,'id_rol'       => Session::get('id_rol')
                                ,'id_empresa'   => Session::get('id_empresa')
                                ,'id_sucursal'  => Session::get('id_sucursal')
                                ,'id_menu'      => 28
                                ,'id_pedido'    => isset($id_pedido->id)?$id_pedido->id:$p[0]['id']
                                ,'id_concepto'  => $ins->id
                            ]; 
                        
                            $insert = SysUsersPedidosModel::create($id_user_pe);
                    
                     }
                    // $data = []; 
                    //     foreach($id_concep as $concp){
                    //         $data[] = 
                    //     [
                    //         'id_producto' => $concp->id_producto
                    //         ,'id_plan' => $concp->id_plan
                    //         ,'cantidad' => $concp->cantidad
                    //         ,'precio' => $concp->precio
                    //         ,'total' => $concp->total
                            
                    //     ];
                    //     }
                    //     //id_producto,id_plan,cantidad,precio,total
                    //debuger($data);

                    // // SysUsersPedidosModel::where('')
                    //insert conceptp pedidos
                

                }else{
                    $cotizacion                 = SysCotizacionModel::FindOrFail($id);
                    $subtotal = $conceptos_cotizaciones['total'] + $cotizacion->subtotal;
                    $iv = Session::get('iva') / 100;
                    $iva = $subtotal * $iv;
                    
                    $cotizacion->codigo         = $request->cotizacion['codigo'];
                    $cotizacion->descripcion    = $request->cotizacion['descripcion'];
                    $cotizacion->id_cliente     = $request->cotizacion['id_cliente'];
                    $cotizacion->id_moneda      = $request->cotizacion['id_moneda'];
                    $cotizacion->id_contacto    = $request->cotizacion['id_contacto'];
                    $cotizacion->id_metodo_pago = $request->cotizacion['id_metodo_pago'];
                    $cotizacion->id_forma_pago  = $request->cotizacion['id_forma_pago'];
                    $cotizacion->id_estatus     = $request->cotizacion['id_estatus'];
                    $cotizacion->iva            = $this->truncarDecimales($iva,2);
                    $cotizacion->subtotal       = $this->truncarDecimales($subtotal,2);
                    $cotizacion->total          = $this->truncarDecimales($subtotal + $iva,2);
                    $cotizacion->save();
                }
                if($request->cotizacion['id_estatus'] == 5){
                    if($cotizacion == true){
                        $cotizacion = [
                            'cotizacion' => $cotizacion
                            ,'id_pedido'  => isset($id_pedido->id)?$id_pedido->id:''
                        ];
                    }
                }else{
                    $cotizacion;
                }
                
                //SysUsersCotizacionesModel::create($user_co);


            DB::commit();
            $success = true;
            } catch (\Exception $e) {
            $success = false;
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            DB::rollback();
            }

            if ($success) {
            return $this->_message_success( 201, $cotizacion , self::$message_success );
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
        * Metodo para borrar el registro producto (concepto)
        * @access public
        * @param Request $request [Description]
        * @return void
        */
        public function destroy( Request $request ){
            #debuger($request->all());
            $error = null;
            DB::beginTransaction();
            try {
                /*Busco id cotizacion en users cotizacion referente al id concepto*/
                $total = SysUsersCotizacionesModel::select('id_cotizacion')->where('id_concepto',$request->input('id'))->groupBy('id_cotizacion')->get();
                foreach ($total as $value) {
                    $dl=    $value->id_cotizacion;
                }
                /*Identifico id_cotizacion*/
                $cot = SysCotizacionModel::where('id',$dl)->get();
                foreach ($cot as $id_cot) {
                    $getCotizacion=    $id_cot->subtotal;
                }
                /*Opetreaciones para restar*/
                $subtotal = $getCotizacion-$request->input('total');
                $iv = Session::get('iva') / 100;
                $iva = $subtotal * $iv;

                $totales = [
                     'iva'          => $this->truncarDecimales($iva,2)
                    ,'subtotal'      => $this->truncarDecimales($subtotal,2)
                    ,'total'        => $this->truncarDecimales($subtotal + $iva,2)
                ];
                /*Update total.iva,subtotal*/
                SysCotizacionModel::where('id',$dl)->update($totales);
                /*Eliminacion cocepto*/
                SysConceptosCotizacionesModel::where(['id' => $request->id])->delete();
                $response = SysUsersCotizacionesModel::where('id_concepto',$request->input('id'))->delete();

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
        * Metodo para borrar el registro cotizacion
        * @access public
        * @param Request $request [Description]
        * @return void
        */
        public function destroy_cotizacion ( Request $request ){
            //debuger($request->all());
            $error = null;
            DB::beginTransaction();
            try {
                $id = SysUsersCotizacionesModel::select('id_concepto')->where('id_cotizacion',$request->input('id'))->get();
                //debuger($id);
                foreach ($id as $value) {
                    $v=    $value->id_concepto;
                    SysConceptosCotizacionesModel::where(['id' => $v])->delete();
                }
    
                SysUsersCotizacionesModel::where('id_cotizacion',$request->input('id'))->delete();

                $response = SysCotizacionModel::where(['id' => $request->id])->delete();

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
        * Metodo para borrar el registro producto (concepto)
        * @access public
        * @param Request $request [Description]
        * @return void
        */
        public function destroy_cotizacion_edit( Request $request ){
            #debuger($request->all());
            $error = null;
            DB::beginTransaction();
            try {
                /*Busco id cotizacion en users cotizacion referente al id concepto*/

                $total = SysUsersCotizacionesModel::select('id_cotizacion')->where('id_concepto',$request->input('id'))->groupBy('id_cotizacion')->get();
                foreach ($total as $value) {
                    $dl=    $value->id_cotizacion;
                }
                /*Identifico id_cotizacion*/
                $cot = SysCotizacionModel::where('id',$dl)->get();
                foreach ($cot as $id_cot) {
                    $getCotizacion=    $id_cot->subtotal;
                }
                /*Opetreaciones para restar*/
                $subtotal = $getCotizacion-$request->input('total');
                $iv = Session::get('iva') / 100;
                $iva = $subtotal * $iv;

                $totales = [
                     'iva'          => $this->truncarDecimales($iva,2)
                    ,'subtotal'     => $this->truncarDecimales($subtotal,2)
                    ,'total'        => $this->truncarDecimales($subtotal + $iva,2)
                ];
                /*Update total.iva,subtotal*/
                SysCotizacionModel::where('id',$dl)->update($totales);
                /*Eliminacion cocepto*/
                SysConceptosCotizacionesModel::where(['id' => $request->id])->delete();
                $response = SysUsersCotizacionesModel::where('id_concepto',$request->input('id'))->delete();

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
        * Metodo para traer informacion de la empresa cliente
        * @access public
        * @param Request $request [Description]
        * @return void
        */
        public function getbycontactos( Request $request ){

            try {
                $response = SysContactosModel::where(['id' => $request->id])->get();
                #$response = SysClientesModel::all();
            return $this->_message_success( 201, $response[0] , self::$message_success );
            } catch (\Exception $e) {
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            return $this->show_error(6, $error, self::$message_error );
            }

        }
        /**
        * Metodo para traer informacion de la empresa cliente
        * @access public
        * @param Request $request [Description]
        * @return void
        */
        public function getContacto( Request $request ){

            try {
                #debuger($request->input('id'));
                $response = SysClientesModel::with(['contactos'])
                ->where(['estatus' => 1,'id' => $request->input('id')])
                ->orderby('id','asc')
                ->get();
                #debuger($response);
                $contactos = [];
                foreach ($response as $contacto) {
                    $contactos = $contacto->contactos;
                }                
                $contact = dropdown([
                     'data'       => $contactos
                     ,'value'     => 'id'
                     ,'text'      => 'nombre_completo'
                     ,'name'      => 'cmb_contactos'
                     ,'class'     => 'form-control'
                     ,'leyenda'   => 'Seleccione Opción'
                     ,'attr'      => 'data-live-search="true" '
                     ,'event'      => 'parser_data()'
               ]);
                $data = [
                    'combo_contactos' => $contact
                    ,'rfc' => isset($response[0])? $response[0]->rfc_receptor:""
                    ,'telefono' => isset($response[0])? $response[0]:""
                    ,'correo' => isset($response[0])? $response[0]: ""
                ];
                #$response = SysClientesModel::all();
            return $this->_message_success( 201, $data , self::$message_success );
            } catch (\Exception $e) {
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            return $this->show_error(6, $error, self::$message_error );
            }

        }

                /**
        * Metodo para traer informacion de la empresa cliente edicion
        * @access public
        * @param Request $request [Description]
        * @return void
        */
        public function getContactoEdicion( Request $request ){

            try {
                #debuger($request->input('id'));
                $response = SysClientesModel::with(['contactos'])
                ->where(['estatus' => 1,'id' => $request->input('id')])
                ->orderby('id','asc')
                ->get();
                #debuger($response);
                $contactos = [];
                foreach ($response as $contacto) {
                    $contactos = $contacto->contactos;
                }                
                $contact = dropdown([
                     'data'       => $contactos
                     ,'value'     => 'id'
                     ,'text'      => 'nombre_completo'
                     ,'name'      => 'cmb_contactos_edit'
                     ,'class'     => 'form-control'
                     ,'leyenda'   => 'Seleccione Opción'
                     ,'attr'      => 'data-live-search="true" '
                     ,'event'      => 'parser_data_edit()'
               ]);
                $data = [
                    'combo_contactos' => $contact
                    ,'rfc' => isset($response[0])? $response[0]->rfc_receptor:""
                    ,'telefono' => isset($response[0])? $response[0]:""
                    ,'correo' => isset($response[0])? $response[0]: ""
                ];
                #$response = SysClientesModel::all();
            return $this->_message_success( 201, $data , self::$message_success );
            } catch (\Exception $e) {
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            return $this->show_error(6, $error, self::$message_error );
            }

        }

          public function getProducto( Request $request ){

            try {
                #debuger($request->input('id'));
                $response = SysProductosModel::where(['estatus' => 1,'id' => $request->input('id')])
                ->orderby('id','asc')
                ->get();
              
            return $this->_message_success( 201, $response[0] , self::$message_success );
            } catch (\Exception $e) {
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            return $this->show_error(6, $error, self::$message_error );
            }

        }

        public function get_planes( Request $request ){

            try {
                #debuger($request->input('id'));
                $response = SysPlanesModel::where(['estatus' => 1,'id' => $request->input('id')])
                ->orderby('id','asc')
                ->get();
              
            return $this->_message_success( 201, $response[0] , self::$message_success );
            } catch (\Exception $e) {
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            return $this->show_error(6, $error, self::$message_error );
            }

        }

        public function truncarDecimales($numero, $digitos)
        {
            $truncar = 10**$digitos;
            return intval($numero * $truncar) / $truncar;
        }

        public function get_pdf( $id )
        {
        $sql=  "SELECT sys_users_cotizaciones.id_cotizacion,sys_users_cotizaciones.id_concepto,
            CONCAT(sys_users.name,' ',sys_users.first_surname) as vendedor,
            sys_cotizaciones.descripcion as des_cot,
            sys_cotizaciones.codigo,DATE_FORMAT(sys_cotizaciones.created_at, '%Y-%m-%d') as fecha_alta,
            sys_contactos.nombre_completo as contacto,
            sys_contactos.correo as correo,
            sys_contactos.telefono as telefono,
            sys_clientes.nombre_comercial as empresa,
            sys_cotizaciones.id_estatus,
            sys_estatus.nombre,
            sys_empresas.nombre_comercial,
            sys_empresas.razon_social as razon_em,
            sys_empresas.logo, sys_empresas.telefono as tel_em,
            sys_empresas.calle as calle_em,
            sys_empresas.colonia as col_em,
            sys_empresas.logo as muni_emp,
            sys_cotizaciones.iva,sys_cotizaciones.subtotal,sys_cotizaciones.total as total_conc,
            sys_formas_pagos.descripcion as des_forma_p,sys_metodos_pagos.descripcion as des_metod_p
          FROM sys_users_cotizaciones
          inner join sys_cotizaciones on sys_cotizaciones.id = sys_users_cotizaciones.id_cotizacion
          left join  sys_clientes on sys_clientes.id = sys_cotizaciones.id_cliente
          left join  sys_contactos on sys_contactos.id = sys_cotizaciones.id_contacto
          left join  sys_estatus on sys_estatus.id = sys_cotizaciones.id_estatus
          inner join sys_conceptos_cotizaciones on sys_conceptos_cotizaciones.id = sys_users_cotizaciones.id_concepto
          left join sys_productos on sys_productos.id = sys_conceptos_cotizaciones.id_producto
          left join sys_planes on sys_planes.id = sys_conceptos_cotizaciones.id_plan
          left join sys_users on sys_users.id = sys_users_cotizaciones.id_users
          left join sys_empresas on sys_empresas.id = sys_users_cotizaciones.id_empresa
          left join sys_formas_pagos on sys_formas_pagos.id = sys_cotizaciones.id_forma_pago
          left join sys_metodos_pagos on sys_metodos_pagos.id = sys_cotizaciones.id_metodo_pago
          where sys_cotizaciones.id =" .$id ." "."GROUP BY sys_users_cotizaciones.id_cotizacion";

          $prod = "SELECT sys_users_cotizaciones.id_cotizacion,sys_users_cotizaciones.id_concepto,
            sys_cotizaciones.codigo,sys_cotizaciones.created_at,sys_productos.descripcion as prod_desc,sys_planes.descripcion,
            sys_conceptos_cotizaciones.cantidad,sys_conceptos_cotizaciones.precio,sys_conceptos_cotizaciones.total,
            sys_cotizaciones.id,sys_cotizaciones.descripcion as des_cot,sys_cotizaciones.id_cliente
        FROM sys_users_cotizaciones
        inner join sys_cotizaciones on sys_cotizaciones.id = sys_users_cotizaciones.id_cotizacion
        inner join sys_conceptos_cotizaciones on sys_conceptos_cotizaciones.id = sys_users_cotizaciones.id_concepto
        left join sys_productos on sys_productos.id = sys_conceptos_cotizaciones.id_producto
        left join sys_planes on sys_planes.id = sys_conceptos_cotizaciones.id_plan where sys_cotizaciones.id =" .$id;
          
            $datos  = DB::select($sql);
            $produc = DB::select($prod); 
            $total = DB::select($sql);

                if(count($total) >= 1){
                    $subtotal = $total[0]->subtotal;
                    $iv = Session::get('iva') / 100;
                    $iva = $subtotal * $iv;

                    $totales = [
                         'iva'          => format_currency($iva,2)
                        ,'subtotal'     => format_currency($subtotal,2)
                        ,'total'        => format_currency($subtotal + $iva,2)
                        ,'iva_'         => number_format($iva,2)
                        ,'subtotal_'    => number_format($subtotal,2)
                        ,'total_'       => number_format($subtotal + $iva,2)
                    ];
                }else{
                    $totales = [];
                }

                $response = [
                    'datos'             => $datos
                    ,'prod'             => $produc
                    ,'totales'          => $totales
                ];
                
        $pdf = PDF::loadView('ventas.pdf.pdf_cotizacion', ['data' => $response]);
        return $pdf->stream('pdf.generar');
        }

        public function send_pdf( Request $request )
        {
            try {

            $data = [
                'email'     => $request->input('correo')
                ,'name'     => $request->input('contacto')
                ,'asunto'   => $request->input('asunto')
                ,'mensaje'  => $request->input('mensaje')
                ,'id'       => $request->input('id')
            ];
            
 
            Mail::send('ventas.pdf.template', $data, function($message) use ( $data ) {
                
            $sql=  "SELECT sys_users_cotizaciones.id_cotizacion,sys_users_cotizaciones.id_concepto,
            CONCAT(sys_users.name,' ',sys_users.first_surname) as vendedor,
            sys_cotizaciones.descripcion as des_cot,
            sys_cotizaciones.codigo,DATE_FORMAT(sys_cotizaciones.created_at, '%Y-%m-%d') as fecha_alta,
            sys_contactos.nombre_completo as contacto,
            sys_contactos.correo as correo,
            sys_contactos.telefono as telefono,
            sys_clientes.nombre_comercial as empresa,
            sys_cotizaciones.id_estatus,
            sys_estatus.nombre,
            sys_empresas.nombre_comercial,
            sys_empresas.razon_social as razon_em,
            sys_empresas.logo, sys_empresas.telefono as tel_em,
            sys_empresas.calle as calle_em,
            sys_empresas.colonia as col_em,
            sys_empresas.logo as muni_emp,
            sys_cotizaciones.iva,sys_cotizaciones.subtotal,sys_cotizaciones.total as total_conc,
            sys_formas_pagos.descripcion as des_forma_p,sys_metodos_pagos.descripcion as des_metod_p
          FROM sys_users_cotizaciones
          inner join sys_cotizaciones on sys_cotizaciones.id = sys_users_cotizaciones.id_cotizacion
          left join  sys_clientes on sys_clientes.id = sys_cotizaciones.id_cliente
          left join  sys_contactos on sys_contactos.id = sys_cotizaciones.id_contacto
          left join  sys_estatus on sys_estatus.id = sys_cotizaciones.id_estatus
          inner join sys_conceptos_cotizaciones on sys_conceptos_cotizaciones.id = sys_users_cotizaciones.id_concepto
          left join sys_productos on sys_productos.id = sys_conceptos_cotizaciones.id_producto
          left join sys_planes on sys_planes.id = sys_conceptos_cotizaciones.id_plan
          left join sys_users on sys_users.id = sys_users_cotizaciones.id_users
          left join sys_empresas on sys_empresas.id = sys_users_cotizaciones.id_empresa
          left join sys_formas_pagos on sys_formas_pagos.id = sys_cotizaciones.id_forma_pago
          left join sys_metodos_pagos on sys_metodos_pagos.id = sys_cotizaciones.id_metodo_pago
          where sys_cotizaciones.id =" .$data['id'] ." "."GROUP BY sys_users_cotizaciones.id_cotizacion";

          $prod = "SELECT sys_users_cotizaciones.id_cotizacion,sys_users_cotizaciones.id_concepto,
            sys_cotizaciones.codigo,sys_cotizaciones.created_at,sys_productos.descripcion as prod_desc,sys_planes.descripcion,
            sys_conceptos_cotizaciones.cantidad,sys_conceptos_cotizaciones.precio,sys_conceptos_cotizaciones.total,
            sys_cotizaciones.id,sys_cotizaciones.descripcion as des_cot,sys_cotizaciones.id_cliente
        FROM sys_users_cotizaciones
        inner join sys_cotizaciones on sys_cotizaciones.id = sys_users_cotizaciones.id_cotizacion
        inner join sys_conceptos_cotizaciones on sys_conceptos_cotizaciones.id = sys_users_cotizaciones.id_concepto
        left join sys_productos on sys_productos.id = sys_conceptos_cotizaciones.id_producto
        left join sys_planes on sys_planes.id = sys_conceptos_cotizaciones.id_plan where sys_cotizaciones.id =" .$data['id'];
          
            $datos  = DB::select($sql);
            $produc = DB::select($prod); 
            $total = DB::select($sql);

                if(count($total) >= 1){
                    $subtotal = $total[0]->subtotal;
                    $iv = Session::get('iva') / 100;
                    $iva = $subtotal * $iv;

                    $totales = [
                         'iva'          => format_currency($iva,2)
                        ,'subtotal'     => format_currency($subtotal,2)
                        ,'total'        => format_currency($subtotal + $iva,2)
                        ,'iva_'         => number_format($iva,2)
                        ,'subtotal_'    => number_format($subtotal,2)
                        ,'total_'       => number_format($subtotal + $iva,2)
                    ];
                }else{
                    $totales = [];
                }

                $response = [
                    'datos'             => $datos
                    ,'prod'             => $produc
                    ,'totales'          => $totales
                ];
                $pdf = PDF::loadView('ventas.pdf.pdf_cotizacion', ['data' => $response]);
                $message->to( 'al221211431@gmail.com', $data['name'] )
                        ->from('notificaciones@burolaboralmexico.com.mx','BLM')
                        ->subject(  $data['asunto'] )
                        ->attachData($pdf->output(), "cotizacion.pdf");
            });
            $d = TRUE;
            return $this->_message_success( 201, $d , self::$message_success );
            } catch (\Exception $e) {
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            return $this->show_error(6, $error, self::$message_error );
            }
            
        }

        public function get_correo( Request $request )
        {
            try {
        
            $email = "SELECT sys_users_cotizaciones.id_cotizacion,
                    sys_contactos.nombre_completo as contacto,
                    sys_contactos.correo as correo,
                    sys_empresas.nombre_comercial,
                    sys_empresas.razon_social as razon_em
                FROM sys_users_cotizaciones
                inner join sys_cotizaciones on sys_cotizaciones.id = sys_users_cotizaciones.id_cotizacion
                left join  sys_contactos on sys_contactos.id = sys_cotizaciones.id_contacto
                left join sys_empresas on sys_empresas.id = sys_users_cotizaciones.id_empresa
                where sys_cotizaciones.id =" .$request->input('id').' '."GROUP BY sys_users_cotizaciones.id_cotizacion";

            $contacto = DB::select($email);
              
            return $this->_message_success( 201, $contacto , self::$message_success );
            } catch (\Exception $e) {
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            return $this->show_error(6, $error, self::$message_error );
            }
                    
        }
                 
        

    }