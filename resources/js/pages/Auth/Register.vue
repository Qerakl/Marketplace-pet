<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3'
import MainLayout from '@/layouts/MainLayout.vue'
import { computed } from 'vue'

const page = usePage()
const errors = computed(() => page.props.errors || {})

const form = useForm({
    name: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: '',
})

function submit() {
    form.post('/register', {
        onFinish: () => form.reset('password', 'password_confirmation'),
    })
}

// Получаем первую ошибку для поля
function getError(field: string): string | null {
    const fieldErrors = errors.value[field] || form.errors[field]
    if (Array.isArray(fieldErrors)) return fieldErrors[0]
    return fieldErrors || null
}

function hasError(field: string): boolean {
    return !!getError(field)
}
</script>

<template>
    <Head>
        <title>Регистрация</title>
        <meta name="description" content="Создайте аккаунт на маркетплейсе" />
    </Head>

    <MainLayout>
        <div class="auth-page">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-5">
                        <div class="auth-card">
                            <div class="auth-header">
                                <div class="auth-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/>
                                    </svg>
                                </div>
                                <h1 class="auth-title">Создать аккаунт</h1>
                                <p class="auth-subtitle">
                                    Зарегистрируйтесь, чтобы начать покупать и продавать
                                </p>
                            </div>

                            <form @submit.prevent="submit" class="auth-form">
                                <!-- Name -->
                                <div class="form-group" :class="{ 'has-error': hasError('name') }">
                                    <label for="name" class="form-label">Имя</label>
                                    <input
                                        id="name"
                                        v-model="form.name"
                                        type="text"
                                        class="form-input"
                                        :class="{ 'input-error': hasError('name') }"
                                        placeholder="Ваше имя"
                                        autofocus
                                    />
                                    <span v-if="hasError('name')" class="error-message">
                                        {{ getError('name') }}
                                    </span>
                                </div>

                                <!-- Email -->
                                <div class="form-group" :class="{ 'has-error': hasError('email') }">
                                    <label for="email" class="form-label">Email</label>
                                    <input
                                        id="email"
                                        v-model="form.email"
                                        type="email"
                                        class="form-input"
                                        :class="{ 'input-error': hasError('email') }"
                                        placeholder="you@example.com"
                                    />
                                    <span v-if="hasError('email')" class="error-message">
                                        {{ getError('email') }}
                                    </span>
                                </div>

                                <!-- Phone -->
                                <div class="form-group">
                                    <label for="phone" class="form-label">
                                        Телефон <span class="optional">(необязательно)</span>
                                    </label>
                                    <input
                                        id="phone"
                                        v-model="form.phone"
                                        type="tel"
                                        class="form-input"
                                        :class="{ 'input-error': hasError('phone') }"
                                        placeholder="+7 (999) 123-45-67"
                                    />
                                    <span v-if="hasError('phone')" class="error-message">
                                        {{ getError('phone') }}
                                    </span>
                                </div>

                                <!-- Password -->
                                <div class="form-group" :class="{ 'has-error': hasError('password') }">
                                    <label for="password" class="form-label">Пароль</label>
                                    <input
                                        id="password"
                                        v-model="form.password"
                                        type="password"
                                        class="form-input"
                                        :class="{ 'input-error': hasError('password') }"
                                        placeholder="Минимум 8 символов"
                                    />
                                    <span v-if="hasError('password')" class="error-message">
                                        {{ getError('password') }}
                                    </span>
                                </div>

                                <!-- Password Confirmation -->
                                <div class="form-group">
                                    <label for="password_confirmation" class="form-label">
                                        Подтвердите пароль
                                    </label>
                                    <input
                                        id="password_confirmation"
                                        v-model="form.password_confirmation"
                                        type="password"
                                        class="form-input"
                                        placeholder="Повторите пароль"
                                    />
                                </div>

                                <!-- Terms -->
                                <p class="terms-text">
                                    Регистрируясь, вы соглашаетесь с
                                    <a href="/terms">условиями использования</a>
                                    и
                                    <a href="/privacy">политикой конфиденциальности</a>
                                </p>

                                <!-- Submit -->
                                <button
                                    type="submit"
                                    class="btn-submit"
                                    :disabled="form.processing"
                                >
                                    <span v-if="form.processing" class="spinner"></span>
                                    <span>{{ form.processing ? 'Регистрация...' : 'Зарегистрироваться' }}</span>
                                </button>
                            </form>

                            <div class="auth-footer">
                                <span>Уже есть аккаунт?</span>
                                <a href="/login">Войти</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<style scoped>
.auth-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ec 100%);
    padding: 3rem 0;
    display: flex;
    align-items: center;
}

.auth-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
    padding: 2.5rem;
}

.auth-header {
    text-align: center;
    margin-bottom: 2rem;
}

.auth-icon {
    width: 64px;
    height: 64px;
    background: linear-gradient(135deg, #0d6efd, #0056b3);
    color: #fff;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
}

.auth-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #212529;
    margin-bottom: 0.5rem;
}

.auth-subtitle {
    color: #6c757d;
    margin: 0;
}

.auth-form {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
}

.form-label {
    font-weight: 500;
    color: #495057;
    font-size: 0.9375rem;
}

.optional {
    color: #adb5bd;
    font-weight: 400;
}

.form-input {
    padding: 0.75rem 1rem;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.2s;
    background: #fff;
}

.form-input:focus {
    outline: none;
    border-color: #0d6efd;
    box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
}

.form-input.input-error {
    border-color: #dc3545;
    background: #fff5f5;
}

.form-input.input-error:focus {
    box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.15);
}

.error-message {
    color: #dc3545;
    font-size: 0.875rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.error-message::before {
    content: '⚠';
    font-size: 0.75rem;
}

.terms-text {
    font-size: 0.875rem;
    color: #6c757d;
    text-align: center;
    margin: 0;
}

.terms-text a {
    color: #0d6efd;
    text-decoration: none;
}

.terms-text a:hover {
    text-decoration: underline;
}

.btn-submit {
    padding: 0.875rem 1.5rem;
    background: linear-gradient(135deg, #0d6efd, #0056b3);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-submit:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(13, 110, 253, 0.35);
}

.btn-submit:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.spinner {
    width: 18px;
    height: 18px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-top-color: #fff;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.auth-footer {
    text-align: center;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e9ecef;
    color: #6c757d;
}

.auth-footer a {
    color: #0d6efd;
    font-weight: 600;
    text-decoration: none;
    margin-left: 0.25rem;
}

.auth-footer a:hover {
    text-decoration: underline;
}
</style>
