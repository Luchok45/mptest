<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('lk_id');
            $table->string('avatar', 100)->nullable();

            $table->index(['id', 'email']);
            $table->index(['id', 'oauth_prometheus_id']);
            $table->index(['id', 'avatar']);
            $table->index(['id', 'last_name', 'first_name', 'patronymic']);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('lk_id')->nullable()->after('id');
            $table->dropColumn('avatar');

            $table->dropIndex(['id', 'email']);
            $table->dropIndex(['id', 'oauth_prometheus_id']);
            $table->dropIndex(['id', 'avatar']);
            $table->dropIndex(['id', 'last_name', 'first_name', 'patronymic']);
        });
    }
};
