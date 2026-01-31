<script setup lang="ts">
import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const page = usePage()
const siteName = computed(() => page.props.name || 'Marketplace')
const user = computed(() => page.props.auth?.user)
</script>

<template>
    <!-- Header -->
    <header class="border-bottom bg-white sticky-top">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container py-2">
                <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="/">
                    <span
                        class="d-inline-flex align-items-center justify-content-center rounded-3 bg-primary text-white"
                        style="width: 34px; height: 34px"
                    >
                        MP
                    </span>
                    <span>{{ siteName }}</span>
                </a>

                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#mainNav"
                    aria-controls="mainNav"
                    aria-expanded="false"
                    aria-label="Меню"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="mainNav">
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                        <li class="nav-item">
                            <a class="nav-link" href="/catalog">Каталог</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#categories">Категории</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#how">Как это работает</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#faq">FAQ</a>
                        </li>

                        <template v-if="user">
                            <li class="nav-item ms-lg-2">
                                <a class="btn btn-outline-primary" href="/profile">
                                    {{ user.name }}
                                </a>
                            </li>
                        </template>
                        <template v-else>
                            <li class="nav-item ms-lg-2">
                                <a class="btn btn-outline-primary" href="/login">Войти</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-primary" href="/register">Регистрация</a>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Content -->
    <main>
        <slot />
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white-50">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span
                            class="d-inline-flex align-items-center justify-content-center rounded-3 bg-primary text-white"
                            style="width: 34px; height: 34px"
                        >
                            MP
                        </span>
                        <div class="fw-bold text-white">{{ siteName }}</div>
                    </div>
                    <div class="small">
                        Маркетплейс для покупки и продажи товаров: безопасно, удобно, быстро.
                    </div>
                </div>

                <div class="col-6 col-lg-2">
                    <div class="fw-semibold text-white mb-2">Покупателям</div>
                    <ul class="list-unstyled small">
                        <li>
                            <a
                                class="link-light link-opacity-75-hover text-decoration-none"
                                href="/catalog"
                            >
                                Каталог
                            </a>
                        </li>
                        <li>
                            <a
                                class="link-light link-opacity-75-hover text-decoration-none"
                                href="/#how"
                            >
                                Как купить
                            </a>
                        </li>
                        <li>
                            <a
                                class="link-light link-opacity-75-hover text-decoration-none"
                                href="/support"
                            >
                                Поддержка
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-6 col-lg-2">
                    <div class="fw-semibold text-white mb-2">Продавцам</div>
                    <ul class="list-unstyled small">
                        <li>
                            <a
                                class="link-light link-opacity-75-hover text-decoration-none"
                                href="/sell"
                            >
                                Как продавать
                            </a>
                        </li>
                        <li>
                            <a
                                class="link-light link-opacity-75-hover text-decoration-none"
                                href="/pricing"
                            >
                                Тарифы
                            </a>
                        </li>
                        <li>
                            <a
                                class="link-light link-opacity-75-hover text-decoration-none"
                                href="/register"
                            >
                                Открыть магазин
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-4">
                    <div class="fw-semibold text-white mb-2">Юридическое</div>
                    <ul class="list-unstyled small mb-0">
                        <li>
                            <a
                                class="link-light link-opacity-75-hover text-decoration-none"
                                href="/terms"
                            >
                                Пользовательское соглашение
                            </a>
                        </li>
                        <li>
                            <a
                                class="link-light link-opacity-75-hover text-decoration-none"
                                href="/privacy"
                            >
                                Политика конфиденциальности
                            </a>
                        </li>
                        <li>
                            <a
                                class="link-light link-opacity-75-hover text-decoration-none"
                                href="/cookies"
                            >
                                Cookie
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="border-secondary my-4" />

            <div class="d-flex flex-wrap justify-content-between gap-2 small">
                <div>© {{ new Date().getFullYear() }} {{ siteName }}. Все права защищены.</div>
                <div class="text-white-50">Сделано с любовью</div>
            </div>
        </div>
    </footer>
</template>
