<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AccountRequestTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert a single pending account request for testing
        if (! DB::table('Account_Request')->where('plv_student_id', 'PLVTEST001')->exists()) {
            DB::table('Account_Request')->insert([
                'plv_student_id' => 'PLVTEST001',
                'email' => 'plvtest001@example.com',
                'first_name' => 'Test',
                'last_name' => 'User',
                'password_hash' => password_hash('TestPass123!', PASSWORD_BCRYPT),
                'request_status' => 'Pending',
                'reviewed_by' => null,
                'reviewed_at' => null,
                'created_at' => now(),
            ]);
        }
    }
}
