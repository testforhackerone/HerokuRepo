<?php

use App\Model\Coin;
use Illuminate\Database\Seeder;

class CoinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coin::create(['name'=>'Default Coin', 'amount' => 500, 'sold_amount'=> 0, 'price'=>10,'is_active'=> 1]);
    }
}
