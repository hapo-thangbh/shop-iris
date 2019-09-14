<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'account' => 'admin',
                'name' => 'ADMIN',
                'phone' => '0213213211',
                'email' => 'admin@gmail.com',
                'level' => User::ADMIN,
                'is_active' => User::ACTIVE,
                'password' => bcrypt('admin'),
                'address' => 'Hà Nội',
            ],
        ]);
    }
}
