<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('UserSeeder');
        $this->call('ProfileSeeder');
        $this->call('BrokerSeeder');
        $this->call('WalletSeeder');
        $this->call('CategorySeeder');
        $this->call('AssetSeeder');
        $this->call('TradeSeeder');
    }
}
