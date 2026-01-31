<script setup lang="ts">
import { usePage, useForm } from '@inertiajs/vue3'
import { computed, ref } from 'vue'

const page = usePage()
const siteName = computed(() => page.props.name || 'Marketplace')
const user = computed(() => page.props.auth?.user)

const showMobileMenu = ref(false)
const showUserDropdown = ref(false)

const logoutForm = useForm({})

function logout() {
    logoutForm.post('/logout')
}

const navLinks = [
    { href: '/catalog', label: 'Каталог' },
    { href: '/categories', label: 'Категории' },
    { href: '/how-it-works', label: 'Как это работает' },
    { href: '/faq', label: 'FAQ' },
]
</script>

<template>
    <!-- Header -->
    <header class="header-main border-bottom bg-white sticky-top">
        <div class="container">
            <nav class="navbar-main">
                <!-- Logo -->
                <a class="logo" href="/">
                    <span class="logo-icon">MP</span>
                    <span class="logo-text">{{ siteName }}</span>
                </a>

                <!-- Desktop Nav -->
                <ul class="nav-links d-none d-lg-flex">
                    <li v-for="link in navLinks" :key="link.href">
                        <a :href="link.href" class="nav-link-item">
                            {{ link.label }}
                        </a>
                    </li>
                </ul>

                <!-- Search (Desktop) -->
                <form class="search-form d-none d-lg-flex" action="/catalog" method="get">
                    <div class="search-input-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                        <input
                            type="search"
                            name="q"
                            placeholder="Поиск товаров..."
                            class="search-input"
                        />
                    </div>
                </form>

                <!-- Actions -->
                <div class="nav-actions">
                    <!-- Favorites -->
                    <a href="/profile" class="nav-action-btn d-none d-md-flex" title="Избранное">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                        </svg>
                    </a>

                    <!-- User Menu -->
                    <template v-if="user">
                        <div class="user-dropdown">
                            <button class="user-btn" @click="showUserDropdown = !showUserDropdown">
                                <span class="user-avatar">{{ user.name.charAt(0).toUpperCase() }}</span>
                                <span class="user-name d-none d-md-inline">{{ user.name }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </button>

                            <div v-show="showUserDropdown" class="dropdown-menu-custom" @click.stop>
                                <a href="/profile" class="dropdown-item-custom" @click="showUserDropdown = false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
                                    </svg>
                                    Мой профиль
                                </a>
                                <a href="/profile/edit" class="dropdown-item-custom" @click="showUserDropdown = false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                                    </svg>
                                    Настройки
                                </a>
                                <hr class="dropdown-divider" />
                                <button @click="logout" class="dropdown-item-custom text-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                                        <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                    </svg>
                                    Выйти
                                </button>
                            </div>
                        </div>
                    </template>

                    <template v-else>
                        <a href="/login" class="btn-login d-none d-md-inline-flex">Войти</a>
                        <a href="/register" class="btn-register">Регистрация</a>
                    </template>

                    <!-- Mobile Menu Toggle -->
                    <button
                        class="mobile-toggle d-lg-none"
                        @click="showMobileMenu = !showMobileMenu"
                        aria-label="Меню"
                    >
                        <svg v-if="!showMobileMenu" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                        </svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                        </svg>
                    </button>
                </div>
            </nav>
        </div>

        <!-- Mobile Menu -->
        <div v-show="showMobileMenu" class="mobile-menu d-lg-none">
            <div class="container">
                <!-- Mobile Search -->
                <form class="mobile-search" action="/catalog" method="get">
                    <input
                        type="search"
                        name="q"
                        placeholder="Поиск товаров..."
                        class="form-control"
                    />
                    <button type="submit" class="btn btn-primary">Найти</button>
                </form>

                <!-- Mobile Nav Links -->
                <ul class="mobile-nav-links">
                    <li v-for="link in navLinks" :key="link.href">
                        <a :href="link.href" @click="showMobileMenu = false">
                            {{ link.label }}
                        </a>
                    </li>
                </ul>

                <!-- Mobile Auth -->
                <div v-if="!user" class="mobile-auth">
                    <a href="/login" class="btn btn-outline-primary w-100 mb-2">Войти</a>
                    <a href="/register" class="btn btn-primary w-100">Регистрация</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Click outside to close dropdown -->
    <div
        v-if="showUserDropdown"
        class="dropdown-backdrop"
        @click="showUserDropdown = false"
    ></div>

    <!-- Content -->
    <main>
        <slot />
    </main>

    <!-- Footer -->
    <footer class="footer-main">
        <div class="container">
            <div class="footer-grid">
                <!-- Brand -->
                <div class="footer-brand">
                    <a href="/" class="logo mb-3">
                        <span class="logo-icon">MP</span>
                        <span class="logo-text text-white">{{ siteName }}</span>
                    </a>
                    <p class="footer-description">
                        Маркетплейс для покупки и продажи товаров: безопасно, удобно, быстро.
                    </p>
                    <div class="social-links">
                        <a href="#" class="social-link" aria-label="Telegram">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.287 5.906c-.778.324-2.334.994-4.666 2.01-.378.15-.577.298-.595.442-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294.26.006.549-.1.868-.32 2.179-1.471 3.304-2.214 3.374-2.23.05-.012.12-.026.166.016.047.041.042.12.037.141-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8.154 8.154 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629.093.06.183.125.27.187.331.236.63.448.997.414.214-.02.435-.22.547-.82.265-1.417.786-4.486.906-5.751a1.426 1.426 0 0 0-.013-.315.337.337 0 0 0-.114-.217.526.526 0 0 0-.31-.093c-.3.005-.763.166-2.984 1.09z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="VK">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M15.725 4.566a.75.75 0 0 0-.604-.45c-.742-.125-2.252.312-3.434 1.056-.22-.818-.648-1.803-1.454-2.593C9.135 1.48 7.792 1 6.206 1c-1.585 0-2.928.48-4.027 1.579C.384 4.374 0 6.54 0 8.5c0 1.96.384 4.126 2.179 5.921C3.278 15.52 4.621 16 6.206 16c1.586 0 2.929-.48 4.027-1.579.806-.79 1.234-1.775 1.454-2.593 1.182.744 2.692 1.18 3.434 1.056a.75.75 0 0 0 .604-.45c.126-.28.063-.61-.155-.847-.984-1.07-2.56-1.47-3.627-1.587.067-.5.067-1 0-1.5 1.067-.117 2.643-.517 3.627-1.587.218-.237.281-.567.155-.847z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Links -->
                <div class="footer-links-group">
                    <h6 class="footer-title">Покупателям</h6>
                    <ul class="footer-links">
                        <li><a href="/catalog">Каталог</a></li>
                        <li><a href="/#how">Как купить</a></li>
                        <li><a href="/support">Поддержка</a></li>
                    </ul>
                </div>

                <div class="footer-links-group">
                    <h6 class="footer-title">Продавцам</h6>
                    <ul class="footer-links">
                        <li><a href="/sell">Как продавать</a></li>
                        <li><a href="/pricing">Тарифы</a></li>
                        <li><a href="/register">Открыть магазин</a></li>
                    </ul>
                </div>

                <div class="footer-links-group">
                    <h6 class="footer-title">Информация</h6>
                    <ul class="footer-links">
                        <li><a href="/terms">Условия использования</a></li>
                        <li><a href="/privacy">Конфиденциальность</a></li>
                        <li><a href="/cookies">Cookie</a></li>
                    </ul>
                </div>
            </div>

            <hr class="footer-divider" />

            <div class="footer-bottom">
                <div>© {{ new Date().getFullYear() }} {{ siteName }}. Все права защищены.</div>
            </div>
        </div>
    </footer>
</template>

<style scoped>
/* Header */
.header-main {
    background: #fff;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}

.navbar-main {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 0.75rem 0;
}

/* Logo */
.logo {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    flex-shrink: 0;
}

.logo-icon {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, #0d6efd, #0056b3);
    color: #fff;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.875rem;
}

.logo-text {
    font-weight: 700;
    font-size: 1.25rem;
    color: #212529;
}

/* Nav Links */
.nav-links {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav-link-item {
    padding: 0.5rem 1rem;
    color: #495057;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.9375rem;
    border-radius: 8px;
    transition: all 0.2s;
}

.nav-link-item:hover {
    color: #0d6efd;
    background: rgba(13, 110, 253, 0.08);
}

/* Search */
.search-form {
    flex: 1;
    max-width: 400px;
}

.search-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.search-input-wrapper svg {
    position: absolute;
    left: 12px;
    color: #6c757d;
}

.search-input {
    width: 100%;
    padding: 0.625rem 1rem 0.625rem 2.5rem;
    border: 1px solid #e9ecef;
    border-radius: 10px;
    font-size: 0.9375rem;
    background: #f8f9fa;
    transition: all 0.2s;
}

.search-input:focus {
    outline: none;
    border-color: #0d6efd;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
}

/* Actions */
.nav-actions {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-left: auto;
}

.nav-action-btn {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #495057;
    border-radius: 10px;
    transition: all 0.2s;
}

.nav-action-btn:hover {
    color: #0d6efd;
    background: rgba(13, 110, 253, 0.08);
}

/* User Dropdown */
.user-dropdown {
    position: relative;
}

.user-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.375rem 0.75rem;
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s;
}

.user-btn:hover {
    background: #e9ecef;
}

.user-avatar {
    width: 28px;
    height: 28px;
    background: linear-gradient(135deg, #0d6efd, #0056b3);
    color: #fff;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.875rem;
}

.user-name {
    font-weight: 500;
    color: #212529;
}

.dropdown-menu-custom {
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    min-width: 200px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    padding: 0.5rem;
    z-index: 1050;
}

.dropdown-item-custom {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.625rem 0.875rem;
    color: #495057;
    text-decoration: none;
    border-radius: 8px;
    font-size: 0.9375rem;
    transition: all 0.15s;
    border: none;
    background: none;
    width: 100%;
    cursor: pointer;
}

.dropdown-item-custom:hover {
    background: #f8f9fa;
    color: #212529;
}

.dropdown-item-custom.text-danger:hover {
    background: #fee2e2;
    color: #dc3545;
}

.dropdown-divider {
    margin: 0.5rem 0;
    border-color: #e9ecef;
}

.dropdown-backdrop {
    position: fixed;
    inset: 0;
    z-index: 1040;
}

/* Buttons */
.btn-login {
    padding: 0.5rem 1rem;
    color: #0d6efd;
    font-weight: 500;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.2s;
}

.btn-login:hover {
    background: rgba(13, 110, 253, 0.08);
}

.btn-register {
    padding: 0.5rem 1.25rem;
    background: linear-gradient(135deg, #0d6efd, #0056b3);
    color: #fff;
    font-weight: 500;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.2s;
}

.btn-register:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.35);
}

/* Mobile Toggle */
.mobile-toggle {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: none;
    border: none;
    color: #495057;
    cursor: pointer;
    border-radius: 8px;
}

.mobile-toggle:hover {
    background: #f8f9fa;
}

/* Mobile Menu */
.mobile-menu {
    background: #fff;
    border-top: 1px solid #e9ecef;
    padding: 1rem 0;
}

.mobile-search {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.mobile-nav-links {
    list-style: none;
    padding: 0;
    margin: 0 0 1rem 0;
}

.mobile-nav-links li a {
    display: block;
    padding: 0.75rem 0;
    color: #495057;
    text-decoration: none;
    font-weight: 500;
    border-bottom: 1px solid #f1f3f4;
}

.mobile-nav-links li a:hover {
    color: #0d6efd;
}

/* Footer */
.footer-main {
    background: #1a1d21;
    color: rgba(255, 255, 255, 0.7);
    padding: 3rem 0 1.5rem;
}

.footer-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    gap: 2rem;
}

@media (max-width: 991px) {
    .footer-grid {
        grid-template-columns: 1fr 1fr;
    }
}

@media (max-width: 575px) {
    .footer-grid {
        grid-template-columns: 1fr;
    }
}

.footer-brand {
    max-width: 280px;
}

.footer-description {
    font-size: 0.875rem;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.social-links {
    display: flex;
    gap: 0.75rem;
}

.social-link {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.7);
    border-radius: 8px;
    transition: all 0.2s;
}

.social-link:hover {
    background: #0d6efd;
    color: #fff;
}

.footer-title {
    color: #fff;
    font-weight: 600;
    margin-bottom: 1rem;
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 0.5rem;
}

.footer-links a {
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    font-size: 0.875rem;
    transition: color 0.2s;
}

.footer-links a:hover {
    color: #fff;
}

.footer-divider {
    border-color: rgba(255, 255, 255, 0.1);
    margin: 2rem 0 1rem;
}

.footer-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.875rem;
    flex-wrap: wrap;
    gap: 1rem;
}
</style>
