<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = (array)DB::table('users')->first();
        $userId = (string)$user['_id'];

        DB::table('profiles')->insert([
            'name' => 'Padrão',
            'email' => 'wouerner@protonmail.com',
            'user_id' => $userId,
        ]);
    }
}
