<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import MainLayout from '@/layouts/MainLayout.vue'

interface Category {
    id: number
    name: string
    slug: string
    description: string
    products_count: number
}

defineProps<{
    categories: Category[]
}>()

const categoryIcons: Record<string, string> = {
    electronics: '📱',
    home: '🏠',
    fashion: '👗',
    kids: '🧸',
    auto: '🚗',
    sports: '⚽',
    beauty: '💄',
    hobby: '🎮',
}

function getIcon(slug: string): string {
    return categoryIcons[slug] || '📦'
}
</script>

<template>
    <Head>
        <title>Категории товаров</title>
        <meta name="description" content="Все категории товаров на маркетплейсе" />
    </Head>

    <MainLayout>
        <div class="categories-page">
            <div class="container">
                <div class="page-header">
                    <h1>Категории</h1>
                    <p>Выберите интересующую категорию товаров</p>
                </div>

                <div class="categories-grid">
                    <a
                        v-for="category in categories"
                        :key="category.id"
                        :href="`/catalog?category=${category.slug}`"
                        class="category-card"
                    >
                        <div class="category-icon">
                            {{ getIcon(category.slug) }}
                        </div>
                        <div class="category-info">
                            <h3>{{ category.name }}</h3>
                            <p>{{ category.description }}</p>
                            <span class="category-count">
                                {{ category.products_count }} товаров
                            </span>
                        </div>
                        <svg class="category-arrow" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<style scoped>
.categories-page {
    padding: 3rem 0;
    min-height: 100vh;
    background: #f8f9fa;
}

.page-header {
    text-align: center;
    margin-bottom: 3rem;
}

.page-header h1 {
    font-size: 2.25rem;
    font-weight: 700;
    color: #212529;
    margin-bottom: 0.5rem;
}

.page-header p {
    color: #6c757d;
    font-size: 1.125rem;
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}

@media (max-width: 767px) {
    .categories-grid {
        grid-template-columns: 1fr;
    }
}

.category-card {
    background: #fff;
    border-radius: 16px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1.25rem;
    text-decoration: none;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    transition: all 0.2s;
}

.category-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
}

.category-card:hover .category-arrow {
    transform: translateX(4px);
    color: #0d6efd;
}

.category-icon {
    width: 64px;
    height: 64px;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    flex-shrink: 0;
}

.category-info {
    flex: 1;
    min-width: 0;
}

.category-info h3 {
    font-size: 1.125rem;
    font-weight: 600;
    color: #212529;
    margin-bottom: 0.25rem;
}

.category-info p {
    color: #6c757d;
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.category-count {
    font-size: 0.8125rem;
    color: #0d6efd;
    font-weight: 500;
}

.category-arrow {
    color: #adb5bd;
    flex-shrink: 0;
    transition: all 0.2s;
}
</style>
