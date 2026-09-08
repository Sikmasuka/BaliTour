<?php

namespace Database\Seeders;

use App\Models\TouristProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TouristUserSeeder extends Seeder
{
    /**
     * Run the database seeds for Tourist role.
     */
    public function run(): void
    {
        $tourist = User::firstOrCreate(
            ['username' => 'mariasantos'],
            [
                'email' => 'tourist@balitours.test',
                'password' => Hash::make('password'),
                'role' => 'tourist',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        TouristProfile::firstOrCreate(
            ['user_id' => $tourist->id],
            [
                'first_name' => 'Maria',
                'middle_name' => 'Clara',
                'last_name' => 'Santos',
                'mobile_number' => '09123456789',
                'city_municipality' => 'Balingasag',
                'province' => 'Misamis Oriental',
                'barangay' => 'Poblacion',
            ]
        );
    }
}
