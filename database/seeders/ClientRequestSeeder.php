<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Client;
use App\Models\ClientRequest;

class ClientRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = Client::all();

        if ($clients->isEmpty()) {
            return;
        }

        $requests = [
            [
                'type' => 'Change Agent',
                'priority' => 'High',
                'status' => 'Pending',
                'description' => 'Client is not happy with current agent schedule.',
            ],
            [
                'type' => 'Outdoor Access',
                'priority' => 'Medium',
                'status' => 'Approved',
                'description' => 'Requesting weekly outdoor trips.',
            ],
            [
                'type' => 'Cancellations',
                'priority' => 'Low',
                'status' => 'Pending',
                'description' => 'Needs to cancel Friday session due to doctor appointment.',
            ],
            [
                'type' => 'Change Agent',
                'priority' => 'Medium',
                'status' => 'Rejected',
                'description' => 'Requested different agent but no availability.',
            ],
        ];

        foreach ($requests as $index => $reqData) {
            $client = $clients->random();
            ClientRequest::create([
                'client_id' => $client->id,
                'request_custom_id' => '#REQ-882' . ($index + 1),
                'type' => $reqData['type'],
                'priority' => $reqData['priority'],
                'status' => $reqData['status'],
                'description' => $reqData['description'],
            ]);
        }
    }
}
