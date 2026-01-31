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
</script>

<template>
    <a :href="category.url" class="text-decoration-none">
        <div class="card h-100 border-0 shadow-sm hover-lift">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="fw-semibold">{{ category.name }}</div>
                    <span class="badge text-bg-light border">
                        {{ formatCount(category.products_count) }}
                    </span>
                </div>
                <div v-if="category.description" class="text-secondary small">
                    {{ category.description }}
                </div>
            </div>
            <div class="card-footer bg-white border-0 pt-0">
                <div class="text-primary small fw-semibold">Открыть →</div>
            </div>
        </div>
    </a>
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
