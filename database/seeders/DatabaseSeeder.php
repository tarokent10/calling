<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->createMany([
            ['name' => '武石'],
            ['name' => '平山'],
            ['name' => '二村'],
            ['name' => 'Me'],
        ]);

        //        PhoneCall::factory()->create();
    }
}
