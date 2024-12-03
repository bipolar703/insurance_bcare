<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InitialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = Hash::make('12345678');

        // ============================================================================
        // ============================ Super Admin Section ===========================
        // ============================================================================
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'super_admin@insurance.com',
            'phone' => '0797210065',
            'type' => 1, // 1 => Super Admin
            'status' => 1, // 1 => Active
            'password' => $password,
        ]);

      

      

      

    
    }
}
