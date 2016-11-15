<?php

use Illuminate\Database\Seeder;

class AdminSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins=[
        	[
        		'name'=>'admin',
        		'email'=>'admin@admin.com',
        		'password'=>bcrypt('password')
        	]
        ];
        foreach($admins as $key=>$admin)
        {
        	$user=\App\User::firstOrCreate($admin);
        	$user->roles()->attach(1);//1 is admin id by default
        };
    }
}
