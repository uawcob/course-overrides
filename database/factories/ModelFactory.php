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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    $first = $faker->firstName;
    $last = $faker->lastName;

    return [
        'name' => "$first $last",
        'first_name' => $first,
        'last_name' => $last,
        'student_id' => $faker->unique()->numberBetween(100000000, 999999999),
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Course::class, function (Faker\Generator $faker) {
    return [
        'number' => $faker->numberBetween(1000, 99999),
        'code' => $faker->regexify('(WCOB|FINN|ISYS|ACCT|MGMT|SCMT|ECON|MKTG)[1-4]{4}'),
        'section' => sprintf('%03d', $faker->numberBetween(1, 19)),
        'title' => $faker->sentence(4),
        'time' => "Mon, Wed, Fri 11:00 AM - 12:30 PM",
        'semester' => new App\Semester('Fall', 2017),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Note::class, function (Faker\Generator $faker) {
    return [
        'body' => $faker->paragraph(),
        'sensitivity' => $faker->regexify('(success|info|warning|danger)'),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\IntendedPlan::class, function (Faker\Generator $faker) {
    $category = $faker->randomElement([
        'Majors',
        'Minors for Business Majors',
        'Minors for Non-Business Majors',
    ]);

    $getAbbr = function($category){
        if ($category === 'Majors') {
            return '(M)';
        }
        if ($category === 'Minors for Business Majors') {
            return '(mB)';
        }
        if ($category === 'Minors for Non-Business Majors') {
            return '(mN)';
        }
    };

    return [
        'name' => $faker->unique()->sentence(2),
        'category' => $category,
        'abbr' => $getAbbr($category),
    ];
});
