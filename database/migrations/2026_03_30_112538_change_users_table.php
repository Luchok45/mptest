<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->unsignedBigInteger('lk_id')->nullable()->after('id');
            $table->string('last_name')->after('email');
            $table->string('first_name')->after('last_name');
            $table->string('patronymic')->nullable()->after('first_name');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->after('email');
            $table->dropColumn('lk_id');
            $table->dropColumn('last_name');
            $table->dropColumn('first_name');
            $table->dropColumn('patronymic');
        });
    }
};
