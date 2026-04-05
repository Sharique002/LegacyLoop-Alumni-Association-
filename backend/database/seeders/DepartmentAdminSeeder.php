<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DepartmentAdminSeeder extends Seeder
{
    /**
     * Create admin accounts for all departments with real person names.
     * Password: Department@123
     */
    public function run(): void
    {
        $password = Hash::make('Department@123');

        $departments = [
            [
                'email'           => 'raj.patel@legacyloop.in',
                'first_name'      => 'Raj',
                'last_name'       => 'Patel',
                'branch'          => 'CS',
                'degree'          => 'B.Tech',
                'graduation_year' => '2018',
                'enrollment_no'   => 'CS-DEPT-001',
                'job_title'       => 'Department Head - Computer Science',
                'current_company' => 'LegacyLoop',
                'industry'        => 'Education',
                'city'            => 'Bangalore',
                'country'         => 'India',
                'bio'             => 'Leading Computer Science Department Alumni Network',
                'is_admin'        => true,
            ],
            [
                'email'           => 'priya.sharma@legacyloop.in',
                'first_name'      => 'Priya',
                'last_name'       => 'Sharma',
                'branch'          => 'IT',
                'degree'          => 'B.Tech',
                'graduation_year' => '2019',
                'enrollment_no'   => 'IT-DEPT-001',
                'job_title'       => 'Department Head - Information Technology',
                'current_company' => 'LegacyLoop',
                'industry'        => 'Education',
                'city'            => 'Hyderabad',
                'country'         => 'India',
                'bio'             => 'Leading Information Technology Department Alumni Network',
                'is_admin'        => true,
            ],
            [
                'email'           => 'vikram.singh@legacyloop.in',
                'first_name'      => 'Vikram',
                'last_name'       => 'Singh',
                'branch'          => 'ME',
                'degree'          => 'B.Tech',
                'graduation_year' => '2017',
                'enrollment_no'   => 'ME-DEPT-001',
                'job_title'       => 'Department Head - Mechanical Engineering',
                'current_company' => 'LegacyLoop',
                'industry'        => 'Education',
                'city'            => 'Pune',
                'country'         => 'India',
                'bio'             => 'Leading Mechanical Engineering Department Alumni Network',
                'is_admin'        => true,
            ],
            [
                'email'           => 'anita.gupta@legacyloop.in',
                'first_name'      => 'Anita',
                'last_name'       => 'Gupta',
                'branch'          => 'CIVIL',
                'degree'          => 'B.Tech',
                'graduation_year' => '2016',
                'enrollment_no'   => 'CV-DEPT-001',
                'job_title'       => 'Department Head - Civil Engineering',
                'current_company' => 'LegacyLoop',
                'industry'        => 'Education',
                'city'            => 'Mumbai',
                'country'         => 'India',
                'bio'             => 'Leading Civil Engineering Department Alumni Network',
                'is_admin'        => true,
            ],
            [
                'email'           => 'suresh.mishra@legacyloop.in',
                'first_name'      => 'Suresh',
                'last_name'       => 'Mishra',
                'branch'          => 'EE',
                'degree'          => 'B.Tech',
                'graduation_year' => '2018',
                'enrollment_no'   => 'EE-DEPT-001',
                'job_title'       => 'Department Head - Electrical Engineering',
                'current_company' => 'LegacyLoop',
                'industry'        => 'Education',
                'city'            => 'Jaipur',
                'country'         => 'India',
                'bio'             => 'Leading Electrical Engineering Department Alumni Network',
                'is_admin'        => true,
            ],
            [
                'email'           => 'siddharth.rao@legacyloop.in',
                'first_name'      => 'Siddharth',
                'last_name'       => 'Rao',
                'branch'          => 'EC',
                'degree'          => 'B.Tech',
                'graduation_year' => '2017',
                'enrollment_no'   => 'EC-DEPT-001',
                'job_title'       => 'Department Head - Electronics Engineering',
                'current_company' => 'LegacyLoop',
                'industry'        => 'Education',
                'city'            => 'Bangalore',
                'country'         => 'India',
                'bio'             => 'Leading Electronics Engineering Department Alumni Network',
                'is_admin'        => true,
            ],
            [
                'email'           => 'gaurav.shah@legacyloop.in',
                'first_name'      => 'Gaurav',
                'last_name'       => 'Shah',
                'branch'          => 'CH',
                'degree'          => 'B.Tech',
                'graduation_year' => '2019',
                'enrollment_no'   => 'CH-DEPT-001',
                'job_title'       => 'Department Head - Chemical Engineering',
                'current_company' => 'LegacyLoop',
                'industry'        => 'Education',
                'city'            => 'Surat',
                'country'         => 'India',
                'bio'             => 'Leading Chemical Engineering Department Alumni Network',
                'is_admin'        => true,
            ],
        ];

        foreach ($departments as $data) {
            // Update if exists, otherwise create
            User::updateOrCreate(
                ['email' => $data['email']],
                array_merge($data, [
                    'password'                 => $password,
                    'is_active'                => true,
                    'experience_years'         => 5,
                    'is_profile_public'        => true,
                    'is_open_to_mentor'        => true,
                    'is_seeking_opportunities' => false,
                ])
            );
        }

        $this->command->info('✅ Department Admin accounts created/updated successfully!');
        $this->command->info('');
        $this->command->info('📧 DEPARTMENT ADMIN CREDENTIALS:');
        $this->command->info('─────────────────────────────────────────────────────────');
        $this->command->info('| Name                  | Email                      | Password       |');
        $this->command->info('─────────────────────────────────────────────────────────');
        $this->command->info('| Raj Patel             | raj.patel@legacyloop.in    | Department@123 |');
        $this->command->info('| Priya Sharma          | priya.sharma@legacyloop.in | Department@123 |');
        $this->command->info('| Vikram Singh          | vikram.singh@legacyloop.in | Department@123 |');
        $this->command->info('| Anita Gupta           | anita.gupta@legacyloop.in  | Department@123 |');
        $this->command->info('| Suresh Mishra         | suresh.mishra@legacyloop.in| Department@123 |');
        $this->command->info('| Siddharth Rao         | siddharth.rao@legacyloop.in| Department@123 |');
        $this->command->info('| Gaurav Shah           | gaurav.shah@legacyloop.in  | Department@123 |');
        $this->command->info('─────────────────────────────────────────────────────────');
        $this->command->info('');
        $this->command->info('✨ All accounts have admin privileges enabled.');
    }
}

