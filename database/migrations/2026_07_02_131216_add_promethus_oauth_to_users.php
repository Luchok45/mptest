<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('oauth_prometheus_id')->nullable();
            $table->string('oauth_prometheus_token', 1000)->nullable();
            $table->string('oauth_prometheus_refresh_token', 1000)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('oauth_prometheus_id');
            $table->dropColumn('oauth_prometheus_token');
            $table->dropColumn('oauth_prometheus_refresh_token');
        });
    }
};
