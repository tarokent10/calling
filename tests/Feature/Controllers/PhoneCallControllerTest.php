<?php

namespace Tests\Feature\Controllers;

use App\Enums\PhoneCallStatus;
use App\Models\PhoneCall;
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

        $userId = 1;

        // when
        $response = $this->post('/api/phone_calls', [
            'user_id' => $userId,
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
            'caller_user_id' => 4,
            'receiver_user_id' => $userId,
            'status' => PhoneCallStatus::WaitingReceiver,
            'called_at' => now(),
        ]);
    }
}
