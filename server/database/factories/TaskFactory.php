<?php

use Faker\Generator as Faker;
use App\Task;
use App\Folder;
use Carbon\Carbon;

$factory->define(Task::class, function (Faker $faker) {
    $folder = Folder::get()->first();
    $now = Carbon::now();

    return [
        'folder_id'  => $folder->id,
        'title'      => $faker->name,
        'status'     => $faker->numberBetween(1,3),
        'due_date'   => $now->copy()->addDay(1),
        'created_at' => $now,
        'updated_at' => $now,
    ];
});
