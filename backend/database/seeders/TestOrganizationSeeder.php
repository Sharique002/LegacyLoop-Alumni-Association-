<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organization;
use Illuminate\Support\Facades\Hash;

class TestOrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        echo "Creating test organization...\n";
        
        $org = Organization::updateOrCreate(
            ['email' => 'test@university.edu'],
            [
                'name' => 'Test University',
                'password' => 'password123', // Will be hashed by mutator
                'type' => 'university',
                'is_verified' => true,
                'is_active' => true,
                'description' => 'Test university for development',
                'website' => 'https://test-university.edu',
                'city' => 'Test City',
                'state' => 'Test State',
                'country' => 'Test Country',
                'contact_phone' => '+1234567890',
                'contact_email' => 'contact@university.edu',
            ]
        );
        
        echo "✓ Organization created successfully!\n";
        echo "  Email: test@university.edu\n";
        echo "  Password: password123\n";
        echo "  ID: {$org->id}\n";
        echo "  Verified: " . ($org->is_verified ? 'Yes' : 'No') . "\n";
        echo "\nYou can now login at: http://localhost/organization/login\n";
    }
}
