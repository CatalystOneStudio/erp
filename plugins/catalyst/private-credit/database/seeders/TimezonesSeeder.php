<?php

namespace Catalyst\PrivateCredit\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Catalyst\PrivateCredit\Models\Timezone;
use DateTime;
use DateTimeZone;

class TimezonesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);

        foreach ($timezones as $timezoneName) {
            $dateTime = new DateTime('now', new DateTimeZone($timezoneName));
            $offset = $dateTime->format('P'); // Get the UTC offset in +/-HH:MM format

            Timezone::create([
                'name' => $timezoneName,
                'offset' => 'UTC' . $offset,
            ]);
        }
    }
}
