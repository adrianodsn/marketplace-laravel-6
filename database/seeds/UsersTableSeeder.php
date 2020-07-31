<?php

use App\Models\Store;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 40)->create()->each(function ($user) {
            $user->store()->save(factory(Store::class)->make());
        });
    }
}
