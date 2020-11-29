<?php

namespace Database\Seeders;

use App\Models\CrmStatus;
use Illuminate\Database\Seeder;

class CrmStatusTableSeeder extends Seeder
{
    public function run()
    {
        $crmStatuses = [
            [
                'id'         => 1,
                'name'       => 'Lead',
                'created_at' => '2020-11-29 00:44:07',
                'updated_at' => '2020-11-29 00:44:07',
            ],
            [
                'id'         => 2,
                'name'       => 'Customer',
                'created_at' => '2020-11-29 00:44:07',
                'updated_at' => '2020-11-29 00:44:07',
            ],
            [
                'id'         => 3,
                'name'       => 'Partner',
                'created_at' => '2020-11-29 00:44:07',
                'updated_at' => '2020-11-29 00:44:07',
            ],
        ];

        CrmStatus::insert($crmStatuses);
    }
}
