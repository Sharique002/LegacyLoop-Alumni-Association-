<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        $organizations = [
            [
                'name' => 'Indian Institute of Technology Delhi',
                'email' => 'alumni@iitd.ac.in',
                'password' => 'password123',
                'type' => 'university',
                'description' => 'Premier engineering institution in India',
                'website' => 'https://www.iitd.ac.in',
                'city' => 'New Delhi',
                'state' => 'Delhi',
                'country' => 'India',
                'is_verified' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Indian Institute of Technology Bombay',
                'email' => 'alumni@iitb.ac.in',
                'password' => 'password123',
                'type' => 'university',
                'description' => 'Leading technical university in Mumbai',
                'website' => 'https://www.iitb.ac.in',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
                'country' => 'India',
                'is_verified' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Delhi University',
                'email' => 'alumni@du.ac.in',
                'password' => 'password123',
                'type' => 'university',
                'description' => 'One of the largest universities in India',
                'website' => 'https://www.du.ac.in',
                'city' => 'New Delhi',
                'state' => 'Delhi',
                'country' => 'India',
                'is_verified' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Stanford University',
                'email' => 'alumni@stanford.edu',
                'password' => 'password123',
                'type' => 'university',
                'description' => 'Private research university in California',
                'website' => 'https://www.stanford.edu',
                'city' => 'Stanford',
                'state' => 'California',
                'country' => 'USA',
                'is_verified' => true,
                'is_active' => true,
            ],
            [
                'name' => 'MIT',
                'email' => 'alumni@mit.edu',
                'password' => 'password123',
                'type' => 'university',
                'description' => 'Massachusetts Institute of Technology',
                'website' => 'https://www.mit.edu',
                'city' => 'Cambridge',
                'state' => 'Massachusetts',
                'country' => 'USA',
                'is_verified' => true,
                'is_active' => true,
            ],
        ];

        foreach ($organizations as $org) {
            Organization::create($org);
        }
    }
}
