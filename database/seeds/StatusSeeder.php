<?php

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Status::create([
            'name' => 'Chờ gửi',
            'type' => 2
        ]);

        \App\Status::create([
            'name' => 'Đã gửi',
            'type' => 2
        ]);

        \App\Status::create([
            'name' => 'Hoàn',
            'type' => 2
        ]);

        \App\Status::create([
            'name' => 'Hủy',
            'type' => 2
        ]);

        \App\Status::create([
            'name' => 'Hoàn thành',
            'type' => 2
        ]);
    }
}
