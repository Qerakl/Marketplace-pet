<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Создаёт таблицу категорий товаров.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->string('icon')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->unsignedInteger('products_count')->default(0);
            $table->timestamps();

            $table->index('sort_order');
        });
    }

    /**
     * Откатывает изменения.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
