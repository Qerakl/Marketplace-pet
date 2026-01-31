<script setup lang="ts">
import { Head, router, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import MainLayout from '@/layouts/MainLayout.vue'
import ProductCard from '@/components/ui/ProductCard.vue'
import { useFavorites } from '@/composables/useFavorites'

interface User {
    id: number
    name: string
    email: string
    phone?: string
    avatar?: string
    role: string
    is_verified: boolean
    created_at: string
}

interface Product {
    id: number
    title: string
    slug: string
    formatted_price: string
    formatted_old_price?: string
    has_discount: boolean
    location?: string
    rating: number
    reviews_count?: number
    url: string
    main_image?: { url: string; thumb_url: string }
    category?: { name: string }
    status?: string
}

interface Props {
    user: User
    products: { data: Product[] }
    favorites: { data: Product[] }
}

const props = defineProps<Props>()
const { isFavorite, toggle: toggleFavorite } = useFavorites()

const activeTab = ref<'products' | 'favorites'>('products')
const showLogoutConfirm = ref(false)

const logoutForm = useForm({})

function logout() {
    logoutForm.post('/logout')
}

function handleToggleFavorite(productId: number) {
    toggleFavorite(productId)
}

function getRoleName(role: string): string {
    const roles: Record<string, string> = {
        buyer: 'Покупатель',
        seller: 'Продавец',
        admin: 'Администратор',
    }
    return roles[role] || role
}
</script>

<template>
    <Head>
        <title>Мой профиль</title>
        <meta name="robots" content="noindex,nofollow" />
    </Head>

    <MainLayout>
        <div class="bg-light py-4">
            <div class="container">
                <div class="row g-4">
                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center p-4">
                                <!-- Avatar -->
                                <div
                                    class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3"
                                    style="width: 80px; height: 80px; font-size: 2rem"
                                >
                                    {{ user.name.charAt(0).toUpperCase() }}
                                </div>

                                <h4 class="fw-bold mb-1">{{ user.name }}</h4>
                                <p class="text-secondary mb-2">{{ user.email }}</p>

                                <div class="d-flex justify-content-center gap-2 mb-3">
                                    <span class="badge text-bg-primary">
                                        {{ getRoleName(user.role) }}
                                    </span>
                                    <span v-if="user.is_verified" class="badge text-bg-success">
                                        Подтверждён
                                    </span>
                                </div>

                                <p v-if="user.phone" class="text-secondary small mb-2">
                                    {{ user.phone }}
                                </p>
                                <p class="text-secondary small mb-0">
                                    На сайте с {{ user.created_at }}
                                </p>
                            </div>

                            <div class="card-footer bg-white border-top">
                                <div class="d-grid gap-2">
                                    <a href="/profile/edit" class="btn btn-outline-primary">
                                        Редактировать профиль
                                    </a>
                                    <button
                                        class="btn btn-outline-danger"
                                        @click="showLogoutConfirm = true"
                                    >
                                        Выйти
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Stats -->
                        <div class="card border-0 shadow-sm mt-3">
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-6">
                                        <div class="h4 fw-bold mb-0">
                                            {{ products.data.length }}
                                        </div>
                                        <div class="text-secondary small">Товаров</div>
                                    </div>
                                    <div class="col-6">
                                        <div class="h4 fw-bold mb-0">
                                            {{ favorites.data.length }}
                                        </div>
                                        <div class="text-secondary small">В избранном</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="col-lg-8">
                        <!-- Tabs -->
                        <ul class="nav nav-pills mb-4">
                            <li class="nav-item">
                                <button
                                    class="nav-link"
                                    :class="{ active: activeTab === 'products' }"
                                    @click="activeTab = 'products'"
                                >
                                    Мои товары
                                </button>
                            </li>
                            <li class="nav-item">
                                <button
                                    class="nav-link"
                                    :class="{ active: activeTab === 'favorites' }"
                                    @click="activeTab = 'favorites'"
                                >
                                    Избранное
                                </button>
                            </li>
                        </ul>

                        <!-- Products Tab -->
                        <div v-if="activeTab === 'products'">
                            <div v-if="products.data.length > 0" class="row g-3">
                                <div
                                    v-for="product in products.data"
                                    :key="product.id"
                                    class="col-md-6"
                                >
                                    <ProductCard
                                        :product="product"
                                        :is-favorite="isFavorite(product.id)"
                                        @toggle-favorite="handleToggleFavorite"
                                    />
                                </div>
                            </div>

                            <div v-else class="text-center py-5">
                                <div class="text-secondary mb-3">У вас пока нет товаров</div>
                                <a href="/products/create" class="btn btn-primary">
                                    Добавить товар
                                </a>
                            </div>
                        </div>

                        <!-- Favorites Tab -->
                        <div v-if="activeTab === 'favorites'">
                            <div v-if="favorites.data.length > 0" class="row g-3">
                                <div
                                    v-for="product in favorites.data"
                                    :key="product.id"
                                    class="col-md-6"
                                >
                                    <ProductCard
                                        :product="product"
                                        :is-favorite="true"
                                        @toggle-favorite="handleToggleFavorite"
                                    />
                                </div>
                            </div>

                            <div v-else class="text-center py-5">
                                <div class="text-secondary mb-3">
                                    Вы ещё не добавили товары в избранное
                                </div>
                                <a href="/catalog" class="btn btn-primary">Перейти в каталог</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logout Modal -->
        <div
            v-if="showLogoutConfirm"
            class="modal fade show d-block"
            tabindex="-1"
            style="background: rgba(0, 0, 0, 0.5)"
            @click.self="showLogoutConfirm = false"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title">Выход из аккаунта</h5>
                        <button
                            type="button"
                            class="btn-close"
                            @click="showLogoutConfirm = false"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0">Вы уверены, что хотите выйти?</p>
                    </div>
                    <div class="modal-footer border-0">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            @click="showLogoutConfirm = false"
                        >
                            Отмена
                        </button>
                        <button
                            type="button"
                            class="btn btn-danger"
                            :disabled="logoutForm.processing"
                            @click="logout"
                        >
                            Выйти
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
