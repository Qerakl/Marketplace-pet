<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import MainLayout from '@/layouts/MainLayout.vue'

const steps = [
    {
        icon: '👤',
        title: 'Регистрация',
        description: 'Создайте аккаунт за 30 секунд. Только email и пароль — и вы готовы к покупкам и продажам.',
        color: '#0d6efd'
    },
    {
        icon: '📦',
        title: 'Размещение товара',
        description: 'Добавьте фотографии, описание и цену. Ваше объявление увидят тысячи покупателей.',
        color: '#198754'
    },
    {
        icon: '💬',
        title: 'Общение',
        description: 'Покупатели пишут вам напрямую. Договаривайтесь о цене, доставке и деталях сделки.',
        color: '#6f42c1'
    },
    {
        icon: '💳',
        title: 'Безопасная оплата',
        description: 'Деньги поступают на защищённый счёт и переводятся продавцу после получения товара.',
        color: '#fd7e14'
    },
    {
        icon: '🚚',
        title: 'Доставка',
        description: 'Выберите удобный способ: курьер, почта, пункт выдачи или личная встреча.',
        color: '#dc3545'
    },
    {
        icon: '⭐',
        title: 'Отзывы',
        description: 'Оставьте отзыв о сделке. Рейтинги помогают другим пользователям выбрать надёжного продавца.',
        color: '#20c997'
    }
]

const benefits = [
    { icon: '🛡️', title: 'Безопасные сделки', text: 'Гарантия возврата денег при проблемах с заказом' },
    { icon: '💰', title: 'Без комиссии', text: 'Бесплатное размещение объявлений' },
    { icon: '📱', title: 'Удобно везде', text: 'Работает на компьютере, планшете и телефоне' },
    { icon: '⚡', title: 'Быстрый старт', text: 'Регистрация за минуту, продажа за день' },
]
</script>

<template>
    <Head>
        <title>Как это работает</title>
        <meta name="description" content="Узнайте, как легко покупать и продавать на нашем маркетплейсе" />
    </Head>

    <MainLayout>
        <div class="how-page">
            <!-- Hero -->
            <section class="how-hero">
                <div class="container">
                    <h1>Как это работает</h1>
                    <p>Простой и безопасный способ покупать и продавать</p>
                </div>
            </section>

            <!-- Steps -->
            <section class="how-steps">
                <div class="container">
                    <div class="steps-grid">
                        <div
                            v-for="(step, index) in steps"
                            :key="index"
                            class="step-card"
                        >
                            <div class="step-number">{{ index + 1 }}</div>
                            <div class="step-icon" :style="{ background: step.color + '15', color: step.color }">
                                {{ step.icon }}
                            </div>
                            <h3 class="step-title">{{ step.title }}</h3>
                            <p class="step-desc">{{ step.description }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Benefits -->
            <section class="how-benefits">
                <div class="container">
                    <h2>Почему выбирают нас</h2>
                    <div class="benefits-grid">
                        <div
                            v-for="(benefit, index) in benefits"
                            :key="index"
                            class="benefit-card"
                        >
                            <span class="benefit-icon">{{ benefit.icon }}</span>
                            <h4>{{ benefit.title }}</h4>
                            <p>{{ benefit.text }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA -->
            <section class="how-cta">
                <div class="container">
                    <div class="cta-box">
                        <h2>Готовы начать?</h2>
                        <p>Присоединяйтесь к тысячам пользователей уже сегодня</p>
                        <div class="cta-buttons">
                            <a href="/register" class="btn-primary">Создать аккаунт</a>
                            <a href="/catalog" class="btn-secondary">Смотреть каталог</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </MainLayout>
</template>

<style scoped>
.how-page {
    background: #f8f9fa;
}

/* Hero */
.how-hero {
    background: linear-gradient(135deg, #0d6efd, #0056b3);
    color: #fff;
    padding: 4rem 0;
    text-align: center;
}

.how-hero h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.how-hero p {
    font-size: 1.25rem;
    opacity: 0.9;
}

/* Steps */
.how-steps {
    padding: 4rem 0;
}

.steps-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
}

@media (max-width: 991px) {
    .steps-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 575px) {
    .steps-grid {
        grid-template-columns: 1fr;
    }
}

.step-card {
    background: #fff;
    border-radius: 16px;
    padding: 2rem;
    text-align: center;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
    position: relative;
    transition: transform 0.2s, box-shadow 0.2s;
}

.step-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
}

.step-number {
    position: absolute;
    top: -12px;
    left: -12px;
    width: 32px;
    height: 32px;
    background: #0d6efd;
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.875rem;
}

.step-icon {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    margin: 0 auto 1rem;
}

.step-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #212529;
    margin-bottom: 0.5rem;
}

.step-desc {
    color: #6c757d;
    line-height: 1.6;
    margin: 0;
}

/* Benefits */
.how-benefits {
    padding: 4rem 0;
    background: #fff;
}

.how-benefits h2 {
    text-align: center;
    font-size: 2rem;
    font-weight: 700;
    color: #212529;
    margin-bottom: 3rem;
}

.benefits-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 2rem;
}

@media (max-width: 991px) {
    .benefits-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 575px) {
    .benefits-grid {
        grid-template-columns: 1fr;
    }
}

.benefit-card {
    text-align: center;
    padding: 1.5rem;
}

.benefit-icon {
    font-size: 2.5rem;
    display: block;
    margin-bottom: 1rem;
}

.benefit-card h4 {
    font-size: 1.125rem;
    font-weight: 600;
    color: #212529;
    margin-bottom: 0.5rem;
}

.benefit-card p {
    color: #6c757d;
    margin: 0;
    font-size: 0.9375rem;
}

/* CTA */
.how-cta {
    padding: 4rem 0;
}

.cta-box {
    background: linear-gradient(135deg, #212529, #343a40);
    border-radius: 20px;
    padding: 3rem;
    text-align: center;
    color: #fff;
}

.cta-box h2 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.cta-box p {
    opacity: 0.8;
    margin-bottom: 2rem;
}

.cta-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-primary {
    padding: 0.875rem 2rem;
    background: #0d6efd;
    color: #fff;
    font-weight: 600;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-primary:hover {
    background: #0b5ed7;
    transform: translateY(-2px);
}

.btn-secondary {
    padding: 0.875rem 2rem;
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
    font-weight: 600;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-secondary:hover {
    background: rgba(255, 255, 255, 0.2);
}
</style>
