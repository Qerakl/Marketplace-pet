<script setup lang="ts">
interface PaginationLink {
    url: string | null
    label: string
    active: boolean
}

interface PaginationMeta {
    current_page: number
    last_page: number
    per_page: number
    total: number
    links: PaginationLink[]
}

defineProps<{
    meta: PaginationMeta
}>()
</script>

<template>
    <nav v-if="meta.last_page > 1" aria-label="Пагинация">
        <ul class="pagination justify-content-center mb-0">
            <li
                v-for="(link, index) in meta.links"
                :key="index"
                class="page-item"
                :class="{ active: link.active, disabled: !link.url }"
            >
                <a
                    v-if="link.url"
                    class="page-link"
                    :href="link.url"
                    v-html="link.label"
                />
                <span v-else class="page-link" v-html="link.label" />
            </li>
        </ul>
    </nav>
</template>
