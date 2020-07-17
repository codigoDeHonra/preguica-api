<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
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

        $profile = (array)DB::table('profiles')->first();
        $profileId = (string)$profile['_id'];

        $wallet = (array)DB::table('wallets')->first();
        $walletId = (string)$wallet['_id'];

        DB::table('categories')->insert([
            'name' => 'Categoria 1',
            'wallet_id' => $walletId,
            'percentageInWallet' => 50,
            'user_id' => $userId,
            'profile_id' => $profileId,
        ]);

        DB::table('categories')->insert([
            'name' => 'Categoria 2',
            'wallet_id' => $walletId,
            'percentageInWallet' => 50,
            'user_id' => $userId,
            'profile_id' => $profileId,
        ]);
    }
}
