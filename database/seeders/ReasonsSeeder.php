<?php

namespace Database\Seeders;

use App\Models\Reason;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReasonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'reason_ar' => 'لا يمكن الطلب',
                'reason_en' => 'It is not possible to order',
                'status' => 'ACTIVE',
            ],
            [
                'reason_ar' => 'لا يمكن الطلب عشان ...',
                'reason_en' => 'Cant order because...',
                'status' => 'ACTIVE',
            ],
            [
                'reason_ar' => 'الله المستعان',
                'reason_en' => 'may Allah help',
                'status' => 'ACTIVE',
            ],
        ];
        foreach ($data as $value) {
            Reason::create([
                'reason_ar' => $value['reason_ar'],
                'reason_en' => $value['reason_en'],
                'status' => $value['status'],
            ]);
        }
    }
}
