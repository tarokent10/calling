<?php

namespace Database\Factories;

use App\Enums\PhoneCallStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PhoneCall>
 */
class PhoneCallFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'caller_user_id' => User::factory()->create(),
            'receiver_user_id' => User::factory()->create(),
            'status' => Arr::random(PhoneCallStatus::cases()),
        ];
    }
}
