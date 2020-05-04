<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'administrator']);
        $role->givePermissionTo('users_manage');

        $stu_role = Role::create(['name' => 'student']);
        $stu_role->givePermissionTo('attend_exam');

        $proc_role = Role::create(['name' => 'proctor']);
        $proc_role->givePermissionTo('invigilation_manage');
        
    }
}
