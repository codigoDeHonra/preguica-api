<?php

use Illuminate\Database\Seeder;

class TradeSeeder extends Seeder
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

        $asset = (array)DB::table('assets')->first();
        $assetId = (string)$asset['_id'];

        DB::table('trades')->insert([
            'broker' => 1,
            'amount' => 1,
            'payout' => 1,
            'date' => '01-01-2020',
            'investiment' => 1,
            'asset_id' => $assetId,
            'user_id' => $userId,
        ]);
    }
}
