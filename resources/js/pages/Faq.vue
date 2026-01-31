<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import MainLayout from '@/layouts/MainLayout.vue'
import { ref } from 'vue'

const openIndex = ref<number | null>(null)

function toggle(index: number) {
    openIndex.value = openIndex.value === index ? null : index
}

const faqs = [
    {
        question: 'Как зарегистрироваться на платформе?',
        answer: 'Нажмите кнопку «Регистрация» в правом верхнем углу сайта. Заполните форму с вашим именем, email и паролем. После регистрации вы сможете сразу начать покупать и продавать товары.'
    },
    {
        question: 'Как разместить товар на продажу?',
        answer: 'После входа в аккаунт перейдите в раздел «Мой профиль» и нажмите «Добавить товар». Заполните название, описание, цену и загрузите фотографии. Ваше объявление появится в каталоге после модерации.'
    },
    {
        question: 'Какие способы оплаты доступны?',
        answer: 'Мы поддерживаем оплату банковскими картами (Visa, Mastercard, МИР), электронными кошельками и СБП. Все платежи защищены и проходят через безопасный платёжный шлюз.'
    },
    {
        question: 'Как работает доставка?',
        answer: 'Продавец указывает доступные способы доставки в объявлении. Это может быть самовывоз, курьерская доставка или отправка почтой. Стоимость и сроки зависят от выбранного способа.'
    },
    {
        question: 'Что делать, если товар не соответствует описанию?',
        answer: 'Свяжитесь с продавцом через чат на сайте. Если решить вопрос не удалось, обратитесь в нашу службу поддержки — мы поможем разрешить ситуацию и при необходимости оформим возврат средств.'
    },
    {
        question: 'Как связаться с продавцом?',
        answer: 'На странице товара есть кнопка «Написать продавцу». Вы можете задать вопросы о товаре, уточнить детали доставки или договориться о встрече для самовывоза.'
    },
    {
        question: 'Безопасно ли покупать на платформе?',
        answer: 'Да! Мы проверяем продавцов, защищаем платежи и предоставляем гарантию возврата денег. Все отзывы на сайте оставлены реальными покупателями.'
    },
    {
        question: 'Какая комиссия за продажу?',
        answer: 'Размещение объявлений бесплатно. Комиссия взимается только при успешной продаже и составляет от 3% до 5% в зависимости от категории товара.'
    },
]
</script>

<template>
    <Head>
        <title>Часто задаваемые вопросы</title>
        <meta name="description" content="Ответы на популярные вопросы о работе маркетплейса" />
    </Head>

    <MainLayout>
        <div class="faq-page">
            <div class="container">
                <div class="faq-header">
                    <h1>Часто задаваемые вопросы</h1>
                    <p>Найдите ответы на популярные вопросы о нашей платформе</p>
                </div>

                <div class="faq-list">
                    <div
                        v-for="(faq, index) in faqs"
                        :key="index"
                        class="faq-item"
                        :class="{ 'is-open': openIndex === index }"
                    >
                        <button
                            class="faq-question"
                            @click="toggle(index)"
                        >
                            <span>{{ faq.question }}</span>
                            <svg
                                class="faq-icon"
                                xmlns="http://www.w3.org/2000/svg"
                                width="20"
                                height="20"
                                fill="currentColor"
                                viewBox="0 0 16 16"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"
                                />
                            </svg>
                        </button>
                        <div class="faq-answer">
                            <p>{{ faq.answer }}</p>
                        </div>
                    </div>
                </div>

                <div class="faq-contact">
                    <h3>Не нашли ответ?</h3>
                    <p>Напишите нам, и мы с удовольствием поможем!</p>
                    <a href="/support" class="btn-contact">Связаться с поддержкой</a>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<style scoped>
.faq-page {
    padding: 3rem 0;
    min-height: 100vh;
    background: #f8f9fa;
}

.faq-header {
    text-align: center;
    margin-bottom: 3rem;
}

.faq-header h1 {
    font-size: 2.25rem;
    font-weight: 700;
    color: #212529;
    margin-bottom: 0.5rem;
}

.faq-header p {
    color: #6c757d;
    font-size: 1.125rem;
}

.faq-list {
    max-width: 800px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.faq-item {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.faq-question {
    width: 100%;
    padding: 1.25rem 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    background: none;
    border: none;
    cursor: pointer;
    text-align: left;
    font-size: 1.0625rem;
    font-weight: 600;
    color: #212529;
    transition: color 0.2s;
}

.faq-question:hover {
    color: #0d6efd;
}

.faq-icon {
    flex-shrink: 0;
    color: #6c757d;
    transition: transform 0.3s;
}

.faq-item.is-open .faq-icon {
    transform: rotate(180deg);
    color: #0d6efd;
}

.faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease, padding 0.3s ease;
}

.faq-item.is-open .faq-answer {
    max-height: 300px;
}

.faq-answer p {
    padding: 0 1.5rem 1.25rem;
    color: #495057;
    line-height: 1.7;
    margin: 0;
}

.faq-contact {
    text-align: center;
    margin-top: 4rem;
    padding: 2.5rem;
    background: linear-gradient(135deg, #0d6efd, #0056b3);
    border-radius: 16px;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
    color: #fff;
}

.faq-contact h3 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.faq-contact p {
    opacity: 0.9;
    margin-bottom: 1.5rem;
}

.btn-contact {
    display: inline-block;
    padding: 0.75rem 2rem;
    background: #fff;
    color: #0d6efd;
    font-weight: 600;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-contact:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
}
</style>
