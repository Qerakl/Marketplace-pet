<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Заполняет таблицу категорий.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Электроника', 'slug' => 'electronics', 'description' => 'Смартфоны, ноутбуки, аксессуары', 'sort_order' => 1],
            ['name' => 'Дом и ремонт', 'slug' => 'home', 'description' => 'Инструменты, мебель, декор', 'sort_order' => 2],
            ['name' => 'Одежда', 'slug' => 'fashion', 'description' => 'Кроссовки, куртки, бренды', 'sort_order' => 3],
            ['name' => 'Детям', 'slug' => 'kids', 'description' => 'Игрушки, коляски, одежда', 'sort_order' => 4],
            ['name' => 'Авто', 'slug' => 'auto', 'description' => 'Запчасти, аксессуары', 'sort_order' => 5],
            ['name' => 'Спорт', 'slug' => 'sports', 'description' => 'Тренировки, инвентарь', 'sort_order' => 6],
            ['name' => 'Красота', 'slug' => 'beauty', 'description' => 'Уход, техника, парфюм', 'sort_order' => 7],
            ['name' => 'Хобби', 'slug' => 'hobby', 'description' => 'Коллекции, гаджеты, настолки', 'sort_order' => 8],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
