<?php
namespace App\Http\Controllers\Administracion\Configuracion;
use App\Facades\Upload;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysAccionesModel;
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
use App\Model\Ventas\SysFacturacionesModel;
use App\Model\Administracion\Configuracion\SysRegimenFiscalModel;
use App\Model\Administracion\Configuracion\SysUsoCfdiModel;
use App\Model\Administracion\Configuracion\SysTipoFactorModel;
use App\Model\Administracion\Configuracion\SysTasaModel;
use App\Model\Administracion\Configuracion\SysImpuestoModel;
use App\Model\Administracion\Configuracion\SysClaveProdServicioModel;
use App\Model\Administracion\Configuracion\SysPaisModel;
use App\Model\Administracion\Configuracion\SysCodigoPostalModel;
use App\Model\Administracion\Configuracion\SysServiciosComercialesModel;
use App\Model\Administracion\Configuracion\SysCategoriasProductosModel;
use App\Model\Development\SysProyectosModel;
use Symfony\Component\HttpFoundation\JsonResponse;


class UploadController extends MasterController
{

    /**
     * UploadController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->index();
    }

    /**
     *Metodo para obtener la vista y cargar los datos
     * @access public
     * @return void
     */
    public function index(){

        switch ( $this->show() ) {
                case "Roles":
                $this->_entity = new SysRolesModel;
            break;
                case 'Clientes':
                $this->_entity = new SysClientesModel;
            break;
                case 'Acciones':
                $this->_entity = new SysAccionesModel;
            break;
                case 'Empresas':
                $this->_entity = new SysEmpresasModel;
            break;
                case 'Estatus':
                $this->_entity = new SysEstatusModel;
            break;
                case 'Formaspagos':
                $this->_entity = new SysFormasPagosModel;
            break;
                case 'Menus':
                $this->_entity = new SysMenuModel;
            break;
                case 'Metodospagos':
                $this->_entity = new SysMetodosPagosModel;
            break;
                case 'Notificaciones':
                $this->_entity = new SysNotificacionesModel;
            break;
                case 'Productos':
                $this->_entity = new SysProductosModel;
            break;
                case 'Skills':
                $this->_entity = new SysSkillsModel;
            break;
                 case 'Sucursales':
                $this->_entity = new SysSucursalesModel;
            break;
                 case 'Usuarios':
                $this->_entity = new SysUsersModel;
            break;
                 case 'Conceptos':
                $this->_entity = new SysConceptosModel;
            break;
                 case 'Facturacion':
                $this->_entity = new SysFacturacionModel;
            break;
               case "Contactos": 
                $this->_entity = new SysContactosModel;
            break;
               case "Planes": 
                $this->_entity = new SysPlanesModel;
            break;
               case "Cuentas": 
                $this->_entity = new SysCuentasModel;
            break;
               case "Proveedores": 
                $this->_entity = new SysProveedoresModel;
            break;
               case "Pedidos": 
                $this->_entity = new SysPedidosModel;
            break;
               case "Monedas": 
                $this->_entity = new SysMonedasModel;
            break;
               case "Almacenes": 
                $this->_entity = new SysAlmacenesModel;
            break;
               case "Tiposcomprobantes": 
                $this->_entity = new SysTiposComprobantesModel;
            break;
               case "Unidadesmedidas": 
                $this->_entity = new SysUnidadesMedidasModel;
            break;
               case "Cotizacion": 
                $this->_entity = new SysCotizacionModel;
            break;
               case "Facturaciones": 
                $this->_entity = new SysFacturacionesModel;
            break;
               case "Regimenfiscal": 
                $this->_entity = new SysRegimenFiscalModel;
            break;
               case "Usocfdi": 
                $this->_entity = new SysUsoCfdiModel;
            break;
               case "Tipofactor": 
                $this->_entity = new SysTipoFactorModel;
            break;
               case "Tasa": 
                $this->_entity = new SysTasaModel;
            break;
               case "Impuesto": 
                $this->_entity = new SysImpuestoModel;
            break;
               case "Claveprodservicio": 
                $this->_entity = new SysClaveProdServicioModel;
            break;
               case "Pais": 
                $this->_entity = new SysPaisModel;
            break;
               case "Codigopostal": 
                $this->_entity = new SysCodigoPostalModel;
            break;
               case "Servicioscomerciales": 
                $this->_entity = new SysServiciosComercialesModel;
            break;
               case "Categoriasproductos": 
                $this->_entity = new SysCategoriasProductosModel;
            break;
               case "Proyectos": 
                $this->_entity = new SysProyectosModel;
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
     * Metodo subir los catalogos e insertar la informacion
     * @access public
     * @param Request $request [Description]
     * @return void
     */
     public function upload_catalogos( Request $request ){
         try { 
             $response = self::upload_file_catalogos(new Request( $request->all() ),false, $this->_entity);
             if($response->success == false){
                return $this->show_error(6, $response->result , $response->message );    
             }
             return $this->_message_success( 201, $response->result , $response->message );
         } catch (\Exception $e) {
             $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
             return $this->show_error(6, $error, self::$message_error );
         }

     }

    /**
     * This method make upload file to server
     * @access public
     * @param Request $request [Description]
     * @return JsonResponse
     */
     public function uploadsFiles( Request $request )
     {
         try {
             $path      = isset($request->ruta) ? $request->get("ruta") : "upload_file/files/";
             $base64    =  isset($request->base64) ? $request->get("base64") : false;
             $upload    = new Upload($path);
             $responseFile  = $upload->uploadFile( $request );

             if ($responseFile['success']){
                 return new JsonResponse([
                     'success'   => true
                     ,'data'     => $responseFile['path']
                     ,'message'  => self::$message_success
                 ],Response::HTTP_OK);
             }
             return new JsonResponse([
                 'success'   => false
                 ,'data'     => ""
                 ,'message'  => self::$message_error
             ],Response::HTTP_BAD_REQUEST);

         } catch (\Exception $e) {
             $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
             \Log::debug($error);
             return new JsonResponse([
                 'success'   => FALSE
                 ,'data'     => $error
                 ,'message'  => self::$message_error
             ],Response::HTTP_BAD_REQUEST);

         }

     }
    

}