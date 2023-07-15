<?php

namespace Tests\Feature\Controllers;

use App\Enums\PhoneCallStatus;
use App\Models\PhoneCall;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PhoneCallControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_電話をかける(): void
    {
        // given
        $now = CarbonImmutable::now();
        CarbonImmutable::setTestNow($now);

        /** @var User $me */
        $me = User::factory()->create();
        $this->actingAs($me);
        /** @var User $receiver */
        $receiver = User::factory()->create();

        // when
        $response = $this->post('/api/phone_calls', [
            'user_id' => $receiver->id,
        ]);

        // then
        $actual = $response->assertCreated();
        $actual->assertCreated();

        /** @var PhoneCall $latest */
        $latest = PhoneCall::query()->latest()->firstOrFail();
        $actual->assertJsonFragment([
            'phone_call_id' => $latest->id,
        ]);

        $this->assertDatabaseHas('phone_calls', [
            'caller_user_id' => $me->id,
            'receiver_user_id' => $receiver->id,
            'status' => PhoneCallStatus::WaitingReceiver,
            'called_at' => now(),
        ]);
    }
}
