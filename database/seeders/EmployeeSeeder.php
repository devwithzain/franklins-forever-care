<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = [
            [
                'name' => 'James Wilson',
                'email' => 'j.wilson@care.com',
                'agent_custom_id' => 'A-001',
                'phone' => '+1 555-1001',
                'region' => 'Austin, TX',
                'type' => '24/7',
                'status' => 'Active',
            ],
            [
                'name' => 'Lisa Brown',
                'email' => 'l.brown@care.com',
                'agent_custom_id' => 'A-002',
                'phone' => '+1 555-1002',
                'region' => 'Houston, TX',
                'type' => 'Part-time',
                'status' => 'Active',
            ],
            [
                'name' => 'Tom Davis',
                'email' => 't.davis@care.com',
                'agent_custom_id' => 'A-003',
                'phone' => '+1 555-1003',
                'region' => 'San Antonio, TX',
                'type' => '24/7',
                'status' => 'On Leave',
            ],
        ];

        foreach ($employees as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password123'),
                    'role' => 'employee',
                ]
            );

            Employee::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'agent_custom_id' => $data['agent_custom_id'],
                    'phone' => $data['phone'],
                    'ssn' => '***-**-' . rand(1000, 9999),
                    'region' => $data['region'],
                    'type' => $data['type'],
                    'status' => $data['status'],
                    'rating' => 4.5,
                ]
            );
        }
    }
}
