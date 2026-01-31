<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import MainLayout from '@/layouts/MainLayout.vue'

interface User {
    id: number
    name: string
    email: string
    phone?: string
}

interface Props {
    user: User
}

const props = defineProps<Props>()

const profileForm = useForm({
    name: props.user.name,
    email: props.user.email,
    phone: props.user.phone || '',
})

const passwordForm = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
})

const showDeleteModal = ref(false)

const deleteForm = useForm({
    password: '',
})

function updateProfile() {
    profileForm.patch('/profile', {
        preserveScroll: true,
    })
}

function updatePassword() {
    passwordForm.put('/profile/password', {
        preserveScroll: true,
        onSuccess: () => passwordForm.reset(),
    })
}

function deleteAccount() {
    deleteForm.delete('/profile', {
        preserveScroll: true,
    })
}
</script>

<template>
    <Head>
        <title>Редактирование профиля</title>
        <meta name="robots" content="noindex,nofollow" />
    </Head>

    <MainLayout>
        <div class="bg-light py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <!-- Breadcrumb -->
                        <nav aria-label="Навигация">
                            <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item">
                                    <a href="/profile">Профиль</a>
                                </li>
                                <li class="breadcrumb-item active">Редактирование</li>
                            </ol>
                        </nav>

                        <!-- Profile Form -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0 fw-bold">Личные данные</h5>
                            </div>
                            <div class="card-body p-4">
                                <form @submit.prevent="updateProfile">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Имя</label>
                                        <input
                                            id="name"
                                            v-model="profileForm.name"
                                            type="text"
                                            class="form-control"
                                            :class="{ 'is-invalid': profileForm.errors.name }"
                                            required
                                        />
                                        <div
                                            v-if="profileForm.errors.name"
                                            class="invalid-feedback"
                                        >
                                            {{ profileForm.errors.name }}
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input
                                            id="email"
                                            v-model="profileForm.email"
                                            type="email"
                                            class="form-control"
                                            :class="{ 'is-invalid': profileForm.errors.email }"
                                            required
                                        />
                                        <div
                                            v-if="profileForm.errors.email"
                                            class="invalid-feedback"
                                        >
                                            {{ profileForm.errors.email }}
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="phone" class="form-label">Телефон</label>
                                        <input
                                            id="phone"
                                            v-model="profileForm.phone"
                                            type="tel"
                                            class="form-control"
                                            :class="{ 'is-invalid': profileForm.errors.phone }"
                                        />
                                        <div
                                            v-if="profileForm.errors.phone"
                                            class="invalid-feedback"
                                        >
                                            {{ profileForm.errors.phone }}
                                        </div>
                                    </div>

                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                        :disabled="profileForm.processing"
                                    >
                                        Сохранить изменения
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Password Form -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0 fw-bold">Изменить пароль</h5>
                            </div>
                            <div class="card-body p-4">
                                <form @submit.prevent="updatePassword">
                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">
                                            Текущий пароль
                                        </label>
                                        <input
                                            id="current_password"
                                            v-model="passwordForm.current_password"
                                            type="password"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': passwordForm.errors.current_password,
                                            }"
                                            required
                                        />
                                        <div
                                            v-if="passwordForm.errors.current_password"
                                            class="invalid-feedback"
                                        >
                                            {{ passwordForm.errors.current_password }}
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">
                                            Новый пароль
                                        </label>
                                        <input
                                            id="password"
                                            v-model="passwordForm.password"
                                            type="password"
                                            class="form-control"
                                            :class="{ 'is-invalid': passwordForm.errors.password }"
                                            required
                                        />
                                        <div
                                            v-if="passwordForm.errors.password"
                                            class="invalid-feedback"
                                        >
                                            {{ passwordForm.errors.password }}
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="password_confirmation" class="form-label">
                                            Подтвердите новый пароль
                                        </label>
                                        <input
                                            id="password_confirmation"
                                            v-model="passwordForm.password_confirmation"
                                            type="password"
                                            class="form-control"
                                            required
                                        />
                                    </div>

                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                        :disabled="passwordForm.processing"
                                    >
                                        Изменить пароль
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Delete Account -->
                        <div class="card border-0 shadow-sm border-danger">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0 fw-bold text-danger">Удалить аккаунт</h5>
                            </div>
                            <div class="card-body p-4">
                                <p class="text-secondary mb-3">
                                    После удаления аккаунта все ваши данные будут безвозвратно
                                    удалены. Это действие нельзя отменить.
                                </p>
                                <button
                                    class="btn btn-outline-danger"
                                    @click="showDeleteModal = true"
                                >
                                    Удалить аккаунт
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div
            v-if="showDeleteModal"
            class="modal fade show d-block"
            tabindex="-1"
            style="background: rgba(0, 0, 0, 0.5)"
            @click.self="showDeleteModal = false"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title text-danger">Удаление аккаунта</h5>
                        <button
                            type="button"
                            class="btn-close"
                            @click="showDeleteModal = false"
                        ></button>
                    </div>
                    <form @submit.prevent="deleteAccount">
                        <div class="modal-body">
                            <p class="mb-3">
                                Введите пароль для подтверждения удаления аккаунта:
                            </p>
                            <input
                                v-model="deleteForm.password"
                                type="password"
                                class="form-control"
                                :class="{ 'is-invalid': deleteForm.errors.password }"
                                placeholder="Ваш пароль"
                                required
                            />
                            <div v-if="deleteForm.errors.password" class="invalid-feedback">
                                {{ deleteForm.errors.password }}
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                @click="showDeleteModal = false"
                            >
                                Отмена
                            </button>
                            <button
                                type="submit"
                                class="btn btn-danger"
                                :disabled="deleteForm.processing"
                            >
                                Удалить навсегда
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
