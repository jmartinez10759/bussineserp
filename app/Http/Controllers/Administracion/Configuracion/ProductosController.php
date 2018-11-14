<?php
namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysTasaModel;
use App\Model\Administracion\Configuracion\SysImpuestoModel;
use App\Model\Administracion\Configuracion\SysEmpresasModel;
use App\Model\Administracion\Configuracion\SysProductosModel;
use App\Model\Administracion\Configuracion\SysTipoFactorModel;
use App\Model\Administracion\Configuracion\SysPlanesProductosModel;
use App\Model\Administracion\Configuracion\SysCategoriasProductosModel;
use App\Model\Administracion\Configuracion\SysUnidadesMedidasModel;

class ProductosController extends MasterController
{
    #se crea las propiedades
    private $_tabla_model;

    public function __construct(){
        parent::__construct();
        $this->_tabla_model = new SysProductosModel;
    }
    /**
    *Metodo para obtener la vista y cargar los datos
    *@access public
    *@param Request $request [Description]
    *@return void
    */
    public function index(){
        
        if( Session::get('permisos')['GET'] ){
            return view('errors.error');
        }

        /*$response = $this->_catalogos_bussines( $this->_tabla_model, [], [], ['id' => Session::get('id_empresa')] );
        $permisos = (Session::get('id_rol') == 1 || Session::get('permisos')['PER'] == false) ? 'style="display:block" ' : 'style="display:none" ';
        $registros = [];
        foreach ($response as $respuesta) {
            $id['id'] = $respuesta->id;
            $editar   = build_acciones_usuario($id,'v-edit_register','Editar','btn btn-primary','fa fa-edit');
            $borrar   = build_buttons(Session::get('permisos')['DEL'],'v-destroy_register('.$respuesta->id.')','Borrar','btn btn-danger','fa fa-trash','title="Borrar"');                
            $permiso = dropdown([
                 'data'      => SysEmpresasModel::where(['estatus' => 1])->groupby('id')->get()
                 ,'value'     => 'id'
                 ,'text'      => 'nombre_comercial'
                 ,'name'      => 'cmb_empresas_'. $respuesta->id
                 ,'class'     => 'form-control'
                 ,'selected'  => isset($respuesta->empresas[0] )? $respuesta->empresas[0]->id : 0
                 ,'leyenda'   => 'Seleccione Opcion'
                 ,'attr'      => 'data-live-search="true" '. $permisos
                 ,'event'     => 'display_sucursales('. $respuesta->id .')'
            ]);
            if( count($respuesta->empresas) > 0 || Session::get('id_rol') == 1){
                $registros[] = [
                     $respuesta->codigo
                    ,isset($respuesta->categoria->nombre)? $respuesta->categoria->nombre :""
                    ,isset($respuesta->unidades->nombre)? $respuesta->unidades->nombre :""
                    ,$respuesta->clave_unidad
                    ,$respuesta->nombre
                    , format_currency($respuesta->subtotal,2)
                    , format_currency($respuesta->total,2)                   
                    ,($respuesta->estatus == 1)?"ACTIVO":"BAJA"
                    ,$editar
                    ,$permiso
                    ,$borrar
                ];

            }

        }
        $titulos = ['Código','Categoria','Unidad de Medida','Clave','Producto', 'SubTotal','Total','Estatus','','','',''];
        $table = [
            'titulos' 		   => $titulos
            ,'registros' 	   => $registros
            ,'id' 			   => "datatable"
            ,'class'           => "fixed_header"
        ];*/

        $categorias = dropdown([
                'data'      => SysCategoriasProductosModel::where(['estatus' => 1])->get()
                ,'value'     => 'id'
                ,'text'      => 'nombre'
                ,'name'      => 'cmb_categorias'
                ,'class'     => 'form-control'
                ,'leyenda'   => 'Seleccione Opcion'
                ,'attr'      => 'data-live-search="true" '
        ]);

        $categorias_edit = dropdown([
                 'data'      => SysCategoriasProductosModel::where(['estatus' => 1])->get()
                 ,'value'     => 'id'
                 ,'text'      => 'nombre'
                 ,'name'      => 'cmb_categorias'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opcion'
                 ,'attr'      => 'data-live-search="true" '
           ]);

        $unidades = dropdown([
                 'data'      => SysUnidadesMedidasModel::where(['estatus' => 1])->get()
                 ,'value'     => 'id'
                 ,'text'      => 'clave nombre'
                 ,'name'      => 'cmb_unidades'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opcion'
                 ,'attr'      => 'data-live-search="true" '
           ]);

        $unidades_edit = dropdown([
                 'data'      => SysUnidadesMedidasModel::where(['estatus' => 1])->get()
                 ,'value'     => 'id'
                 ,'text'      => 'clave nombre'
                 ,'name'      => 'cmb_unidades_edit'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opcion'
                 ,'attr'      => 'data-live-search="true" '
           ]);
        $tasa = dropdown([
                 'data'      => SysTasaModel::get()
                 ,'value'     => 'id'
                 ,'text'      => 'clave valor_maximo'
                 ,'name'      => 'cmb_tasas'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opcion'
                 ,'attr'      => 'data-live-search="true" '
           ]);
        $tasa_edit = dropdown([
                 'data'      => SysTasaModel::get()
                 ,'value'     => 'id'
                 ,'text'      => 'clave valor_maximo'
                 ,'name'      => 'cmb_tasas_edit'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opcion'
                 ,'attr'      => 'data-live-search="true" '                 
           ]);

        $impuesto = dropdown([
                 'data'      => SysImpuestoModel::get()
                 ,'value'     => 'id'
                 ,'text'      => 'clave descripcion'
                 ,'name'      => 'cmb_impuestos'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opcion'
                 ,'attr'      => 'data-live-search="true" '                 
           ]);

        $impuesto_edit = dropdown([
                 'data'      => SysImpuestoModel::get()
                 ,'value'     => 'id'
                 ,'text'      => 'clave descripcion'
                 ,'name'      => 'cmb_impuestos_edit'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opcion'
                 ,'attr'      => 'data-live-search="true" '                 
           ]);
        $tipo_factor = dropdown([
                 'data'      => SysTipoFactorModel::get()
                 ,'value'     => 'id'
                 ,'text'      => 'clave descripcion'
                 ,'name'      => 'cmb_tipofactor'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opcion'
                 ,'attr'      => 'data-live-search="true" '                 
           ]);
        $tipo_factor_edit = dropdown([
                 'data'      => SysTipoFactorModel::get()
                 ,'value'     => 'id'
                 ,'text'      => 'clave descripcion'
                 ,'name'      => 'cmb_tipofactor_edit'
                 ,'class'     => 'form-control'
                 ,'leyenda'   => 'Seleccione Opcion'
                 ,'attr'      => 'data-live-search="true" '                 
           ]);

        $data = [
            'page_title' 	         => "Configuración"
            ,'title'  		         => "Productos"
            ,'data_table'  		     => "data_table(table)"
            ,'categorias'            => $categorias
            ,'categorias_edit'       => $categorias_edit
            ,'unidades'              => $unidades
            ,'unidades_edit'         => $unidades_edit
            ,'tasa'                  => $tasa
            ,'tasa_edit'             => $tasa_edit
            ,'impuesto'              => $impuesto
            ,'impuesto_edit'         => $impuesto_edit
            ,'tipo_factor'           => $tipo_factor
            ,'tipo_factor_edit'      => $tipo_factor_edit
        ];
        return self::_load_view( "administracion.configuracion.productos",$data );
    }
    /**
     *Metodo para obtener los datos de manera asicronica.
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function all( Request $request ){

        try {
           $response = $this->_catalogos_bussines( $this->_tabla_model, ['categorias','unidades'], [], ['id' => Session::get('id_empresa')] );
          return $this->_message_success( 200, $response , self::$message_success );
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
            $response = $this->_tabla_model::where(['id' => $request->id])->get();

        return $this->_message_success( 201, $response[0] , self::$message_success );
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
            $registros = [];
            foreach ($request->all() as $key => $value) {
                $registros[$key] = strtoupper($value);
            }
            $response = $this->_tabla_model::create( $registros );
            $data = [
                'id_empresa'      => Session::get('id_empresa')
                ,'id_sucursal'    => Session::get('id_sucursal')
                ,'id_plan'        => 0
                ,'id_producto'    => $response->id
            ];
            SysPlanesProductosModel::create($data);
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
            $registros = [];
            foreach ($request->all() as $key => $value) {
                $registros[$key] = strtoupper($value);
            }
            $response = $this->_tabla_model::where(['id' => $request->id])->update($registros);

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
            SysPlanesProductosModel::where(['id_producto' => $request->id])->delete();
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
    public function display_sucursales( Request $request ){
        #debuger($request->all());
        try {
            #$sucursales = [];
            $response = SysEmpresasModel::with(['sucursales' => function($query){
                return $query->where(['sys_sucursales.estatus' => 1, 'sys_empresas_sucursales.estatus' => 1])->groupby('id')->get();
            }])->where(['id' => $request->id_empresa])->get();
            $sucursales = SysPlanesProductosModel::select('id_sucursal')->where($request->all())->get();
            #se crea la tabla 
            $registros = [];
            foreach ($response[0]->sucursales as $respuesta) {
                $id['id'] = $respuesta->id;
                $icon = build_actions_icons($id, 'id_sucursal="' . $respuesta->id . '" ');
                $registros[] = [
                    $respuesta->codigo
                    ,$respuesta->sucursal
                    ,$respuesta->direccion
                    ,($respuesta->estatus == 1)?"ACTIVO":"BAJA"
                    ,$icon
                ];
            }

            $titulos = [ 'Codigo','Sucursal','Direccion', 'Estatus',''];
            $table = [
                'titulos' 		   => $titulos
                ,'registros' 	   => $registros
                ,'id' 			   => "sucursales"
                #,'class'           => "fixed_header"
            ];
            $data = [
                'tabla_sucursales' => data_table($table)
                ,'sucursales'   => $sucursales
            ];
            return $this->_message_success(201, $data, self::$message_success);
        } catch (\Exception $e) {
            $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
            return $this->show_error(6, $error, self::$message_error);
        }

    
    }
/**
 * Metodo para insertar los permisos de los productos
 * @access public
 * @param Request $request [Description]
 * @return void
 */
public function register_permisos(Request $request){

    $error = null;
    DB::beginTransaction();
    try {
        
        $response_producto = SysPlanesProductosModel::where([
            'id_empresa'   => Session::get('id_empresa')
            ,'id_sucursal' => Session::get('id_sucursal')
            #,'id_producto' => $request->id_producto 
            ] )->get();
        if( count($response_producto) > 0){
            SysPlanesProductosModel::where([
                'id_empresa'   => Session::get('id_empresa')
                ,'id_sucursal' => Session::get('id_sucursal')
                #,'id_producto' => $request->id_producto 
            ])->delete();
        }
        SysPlanesProductosModel::where([
             #'id_empresa'   => $request->id_empresa
            'id_producto'    => $request->id_producto 
            ])->delete();
        $response = [];
        for ($i=0; $i < count($request->matrix) ; $i++) { 
            $matrices = explode('|', $request->matrix[$i] );
            $id_sucursal = $matrices[0];
            #se realiza una consulta si existe un registro.
            $data = [
                'id_empresa'      => $request->id_empresa
                ,'id_sucursal'    => $id_sucursal
                ,'id_plan'        => 0
                ,'id_producto'    => $request->id_producto
            ];
            $response[] = SysPlanesProductosModel::create($data);
        }

        DB::commit();
        $success = true;
    } catch (\Exception $e) {
        $success = false;
        $error = $e->getMessage() . " " . $e->getLine() . " " . $e->getFile();
        DB::rollback();
    }

    if ($success) {
        return $this->_message_success(201, $response, self::$message_success);
    }
    return $this->show_error(6, $error, self::$message_error);


}



}