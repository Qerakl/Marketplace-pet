<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Создаёт таблицу товаров.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->decimal('old_price', 12, 2)->nullable();
            $table->string('location')->nullable();
            $table->enum('status', ['active', 'pending', 'sold'])->default('pending');
            $table->unsignedInteger('views_count')->default(0);
            $table->decimal('rating', 2, 1)->default(0);
            $table->timestamps();

            $table->index('status');
            $table->index('price');
            $table->index('created_at');
            $table->index(['category_id', 'status']);
        });
    }

    /**
     * Откатывает изменения.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
