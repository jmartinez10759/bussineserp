<?php
namespace App\Http\Controllers\Administracion\Configuracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysAccionesModel;
use App\Model\Administracion\Configuracion\SysCategoriasProductosModel;
use App\Model\Administracion\Configuracion\SysClientesModel;
use App\Model\Administracion\Configuracion\SysEmpresasModel;
use App\Model\Administracion\Configuracion\SysEmpresasSecursalesModel;
use App\Model\Administracion\Configuracion\SysEstadosModel;
use App\Model\Administracion\Configuracion\SysEstatusModel;
use App\Model\Administracion\Configuracion\SysFormasPagosModel;
use App\Model\Administracion\Configuracion\SysMenuModel;
use App\Model\Administracion\Configuracion\SysMetodosPagosModel;
use App\Model\Administracion\Configuracion\SysNotificacionesModel;
use App\Model\Administracion\Configuracion\SysPerfilUsersModel;
use App\Model\Administracion\Configuracion\SysProductosModel;
use App\Model\Administracion\Configuracion\SysRolesModel;
use App\Model\Administracion\Configuracion\SysRolesNotificacionesModel;
use App\Model\Administracion\Configuracion\SysRolMenuModel;
use App\Model\Administracion\Configuracion\SysSesionesModel;
use App\Model\Administracion\Configuracion\SysSkillsModel;
use App\Model\Administracion\Configuracion\SysSucursalesModel;
use App\Model\Administracion\Configuracion\SysUsersModel;
use App\Model\Administracion\Configuracion\SysUsersPermisosModel;
use App\Model\Administracion\Configuracion\SysUsersRolesModel;
use App\Model\Administracion\Configuracion\SysCuentasModel;
use App\Model\Administracion\Configuracion\SysCuentasEmpresasModel;
#facturacion
use App\Model\Administracion\Facturacion\SysConceptosModel;
use App\Model\Administracion\Facturacion\SysFacturacionModel;
use App\Model\Administracion\Facturacion\SysParcialidadesFechasModel;
use App\Model\Administracion\Facturacion\SysUsersFacturacionModel;
#development
use App\Model\Development\SysAtencionesModel;
use App\Model\Administracion\Configuracion\SysContactosModel;
use App\Model\Administracion\Configuracion\SysProveedoresModel;
use App\Model\Ventas\SysPedidosModel;
use App\Model\Administracion\Configuracion\SysPlanesModel;
use App\Model\Administracion\Configuracion\SysMonedasModel;
use App\Model\Almacenes\SysAlmacenesModel;
use App\Model\Administracion\Configuracion\SysTiposComprobantesModel;
use App\Model\Administracion\Configuracion\SysUnidadesMedidasModel;
use App\Model\Ventas\SysCotizacionModel;
use App\Model\Admnistracion\Configuracion\SysCuentasModel;
use App\Model\Administracion\Configuracion\SysCuentasModel;

















class UploadController extends MasterController
{
    #se crea las propiedades
    public $_tabla_model;

    public function __construct(){
        parent::__construct();
        $this->index();
    }
    /**
     *Metodo para obtener la vista y cargar los datos
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public function index(){

        switch ( $this->show() ) {
                case "Roles":
                $this->_tabla_model = new SysRolesModel;
            break;
                case 'Clientes':
                $this->_tabla_model = new SysClientesModel;
            break;
                case 'Acciones':
                $this->_tabla_model = new SysAccionesModel;
            break;
                case 'Empresas':
                $this->_tabla_model = new SysEmpresasModel;
            break;
                case 'Estatus':
                $this->_tabla_model = new SysEstatusModel;
            break;
                case 'Formaspagos':
                $this->_tabla_model = new SysFormasPagosModel;
            break;
                case 'Menus':
                $this->_tabla_model = new SysMenuModel;
            break;
                case 'Metodospagos':
                $this->_tabla_model = new SysMetodosPagosModel;
            break;
                case 'Notificaciones':
                $this->_tabla_model = new SysNotificacionesModel;
            break;
                case 'Productos':
                $this->_tabla_model = new SysProductosModel;
            break;
                case 'Skills':
                $this->_tabla_model = new SysSkillsModel;
            break;
                 case 'Sucursales':
                $this->_tabla_model = new SysSucursalesModel;
            break;
                 case 'Usuarios':
                $this->_tabla_model = new SysUsersModel;
            break;
                 case 'Conceptos':
                $this->_tabla_model = new SysConceptosModel;
            break;
                 case 'Facturacion':
                $this->_tabla_model = new SysFacturacionModel;
            break;
               case "Contactos": 
                $this->_tabla_model = new SysContactosModel; 
            break;
               case "Planes": 
                $this->_tabla_model = new SysPlanesModel; 
            break;
               case "Cuentas": 
                $this->_tabla_model = new SysCuentasModel; 
            break;
               case "Productos": 
                $this->_tabla_model = new SysProductosModel; 
            break;
               case "Proveedores": 
                $this->_tabla_model = new SysProveedoresModel; 
            break;
               case "Pedidos": 
                $this->_tabla_model = new SysPedidosModel; 
            break;
               case "Monedas": 
                $this->_tabla_model = new SysMonedasModel; 
            break;
               case "Almacenes": 
                $this->_tabla_model = new SysAlmacenesModel; 
            break;
               case "Tiposcomprobantes": 
                $this->_tabla_model = new SysTiposComprobantesModel; 
            break;
               case "Unidadesmedidas": 
                $this->_tabla_model = new SysUnidadesMedidasModel; 
            break;
               case "Cotizacion": 
                $this->_tabla_model = new SysCotizacionModel; 
            break;
               case "Cuentas": 
                $this->_tabla_model = new SysCuentasModel; 
            break;
               case "Cuentas": 
                $this->_tabla_model = new SysCuentasModel; 
            break;






        }
        
    }
    /**
     *Metodo para realizar la consulta por medio de su id
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public static function show(){
        
        $urls = explode("/",parse_domain()->urls);
         if( count($urls) > 2){
             $modelo = ucwords($urls[2]);
         }
         if( count($urls) > 1 && count($urls) < 2){
             $modelo = ucwords($urls[1]);
         }
        return $modelo;

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
     * Metodo subir los catalogos e insertar la informacion
     * @access public
     * @param Request $request [Description]
     * @return void
     */
     public function upload_catalogos( Request $request ){
         try { 
             $response = self::upload_file_catalogos(new Request( $request->all() ),false, $this->_tabla_model);
             if($response->success == false){
                return $this->show_error(6, $response->result , $response->message );    
             }
             return $this->_message_success( 201, $response->result , $response->message );
         } catch (\Exception $e) {
             $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
             return $this->show_error(6, $error, self::$message_error );
         }

     }

    
    
    

}