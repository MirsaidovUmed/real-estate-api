# 🏠 Real Estate API (Laravel)

REST API сервис для управления объектами недвижимости и их бронированием.

---

## 📌 Описание

Сервис позволяет:

* создавать и редактировать объекты недвижимости
* получать список объектов с фильтрацией
* просматривать конкретный объект
* удалять объекты
* бронировать недвижимость

Проект реализован с использованием **Laravel**, соблюдая принципы чистой архитектуры:

* Form Request (валидация)
* Service Layer (бизнес-логика)
* API Resource (ответы)
* Eloquent ORM
* Pagination
* Feature Tests

---

## ⚙️ Технологии

* PHP 8.2+
* Laravel 12
* MySQL / MariaDB
* Eloquent ORM
* PHPUnit (Feature tests)

---

## 🚀 Установка и запуск

### 1. Клонирование проекта

```bash
git clone https://github.com/MirsaidovUmed/real-estate-api.git
cd real-estate-api
```

---

### 2. Установка зависимостей

```bash
composer install
```

---

### 3. Настройка окружения

```bash
cp .env.example .env
php artisan key:generate
```

Настройте подключение к базе данных в `.env`:

```env
DB_DATABASE=real_estate_api
DB_USERNAME=root
DB_PASSWORD=
```

---

### 4. Миграции и сиды

```bash
php artisan migrate --seed
```

---

### 5. Запуск сервера

```bash
php artisan serve
```

API будет доступен по адресу:

```
http://127.0.0.1:8000/api
```

---

## 📚 API Endpoints

### 🔹 Объекты недвижимости

#### Получить список объектов

```http
GET /api/properties
```

##### Фильтры:

```
?city=Dushanbe
?min_price=50000
?max_price=100000
?rooms=2
?type=apartment
```

Можно комбинировать:

```
/api/properties?city=Dushanbe&type=apartment&rooms=2
```

---

#### Получить один объект

```http
GET /api/properties/{id}
```

---

#### Создать объект

```http
POST /api/properties
```

```json
{
  "title": "2 комнатная квартира",
  "description": "Хороший ремонт",
  "price": 85000,
  "type": "apartment",
  "city": "Dushanbe",
  "address": "Rudaki 12",
  "rooms": 2,
  "area": 65
}
```

---

#### Обновить объект

```http
PUT /api/properties/{id}
PATCH /api/properties/{id}
```

---

#### Удалить объект

```http
DELETE /api/properties/{id}
```

---

### 🔹 Бронирование

#### Забронировать объект

```http
POST /api/properties/{id}/book
```

```json
{
  "name": "Ali",
  "phone": "+992900000000"
}
```

---

### ⚠️ Ограничения

* Нельзя забронировать объект со статусом:

    * `booked`
    * `sold`

---

## 📦 Структура проекта

```
app/
 ├─ Http/
 │   ├─ Controllers/Api
 │   ├─ Requests
 │   └─ Resources
 ├─ Models
 └─ Services

database/
 ├─ factories
 ├─ migrations
 └─ seeders

tests/
 └─ Feature
```

---

## 🧠 Архитектура

* **Controllers** — принимают HTTP-запросы
* **FormRequest** — валидация данных
* **Service Layer** — бизнес-логика (бронирование)
* **Models (Eloquent)** — работа с БД
* **Resources** — форматирование ответа

---

## 🧪 Тестирование

Запуск тестов:

```bash
php artisan test
```

Покрыто:

* создание объекта
* фильтрация
* успешное бронирование
* запрет бронирования (booked / sold)

---

## 📊 Пример ответа

```json
{
  "data": [
    {
      "id": 1,
      "title": "2 комнатная квартира",
      "price": "85000.00",
      "city": "Dushanbe",
      "status": "available"
    }
  ],
  "links": {},
  "meta": {}
}
```

---

## ➕ Дополнительно

Реализовано:

* pagination
* soft deletes
* factory + seeder
* feature tests
* транзакции при бронировании

