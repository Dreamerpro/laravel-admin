<?php

use Illuminate\Database\Seeder;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles=['admin','superadmin'];//admin seed needs to be changed if this array changed
        foreach ($roles as $key => $role) {
        	\App\Models\Admin\Role::firstOrCreate(['name'=>$role]);
        };
    }
}
