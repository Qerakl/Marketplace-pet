<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Проверяет права на создание товара.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isSeller();
    }

    /**
     * Правила валидации при создании товара.
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string', 'max:5000'],
            'price' => ['required', 'numeric', 'min:1', 'max:99999999'],
            'old_price' => ['nullable', 'numeric', 'min:1', 'max:99999999'],
            'location' => ['nullable', 'string', 'max:100'],
            'images' => ['nullable', 'array', 'max:10'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];
    }

    /**
     * Сообщения об ошибках.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Укажите название товара',
            'title.min' => 'Название должно быть не менее 3 символов',
            'category_id.required' => 'Выберите категорию',
            'category_id.exists' => 'Категория не найдена',
            'price.required' => 'Укажите цену',
            'price.min' => 'Цена должна быть больше 0',
            'images.max' => 'Максимум 10 изображений',
            'images.*.max' => 'Размер изображения не более 5 МБ',
        ];
    }
}
