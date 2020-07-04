<?php

use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profile = (array)DB::table('profiles')->first();
        $profileId = (string)$profile['_id'];

        DB::table('wallets')->insert([
            'name' => 'Carteira 1',
            'profile_id' => $profileId,
        ]);

    }
}
