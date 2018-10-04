<?php

namespace App\Http\Controllers\Administracion\Correos;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\TblEstadosModel;
use App\Model\Administracion\Correos\SysCategoriasCorreosModel;

class RecibidoController extends MasterController
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
          debuger(Session::all());
           $data = [
              'page_title' 	      	=> "Correos"
              ,'title'  		      	=> "Recibidos"
              ,'subtitle' 	      	=> "Recibidos"
            ];
            debuger($data);
          return self::_load_view('administracion.correos.recibidos',$data);

      }
      /**
       *Metodo para realizar la consulta por medio de su id
       *@access public
       *@param Request $request [Description]
       *@return void
       */
      public static function show( Request $request ){

          debuger(Session::all());
          $where = [
            'id_users'      => Session::get('id')
            ,'id_sucursal'  => Session::get('id_sucursal')
            ,'id_empresa'   => Session::get('id_empresa')
          ];
          $response = SysCategoriasCorreosModel::where( $where )->orderBy('created_at','ASC')->get();
          if ($response) {
              return message(true, $response, "Tiene Correos en su bandeja de Entrada");
          }else{
            return message(true, $response, "¡No Tiene ningun correo en su bandeja de entrada.!");
          }


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
       *@param $id [Description]
       *@return void
       */
      public static function destroy( $id ){


      }
  }
