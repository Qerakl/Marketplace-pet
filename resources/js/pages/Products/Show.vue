<script setup lang="ts">
import { computed } from 'vue'
import { Head } from '@inertiajs/vue3'
import MainLayout from '@/layouts/MainLayout.vue'
import ProductCard from '@/components/ui/ProductCard.vue'
import { useFavorites } from '@/composables/useFavorites'

interface ProductImage {
    id: number
    url: string
    thumb_url: string
    is_main: boolean
}

interface Review {
    id: number
    rating: number
    comment: string
    user: { id: number; name: string; avatar?: string }
    created_at: string
}

interface Product {
    id: number
    title: string
    slug: string
    description?: string
    formatted_price: string
    formatted_old_price?: string
    has_discount: boolean
    location?: string
    rating: number
    reviews_count?: number
    views_count: number
    url: string
    main_image?: ProductImage
    images?: ProductImage[]
    category?: { id: number; name: string; slug: string; url: string }
    user?: { id: number; name: string; avatar?: string; is_verified: boolean }
    reviews?: Review[]
    created_at: string
}

interface Props {
    product: Product
    similar: Product[]
}

const props = defineProps<Props>()
const { isFavorite, toggle: toggleFavorite } = useFavorites()

const mainImage = computed(() => {
    if (props.product.main_image) {
        return props.product.main_image.url
    }
    if (props.product.images?.length) {
        return props.product.images[0].url
    }
    return '/images/placeholder.jpg'
})

const pageTitle = computed(() => `${props.product.title} — Купить`)

const pageDescription = computed(() => {
    const desc = props.product.description?.slice(0, 160) || ''
    return `${props.product.title} за ${props.product.formatted_price}. ${desc}`
})

function handleToggleFavorite(productId: number) {
    toggleFavorite(productId)
}

function formatRating(rating: number): string {
    return '★'.repeat(Math.round(rating)) + '☆'.repeat(5 - Math.round(rating))
}
</script>

<template>
    <Head>
        <title>{{ pageTitle }}</title>
        <meta name="description" :content="pageDescription" />
        <meta name="robots" content="index,follow" />

        <meta property="og:type" content="product" />
        <meta property="og:title" :content="product.title" />
        <meta property="og:description" :content="pageDescription" />
        <meta property="og:image" :content="mainImage" />

        <meta property="product:price:amount" :content="String(product.formatted_price)" />
        <meta property="product:price:currency" content="RUB" />
    </Head>

    <MainLayout>
        <div class="bg-light py-4">
            <div class="container">
                <!-- Breadcrumb -->
                <nav aria-label="Навигация">
                    <ol class="breadcrumb mb-3">
                        <li class="breadcrumb-item">
                            <a href="/">Главная</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="/catalog">Каталог</a>
                        </li>
                        <li v-if="product.category" class="breadcrumb-item">
                            <a :href="product.category.url">{{ product.category.name }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ product.title }}
                        </li>
                    </ol>
                </nav>

                <div class="row g-4">
                    <!-- Images -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm">
                            <div class="ratio ratio-1x1">
                                <img
                                    :src="mainImage"
                                    :alt="product.title"
                                    class="object-fit-contain p-3"
                                />
                            </div>
                        </div>

                        <div
                            v-if="product.images && product.images.length > 1"
                            class="row g-2 mt-2"
                        >
                            <div
                                v-for="image in product.images.slice(0, 4)"
                                :key="image.id"
                                class="col-3"
                            >
                                <div class="ratio ratio-1x1">
                                    <img
                                        :src="image.thumb_url"
                                        :alt="product.title"
                                        class="object-fit-cover rounded border"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between gap-2">
                                    <h1 class="h3 fw-bold mb-2">{{ product.title }}</h1>
                                    <button
                                        class="btn btn-outline-secondary"
                                        @click="handleToggleFavorite(product.id)"
                                    >
                                        <span v-if="isFavorite(product.id)" class="fs-5">♥</span>
                                        <span v-else class="fs-5">♡</span>
                                    </button>
                                </div>

                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div v-if="product.rating > 0" class="text-warning">
                                        {{ formatRating(product.rating) }}
                                        <span class="text-secondary ms-1">
                                            {{ product.rating }}
                                        </span>
                                    </div>
                                    <span
                                        v-if="product.reviews_count"
                                        class="text-secondary small"
                                    >
                                        {{ product.reviews_count }} отзывов
                                    </span>
                                    <span class="text-secondary small">
                                        {{ product.views_count }} просмотров
                                    </span>
                                </div>

                                <div class="mb-4">
                                    <span class="h2 fw-bold text-primary">
                                        {{ product.formatted_price }}
                                    </span>
                                    <span
                                        v-if="
                                            product.has_discount && product.formatted_old_price
                                        "
                                        class="text-secondary text-decoration-line-through ms-2"
                                    >
                                        {{ product.formatted_old_price }}
                                    </span>
                                </div>

                                <div class="d-grid gap-2 mb-4">
                                    <button class="btn btn-primary btn-lg">Купить</button>
                                    <button class="btn btn-outline-secondary">
                                        Написать продавцу
                                    </button>
                                </div>

                                <!-- Seller -->
                                <div v-if="product.user" class="border-top pt-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div
                                            class="rounded-circle bg-secondary-subtle d-flex align-items-center justify-content-center"
                                            style="width: 48px; height: 48px"
                                        >
                                            <span class="text-secondary">
                                                {{ product.user.name.charAt(0) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">
                                                {{ product.user.name }}
                                                <span
                                                    v-if="product.user.is_verified"
                                                    class="badge text-bg-success ms-1"
                                                >
                                                    Проверен
                                                </span>
                                            </div>
                                            <div
                                                v-if="product.location"
                                                class="text-secondary small"
                                            >
                                                {{ product.location }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div v-if="product.description" class="card border-0 shadow-sm mt-3">
                            <div class="card-body">
                                <h2 class="h5 fw-bold mb-3">Описание</h2>
                                <div class="text-secondary" style="white-space: pre-line">
                                    {{ product.description }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reviews -->
                <div v-if="product.reviews?.length" class="card border-0 shadow-sm mt-4">
                    <div class="card-body">
                        <h2 class="h5 fw-bold mb-3">
                            Отзывы ({{ product.reviews_count }})
                        </h2>

                        <div class="row g-3">
                            <div
                                v-for="review in product.reviews"
                                :key="review.id"
                                class="col-12 col-md-6"
                            >
                                <div class="border rounded p-3">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div
                                            class="rounded-circle bg-secondary-subtle d-flex align-items-center justify-content-center"
                                            style="width: 32px; height: 32px"
                                        >
                                            <span class="text-secondary small">
                                                {{ review.user.name.charAt(0) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="fw-semibold small">
                                                {{ review.user.name }}
                                            </div>
                                            <div class="text-warning small">
                                                {{ formatRating(review.rating) }}
                                            </div>
                                        </div>
                                        <div class="text-secondary small ms-auto">
                                            {{ review.created_at }}
                                        </div>
                                    </div>
                                    <div v-if="review.comment" class="text-secondary small">
                                        {{ review.comment }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Similar products -->
                <div v-if="similar.length > 0" class="mt-4">
                    <h2 class="h5 fw-bold mb-3">Похожие товары</h2>
                    <div class="row g-3">
                        <div
                            v-for="item in similar"
                            :key="item.id"
                            class="col-12 col-md-6 col-lg-3"
                        >
                            <ProductCard
                                :product="item"
                                :is-favorite="isFavorite(item.id)"
                                @toggle-favorite="handleToggleFavorite"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
