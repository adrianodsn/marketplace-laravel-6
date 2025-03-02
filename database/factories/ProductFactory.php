<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->sentence,
        'body' => $faker->paragraphs(5, true),
        'price' => $faker->randomFloat(2, 1, 10),
        'slug' => $faker->slug
    ];
});
