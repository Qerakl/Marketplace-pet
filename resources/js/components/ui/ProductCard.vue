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
</script>

<template>
    <div class="card h-100 border-0 shadow-sm hover-lift">
        <a :href="product.url" class="text-decoration-none">
            <div class="ratio ratio-4x3 rounded-top overflow-hidden">
                <img
                    :src="imageUrl"
                    :alt="product.title"
                    class="object-fit-cover"
                    loading="lazy"
                />
            </div>
        </a>

        <div class="card-body">
            <div class="d-flex align-items-start justify-content-between gap-2">
                <a :href="product.url" class="text-decoration-none text-dark">
                    <div class="fw-semibold text-truncate">{{ product.title }}</div>
                </a>
                <span v-if="product.category" class="badge text-bg-light border small">
                    {{ product.category.name }}
                </span>
            </div>

            <div v-if="product.location" class="text-secondary small mb-2 text-truncate">
                {{ product.location }}
            </div>

            <div class="d-flex align-items-center justify-content-between mb-2">
                <div>
                    <span class="fw-bold fs-5">{{ product.formatted_price }}</span>
                    <span
                        v-if="product.has_discount && product.formatted_old_price"
                        class="text-secondary text-decoration-line-through ms-2 small"
                    >
                        {{ product.formatted_old_price }}
                    </span>
                </div>
                <div v-if="product.rating > 0" class="small text-secondary">
                    ★ {{ product.rating }}
                    <span v-if="product.reviews_count">({{ product.reviews_count }})</span>
                </div>
            </div>

            <div class="d-flex gap-2">
                <a class="btn btn-primary w-100" :href="product.url">Открыть</a>
                <button
                    class="btn btn-outline-secondary"
                    type="button"
                    @click="emit('toggleFavorite', product.id)"
                >
                    <span v-if="isFavorite">♥</span>
                    <span v-else>♡</span>
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
.hover-lift {
    transition:
        transform 0.15s ease,
        box-shadow 0.15s ease;
}
.hover-lift:hover {
    transform: translateY(-2px);
}
</style>
