<?php

namespace App\Http\Controllers\Administracion\Configuracion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\SysUsersModel;
use App\Model\Administracion\Configuracion\SysSucursalesModel;
use App\Model\Administracion\Configuracion\SysEmpresasModel;
use App\Model\Administracion\Configuracion\SysEstadosModel;

class SucursalesController extends MasterController
{
    #se crea las propiedades
    private $_tabla_model;

    public function __construct(){
        parent::__construct();
        $this->_tabla_model = new SysSucursalesModel;
    }
    /**
     *Metodo para pintar la vista y cargar la informacion principal del menu
     *@access public
     *@return void
     */
     public function index(){
      if( Session::get('permisos')['GET'] ){ return view('errors.error'); }
           $data = [
             'page_title' 	     => "Configuracion"
             ,'title'  		       => "Sucursales"
             
           ];
            
         return self::_load_view( 'administracion.configuracion.sucursales', $data );

     }
      /**
         *Metodo para obtener los datos de manera asicronica.
         *@access public
         *@param Request $request [Description]
         *@return void
         */
        public function all( Request $request ){

            try {
                $response = $this->_tabla_model::get();

        // debuger($data);
        $data = [
          'sucursales'  => $response
        ];
              return $this->_message_success( 200, $data , self::$message_success );
            } catch (\Exception $e) {
                $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
                return $this->show_error(6, $error, self::$message_error );
            }

