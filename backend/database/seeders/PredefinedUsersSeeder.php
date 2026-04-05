<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class PredefinedUsersSeeder extends Seeder
{
    /**
     * Create predefined users for each department for easy testing.
     * All passwords: LegacyLoop@123
     * All emails end with @legacyloop.in
     */
    public function run(): void
    {
        // Note: Do NOT use Hash::make() here - the User model's setPasswordAttribute 
        // mutator automatically hashes passwords with bcrypt()

        // Create the main test user (john@legacyloop.in)
        User::updateOrCreate(
            ['email' => 'john@legacyloop.in'],
            [
                'password'                 => 'John123',  // Plain password - mutator will hash it
                'first_name'               => 'John',
                'last_name'                => 'Doe',
                'branch'                   => 'CS',
                'degree'                   => 'B.Tech',
                'graduation_year'          => '2020',
                'enrollment_no'            => 'CS2020001',
                'current_company'          => 'TechCorp',
                'job_title'                => 'Software Developer',
                'industry'                 => 'Technology',
                'city'                     => 'Mumbai',
                'country'                  => 'India',
                'bio'                      => 'Computer Science Alumni - Full Stack Developer',
                'is_admin'                 => false,
                'is_active'                => true,
                'experience_years'         => 5,
                'is_profile_public'        => true,
                'is_open_to_mentor'        => true,
                'is_seeking_opportunities' => false,
            ]
        );

        $users = [
            // Computer Science Department Users
            [
                'email'           => 'student.cs@legacyloop.in',
                'first_name'      => 'Arjun',
                'last_name'       => 'Sharma',
                'branch'          => 'CS',
                'degree'          => 'B.Tech',
                'graduation_year' => '2022',
                'enrollment_no'   => 'CS2022001',
                'current_company' => 'Google',
                'job_title'       => 'Software Engineer',
                'industry'        => 'Technology',
                'city'            => 'Bangalore',
                'country'         => 'India',
                'bio'             => 'Computer Science Alumni - Full Stack Developer',
                'is_admin'        => false,
            ],
            // Information Technology Department Users
            [
                'email'           => 'student.it@legacyloop.in',
                'first_name'      => 'Sneha',
                'last_name'       => 'Patel',
                'branch'          => 'IT',
                'degree'          => 'B.Tech',
                'graduation_year' => '2021',
                'enrollment_no'   => 'IT2021001',
                'current_company' => 'Amazon',
                'job_title'       => 'Cloud Engineer',
                'industry'        => 'Technology',
                'city'            => 'Mumbai',
                'country'         => 'India',
                'bio'             => 'Information Technology Alumni - AWS Specialist',
                'is_admin'        => false,
            ],
            // Mechanical Engineering Department Users
            [
                'email'           => 'student.me@legacyloop.in',
                'first_name'      => 'Rahul',
                'last_name'       => 'Kumar',
                'branch'          => 'ME',
                'degree'          => 'B.Tech',
                'graduation_year' => '2020',
                'enrollment_no'   => 'ME2020001',
                'current_company' => 'Tata Motors',
                'job_title'       => 'Design Engineer',
                'industry'        => 'Automotive',
                'city'            => 'Pune',
                'country'         => 'India',
                'bio'             => 'Mechanical Engineering Alumni - CAD/CAM Expert',
                'is_admin'        => false,
            ],
            // Civil Engineering Department Users
            [
                'email'           => 'student.civil@legacyloop.in',
                'first_name'      => 'Suresh',
                'last_name'       => 'Gupta',
                'branch'          => 'CIVIL',
                'degree'          => 'B.Tech',
                'graduation_year' => '2020',
                'enrollment_no'   => 'CV2020001',
                'current_company' => 'L&T Construction',
                'job_title'       => 'Site Engineer',
                'industry'        => 'Construction',
                'city'            => 'Ahmedabad',
                'country'         => 'India',
                'bio'             => 'Civil Engineering Alumni - Infrastructure Developer',
                'is_admin'        => false,
            ],
            // Electrical Engineering Department Users
            [
                'email'           => 'student.ee@legacyloop.in',
                'first_name'      => 'Neha',
                'last_name'       => 'Mishra',
                'branch'          => 'EE',
                'degree'          => 'B.Tech',
                'graduation_year' => '2021',
                'enrollment_no'   => 'EE2021001',
                'current_company' => 'Siemens',
                'job_title'       => 'Electrical Engineer',
                'industry'        => 'Energy',
                'city'            => 'Jaipur',
                'country'         => 'India',
                'bio'             => 'Electrical Engineering Alumni - Power Systems Expert',
                'is_admin'        => false,
            ],
            // Electronics Engineering Department Users
            [
                'email'           => 'student.ec@legacyloop.in',
                'first_name'      => 'Siddharth',
                'last_name'       => 'Rao',
                'branch'          => 'EC',
                'degree'          => 'B.Tech',
                'graduation_year' => '2021',
                'enrollment_no'   => 'EC2021001',
                'current_company' => 'Qualcomm',
                'job_title'       => 'VLSI Engineer',
                'industry'        => 'Semiconductor',
                'city'            => 'Bangalore',
                'country'         => 'India',
                'bio'             => 'Electronics Engineering Alumni - VLSI Specialist',
                'is_admin'        => false,
            ],
            // Chemical Engineering Department Users
            [
                'email'           => 'student.ch@legacyloop.in',
                'first_name'      => 'Ritu',
                'last_name'       => 'Agarwal',
                'branch'          => 'CH',
                'degree'          => 'B.Tech',
                'graduation_year' => '2021',
                'enrollment_no'   => 'CH2021001',
                'current_company' => 'Reliance Industries',
                'job_title'       => 'Process Engineer',
                'industry'        => 'Petrochemical',
                'city'            => 'Jamnagar',
                'country'         => 'India',
                'bio'             => 'Chemical Engineering Alumni - Process Optimization Expert',
                'is_admin'        => false,
            ],
        ];

        foreach ($users as $data) {
            // Update if exists, otherwise create
            User::updateOrCreate(
                ['email' => $data['email']],
                array_merge($data, [
                    'password'                 => 'LegacyLoop@123',  // Plain password - mutator will hash it
                    'is_active'                => true,
                    'experience_years'         => 3,
                    'is_profile_public'        => true,
                    'is_open_to_mentor'        => true,
                    'is_seeking_opportunities' => false,
                ])
            );
        }

        $this->command->info('✅ Predefined Users created/updated successfully!');
        $this->command->info('');
        $this->command->info('📧 TEST LOGIN CREDENTIALS:');
        $this->command->info('═══════════════════════════════════════════════════════════');
        $this->command->info('| Email                      | Password       | Department              |');
        $this->command->info('═══════════════════════════════════════════════════════════');
        $this->command->info('| john@legacyloop.in         | John123        | Computer Science        |');
        $this->command->info('| student.cs@legacyloop.in   | LegacyLoop@123 | Computer Science        |');
        $this->command->info('| student.it@legacyloop.in   | LegacyLoop@123 | Information Technology  |');
        $this->command->info('| student.me@legacyloop.in   | LegacyLoop@123 | Mechanical Engineering  |');
        $this->command->info('| student.civil@legacyloop.in| LegacyLoop@123 | Civil Engineering       |');
        $this->command->info('| student.ee@legacyloop.in   | LegacyLoop@123 | Electrical Engineering  |');
        $this->command->info('| student.ec@legacyloop.in   | LegacyLoop@123 | Electronics Engineering |');
        $this->command->info('| student.ch@legacyloop.in   | LegacyLoop@123 | Chemical Engineering    |');
        $this->command->info('═══════════════════════════════════════════════════════════');
        $this->command->info('');
        $this->command->info('🌐 Test URL: http://localhost:8000/login');
    }
}
