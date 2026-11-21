<?php

use App\Enums\EventStatus;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default(EventStatus::DRAFT->value);
            $table->string('reject_comment', 2000)->nullable();

            $table->string('main_name');
            $table->string('main_event_level');
            $table->string('main_activity_direction');
            $table->string('main_youth_policy_direction');

            $table->dateTimeTz('dates_start_date');
            $table->dateTimeTz('dates_end_date')->nullable();
            $table->timeTz('dates_start_time');

            $table->string('plan_target_audience', length: 1000)->nullable();
            $table->string('plan_description', length: 1000)->nullable();
            $table->string('plan_target_smart', length: 1000)->nullable();
            $table->string('plan_qualitative_indicators', length: 1000)->nullable();
            $table->json('plan_scenario_file')->nullable();
            $table->json('plan_estimate_file')->nullable();

            $table->boolean('announcement_enabled')->default(false);
            $table->string('announcement_description', length: 2500)->nullable();
            $table->json('announcement_image_file')->nullable();

            $table->boolean('registration_enabled')->default(false);
            $table->dateTimeTz('registration_end_date')->nullable();
            $table->unsignedInteger('registration_members_count')->nullable();

            $table->foreignIdFor(User::class, column: 'creator_id')
                ->constrained('users');
            $table->timestamps();

            $table->index(['id', 'status']);
            $table->index(['id', 'status', 'dates_start_time', 'dates_end_date', 'dates_start_time']);
            $table->index(['id', 'creator_id']);
            $table->index(['id', 'dates_start_date', 'dates_end_date', 'dates_start_time']);
            $table->index(['id', 'announcement_enabled']);
            $table->index(['id', 'registration_enabled']);
            $table->index(['id', 'registration_end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
