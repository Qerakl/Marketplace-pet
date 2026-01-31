<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3'
import MainLayout from '@/layouts/MainLayout.vue'

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
</script>

<template>
    <Head>
        <title>Регистрация</title>
        <meta name="description" content="Создайте аккаунт на маркетплейсе" />
    </Head>

    <MainLayout>
        <div class="bg-light min-vh-100 d-flex align-items-center py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4 p-md-5">
                                <div class="text-center mb-4">
                                    <h1 class="h3 fw-bold">Создать аккаунт</h1>
                                    <p class="text-secondary">
                                        Зарегистрируйтесь, чтобы начать покупать и продавать
                                    </p>
                                </div>

                                <form @submit.prevent="submit">
                                    <!-- Name -->
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Имя</label>
                                        <input
                                            id="name"
                                            v-model="form.name"
                                            type="text"
                                            class="form-control form-control-lg"
                                            :class="{ 'is-invalid': form.errors.name }"
                                            placeholder="Ваше имя"
                                            required
                                            autofocus
                                        />
                                        <div v-if="form.errors.name" class="invalid-feedback">
                                            {{ form.errors.name }}
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input
                                            id="email"
                                            v-model="form.email"
                                            type="email"
                                            class="form-control form-control-lg"
                                            :class="{ 'is-invalid': form.errors.email }"
                                            placeholder="you@example.com"
                                            required
                                        />
                                        <div v-if="form.errors.email" class="invalid-feedback">
                                            {{ form.errors.email }}
                                        </div>
                                    </div>

                                    <!-- Phone -->
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">
                                            Телефон <span class="text-secondary">(необязательно)</span>
                                        </label>
                                        <input
                                            id="phone"
                                            v-model="form.phone"
                                            type="tel"
                                            class="form-control form-control-lg"
                                            :class="{ 'is-invalid': form.errors.phone }"
                                            placeholder="+7 (999) 123-45-67"
                                        />
                                        <div v-if="form.errors.phone" class="invalid-feedback">
                                            {{ form.errors.phone }}
                                        </div>
                                    </div>

                                    <!-- Password -->
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Пароль</label>
                                        <input
                                            id="password"
                                            v-model="form.password"
                                            type="password"
                                            class="form-control form-control-lg"
                                            :class="{ 'is-invalid': form.errors.password }"
                                            placeholder="Минимум 8 символов"
                                            required
                                        />
                                        <div v-if="form.errors.password" class="invalid-feedback">
                                            {{ form.errors.password }}
                                        </div>
                                    </div>

                                    <!-- Password Confirmation -->
                                    <div class="mb-4">
                                        <label for="password_confirmation" class="form-label">
                                            Подтвердите пароль
                                        </label>
                                        <input
                                            id="password_confirmation"
                                            v-model="form.password_confirmation"
                                            type="password"
                                            class="form-control form-control-lg"
                                            placeholder="Повторите пароль"
                                            required
                                        />
                                    </div>

                                    <!-- Terms -->
                                    <div class="mb-4">
                                        <p class="small text-secondary mb-0">
                                            Регистрируясь, вы соглашаетесь с
                                            <a href="/terms" class="text-decoration-none">
                                                условиями использования
                                            </a>
                                            и
                                            <a href="/privacy" class="text-decoration-none">
                                                политикой конфиденциальности
                                            </a>
                                        </p>
                                    </div>

                                    <!-- Submit -->
                                    <div class="d-grid">
                                        <button
                                            type="submit"
                                            class="btn btn-primary btn-lg"
                                            :disabled="form.processing"
                                        >
                                            <span v-if="form.processing">Регистрация...</span>
                                            <span v-else>Зарегистрироваться</span>
                                        </button>
                                    </div>
                                </form>

                                <div class="text-center mt-4">
                                    <span class="text-secondary">Уже есть аккаунт?</span>
                                    <a href="/login" class="ms-1 text-decoration-none fw-semibold">
                                        Войти
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
