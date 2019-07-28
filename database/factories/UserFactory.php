<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
    ];
});


/**
 * Writing Factories
 *
 * @url https://laravel.com/docs/5.8/database-testing#writing-factories
 *
 * Factory state example no.1
 */
$factory->state(App\User::class, 'with_token', function ($faker) {
    return [
        'remember_token' => Str::random(10),
    ];
});

/**
 * Factory state example no.2
 */
$factory->state(App\User::class, 'admin', [
    'name' => 'Piotr Zatorski',
    'email' => 'piotr.zat@gmail.com',
    'password' => Hash::make('1234asdf'), // password
]);

/**
 * Factory callback example
 */
$factory->afterCreating(App\User::class, function ($user, $faker) {
    $user->addresses()->save(factory(App\Address::class)->state('primary')->make());
    $user->addresses()->save(factory(App\Address::class)->make());
    $user->addresses()->save(factory(App\Address::class)->make());
});
