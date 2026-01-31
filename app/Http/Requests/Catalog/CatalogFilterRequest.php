<?php

namespace App\Http\Requests\Catalog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CatalogFilterRequest extends FormRequest
{
    /**
     * Разрешает запрос для всех пользователей.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Правила валидации фильтров каталога.
     */
    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:100'],
            'category' => ['nullable', 'string', 'exists:categories,slug'],
            'min_price' => ['nullable', 'numeric', 'min:0'],
            'max_price' => ['nullable', 'numeric', 'min:0'],
            'sort' => ['nullable', Rule::in(['price_asc', 'price_desc', 'newest', 'popular'])],
            'page' => ['nullable', 'integer', 'min:1'],
        ];
    }

    /**
     * Сообщения об ошибках.
     */
    public function messages(): array
    {
        return [
            'q.max' => 'Поисковый запрос слишком длинный',
            'category.exists' => 'Категория не найдена',
            'min_price.min' => 'Минимальная цена не может быть отрицательной',
            'max_price.min' => 'Максимальная цена не может быть отрицательной',
        ];
    }

    /**
     * Возвращает валидированные фильтры.
     */
    public function filters(): array
    {
        return $this->only(['q', 'category', 'min_price', 'max_price', 'sort']);
    }
}
