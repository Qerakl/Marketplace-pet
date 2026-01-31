<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3'
import MainLayout from '@/layouts/MainLayout.vue'

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
</script>

<template>
    <Head>
        <title>Вход в аккаунт</title>
        <meta name="description" content="Войдите в свой аккаунт маркетплейса" />
    </Head>

    <MainLayout>
        <div class="bg-light min-vh-100 d-flex align-items-center py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-5">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4 p-md-5">
                                <div class="text-center mb-4">
                                    <h1 class="h3 fw-bold">Вход в аккаунт</h1>
                                    <p class="text-secondary">
                                        Войдите, чтобы покупать и продавать
                                    </p>
                                </div>

                                <form @submit.prevent="submit">
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
                                            autofocus
                                        />
                                        <div v-if="form.errors.email" class="invalid-feedback">
                                            {{ form.errors.email }}
                                        </div>
                                    </div>

                                    <!-- Password -->
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between">
                                            <label for="password" class="form-label">Пароль</label>
                                            <a href="/forgot-password" class="small text-decoration-none">
                                                Забыли пароль?
                                            </a>
                                        </div>
                                        <input
                                            id="password"
                                            v-model="form.password"
                                            type="password"
                                            class="form-control form-control-lg"
                                            :class="{ 'is-invalid': form.errors.password }"
                                            placeholder="••••••••"
                                            required
                                        />
                                        <div v-if="form.errors.password" class="invalid-feedback">
                                            {{ form.errors.password }}
                                        </div>
                                    </div>

                                    <!-- Remember -->
                                    <div class="mb-4">
                                        <div class="form-check">
                                            <input
                                                id="remember"
                                                v-model="form.remember"
                                                type="checkbox"
                                                class="form-check-input"
                                            />
                                            <label for="remember" class="form-check-label">
                                                Запомнить меня
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Submit -->
                                    <div class="d-grid">
                                        <button
                                            type="submit"
                                            class="btn btn-primary btn-lg"
                                            :disabled="form.processing"
                                        >
                                            <span v-if="form.processing">Вход...</span>
                                            <span v-else>Войти</span>
                                        </button>
                                    </div>
                                </form>

                                <div class="text-center mt-4">
                                    <span class="text-secondary">Нет аккаунта?</span>
                                    <a href="/register" class="ms-1 text-decoration-none fw-semibold">
                                        Зарегистрироваться
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
