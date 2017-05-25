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

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => '123123',
        'remember_token' => str_random(10),
        'birthday' => $faker->date(),
        'address' => $faker->streetAddress(),
        'phone' => $faker->tollFreePhoneNumber(),
        'url_file' => 'https://upload.wikimedia.org/wikipedia/commons/1/1e/Default-avatar.jpg',
        'status' => $faker->randomElement([0, 1]),
        'token_confirm' => str_random(10),
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});

$factory->define(App\Models\Type::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});

$factory->define(App\Models\Role::class, function (Faker\Generator $faker) {
    static $typeId;

    return [
        'name' => $faker->word,
        'type_id' => $faker->randomElement(App\Models\Type::all()
            ->pluck('id')->toArray()),
    ];
});

$factory->define(App\Models\Campaign::class, function (Faker\Generator $faker) {
    return [
        'hashtag' => $faker->word,
        'description' => $faker->paragraph(),
        'longitude' => $faker->longitude,
        'latitude' => $faker->latitude,
        'status' => $faker->randomElement([0, 1]),
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});

$factory->define(App\Models\Tag::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});

$factory->define(App\Models\Event::class, function (Faker\Generator $faker) {
    static $userId;
    static $campaignId;

    return [
        'user_id' => $faker->randomElement($userId ?: $userId = App\Models\User::all()
            ->pluck('id')->toArray()),
        'campaign_id' => $faker->randomElement($campaignId ?: $campaignId = App\Models\Campaign::all()
            ->pluck('id')->toArray()),
        'title' => $faker->sentence(10),
        'description' => $faker->paragraph(),
        'longitude' => $faker->longitude,
        'latitude' => $faker->latitude,
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});

$factory->define(App\Models\Action::class, function (Faker\Generator $faker) {
    static $eventId;
    static $userId;

    return [
        'event_id' => $faker->randomElement($eventId ?: $eventId = App\Models\Event::all()
            ->pluck('id')->toArray()),
        'user_id' => $faker->randomElement($userId ?: $userId = App\Models\User::all()
            ->pluck('id')->toArray()),
        'caption' => $faker->sentence(10),
        'description' => $faker->paragraph(),

    ];
});

$factory->define(App\Models\Quality::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});

$factory->define(App\Models\DonationType::class, function (Faker\Generator $faker) {
    static $qualityId;

    return [
        'name' => $faker->word,
        'quality_id' => $faker->randomElement($qualityId ?: $qualityId = App\Models\Quality::all()
            ->pluck('id')->toArray()),
    ];
});

$factory->define(App\Models\Donation::class, function (Faker\Generator $faker) {
    static $userId;
    static $eventId;
    static $donationTypeId;

    return [
        'user_id' => $faker->randomElement($userId ?: $userId = App\Models\User::all()
            ->pluck('id')->toArray()),
        'event_id' => $faker->randomElement($eventId ?: $eventId = App\Models\Event::all()
            ->pluck('id')->toArray()),
        'donation_type_id' => $faker
            ->randomElement($donationTypeId ?: $donationTypeId = App\Models\DonationType::all()
            ->pluck('id')->toArray()),
        'value' => rand(10, 1000),
    ];
});

$factory->define(App\Models\Comment::class, function (Faker\Generator $faker) {
    static $userId;

    return [
        'user_id' => $faker->randomElement($userId ?: $userId = App\Models\User::pluck('id')->toArray()),
        'content' => $faker->paragraph(),
        'parent_id' => rand(1, 100),
    ];
});

$factory->define(App\Models\Like::class, function (Faker\Generator $faker) {
    static $userId;

    return [
        'user_id' => $faker->randomElement($userId ?: $userId = App\Models\User::pluck('id')->toArray()),
    ];
});

$factory->define(App\Models\Setting::class, function (Faker\Generator $faker) {
    return [
        'key' => rand(1, 100),
        'value' => rand(10, 1000),
    ];
});

$factory->define(App\Models\Media::class, function (Faker\Generator $faker) {
    return [
        'url_file' => $faker->imageUrl(),
        'type' => rand(1, 10),
    ];
});