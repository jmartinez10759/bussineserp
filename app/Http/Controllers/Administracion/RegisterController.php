<?php

namespace App\Http\Controllers\Administracion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;
use App\Model\Administracion\Configuracion\TblEstadosModel;

class RegisterController extends MasterController
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

    	#$response = TblMenuModel::orderBy('id','ASC')->get();
    	$response = ['registros' => 1,'registros' => 2];
         $registros = [];
         foreach ($response as $respuesta) {
           #$id['id'] = $respuesta->id;
           $id['id'] = 1;
           $correo = build_acciones_usuario($id,'v-correos','Correo','btn btn-warning','fa fa-envelope','title="Enviar correos"');
           $notas = build_acciones_usuario($id,'v-notas','Notas','btn btn-info','fa fa-edit','title="Generar Notas"');
           $citas = build_acciones_usuario($id,'v-citas','Citas','btn btn-primary','fa fa-calendar','title="Generar Citas"');
           $orden = build_acciones_usuario($id,'v-ordenes','Orden Compra','btn btn-success','fa fa-exchange','title="Generar Orden de Compra"');
           /*$registros[] = [
              $respuesta->id
             ,$respuesta->texto
             ,$respuesta->id_padre
             ,$respuesta->link
             ,$respuesta->tipo
             ,$respuesta->icon
             ,$respuesta->created_at
             ,$respuesta->orden
             ,($respuesta->estatus == 1)?"ACTIVO":"BAJA"
             ,$correo
             ,$notas
             ,$citas
             ,$orden
           ];*/
           $registros[] = [
                'id'
	            ,'Nombre Completo'
	            ,'Correo'
	            ,'Telefono'
	            ,'Marca Auto'
	            ,'Modelo'
	            ,'Descripcion'
             	,$correo
             	,$notas
             	,$citas
             	,$orden
           ];

         }

         $titulos = [
           'id'
           ,'Nombre Completo'
           ,'Correo'
           ,'Telefono'
           ,'Marca Auto'
           ,'Modelo'
           ,'Descripcion'
           ,''
           ,''
           ,''
           ,''
         ];
         $table = [
           'titulos' 		=> $titulos
           ,'registros' 	=> $registros
           ,'id' 			=> "datatable"
         ];

         $estados = dropdown([
           'data'       => TblEstadosModel::all()
           ,'value'     => 'id'
           ,'text'      => 'nombre'
           ,'name'      => 'cmb_estados'
           ,'class'     => 'form-control'
           ,'leyenda'   => 'Seleccione Opcion'
           //,'event'     => 'v-change_usuario()'
           ,'attr'      => 'v-model="newKeep.id_estate" '
         ]);

         $data = [
      			'page_title' 	      	=> "Correos"
      			,'title'  		      	=> "Inbox"
      			,'subtitle' 	      	=> "Recibidos"
      			,'data_table'  	    	=>  data_table($table)
      			,'select_estados'  	  =>  $estados
      			,'titulo_modal'     	=> "Envio de Correo"
      			,'titulo_modal_notas' => "Crear Notas"
      			,'titulo_modal_citas' => "Agendar Cita"
      			,'titulo_modal_ordenes' => "Generar Orden"
      			,'titulo_modal_edit'	=> "Actualizar Registros"
      			,'campo_1' 		      	=> 'Titulo Nota'
      			,'campo_2' 		      	=> 'Asunto Nota'
      			,'campo_3' 		      	=> 'Descripcion Nota'
      			,'campo_4' 		      	=> 'Nombre Completo'
      			,'campo_5' 		      	=> 'Correo'
      			,'campo_6' 		      	=> 'Estado'
      			,'campo_7' 		      	=> 'Fecha Cita'
      			,'campo_8' 		      	=> 'Horario'
      			,'campo_9' 		      	=> 'Asunto Cita'
      		];
          #debuger($data);
        return self::_load_view('administracion.inbox',$data);
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
     *@param $id [Description]
     *@return void
     */
    public static function destroy( $id ){


    }
}
