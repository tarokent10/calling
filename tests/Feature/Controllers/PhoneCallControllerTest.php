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
        CarbonImmutable::setTestNow(CarbonImmutable::now());

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
        $response->assertCreated();
        /** @var PhoneCall $latest */
        $latest = PhoneCall::query()->latest()->firstOrFail();
        $response->assertJsonFragment([
            'phone_call_id' => $latest->id,
        ]);

        $this->assertDatabaseHas(PhoneCall::class, [
            'caller_user_id' => $me->id,
            'receiver_user_id' => $receiver->id,
            'status' => PhoneCallStatus::WaitingReceiver,
            'called_at' => CarbonImmutable::now(),
        ]);
    }

    public function test_電話をキャンセルする(): void
    {
        CarbonImmutable::setTestNow(CarbonImmutable::now());

        // given
        /** @var PhoneCall $phoneCall */
        $phoneCall = PhoneCall::factory()->create([
            'status' => PhoneCallStatus::WaitingReceiver,
        ]);

        // when
        $actual = $this->post("/api/phone_calls/$phoneCall->id/cancel");

        // then
        $actual->assertNoContent();
        $this->assertDatabaseHas(PhoneCall::class, [
            'status' => PhoneCallStatus::Canceled,
            'finished_at' => CarbonImmutable::now(),
        ]);
    }
}
