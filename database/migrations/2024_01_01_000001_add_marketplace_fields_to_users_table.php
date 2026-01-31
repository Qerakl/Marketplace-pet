<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Добавляет поля для маркетплейса в таблицу пользователей.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 20)->nullable()->after('email');
            $table->string('avatar')->nullable()->after('phone');
            $table->enum('role', ['buyer', 'seller', 'admin'])->default('buyer')->after('avatar');
            $table->boolean('is_verified')->default(false)->after('role');
        });
    }

    /**
     * Откатывает изменения.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'avatar', 'role', 'is_verified']);
        });
    }
};
