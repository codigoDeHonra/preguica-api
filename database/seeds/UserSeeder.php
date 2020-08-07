<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'wouerner',
            'email' => 'wouerner@protonmail.com',
            'password' => '$2y$10$aWNHZKxiIKf/ombnxLciou36jgVdiyhhq.zdDO/5uK00aP3JRWM/6',
        ]);
    }
}
