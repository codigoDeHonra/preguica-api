<?php

use Illuminate\Database\Seeder;

class BrokerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brokers')->insert([
            'name' => 'XPTO',
        ]);
    }
}
