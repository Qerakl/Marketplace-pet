<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Разрешает запрос для всех.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Правила валидации регистрации.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
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
            'email.unique' => 'Этот email уже зарегистрирован',
            'password.required' => 'Введите пароль',
            'password.confirmed' => 'Пароли не совпадают',
            'password.min' => 'Пароль должен быть не менее :min символов',
        ];
    }
}
