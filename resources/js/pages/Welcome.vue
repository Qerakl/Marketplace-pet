<script setup lang="ts">
import { computed, reactive, ref } from 'vue'
import { Head, router } from '@inertiajs/vue3'
import MainLayout from '@/layouts/MainLayout.vue'
import ProductCard from '@/components/ui/ProductCard.vue'
import CategoryCard from '@/components/ui/CategoryCard.vue'
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
    categories: Category[]
    featured: Product[]
    stats: {
        products_count: number
        sellers_count: number
        categories_count: number
    }
}

const props = defineProps<Props>()
const { isFavorite, toggle: toggleFavorite } = useFavorites()

const meta = reactive({
    siteName: 'Marketplace',
    title: 'Marketplace — купи и продай товары безопасно',
    description:
        'Маркетплейс для покупки и продажи товаров: категории, отзывы, безопасные сделки и удобная доставка.',
    keywords: 'маркетплейс, купить, продать, товары, доставка, безопасная сделка',
    canonical: typeof window !== 'undefined' ? window.location.origin + '/' : 'https://example.com/',
    ogTitle: 'Marketplace — купи и продай товары безопасно',
    ogDescription:
        'Выбирай товары по категориям, читай отзывы, покупай с защитой сделки и удобной доставкой.',
    ogImage:
        typeof window !== 'undefined'
            ? window.location.origin + '/images/og/marketplace-home.jpg'
            : 'https://example.com/images/og/marketplace-home.jpg',
})

const jsonLd = computed(() => {
    const origin = typeof window !== 'undefined' ? window.location.origin : 'https://example.com'
    return JSON.stringify(
        {
            '@context': 'https://schema.org',
            '@graph': [
                {
                    '@type': 'Organization',
                    name: meta.siteName,
                    url: meta.canonical,
                    logo: origin + '/favicon.ico',
                },
                {
                    '@type': 'WebSite',
                    name: meta.siteName,
                    url: meta.canonical,
                    potentialAction: {
                        '@type': 'SearchAction',
                        target: origin + '/catalog?q={search_term_string}',
                        'query-input': 'required name=search_term_string',
                    },
                },
            ],
        },
        null,
        0
    )
})

const statsDisplay = computed(() => [
    { value: formatCount(props.stats.products_count) + '+', label: 'товаров в каталоге' },
    { value: formatCount(props.stats.sellers_count) + '+', label: 'продавцов' },
    { value: '4.7★', label: 'средний рейтинг' },
    { value: '24/7', label: 'поддержка' },
])

const steps = [
    { title: 'Найди товар', text: 'Поиск, фильтры, категории и честные отзывы.' },
    { title: 'Купи безопасно', text: 'Оплата с защитой сделки и прозрачные условия.' },
    { title: 'Получи доставку', text: 'Трекинг заказа и поддержка на каждом шаге.' },
]

const faqs = [
    {
        q: 'Какая комиссия платформы?',
        a: 'Комиссия зависит от категории и тарифа. На старте можно сделать 0% на первые заказы.',
    },
    {
        q: 'Как работает защита сделки?',
        a: 'Деньги резервируются и перечисляются продавцу после подтверждения получения товара.',
    },
    {
        q: 'Можно ли продавать без ИП?',
        a: 'Да, для частных продаж. Для магазина/массовых продаж лучше подключать юридический профиль.',
    },
    {
        q: 'Как подключить доставку?',
        a: 'Можно выбрать интеграцию с доставкой или самовывоз. Настройки — в кабинете продавца.',
    },
]

const trending = ['iphone', 'airpods', 'drill', 'nike', 'ps5']

const search = reactive({
    q: '',
    category: '',
})

const subscribeEmail = ref('')
const subscribeMsg = ref('')

function formatCount(count: number): string {
    if (count >= 1000) {
        return Math.floor(count / 1000) + 'k'
    }
    return String(count)
}

function onSearch() {
    const params: Record<string, string> = {}
    if (search.q) params.q = search.q
    if (search.category) params.category = search.category
    router.get('/catalog', params)
}

function applyTrending(tag: string) {
    search.q = tag
    onSearch()
}

function handleToggleFavorite(productId: number) {
    toggleFavorite(productId)
}

function onSubscribe() {
    subscribeMsg.value = `Ок! Проверяй почту: ${subscribeEmail.value}`
    subscribeEmail.value = ''
}
</script>

<template>
    <Head>
        <title>{{ meta.title }}</title>
        <meta name="description" :content="meta.description" />
        <meta name="keywords" :content="meta.keywords" />
        <meta name="robots" content="index,follow" />
        <link rel="canonical" :href="meta.canonical" />

        <meta property="og:type" content="website" />
        <meta property="og:site_name" :content="meta.siteName" />
        <meta property="og:title" :content="meta.ogTitle" />
        <meta property="og:description" :content="meta.ogDescription" />
        <meta property="og:url" :content="meta.canonical" />
        <meta property="og:image" :content="meta.ogImage" />

        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" :content="meta.ogTitle" />
        <meta name="twitter:description" :content="meta.ogDescription" />
        <meta name="twitter:image" :content="meta.ogImage" />

        <meta name="theme-color" content="#0d6efd" />

        <script type="application/ld+json" v-html="jsonLd" />
    </Head>

    <MainLayout>
        <!-- Hero -->
        <section class="bg-light">
            <div class="container py-5 py-lg-6">
                <div class="row align-items-center g-4">
                    <div class="col-lg-6">
                        <span class="badge text-bg-primary mb-3">Маркетплейс • Быстро • Надёжно</span>
                        <h1 class="display-5 fw-bold mb-3">
                            Покупай и продавай товары
                            <span class="text-primary">в одном месте</span>
                        </h1>
                        <p class="lead text-secondary mb-4">
                            Поиск по категориям, честные отзывы, безопасные сделки и удобная
                            доставка. Запускай витрину за минуты.
                        </p>

                        <!-- Search -->
                        <form class="card shadow-sm border-0" @submit.prevent="onSearch">
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-12 col-md-7">
                                        <label class="form-label visually-hidden" for="q">
                                            Поиск
                                        </label>
                                        <input
                                            id="q"
                                            v-model.trim="search.q"
                                            type="search"
                                            class="form-control form-control-lg"
                                            placeholder="Например: iPhone, кроссовки, дрель…"
                                            autocomplete="off"
                                        />
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label visually-hidden" for="cat">
                                            Категория
                                        </label>
                                        <select
                                            id="cat"
                                            v-model="search.category"
                                            class="form-select form-select-lg"
                                        >
                                            <option value="">Все категории</option>
                                            <option
                                                v-for="c in categories"
                                                :key="c.id"
                                                :value="c.slug"
                                            >
                                                {{ c.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-2 d-grid">
                                        <button class="btn btn-primary btn-lg" type="submit">
                                            Найти
                                        </button>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap gap-2 mt-3 small text-secondary">
                                    <span>Популярно:</span>
                                    <a
                                        v-for="t in trending"
                                        :key="t"
                                        href="#"
                                        class="link-secondary text-decoration-none"
                                        @click.prevent="applyTrending(t)"
                                    >
                                        #{{ t }}
                                    </a>
                                </div>
                            </div>
                        </form>

                        <div class="d-flex flex-wrap gap-4 mt-4 text-secondary small">
                            <div class="d-flex align-items-center gap-2">
                                <span class="icon-dot bg-success"></span>
                                <span>Проверенные продавцы</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="icon-dot bg-primary"></span>
                                <span>Защита сделки</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="icon-dot bg-warning"></span>
                                <span>Поддержка 24/7</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="position-relative">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <div v-if="featured.length > 0" class="row g-3">
                                        <div
                                            v-for="product in featured.slice(0, 4)"
                                            :key="product.id"
                                            class="col-6"
                                        >
                                            <ProductCard
                                                :product="product"
                                                :is-favorite="isFavorite(product.id)"
                                                @toggle-favorite="handleToggleFavorite"
                                            />
                                        </div>
                                    </div>

                                    <div v-else class="row g-3">
                                        <div v-for="i in 4" :key="i" class="col-6">
                                            <div class="card h-100 border-0 bg-white shadow-sm">
                                                <div
                                                    class="ratio ratio-4x3 rounded-top overflow-hidden"
                                                >
                                                    <div
                                                        class="bg-secondary-subtle d-flex align-items-center justify-content-center"
                                                    >
                                                        <span class="text-secondary small">
                                                            Фото товара
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="placeholder-glow">
                                                        <span
                                                            class="placeholder col-8 mb-2"
                                                        ></span>
                                                        <span class="placeholder col-6"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="alert alert-primary border-0 mt-3 mb-0">
                                        <div class="fw-bold">Новым продавцам</div>
                                        <div class="small text-secondary">
                                            Комиссия 0% на первые 30 заказов. Подключи витрину за 5
                                            минут.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats -->
        <section class="bg-white">
            <div class="container py-4">
                <div class="row g-3 text-center">
                    <div v-for="s in statsDisplay" :key="s.label" class="col-6 col-lg-3">
                        <div class="p-3 border rounded-4 h-100">
                            <div class="h3 fw-bold mb-1">{{ s.value }}</div>
                            <div class="text-secondary small">{{ s.label }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Categories -->
        <section id="categories" class="bg-light">
            <div class="container py-5">
                <div class="d-flex align-items-end justify-content-between gap-3 mb-3">
                    <div>
                        <h2 class="fw-bold mb-1">Категории</h2>
                        <div class="text-secondary">
                            Выбери направление — и смотри лучшие предложения
                        </div>
                    </div>
                    <a class="btn btn-sm btn-outline-secondary" href="/catalog">Все категории</a>
                </div>

                <div class="row g-3">
                    <div
                        v-for="category in categories"
                        :key="category.id"
                        class="col-12 col-sm-6 col-lg-3"
                    >
                        <CategoryCard :category="category" />
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured products -->
        <section id="featured" class="bg-white">
            <div class="container py-5">
                <div class="d-flex align-items-end justify-content-between gap-3 mb-3">
                    <div>
                        <h2 class="fw-bold mb-1">Топ-товары</h2>
                        <div class="text-secondary">
                            Подборка, которая чаще всего покупается сегодня
                        </div>
                    </div>
                    <a class="btn btn-sm btn-outline-primary" href="/catalog">Перейти в каталог</a>
                </div>

                <div class="row g-3">
                    <div
                        v-for="product in featured"
                        :key="product.id"
                        class="col-12 col-md-6 col-lg-3"
                    >
                        <ProductCard
                            :product="product"
                            :is-favorite="isFavorite(product.id)"
                            @toggle-favorite="handleToggleFavorite"
                        />
                    </div>
                </div>
            </div>
        </section>

        <!-- How it works -->
        <section id="how" class="bg-light">
            <div class="container py-5">
                <h2 class="fw-bold mb-1">Как это работает</h2>
                <div class="text-secondary mb-4">3 шага — и ты в деле</div>

                <div class="row g-3">
                    <div v-for="(step, idx) in steps" :key="step.title" class="col-12 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="badge text-bg-primary rounded-pill px-3 py-2">
                                        Шаг {{ idx + 1 }}
                                    </span>
                                </div>
                                <div class="h5 fw-bold">{{ step.title }}</div>
                                <div class="text-secondary">{{ step.text }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 d-flex flex-wrap gap-2">
                    <a class="btn btn-primary" href="/register">Начать продавать</a>
                    <a class="btn btn-outline-secondary" href="/catalog">Смотреть товары</a>
                </div>
            </div>
        </section>

        <!-- FAQ -->
        <section id="faq" class="bg-white">
            <div class="container py-5">
                <div class="row g-4">
                    <div class="col-lg-5">
                        <h2 class="fw-bold mb-1">FAQ</h2>
                        <div class="text-secondary mb-3">
                            Ответы на частые вопросы: комиссии, доставка, безопасность.
                        </div>
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="fw-semibold">Нужна помощь?</div>
                                <div class="text-secondary small mb-3">
                                    Напиши в поддержку — обычно отвечаем быстро.
                                </div>
                                <a class="btn btn-outline-primary" href="/support">Поддержка</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="accordion" id="faqAccordion">
                            <div v-for="(f, i) in faqs" :key="f.q" class="accordion-item">
                                <h2 class="accordion-header" :id="`h-${i}`">
                                    <button
                                        class="accordion-button"
                                        :class="{ collapsed: i !== 0 }"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        :data-bs-target="`#c-${i}`"
                                        :aria-expanded="i === 0 ? 'true' : 'false'"
                                        :aria-controls="`c-${i}`"
                                    >
                                        {{ f.q }}
                                    </button>
                                </h2>
                                <div
                                    :id="`c-${i}`"
                                    class="accordion-collapse collapse"
                                    :class="{ show: i === 0 }"
                                    :aria-labelledby="`h-${i}`"
                                    data-bs-parent="#faqAccordion"
                                >
                                    <div class="accordion-body text-secondary">
                                        {{ f.a }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Newsletter -->
        <section class="bg-primary text-white">
            <div class="container py-5">
                <div class="row align-items-center g-3">
                    <div class="col-lg-7">
                        <h2 class="fw-bold mb-1">Скидки и новые товары — в рассылке</h2>
                        <div class="text-white-50">Без спама. 1–2 письма в неделю.</div>
                    </div>
                    <div class="col-lg-5">
                        <form class="d-flex gap-2" @submit.prevent="onSubscribe">
                            <input
                                v-model.trim="subscribeEmail"
                                type="email"
                                class="form-control form-control-lg"
                                placeholder="you@example.com"
                                required
                            />
                            <button class="btn btn-light btn-lg fw-semibold" type="submit">
                                Подписаться
                            </button>
                        </form>
                        <div v-if="subscribeMsg" class="small mt-2 text-white-50">
                            {{ subscribeMsg }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </MainLayout>
</template>

<style scoped>
.py-lg-6 {
    padding-top: 5rem;
    padding-bottom: 5rem;
}

.icon-dot {
    width: 10px;
    height: 10px;
    border-radius: 999px;
    display: inline-block;
}
</style>
