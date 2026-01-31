<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3'
import { computed, reactive, ref } from 'vue'
import MainLayout from '@/layouts/MainLayout.vue'
import ProductCard from '@/components/ui/ProductCard.vue'
import Pagination from '@/components/ui/Pagination.vue'
import { useFavorites } from '@/composables/useFavorites'

interface Category {
    id: number
    name: string
    slug: string
    description?: string
    products_count: number
    url: string
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
}

interface Props {
    products: {
        data: Product[]
        meta: {
            current_page: number
            last_page: number
            per_page: number
            total: number
            links: Array<{ url: string | null; label: string; active: boolean }>
        }
    }
    categories: Category[]
    currentCategory?: Category
    filters: {
        q?: string
        category?: string
        min_price?: string
        max_price?: string
        sort?: string
    }
}

const props = defineProps<Props>()
const { isFavorite, toggle: toggleFavorite } = useFavorites()

const localFilters = reactive({
    q: props.filters.q || '',
    category: props.filters.category || '',
    min_price: props.filters.min_price || '',
    max_price: props.filters.max_price || '',
    sort: props.filters.sort || '',
})

const isFiltering = ref(false)

const pageTitle = computed(() => {
    if (props.currentCategory) {
        return `${props.currentCategory.name} — Каталог`
    }
    return 'Каталог товаров'
})

const pageDescription = computed(() => {
    if (props.currentCategory) {
        return `Товары в категории ${props.currentCategory.name}. ${props.products.meta.total} предложений.`
    }
    return `Каталог товаров маркетплейса. ${props.products.meta.total} предложений.`
})

function applyFilters() {
    isFiltering.value = true

    const params: Record<string, string> = {}

    if (localFilters.q) params.q = localFilters.q
    if (localFilters.category) params.category = localFilters.category
    if (localFilters.min_price) params.min_price = localFilters.min_price
    if (localFilters.max_price) params.max_price = localFilters.max_price
    if (localFilters.sort) params.sort = localFilters.sort

    router.get('/catalog', params, {
        preserveState: true,
        onFinish: () => {
            isFiltering.value = false
        },
    })
}

function resetFilters() {
    localFilters.q = ''
    localFilters.category = ''
    localFilters.min_price = ''
    localFilters.max_price = ''
    localFilters.sort = ''
    applyFilters()
}

function handleToggleFavorite(productId: number) {
    toggleFavorite(productId)
}
</script>

<template>
    <Head>
        <title>{{ pageTitle }}</title>
        <meta name="description" :content="pageDescription" />
        <meta name="robots" content="index,follow" />
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
                        <li v-if="currentCategory" class="breadcrumb-item">
                            <a href="/catalog">Каталог</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ currentCategory?.name || 'Каталог' }}
                        </li>
                    </ol>
                </nav>

                <h1 class="fw-bold mb-4">{{ pageTitle }}</h1>

                <div class="row g-4">
                    <!-- Sidebar -->
                    <div class="col-lg-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="fw-semibold mb-3">Фильтры</h5>

                                <form @submit.prevent="applyFilters">
                                    <!-- Search -->
                                    <div class="mb-3">
                                        <label class="form-label small" for="search">Поиск</label>
                                        <input
                                            id="search"
                                            v-model="localFilters.q"
                                            type="search"
                                            class="form-control"
                                            placeholder="Название товара"
                                        />
                                    </div>

                                    <!-- Category -->
                                    <div class="mb-3">
                                        <label class="form-label small" for="category">
                                            Категория
                                        </label>
                                        <select
                                            id="category"
                                            v-model="localFilters.category"
                                            class="form-select"
                                        >
                                            <option value="">Все категории</option>
                                            <option
                                                v-for="cat in categories"
                                                :key="cat.id"
                                                :value="cat.slug"
                                            >
                                                {{ cat.name }} ({{ cat.products_count }})
                                            </option>
                                        </select>
                                    </div>

                                    <!-- Price -->
                                    <div class="mb-3">
                                        <label class="form-label small">Цена, ₽</label>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <input
                                                    v-model="localFilters.min_price"
                                                    type="number"
                                                    class="form-control"
                                                    placeholder="От"
                                                    min="0"
                                                />
                                            </div>
                                            <div class="col-6">
                                                <input
                                                    v-model="localFilters.max_price"
                                                    type="number"
                                                    class="form-control"
                                                    placeholder="До"
                                                    min="0"
                                                />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Sort -->
                                    <div class="mb-3">
                                        <label class="form-label small" for="sort">
                                            Сортировка
                                        </label>
                                        <select
                                            id="sort"
                                            v-model="localFilters.sort"
                                            class="form-select"
                                        >
                                            <option value="">По умолчанию</option>
                                            <option value="newest">Сначала новые</option>
                                            <option value="price_asc">Сначала дешёвые</option>
                                            <option value="price_desc">Сначала дорогие</option>
                                            <option value="popular">По популярности</option>
                                        </select>
                                    </div>

                                    <div class="d-grid gap-2">
                                        <button
                                            type="submit"
                                            class="btn btn-primary"
                                            :disabled="isFiltering"
                                        >
                                            Применить
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-outline-secondary"
                                            @click="resetFilters"
                                        >
                                            Сбросить
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Products -->
                    <div class="col-lg-9">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="text-secondary">
                                Найдено: {{ products.meta.total }} товаров
                            </div>
                        </div>

                        <div v-if="products.data.length > 0" class="row g-3">
                            <div
                                v-for="product in products.data"
                                :key="product.id"
                                class="col-12 col-md-6 col-xl-4"
                            >
                                <ProductCard
                                    :product="product"
                                    :is-favorite="isFavorite(product.id)"
                                    @toggle-favorite="handleToggleFavorite"
                                />
                            </div>
                        </div>

                        <div v-else class="text-center py-5">
                            <div class="text-secondary mb-3">
                                Товары не найдены. Попробуйте изменить фильтры.
                            </div>
                            <button class="btn btn-outline-primary" @click="resetFilters">
                                Сбросить фильтры
                            </button>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            <Pagination :meta="products.meta" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
