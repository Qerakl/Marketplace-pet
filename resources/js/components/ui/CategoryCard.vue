<script setup lang="ts">
interface Category {
    id: number
    name: string
    slug: string
    description?: string
    icon?: string
    products_count: number
    url: string
}

defineProps<{
    category: Category
}>()

function formatCount(count: number): string {
    if (count >= 1000) {
        return Math.floor(count / 1000) + 'k'
    }
    return String(count)
}

const categoryIcons: Record<string, string> = {
    electronics: '💻',
    home: '🏠',
    fashion: '👕',
    kids: '🧸',
    auto: '🚗',
    sports: '⚽',
    beauty: '💄',
    hobby: '🎮',
}

function getCategoryIcon(slug: string): string {
    return categoryIcons[slug] || '📦'
}
</script>

<template>
    <a :href="category.url" class="text-decoration-none">
        <div class="category-card card h-100 border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div class="category-icon">
                        {{ getCategoryIcon(category.slug) }}
                    </div>
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                        {{ formatCount(category.products_count) }}
                    </span>
                </div>

                <h5 class="card-title fw-bold mb-2">{{ category.name }}</h5>

                <p v-if="category.description" class="card-text text-secondary small mb-0">
                    {{ category.description }}
                </p>
            </div>

            <div class="card-footer bg-transparent border-0 pb-4 pt-0 px-4">
                <div class="d-flex align-items-center text-primary fw-semibold small">
                    Смотреть товары
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        class="ms-2"
                        viewBox="0 0 16 16"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"
                        />
                    </svg>
                </div>
            </div>
        </div>
    </a>
</template>

<style scoped>
.category-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border-radius: 16px;
    overflow: hidden;
}

.category-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1) !important;
}

.category-icon {
    font-size: 2.5rem;
    line-height: 1;
}

.bg-primary-subtle {
    background-color: rgba(13, 110, 253, 0.1);
}
</style>
