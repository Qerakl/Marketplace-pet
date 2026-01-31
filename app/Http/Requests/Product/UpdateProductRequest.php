<?php

namespace App\Http\Requests\Product;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Проверяет права на редактирование товара.
     */
    public function authorize(): bool
    {
        $product = $this->route('product');

        if ($product instanceof Product) {
            return $this->user()->can('update', $product);
        }

        return false;
    }

    /**
     * Правила валидации при обновлении товара.
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'min:3', 'max:255'],
            'category_id' => ['sometimes', 'exists:categories,id'],
            'description' => ['nullable', 'string', 'max:5000'],
            'price' => ['sometimes', 'numeric', 'min:1', 'max:99999999'],
            'old_price' => ['nullable', 'numeric', 'min:1', 'max:99999999'],
            'location' => ['nullable', 'string', 'max:100'],
            'status' => ['sometimes', 'in:active,pending,sold'],
        ];
    }

    /**
     * Сообщения об ошибках.
     */
    public function messages(): array
    {
        return [
            'title.min' => 'Название должно быть не менее 3 символов',
            'category_id.exists' => 'Категория не найдена',
            'price.min' => 'Цена должна быть больше 0',
            'status.in' => 'Недопустимый статус',
        ];
    }
}
