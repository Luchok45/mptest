<?php

use App\Models\Event;
use App\Models\EventMember;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_member_winners', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Event::class)->constrained('events')->onDelete('cascade');
            $table->foreignIdFor(EventMember::class)->constrained('event_members')->onDelete('cascade');
            $table->string('reward_type');
            $table->timestamps();
            $table->index(['id', 'event_id']);
            $table->index(['id', 'event_member_id']);
            $table->index(['id', 'event_id', 'event_member_id']);
            $table->index(['id', 'reward_type']);
            $table->index(['id', 'event_id', 'event_member_id', 'reward_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_member_winners');
    }
};
