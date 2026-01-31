<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3'
import MainLayout from '@/layouts/MainLayout.vue'
import { computed } from 'vue'

const page = usePage()
const errors = computed(() => page.props.errors || {})

const form = useForm({
    email: '',
    password: '',
    remember: false,
})

function submit() {
    form.post('/login', {
        onFinish: () => form.reset('password'),
    })
}

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
        <title>Вход в аккаунт</title>
        <meta name="description" content="Войдите в свой аккаунт маркетплейса" />
    </Head>

    <MainLayout>
        <div class="auth-page">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-5 col-lg-4">
                        <div class="auth-card">
                            <div class="auth-header">
                                <div class="auth-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
                                    </svg>
                                </div>
                                <h1 class="auth-title">Вход в аккаунт</h1>
                                <p class="auth-subtitle">
                                    Войдите, чтобы покупать и продавать
                                </p>
                            </div>

                            <form @submit.prevent="submit" class="auth-form">
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
                                        autofocus
                                    />
                                    <span v-if="hasError('email')" class="error-message">
                                        {{ getError('email') }}
                                    </span>
                                </div>

                                <!-- Password -->
                                <div class="form-group" :class="{ 'has-error': hasError('password') }">
                                    <div class="label-row">
                                        <label for="password" class="form-label">Пароль</label>
                                        <a href="/forgot-password" class="forgot-link">Забыли пароль?</a>
                                    </div>
                                    <input
                                        id="password"
                                        v-model="form.password"
                                        type="password"
                                        class="form-input"
                                        :class="{ 'input-error': hasError('password') }"
                                        placeholder="••••••••"
                                    />
                                    <span v-if="hasError('password')" class="error-message">
                                        {{ getError('password') }}
                                    </span>
                                </div>

                                <!-- Remember -->
                                <label class="checkbox-wrapper">
                                    <input
                                        v-model="form.remember"
                                        type="checkbox"
                                        class="checkbox-input"
                                    />
                                    <span class="checkbox-custom"></span>
                                    <span class="checkbox-label">Запомнить меня</span>
                                </label>

                                <!-- Submit -->
                                <button
                                    type="submit"
                                    class="btn-submit"
                                    :disabled="form.processing"
                                >
                                    <span v-if="form.processing" class="spinner"></span>
                                    <span>{{ form.processing ? 'Вход...' : 'Войти' }}</span>
                                </button>
                            </form>

                            <div class="auth-footer">
                                <span>Нет аккаунта?</span>
                                <a href="/register">Зарегистрироваться</a>
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

.label-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.form-label {
    font-weight: 500;
    color: #495057;
    font-size: 0.9375rem;
}

.forgot-link {
    font-size: 0.875rem;
    color: #0d6efd;
    text-decoration: none;
}

.forgot-link:hover {
    text-decoration: underline;
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

/* Custom Checkbox */
.checkbox-wrapper {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    user-select: none;
}

.checkbox-input {
    display: none;
}

.checkbox-custom {
    width: 20px;
    height: 20px;
    border: 2px solid #dee2e6;
    border-radius: 5px;
    transition: all 0.2s;
    position: relative;
}

.checkbox-input:checked + .checkbox-custom {
    background: #0d6efd;
    border-color: #0d6efd;
}

.checkbox-input:checked + .checkbox-custom::after {
    content: '';
    position: absolute;
    left: 6px;
    top: 2px;
    width: 5px;
    height: 10px;
    border: solid #fff;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

.checkbox-label {
    color: #495057;
    font-size: 0.9375rem;
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
