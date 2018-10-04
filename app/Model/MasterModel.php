<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MasterModel extends Model
{
	
	/**
	 *Metodo Model General para hacer consultas por medio de condiciones
	 *@access public 
	 *@param array $params [description]
	 *@param array $where [description] 
	 *@param object $clase [description] 
	 *@return object 
	 */
	public static function show_model( $params = [], $where= [], $clase= false, $orderby = [] ){
		
		$fields = ($orderby)? array_keys($orderby)[0] : false;
		$order = ($orderby)? array_values($orderby)[0] : false;
		
		if ( $where ) {
			if ( $params ) {
				if ($orderby) {
					$response = $clase::where( $where )->select( $params )->orderBy( $fields, $order )->get();
				 }else{
					$response = $clase::where( $where )->select( $params )->get();
				 }
			}else{ 
				if ($orderby) {
					$response = $clase::where( $where )->orderBy( $fields, $order )->get(); 
				}else{
					$response = $clase::where( $where )->get(); 
				}
			}

		}else{ 
			if ($orderby) {
				$response = $clase::all()->orderBy( $fields, $order );
			}else{
				$response = $clase::all();
			}
		}

		$result = [];
		$i = 0;
		foreach ($response as $respuesta) {

			if ($params) {

				foreach ($params as $key => $value) {
					$result[$i][$value] = $respuesta->$value;
				}

			}else{
				
				foreach ($clase->fillable as $key => $value) {
					$result[$i][$value] = $respuesta->$value;
				}

			}
			$i++;
		}
		return array_to_object( $result );

	}
	/**
	 *Inserccion de los datos con el metodo create, y regresa en formato json el registro ingresado
	 *@access public
	 *@param $data array [Description]
	 *@param $clase object [Descrption]
	 *@return object
	 */
	public static function create_model( $data = array(), $clase =false ){

		#se realiza la inserccion de los datos
		if ( $data ) {

			for ($i=0; $i < count($data); $i++) { 
				$clase::create( $data[$i] );
			}

		}
		$datos = $clase::latest()->limit( count($data) )->get();
		$response = data_march( $datos );
		return $response;

	}
	/**
	 *Metodo Model donde se hace la actualizacion de los datos, y regresa en formato json el registro actualziado
	 *@access public
	 *@param $where array [Description]
	 *@param $data array [Description]
	 *@param $clase object [Descrption]
	 *@return object
	 */
	public static function update_model( $where = array(), $data = array(), $clase =false ){
		
		$clase::where( $where )->update( $data );
		$response = self::show_model( [], $where, $clase );
		return $response;
	
	}
	/**
	 *Metodo Model donde se hace la eliminacion de los registros
	 *@access public
	 *@param $where array [Description]
	 *@param $clase object [Descrption]
	 *@return object
	 */
	public static function delete_model( $where = array(), $clase =false ){
		
		$clase::where( $where )->delete();
		$response = self::show_model( [], $where, $clase );
		return $response;

	}
	/**
	 *Inserccion de los datos con el metodo insert, y regresa en formato json el registro ingresado
	 *@access public
	 *@param $data array [Description]
	 *@param $clase object [Descrption]
	 *@return object
	 */
	public static function insert_model( $data = array(), $clase =false ){
		#se realiza la inserccion de los datos
		if ( $data ) {
			$lasted = [];
			for ($i=0; $i < count($data); $i++) { 
				$clase::insert( $data[$i] );
				$ultimo = self::show_model([],$data[$i], $clase );
				$latest = $ultimo;
			}

		}
		return $latest;
		

	}


}
