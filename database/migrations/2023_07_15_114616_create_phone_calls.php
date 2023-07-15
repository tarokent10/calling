<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('phone_calls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caller_user_id')->nullable()->comment('かけた人（のユーザID）')->references('id')->on('users');
            $table->foreignId('receiver_user_id')->nullable()->comment('かけられた人（のユーザID）')->references('id')->on('users');
            $table->string('status')->comment('ステータス（waiting_receiver,canceled,talk_started,finished）');
            $table->timestamp('called_at')->nullable()->comment('かけた日時');
            $table->timestamp('talk_started_at')->nullable()->comment('通話開始日時');
            $table->timestamp('finished_at')->nullable()->comment('通話終了日時');
            $table->integer('call_charge')->nullable()->comment('通話料金');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phone_calls');
    }
};
