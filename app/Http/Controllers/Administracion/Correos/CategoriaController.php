<?php

namespace App\Http\Controllers\Administracion\Correos;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Correos\SysCategoriasModel;
use App\Model\Administracion\Correos\SysCategoriasCorreosModel;

class CategoriaController extends MasterController
{
    #se crea las propiedades
    private static $_tabla_model;

    public function __construct(){
        parent::__construct();
        self::$_tabla_model = new SysCategoriasModel;
    }
    /**
     *Metodo para obtener la vista y cargar los datos
     *@access public
     *@param Request $request [Description]
     *@return void
     */
    public static function index(){


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
        #se agrega la categoria en la tabla relacion
        $error = null;
        DB::beginTransaction();
        try {
          $data = [
            'categoria'     =>  $request->categoria
            ,'descripcion'  =>  $request->descripcion
            ,'id_users'     =>  Session::get('id')
          ];
          $response_store = SysCategoriasModel::create( $data );
          DB::commit();
          $success = true;
        } catch (\Exception $e) {
            $success = false;
            $error = $e->getMessage();
            DB::rollback();
        }

        if ($success) {
          return message(true,$response_store, self::$message_success );
        }
        return message(false,$error, self::$message_error );

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
       debuger($request->all());
        $where = ['id' => $id];
        $response_destroy = self::$_model::delete_model( $where, self::$_tabla_model );
        if (!$response_destroy) {
          return message( true,$response_destroy,self::$message_success );
        }
        return message( false,$response_destroy,self::$message_error );

     }

}
