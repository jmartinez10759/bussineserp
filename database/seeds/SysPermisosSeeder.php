<?php

use Illuminate\Database\Seeder;

class SysPermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $clave = ['UPD','INS','DEL','GET','EMAIL','PDF','EXL','UPL','UPLF','PER','AGR'];
    	 $descripcion = ['update','insert','destroy','select','correos','pdf','excel','upload','upload excel','asignar permisos','modal agregar'];
      	for ($i=0; $i < sizeof( $clave ); $i++) {

  	        App\Model\Administracion\Configuracion\SysAccionesModel::create([
  	        	'clave_corta' 	=> $clave[$i]
          		,'descripcion'	=> $descripcion[$i]
          		,'estatus'	    => 1
  	        ]);

      	}
    }
}
