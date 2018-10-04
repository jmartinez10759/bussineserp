<?php

use Illuminate\Database\Seeder;

class SysMenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
          'Dashboard'
          ,'Correos'
          ,'Configuracion'
          ,'Roles'
          ,'Menus'
          //,'Permisos'
          ,'Acciones'
          ,'Usuarios'
          ,'Perfil'
          ,'Recibidos'
          ,'Enviados'
          ,'Redactar'
          ,'Destacados'
          ,'Borradores'
          ,'Papelera'
          ,'Empresas'
          ,'Sucursales'
        ];
        $link = [
          'dashboard'
          ,''
          ,''
          ,'configuracion/roles'
          ,'configuracion/menus'
          //,'configuracion/permisos'
          ,'configuracion/actions'
          ,'configuracion/usuarios'
          ,'configuracion/perfiles'
          ,'correos/recibidos'
          ,'correos/envios'
          ,'correos/redactar'
          ,'correos/destacados'
          ,'correos/borradores'
          ,'correos/papelera'
          ,'configuracion/empresas'
          ,'configuracion/sucursales'
        ];
        $tipo = [
          'SIMPLE'
          ,'PADRE'
          ,'PADRE'
          ,'HIJO'
          ,'HIJO'
          //,'HIJO'
          ,'HIJO'
          ,'HIJO'
          ,'HIJO'
          ,'HIJO'
          ,'HIJO'
          ,'HIJO'
          ,'HIJO'
          ,'HIJO'
          ,'HIJO'
          ,'HIJO'
          ,'HIJO'
        ];
        $orden = [1,2,3,1,2,4,5,6,1,2,3,4,5,6,7,8];
        $icon = [
          'fa fa-home'
          ,'fa fa-envelope'
          ,'fa fa-cogs'
          ,''
          ,''
          #,''
          ,''
          ,''
          ,''
          ,''
          ,''
          ,''
          ,''
          ,''
          ,''
          ,''
          ,''
        ];
        $padre = [0,0,0,3,3,3,3,3,2,2,2,2,2,2,3,3];
        $estatus = [1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1];

    	for ($i=0; $i < sizeof( $menus ) ; $i++) {

	        App\Model\Administracion\Configuracion\SysMenuModel::create([
  		        'id_padre' 	=> $padre[$i]
  		        ,'texto' 	  => $menus[$i]
  		        ,'link' 	  => $link[$i]
  		        ,'tipo' 	  => $tipo[$i]
  		        ,'orden' 	  => $orden[$i]
  		        ,'estatus' 	=> 1
  		        ,'icon' 	  => $icon[$i]
	        ]);

    	}
    }
}
