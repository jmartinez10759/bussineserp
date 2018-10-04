<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SysMenusSeeder::class);
        $this->call(SysPermisosSeeder::class);
        $this->call(SysRolesSeeder::class);
        $this->call(SysRolMenusSeeder::class);
        $this->call(SysUserSeeder::class);
        $this->call(SysEstadosSeeder::class);
        $this->call(SysUsersPermisosSeeder::class);
        $this->call(SysUsersRolesSeeder::class);
        $this->call(SysEmpresasSeeder::class);
        $this->call(SysSucursalesSeeder::class);

        $this->call(SysCategoriaProductoSeeder::class);
        $this->call(SysEstatusSeeder::class);
        $this->call(SysFormasPagosSeeder::class);
        $this->call(SysMetodosPagosSeeder::class);
        #$this->call(SysProductosSeeder::class);
        #$this->call(SysCorreosSeeder::class);

    }
}
