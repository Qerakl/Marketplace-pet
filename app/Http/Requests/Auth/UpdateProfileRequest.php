<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Разрешает запрос для авторизованных.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Правила валидации обновления профиля.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
        ];
    }

    /**
     * Сообщения об ошибках.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Введите имя',
            'name.min' => 'Имя должно быть не менее 2 символов',
            'email.required' => 'Введите email',
            'email.email' => 'Некорректный email',
            'email.unique' => 'Этот email уже используется',
        ];
    }
}
