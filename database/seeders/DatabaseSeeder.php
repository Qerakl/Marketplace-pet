<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Заполняет базу данных тестовыми данными.
     */
    public function run(): void
    {
        // Администратор
        User::factory()->admin()->create([
            'name' => 'Администратор',
            'email' => 'admin@example.com',
        ]);

        // Тестовый пользователь
        User::factory()->create([
            'name' => 'Тестовый пользователь',
            'email' => 'test@example.com',
        ]);

        // Категории и товары
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
