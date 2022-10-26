<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name'=>'Arslan Majid',
            'email'=>'amhmultan@gmail.com',
            'password'=>bcrypt('superAdmin@1989')
        ]);

        $writer = User::create([
            'name'=>'Admin',
            'email'=>'admin@admin.com',
            'password'=>bcrypt('password')
        ]);


        $admin_role = Role::create(['name' => 'Arslan']);
        $writer_role = Role::create(['name' => 'admin']);

        // Modules permissions
        $permission = Permission::create(['name' => 'Configuration access']);
        $permission = Permission::create(['name' => 'Hospital access']);
        $permission = Permission::create(['name' => 'Pharmacy access']);
        $permission = Permission::create(['name' => 'Pathology lab access']);


        // Menus persmissions
        $permission = Permission::create(['name' => 'Post access']);
        $permission = Permission::create(['name' => 'Post edit']);
        $permission = Permission::create(['name' => 'Post create']);
        $permission = Permission::create(['name' => 'Post delete']);

        $permission = Permission::create(['name' => 'Role access']);
        $permission = Permission::create(['name' => 'Role edit']);
        $permission = Permission::create(['name' => 'Role create']);
        $permission = Permission::create(['name' => 'Role delete']);

        $permission = Permission::create(['name' => 'User access']);
        $permission = Permission::create(['name' => 'User edit']);
        $permission = Permission::create(['name' => 'User create']);
        $permission = Permission::create(['name' => 'User delete']);

        $permission = Permission::create(['name' => 'Permission access']);
        $permission = Permission::create(['name' => 'Permission edit']);
        $permission = Permission::create(['name' => 'Permission create']);
        $permission = Permission::create(['name' => 'Permission delete']);

        $permission = Permission::create(['name' => 'DoctorNotes access']);
        $permission = Permission::create(['name' => 'DoctorNotes add']);
        $permission = Permission::create(['name' => 'DoctorNotes edit']);
        $permission = Permission::create(['name' => 'DoctorNotes delete']);

        $permission = Permission::create(['name' => 'HospitalConfig access']);
        $permission = Permission::create(['name' => 'HospitalConfig create']);
        $permission = Permission::create(['name' => 'HospitalConfig edit']);
        $permission = Permission::create(['name' => 'HospitalConfig delete']);
        
        $permission = Permission::create(['name' => 'Manufacturer access']);
        $permission = Permission::create(['name' => 'Manufacturer add']);
        $permission = Permission::create(['name' => 'Manufacturer edit']);
        $permission = Permission::create(['name' => 'Manufacturer delete']);
        
        $permission = Permission::create(['name' => 'Patient access']);
        $permission = Permission::create(['name' => 'Patient create']);
        $permission = Permission::create(['name' => 'Patient edit']);
        $permission = Permission::create(['name' => 'Patient delete']);
        
        $permission = Permission::create(['name' => 'PathologyLabConfig access']);
        $permission = Permission::create(['name' => 'PathologyLabConfig new']);
        $permission = Permission::create(['name' => 'PathologyLabConfig edit']);
        $permission = Permission::create(['name' => 'PathologyLabConfig delete']);
        
        $permission = Permission::create(['name' => 'Product access']);
        $permission = Permission::create(['name' => 'Product create']);
        $permission = Permission::create(['name' => 'Product edit']);
        $permission = Permission::create(['name' => 'Product delete']);
        
        $permission = Permission::create(['name' => 'Supplier access']);
        $permission = Permission::create(['name' => 'Supplier add']);
        $permission = Permission::create(['name' => 'Supplier edit']);
        $permission = Permission::create(['name' => 'Supplier delete']);
        
        $permission = Permission::create(['name' => 'Token access']);
        $permission = Permission::create(['name' => 'Token add']);
        $permission = Permission::create(['name' => 'Token edit']);
        $permission = Permission::create(['name' => 'Token delete']);
        

        $admin->assignRole($admin_role);
        $writer->assignRole($writer_role);


        $admin_role->givePermissionTo(Permission::all());
    }
}
