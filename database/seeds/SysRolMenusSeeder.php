<?php

use Illuminate\Database\Seeder;

class SysRolMenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus_admin = [1,2,3,4,5,7,8,9,10,11,12,13,14,15,16,17];
        $estatus_admin = [1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1];
        $menus = [1,2,10,11,12];
		    $estatus = [1,1,1,1,1];
        #$permiso = [1,2,3,4];
        for ($i=0; $i < count( $menus_admin ); $i++) {
  		     App\Model\Administracion\Configuracion\SysRolMenuModel::create([
  	        	'id_rol'		         => 1
  		        ,'id_users'		       => 1
  		        ,'id_empresa'        => 0
  		        ,'id_sucursal'       => 0
  		        ,'id_menu' 		       => $menus_admin[$i]
  		        ,'id_permiso' 	     => 7
  		        ,'estatus' 		       => 1
  		    ]);
        }

        for ($i=0; $i < count( $menus ); $i++) {
  		     App\Model\Administracion\Configuracion\SysRolMenuModel::create([
  	        	'id_rol'		         => 3
  		        ,'id_users'		       => 2
  		        ,'id_empresa'        => 0
  		        ,'id_sucursal'       => 0
  		        ,'id_menu' 		       => $menus[$i]
  		        ,'id_permiso' 	     => 5
  		        ,'estatus' 		       => 1
  		    ]);
        }




    }
}
