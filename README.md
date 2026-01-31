# Marketplace

Современный маркетплейс для покупки и продажи товаров. Проект разработан на Laravel 12 и Vue 3 с использованием Inertia.js.

## Технологии

### Backend
- **PHP 8.4** — современная версия PHP
- **Laravel 12** — фреймворк для веб-приложений
- **MySQL** — база данных
- **Eloquent ORM** — работа с базой данных

### Frontend
- **Vue 3** — реактивный фреймворк
- **TypeScript** — типизация JavaScript
- **Inertia.js** — связь между Laravel и Vue без API
- **Bootstrap 5** — CSS-фреймворк
- **Vite** — сборщик ассетов

## Возможности

- Регистрация и авторизация пользователей
- Каталог товаров с фильтрацией и сортировкой
- Карточки товаров с изображениями и отзывами
- Профиль пользователя
- Избранные товары
- Категории товаров
- Адаптивный дизайн

## Архитектура

### Паттерны

- **Сервисный слой** — бизнес-логика вынесена в сервисы (`app/Services/`)
- **Тонкие контроллеры** — контроллеры только вызывают сервисы
- **Form Request** — валидация в отдельных классах (`app/Http/Requests/`)
- **Policies** — авторизация через политики (`app/Policies/`)
- **API Resources** — форматирование данных (`app/Http/Resources/`)

### Структура проекта

```
app/
├── Http/
│   ├── Controllers/       # Контроллеры
│   │   ├── Auth/          # Авторизация
│   │   ├── CatalogController.php
│   │   ├── HomeController.php
│   │   ├── PageController.php
│   │   ├── ProductController.php
│   │   └── ProfileController.php
│   ├── Middleware/        # Middleware
│   │   ├── HandleInertiaRequests.php
│   │   └── HideServerInfo.php
│   ├── Requests/          # Валидация
│   │   ├── Auth/
│   │   ├── Catalog/
│   │   └── Product/
│   └── Resources/         # API ресурсы
├── Models/                # Eloquent модели
├── Policies/              # Политики авторизации
├── Providers/             # Провайдеры
└── Services/              # Бизнес-логика
    ├── Catalog/
    ├── Home/
    └── Product/

resources/js/
├── components/ui/         # Vue компоненты
├── composables/           # Vue composables
├── layouts/               # Макеты страниц
└── pages/                 # Страницы (Inertia)
    ├── Auth/
    ├── Catalog/
    ├── Products/
    └── Profile/

routes/web/                # Роуты (разделены по модулям)
├── auth.php
├── catalog.php
├── pages.php
└── products.php
```

## Установка

### Требования

- PHP >= 8.2
- Composer
- Node.js >= 18
- MySQL >= 8.0

### Шаги установки

```bash
# Клонирование репозитория
git clone <repository-url>
cd Marketplace

# Установка PHP зависимостей
composer install

# Установка JS зависимостей
npm install

# Копирование конфига
cp .env.example .env

# Генерация ключа
php artisan key:generate

# Настройка базы данных в .env
# DB_DATABASE=marketplace
# DB_USERNAME=root
# DB_PASSWORD=

# Миграции и сидеры
php artisan migrate --seed

# Сборка фронтенда
npm run build
```

### Запуск для разработки

```bash
# В первом терминале
php artisan serve

# Во втором терминале
npm run dev
```

Приложение будет доступно по адресу: http://localhost:8000

## База данных

### Таблицы

- **users** — пользователи (покупатели, продавцы, админы)
- **categories** — категории товаров
- **products** — товары
- **product_images** — изображения товаров
- **reviews** — отзывы на товары
- **favorites** — избранные товары

### Связи

```
User ─┬─< Products
      ├─< Reviews
      └─< Favorites

Category ─< Products

Product ─┬─< ProductImages
         ├─< Reviews
         └─< Favorites
```

## Тестовые данные

После запуска `php artisan db:seed` создаются:

- **Администратор**: admin@example.com / password
- **Тестовый пользователь**: test@example.com / password
- **8 категорий** товаров
- **~100 товаров** с изображениями и отзывами

## Безопасность

- Валидация через Form Request классы
- Rate Limiting для защиты от брутфорса
- CSRF защита
- Хеширование паролей (bcrypt)
- Политики для авторизации действий
- Скрытие серверных заголовков (X-Powered-By)

## API Resources

Все данные форматируются через Resources:

- `ProductResource` — товар
- `CategoryResource` — категория
- `UserResource` — пользователь
- `ReviewResource` — отзыв
- `ProductImageResource` — изображение

## Оптимизация

- **Eager Loading** — решение N+1 проблемы
- **Индексы** — на часто используемых полях
- **Кэширование** — готово к подключению Redis

## Команды

```bash
# Миграции
php artisan migrate

# Откат миграций
php artisan migrate:rollback

# Сидеры
php artisan db:seed

# Очистка кэша
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Тесты
php artisan test

# Линтинг PHP
./vendor/bin/pint

# Сборка для продакшена
npm run build
```

## Роуты

| Метод | URL | Описание |
|-------|-----|----------|
| GET | / | Главная страница |
| GET | /catalog | Каталог товаров |
| GET | /products/{slug} | Страница товара |
| GET | /categories | Все категории |
| GET | /faq | Частые вопросы |
| GET | /how-it-works | Как это работает |
| GET | /login | Вход |
| POST | /login | Авторизация |
| GET | /register | Регистрация |
| POST | /register | Создание аккаунта |
| POST | /logout | Выход |
| GET | /profile | Профиль пользователя |
| GET | /profile/edit | Редактирование профиля |

## Лицензия

MIT License
