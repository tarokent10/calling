<?php

namespace App\Models;

use App\Enums\PhoneCallStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property ?int $caller_user_id
 * @property ?int $receiver_user_id
 * @property string $status
 * @property ?string $called_at
 * @property ?string $talk_started_at
 * @property ?string $finished_at
 * @property ?int $call_charge
 * @property User $caller
 * @property User $receiver
 */
class PhoneCall extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => PhoneCallStatus::class,
        'called_at' => 'immutable_datetime',
        'talk_started_at' => 'immutable_datetime',
        'finished_at' => 'immutable_datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'caller_user_id',
        'receiver_user_id',
        'status',
        'called_at',
        'talk_started_at',
        'finished_at',
        'call_charge',
    ];

    /**
     * @return BelongsTo<User, PhoneCall>
     */
    public function caller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'caller_user_id');
    }

    /**
     * @return BelongsTo<User, PhoneCall>
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_user_id');
    }
}
