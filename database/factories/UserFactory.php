<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use Illuminate\Support\Str;

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

$factory->define(User::class, function () {
    return [
        'name' => 'Администратор',
        'email' => 'ivelini@yandex.ru',
        'email_verified_at' => now(),
        'password' => '$2y$10$2b3qWZjIC6HPPxjd/nXTiuVFLoLFI6UpHWmZ8JViQug9adMW5ZtKy', // 73125478Ilya
        'remember_token' => Str::random(10),
    ];
});


