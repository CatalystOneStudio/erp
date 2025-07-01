<?php

namespace Catalyst\PrivateCredit\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('private_credit_banks')->insert([
            [
                'id' => 1,
                'name' => 'Republic Bank Limited',
                'swift_code' => null,
                'routing_number' => null,
                'country' => 'Trinidad and Tobago',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id' => 2,
                'name' => 'First Citizens Bank Limited',
                'swift_code' => null,
                'routing_number' => null,
                'country' => 'Trinidad and Tobago',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id' => 3,
                'name' => 'RBC Royal Bank (Trinidad and Tobago) Limited',
                'swift_code' => null,
                'routing_number' => null,
                'country' => 'Trinidad and Tobago',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id' => 4,
                'name' => 'Scotiabank Trinidad and Tobago Limited',
                'swift_code' => null,
                'routing_number' => null,
                'country' => 'Trinidad and Tobago',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id' => 5,
                'name' => 'JMMB Bank (Trinidad and Tobago) Limited',
                'swift_code' => null,
                'routing_number' => null,
                'country' => 'Trinidad and Tobago',
                'created_at'    => now(),
                'updated_at'    => now(),
            ]
        ]);
    }
}
