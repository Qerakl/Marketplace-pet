<script setup lang="ts">
import { computed } from 'vue'

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
    status?: string
    main_image?: {
        url: string
        thumb_url: string
    }
    category?: {
        name: string
    }
}

const props = defineProps<{
    product: Product
    isFavorite?: boolean
}>()

const emit = defineEmits<{
    toggleFavorite: [id: number]
}>()

const imageUrl = computed(() => props.product.main_image?.url || '/images/placeholder.jpg')

const discountPercent = computed(() => {
    if (!props.product.has_discount || !props.product.formatted_old_price) return null
    const oldPrice = parseFloat(props.product.formatted_old_price.replace(/\s/g, ''))
    const newPrice = parseFloat(props.product.formatted_price.replace(/\s/g, ''))
    if (oldPrice && newPrice) {
        return Math.round(((oldPrice - newPrice) / oldPrice) * 100)
    }
    return null
})

function formatRating(rating: number | string | null | undefined): string {
    const num = Number(rating) || 0
    return num.toFixed(1)
}
</script>

<template>
    <div class="product-card card h-100 border-0 shadow-sm">
        <!-- Image Container -->
        <div class="position-relative">
            <a :href="product.url" class="text-decoration-none">
                <div class="product-image-wrapper">
                    <img
                        :src="imageUrl"
                        :alt="product.title"
                        class="product-image"
                        loading="lazy"
                    />
                </div>
            </a>

            <!-- Badges -->
            <div class="position-absolute top-0 start-0 p-2 d-flex flex-column gap-1">
                <span v-if="discountPercent" class="badge bg-danger">
                    -{{ discountPercent }}%
                </span>
                <span v-if="product.status === 'pending'" class="badge bg-warning text-dark">
                    На модерации
                </span>
                <span v-if="product.status === 'sold'" class="badge bg-secondary">
                    Продано
                </span>
            </div>

            <!-- Favorite Button -->
            <button
                class="btn-favorite position-absolute top-0 end-0 m-2"
                :class="{ active: isFavorite }"
                type="button"
                @click.prevent="emit('toggleFavorite', product.id)"
                aria-label="Добавить в избранное"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="20"
                    height="20"
                    fill="currentColor"
                    viewBox="0 0 16 16"
                >
                    <path
                        v-if="isFavorite"
                        d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"
                    />
                    <path
                        v-else
                        d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"
                    />
                </svg>
            </button>
        </div>

        <!-- Content -->
        <div class="card-body d-flex flex-column">
            <!-- Category -->
            <div v-if="product.category" class="mb-1">
                <span class="badge bg-light text-secondary border small">
                    {{ product.category.name }}
                </span>
            </div>

            <!-- Title -->
            <a :href="product.url" class="text-decoration-none text-dark">
                <h6 class="card-title fw-semibold mb-2 product-title">
                    {{ product.title }}
                </h6>
            </a>

            <!-- Location -->
            <div v-if="product.location" class="text-secondary small mb-2 d-flex align-items-center">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="12"
                    height="12"
                    fill="currentColor"
                    class="me-1"
                    viewBox="0 0 16 16"
                >
                    <path
                        d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"
                    />
                </svg>
                {{ product.location }}
            </div>

            <!-- Rating -->
            <div v-if="Number(product.rating) > 0" class="d-flex align-items-center mb-2">
                <div class="rating-stars me-1">
                    <span v-for="i in 5" :key="i" class="star" :class="{ filled: i <= Math.round(Number(product.rating)) }">
                        ★
                    </span>
                </div>
                <span class="text-secondary small">
                    {{ formatRating(product.rating) }}
                    <span v-if="product.reviews_count">({{ product.reviews_count }})</span>
                </span>
            </div>

            <!-- Price -->
            <div class="mt-auto">
                <div class="d-flex align-items-baseline gap-2">
                    <span class="h5 fw-bold text-primary mb-0">
                        {{ product.formatted_price }}
                    </span>
                    <span
                        v-if="product.has_discount && product.formatted_old_price"
                        class="text-secondary text-decoration-line-through small"
                    >
                        {{ product.formatted_old_price }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="card-footer bg-white border-0 pt-0 pb-3 px-3">
            <a :href="product.url" class="btn btn-primary w-100">
                Подробнее
            </a>
        </div>
    </div>
</template>

<style scoped>
.product-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    overflow: hidden;
    border-radius: 12px;
}

.product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1) !important;
}

.product-image-wrapper {
    aspect-ratio: 4 / 3;
    overflow: hidden;
    background: #f8f9fa;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image {
    transform: scale(1.05);
}

.product-title {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.4;
}

.btn-favorite {
    width: 36px;
    height: 36px;
    padding: 0;
    border: none;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.9);
    color: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    backdrop-filter: blur(4px);
}

.btn-favorite:hover {
    background: #fff;
    color: #dc3545;
    transform: scale(1.1);
}

.btn-favorite.active {
    color: #dc3545;
}

.rating-stars {
    display: flex;
    gap: 1px;
}

.star {
    color: #dee2e6;
    font-size: 12px;
}

.star.filled {
    color: #ffc107;
}
</style>
