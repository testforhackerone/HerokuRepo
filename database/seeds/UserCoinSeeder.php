<?php

use App\Model\UserCoin;
use Illuminate\Database\Seeder;

class UserCoinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserCoin::create([
            'user_id' => 1,
            'coin' => 100,
            'status' => 1
        ]);

        UserCoin::create([
            'user_id' => 2,
            'coin' => 100,
            'status' => 1
        ]);
    }
}
