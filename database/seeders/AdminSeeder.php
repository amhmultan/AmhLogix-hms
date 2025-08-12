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
        
        // General Menus persmissions
        $permission = Permission::create(['name' => 'Post access']);
        $permission = Permission::create(['name' => 'Post edit']);
        $permission = Permission::create(['name' => 'Post create']);
        $permission = Permission::create(['name' => 'Post delete']);

        // Users Menu persmissions
        $permission = Permission::create(['name' => 'UserMenu access']);
        $permission = Permission::create(['name' => 'User access']);
        $permission = Permission::create(['name' => 'User edit']);
        $permission = Permission::create(['name' => 'User create']);
        $permission = Permission::create(['name' => 'User delete']);

        $permission = Permission::create(['name' => 'Role access']);
        $permission = Permission::create(['name' => 'Role edit']);
        $permission = Permission::create(['name' => 'Role create']);
        $permission = Permission::create(['name' => 'Role delete']);

        $permission = Permission::create(['name' => 'Permission access']);
        $permission = Permission::create(['name' => 'Permission edit']);
        $permission = Permission::create(['name' => 'Permission create']);
        $permission = Permission::create(['name' => 'Permission delete']);

        // Configuration Menu permissions
        $permission = Permission::create(['name' => 'Configuration access']);
        $permission = Permission::create(['name' => 'HospitalConfig access']);
        $permission = Permission::create(['name' => 'HospitalConfig create']);
        $permission = Permission::create(['name' => 'HospitalConfig edit']);
        $permission = Permission::create(['name' => 'HospitalConfig delete']);
        
        $permission = Permission::create(['name' => 'PharmacyConfig access']);
        $permission = Permission::create(['name' => 'PharmacyConfig add']);
        $permission = Permission::create(['name' => 'PharmacyConfig edit']);
        $permission = Permission::create(['name' => 'PharmacyConfig delete']);
        
        // Hospital Menus persmissions
        $permission = Permission::create(['name' => 'Hospital access']);
        $permission = Permission::create(['name' => 'Speciality access']);
        $permission = Permission::create(['name' => 'Speciality create']);
        $permission = Permission::create(['name' => 'Speciality edit']);
        $permission = Permission::create(['name' => 'Speciality delete']);
        
        $permission = Permission::create(['name' => 'Doctor access']);
        $permission = Permission::create(['name' => 'Doctor create']);
        $permission = Permission::create(['name' => 'Doctor edit']);
        $permission = Permission::create(['name' => 'Doctor delete']);
        
        $permission = Permission::create(['name' => 'Appointment access']);
        $permission = Permission::create(['name' => 'Appointment create']);
        $permission = Permission::create(['name' => 'Appointment edit']);
        $permission = Permission::create(['name' => 'Appointment delete']);

        $permission = Permission::create(['name' => 'Patient access']);
        $permission = Permission::create(['name' => 'Patient create']);
        $permission = Permission::create(['name' => 'Patient edit']);
        $permission = Permission::create(['name' => 'Patient delete']);
        
        $permission = Permission::create(['name' => 'Token access']);
        $permission = Permission::create(['name' => 'Token add']);
        $permission = Permission::create(['name' => 'Token edit']);
        $permission = Permission::create(['name' => 'Token delete']);

        $permission = Permission::create(['name' => 'DoctorNotes access']);
        $permission = Permission::create(['name' => 'DoctorNotes add']);
        $permission = Permission::create(['name' => 'DoctorNotes edit']);
        $permission = Permission::create(['name' => 'DoctorNotes delete']);
        
        // Pharmacy Menus persmissions
        $permission = Permission::create(['name' => 'Pharmacy access']);
        $permission = Permission::create(['name' => 'Manufacturer access']);
        $permission = Permission::create(['name' => 'Manufacturer add']);
        $permission = Permission::create(['name' => 'Manufacturer edit']);
        $permission = Permission::create(['name' => 'Manufacturer delete']);

        $permission = Permission::create(['name' => 'Supplier access']);
        $permission = Permission::create(['name' => 'Supplier add']);
        $permission = Permission::create(['name' => 'Supplier edit']);
        $permission = Permission::create(['name' => 'Supplier delete']);
        
        $permission = Permission::create(['name' => 'Product access']);
        $permission = Permission::create(['name' => 'Product create']);
        $permission = Permission::create(['name' => 'Product edit']);
        $permission = Permission::create(['name' => 'Product delete']);

        $permission = Permission::create(['name' => 'Purchase access']);
        $permission = Permission::create(['name' => 'Purchase create']);
        $permission = Permission::create(['name' => 'Purchase edit']);
        $permission = Permission::create(['name' => 'Purchase delete']);
        
        $permission = Permission::create(['name' => 'Sale access']);
        $permission = Permission::create(['name' => 'Sale add']);
        $permission = Permission::create(['name' => 'Sale edit']);
        $permission = Permission::create(['name' => 'Sale delete']);
        // Stock Report permissions
        $permission = Permission::create(['name' => 'Report access']);

        // Token Report permissions
        $permission = Permission::create(['name' => 'TokenReport access']);
        $permission = Permission::create(['name' => 'TokenReport add']);
        $permission = Permission::create(['name' => 'TokenReport edit']);
        $permission = Permission::create(['name' => 'TokenReport delete']);

        $permission = Permission::create(['name' => 'Backup access']);
        $permission = Permission::create(['name' => 'Backup create']);
        $permission = Permission::create(['name' => 'Backup download']);
        $permission = Permission::create(['name' => 'Backup delete']);
        $permission = Permission::create(['name' => 'Backup restore']);

        $admin->assignRole($admin_role);
        $writer->assignRole($writer_role);

        $admin_role->givePermissionTo(Permission::all());
        
    }
}
