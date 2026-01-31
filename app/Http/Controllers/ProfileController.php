<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Показывает профиль пользователя.
     */
    public function show(): Response
    {
        $user = Auth::user();

        $products = $user->products()
            ->with(['category:id,name,slug', 'mainImage'])
            ->withCount('reviews')
            ->latest()
            ->paginate(6);

        $favorites = $user->favorites()
            ->with(['category:id,name,slug', 'mainImage'])
            ->withCount('reviews')
            ->paginate(6);

        return Inertia::render('Profile/Show', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'avatar' => $user->avatar,
                'role' => $user->role,
                'is_verified' => $user->is_verified,
                'created_at' => $user->created_at->format('d.m.Y'),
            ],
            'products' => ProductResource::collection($products),
            'favorites' => ProductResource::collection($favorites),
        ]);
    }

    /**
     * Показывает форму редактирования профиля.
     */
    public function edit(): Response
    {
        $user = Auth::user();

        return Inertia::render('Profile/Edit', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ],
        ]);
    }

    /**
     * Обновляет профиль пользователя.
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->route('profile.show')
            ->with('success', 'Профиль обновлён');
    }

    /**
     * Обновляет пароль пользователя.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ], [
            'current_password.required' => 'Введите текущий пароль',
            'current_password.current_password' => 'Неверный текущий пароль',
            'password.required' => 'Введите новый пароль',
            'password.confirmed' => 'Пароли не совпадают',
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.show')
            ->with('success', 'Пароль изменён');
    }

    /**
     * Удаляет аккаунт пользователя.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ], [
            'password.required' => 'Введите пароль для подтверждения',
            'password.current_password' => 'Неверный пароль',
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
