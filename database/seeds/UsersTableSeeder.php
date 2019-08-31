<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //multiple states doesn't work with state function!!
        factory(App\User::class, 1)->states('admin', 'with_token')->create();

        factory(App\User::class, 50)->state('with_token')->create();

    }
}
