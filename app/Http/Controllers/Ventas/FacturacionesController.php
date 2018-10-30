<?php
    namespace App\Http\Controllers\Ventas;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Session;
    use App\Http\Controllers\MasterController;
    use App\Model\Ventas\SysFacturacionesModel;
    use App\Model\Ventas\SysConceptosFacturacionesModel;
    use App\Model\Administracion\Configuracion\SysUsersModel;
    use App\Model\Administracion\Configuracion\SysPlanesModel;
    use App\Model\Administracion\Configuracion\SysMonedasModel;
    use App\Model\Administracion\Configuracion\SysEstatusModel;
    use App\Model\Administracion\Configuracion\SysClientesModel;
    use App\Model\Administracion\Configuracion\SysEmpresasModel;
    use App\Model\Administracion\Configuracion\SysProductosModel;
    use App\Model\Administracion\Configuracion\SysFormasPagosModel;
    use App\Model\Administracion\Configuracion\SysMetodosPagosModel;

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
                ,'attr'      => 'data-live-search="true"'
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
                ,'event'     => 'display_contactos_edit()'
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
                "page_title"            => "Ventas"
                ,"title"                => "Facturacion"
                ,"cmb_estatus"          => $cmb_estatus
                ,"cmb_estatus_form"     => $cmb_estatus_form
                ,"cmb_estatus_form_edit"=> $cmb_estatus_form_edit
                ,"formas_pagos"         => $cmb_formas_pago
                ,"formas_pagos_edit"    => $cmb_formas_pago_edit
                ,"metodos_pagos"        => $cmb_metodos_pago
                ,"metodos_pagos_edit"   => $cmb_metodos_pago_edit
                ,"monedas"              => $cmb_monedas
                ,"monedas_edit"         => $cmb_monedas_edit
                ,"clientes"             => $cmb_clientes
                ,"clientes_edit"        => $cmb_clientes_edit
                ,"productos"            => $cmb_productos
                ,"productos_edit"       => $cmb_productos_edit
                ,"planes"               => $cmb_planes
                ,"planes_edit"          => $cmb_planes_edit
                ,"iva"                  => (Session::get('id_rol') != 1 )? Session::get('iva') : 16
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
                $response = $this->_tabla_model::with(['','',''])->get();

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