<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\MasterController;

use App\Model\Administracion\Configuracion\SysMenuModel;
use App\Model\Administracion\Configuracion\SysUsersModel;
use App\Model\Administracion\Configuracion\SysEmpresasModel;
use App\Model\Administracion\Configuracion\SysNotificacionesModel;


class ServicesController extends MasterController
{
    public function __construct(){
        parent::__construct();
    }

    public function services(){

    	try {
    		$response = SysUsersModel::with(['notificaciones','correos'])->whereId( Session::get('id') )->first();
	    	$correos  = $response->correos()->whereEstatus_recibidosAndEstatus_vistos(1,0)->orderBy('id','desc')->get();

    		if( Session::get('id_rol') != 1){
	    		$notification = $response->notificaciones()->orderBy('id','desc')->get();
			}else{
				$notification = SysNotificacionesModel::orderBy('id','desc')->get();
			}

	        
	        $data = [
	        	'notification' => $notification
	        	,'correos'	   => $correos 
	        ];
	    	//debuger($data);
        	return $this->_message_success( 200, $data , self::$message_success );
      	} catch (\Exception $e) {
            $error = $e->getMessage()." ".$e->getLine()." ".$e->getFile();
            return $this->show_error(6, $error, self::$message_error );
      	}


    }


}
