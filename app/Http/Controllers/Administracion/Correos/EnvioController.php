<?php

namespace App\Http\Controllers\Administracion\Correos;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Correos\SysEnviadosModel;

class EnvioController extends MasterController
{
    #se crea las propiedades
    private static $_tabla_model;

    public function __construct(){
        parent::__construct();
        self::$_tabla_model = new SysEnviadosModel;
    }
    /**
     *Metodo para obtener la vista y cargar los datos
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public static function index(){

        $data = self::page_mail();
        #debuger($data['correos']);
        return self::_load_view( 'administracion.correos.recibidos' ,$data);

    }
    /**
     *Metodo para realizar la consulta por medio de su id
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public static function show( Request $request ){


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

}
