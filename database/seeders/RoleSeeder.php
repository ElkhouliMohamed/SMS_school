<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Guardian;
use App\Models\Student;
use Carbon\Carbon;
use App\Models\SchoolClass;


class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'manage_users',
            'manage_classes',
            'manage_subjects',
            'manage_teachers',
            'manage_students',
            'manage_guardians',
            'manage_timetables',
            'manage_transports',
            'manage_grades',
            'manage_payments',
            'manage_documents',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles and assign permissions
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions($permissions);

        $teacher = Role::firstOrCreate(['name' => 'teacher', 'guard_name' => 'web']);
        $teacher->syncPermissions(['manage_timetables', 'manage_grades']);

        $accountant = Role::firstOrCreate(['name' => 'accountant', 'guard_name' => 'web']);
        $accountant->syncPermissions(['manage_payments']);

        $student = Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);

        $guardian = Role::firstOrCreate(['name' => 'guardian', 'guard_name' => 'web']);
        // You can give guardians read-only permissions if needed:
        $guardian->syncPermissions([]);

        // Create test users
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin User', 'password' => bcrypt('password123')]
        );
        $adminUser->assignRole('admin');

        $teacherUser = User::firstOrCreate(
            ['email' => 'teacher@example.com'],
            ['name' => 'Test Teacher', 'password' => bcrypt('password123')]
        );
        $teacherUser->assignRole('teacher');

        if (!$teacherUser->teacher) {
            Teacher::create([
                'user_id' => $teacherUser->id,
                'first_name' => 'Test',
                'last_name' => 'Teacher',
                'email' => $teacherUser->email,
            ]);
        }

        $accountantUser = User::firstOrCreate(
            ['email' => 'accountant@example.com'],
            ['name' => 'Test Accountant', 'password' => bcrypt('password123')]
        );
        $accountantUser->assignRole('accountant');

        $guardianUser = User::firstOrCreate(
            ['email' => 'guardian@example.com'],
            ['name' => 'Test Guardian', 'password' => bcrypt('password123')]
        );
        $guardianUser->assignRole('guardian');

        if (!$guardianUser->guardian) {
            Guardian::create([
                'user_id' => $guardianUser->id,
                'first_name' => 'Test',
                'last_name' => 'Guardian',
                'phone' => '0612345678',
                'address' => '123 Rue Example',
                'city' => 'Casablanca',
            ]);
        }
    }
}
