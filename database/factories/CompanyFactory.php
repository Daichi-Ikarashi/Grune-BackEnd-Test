<?php

use App\Models\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    return [
      //added test data
      'name' => $faker->company,
			'email' => $faker->safeEmail,
			'prefecture_id' => '1',
			'phone' => '123-456-789',
			'postcode' => '0600000',
			'city' => $faker->city,
			'local' => $faker->streetName,
			'street_address' => $faker->streetAddress,
			'business_hour' => '10-18',
			'regular_holiday' => $faker->dayOfWeek,
			'image' => 'test.png',
			'fax' => '123-456-789',
			'url' => $faker->url,
			'license_number' => '111000'
    ];
});
