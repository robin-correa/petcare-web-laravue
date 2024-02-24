<?php

namespace Database\Seeders\Admin;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'Dashboard']);
        Permission::create(['name' => 'ViewServices']);
        Permission::create(['name' => 'ViewService']);
        Permission::create(['name' => 'CreateService']);
        Permission::create(['name' => 'UpdateService']);
        Permission::create(['name' => 'DeleteService']);
        Permission::create(['name' => 'ViewSpecieTypes']);
        Permission::create(['name' => 'ViewSpecieType']);
        Permission::create(['name' => 'CreateSpecieType']);
        Permission::create(['name' => 'UpdateSpecieType']);
        Permission::create(['name' => 'DeleteSpecieType']);
        Permission::create(['name' => 'ViewVeterinarians']);
        Permission::create(['name' => 'CreateVeterinarian']);
        Permission::create(['name' => 'UpdateVeterinarian']);
        Permission::create(['name' => 'DeleteVeterinarian']);
        Permission::create(['name' => 'ViewPets']);
        Permission::create(['name' => 'ViewPet']);
        Permission::create(['name' => 'ViewOwnPets']);
        Permission::create(['name' => 'ViewOwnPet']);
        Permission::create(['name' => 'CreatePet']);
        Permission::create(['name' => 'UpdatePet']);
        Permission::create(['name' => 'UpdateOwnPet']);
        Permission::create(['name' => 'DeletePet']);
        Permission::create(['name' => 'DeleteOwnPet']);
        Permission::create(['name' => 'ViewAppointments']);
        Permission::create(['name' => 'ViewAppointment']);
        Permission::create(['name' => 'ViewOwnAppointments']);
        Permission::create(['name' => 'ViewOwnAppointment']);
        Permission::create(['name' => 'CreateAppointment']);
        Permission::create(['name' => 'UpdateAppointment']);
        Permission::create(['name' => 'UpdateOwnAppointment']);
        Permission::create(['name' => 'DeleteAppointment']);
        Permission::create(['name' => 'DeleteOwnAppointment']);
        Permission::create(['name' => 'ViewPayments']);
        Permission::create(['name' => 'ViewPayment']);
        Permission::create(['name' => 'ViewOwnPayments']);
        Permission::create(['name' => 'ViewOwnPayment']);
        Permission::create(['name' => 'CreatePayment']);
        Permission::create(['name' => 'UpdatePayment']);
        Permission::create(['name' => 'UpdateOwnPayment']);
        Permission::create(['name' => 'DeletePayment']);
        Permission::create(['name' => 'DeleteOwnPayment']);
        Permission::create(['name' => 'ViewUsers']);
        Permission::create(['name' => 'ViewUser']);
        Permission::create(['name' => 'ViewOwnUser']);
        Permission::create(['name' => 'CreateUser']);
        Permission::create(['name' => 'UpdateUser']);
        Permission::create(['name' => 'UpdateOwnUser']);
        Permission::create(['name' => 'DeleteUser']);
        Permission::create(['name' => 'ViewRoles']);
        Permission::create(['name' => 'ViewRole']);
        Permission::create(['name' => 'CreateRole']);
        Permission::create(['name' => 'UpdateRole']);
        Permission::create(['name' => 'DeleteRole']);

        // Roles
        Role::create(['name' => 'SuperAdmin']);
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Veterinarian']);
        Role::create(['name' => 'Customer']);
    }
}
