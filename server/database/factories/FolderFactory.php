<?php

use Faker\Generator as Faker;
use App\Folder;
use App\User;
use Carbon\Carbon;

$factory->define(Folder::class, function (Faker $faker) {
    $user = User::get()->first();
    $now = Carbon::now();

    return [
        'title' => $faker->title(),
        'user_id' => $user->id,
        'created_at' => $now,
        'updated_at' => $now,
    ];
});
