<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define Roles
        $roles = [
            'Admin',
            'Doctor',
            'Pathologist',
            'Radiologist',
            'Pharmacist',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Define Permissions
        $permissions = [
            // Doctor Permissions
            ['name' => 'prescribe_medicine', 'group_name' => 'doctor'],
            ['name' => 'view_patient_history', 'group_name' => 'doctor'],
            
            // Pathologist Permissions
            ['name' => 'view_lab_requests', 'group_name' => 'pathology'],
            ['name' => 'enter_lab_results', 'group_name' => 'pathology'],
            
            // Radiologist Permissions
            ['name' => 'view_radiology_requests', 'group_name' => 'radiology'],
            ['name' => 'upload_radiology_reports', 'group_name' => 'radiology'],
            ['name' => 'manage_radiology_results', 'group_name' => 'radiology'],
            
            // Pharmacist Permissions
            ['name' => 'view_prescriptions', 'group_name' => 'pharmacy'],
            ['name' => 'manage_pharmacy_stock', 'group_name' => 'pharmacy'],
            ['name' => 'dispense_medicine', 'group_name' => 'pharmacy'],
            
            // Admin Permissions
            ['name' => 'admin_access', 'group_name' => 'admin'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission['name']], ['group_name' => $permission['group_name']]);
        }

        // Assign Permissions to Roles
        
        // Admin
        $adminRole = Role::where('name', 'Admin')->first();
        $allPermissions = Permission::all();
        $adminRole->permissions()->sync($allPermissions);

        // Doctor
        $doctorRole = Role::where('name', 'Doctor')->first();
        $doctorPermissions = Permission::whereIn('name', [
            'prescribe_medicine',
            'view_patient_history',
            'view_radiology_requests', // Doctors might need to see results?
            'view_lab_requests', // Doctors might need to see results?
        ])->get();
        $doctorRole->permissions()->sync($doctorPermissions);

        // Pathologist
        $pathologistRole = Role::where('name', 'Pathologist')->first();
        $pathologistPermissions = Permission::whereIn('name', [
            'view_lab_requests',
            'enter_lab_results',
        ])->get();
        $pathologistRole->permissions()->sync($pathologistPermissions);

        // Radiologist
        $radiologistRole = Role::where('name', 'Radiologist')->first();
        $radiologistPermissions = Permission::whereIn('name', [
            'view_radiology_requests',
            'upload_radiology_reports',
            'manage_radiology_results',
        ])->get();
        $radiologistRole->permissions()->sync($radiologistPermissions);

        // Pharmacist
        $pharmacistRole = Role::where('name', 'Pharmacist')->first();
        $pharmacistPermissions = Permission::whereIn('name', [
            'view_prescriptions',
            'manage_pharmacy_stock',
            'dispense_medicine',
        ])->get();
        $pharmacistRole->permissions()->sync($pharmacistPermissions);
    }
}
