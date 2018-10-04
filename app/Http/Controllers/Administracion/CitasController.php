<?php

namespace App\Http\Controllers\Administracion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;

class CitasController extends MasterController
{
    public function __construct(){
        parent::__construct();
    }
    /**
     *Metodo para obtener la vista y cargar los datos
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public static function index(){

        debuger("llego");
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
        return message(true,$request->all(), '¡Se realizo la cita correctamente!');
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
     *@param $id [Description]
     *@return void
     */
    public static function destroy( $id ){


    }
}
