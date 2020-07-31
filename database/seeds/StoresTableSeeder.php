<?php

use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Seeder;

class StoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stores = Store::all();

        foreach ($stores as $store) {
            $store->products()->save(factory(Product::class)->make());
        }
    }
}
