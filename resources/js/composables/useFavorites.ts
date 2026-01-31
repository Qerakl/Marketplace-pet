import { ref } from 'vue'

const favorites = ref<Set<number>>(new Set())

/**
 * Composable для работы с избранным.
 */
export function useFavorites() {
    function isFavorite(productId: number): boolean {
        return favorites.value.has(productId)
    }

    function toggle(productId: number): void {
        const set = new Set(favorites.value)

        if (set.has(productId)) {
            set.delete(productId)
        } else {
            set.add(productId)
        }

        favorites.value = set
    }

    function add(productId: number): void {
        const set = new Set(favorites.value)
        set.add(productId)
        favorites.value = set
    }

    function remove(productId: number): void {
        const set = new Set(favorites.value)
        set.delete(productId)
        favorites.value = set
    }

    return {
        favorites,
        isFavorite,
        toggle,
        add,
        remove,
    }
}
