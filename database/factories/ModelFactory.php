<?php
use App\User;
use App\Post;
use Faker\Generator;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
  static $password;

  return [
    'name' => $faker->name,
    'email' => $faker->unique()->safeEmail,
    'password' => $password ?: $password = bcrypt('secret'),
    'remember_token' => str_random( 10),
  ];
});

$factory->define(App\Post::class, function(Faker\Generator $faker) {
  return [
    'title' => $faker->realText(rand(40, 80)),
    'body' => $faker->realText(rand(200, 6000)),
    'user_id' => function() {
      return \App\User::inRandomOrder()->first()->id;
    }
  ];
});
