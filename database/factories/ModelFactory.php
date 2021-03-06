<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use Illuminate\Support\Facades\Config;

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Category::class, function (Faker\Generator $faker) {
    return [
        'slug' => $faker->word,
        'name' => $faker->word,
        'description' => $faker->sentence,
    ];
});

$factory->define(App\Models\Post::class, function (Faker\Generator $faker) {
    $type = $faker->randomElement(array('post','page'));
    return [
        'title' => $faker->sentence,
        'content' => $faker->text($maxNbChars = 500),
        'excerpt' => $faker->text($maxNbChars = 100),
        'slug' => $faker->word,
        'type' => $type,
        'status' => $faker->randomElement(Config::get('blog.post.status')),
        'view_template' => Config::get('blog.post.templates.' . $type . 'Default'),
        'user_id' => 1,
    ];
});
