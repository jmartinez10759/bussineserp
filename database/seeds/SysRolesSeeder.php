<?php

use Illuminate\Database\Seeder;

class SysRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['Administrador','Candidato','Admin'];
        $clave_corta = ['admin','cand','root'];

    	for ($i=0; $i < sizeof( $roles ) ; $i++) {

	        App\Model\Administracion\Configuracion\SysRolesModel::create([
	        	'perfil' 		     => $roles[$i]
		        ,'clave_corta'   => $clave_corta[$i]
		        ,'estatus'		   => 1
	        ]);

    	}
    }
}
