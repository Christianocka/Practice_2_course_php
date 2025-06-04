# ToDo Laravel Project

## О проекте

Это учебный проект ToDo на базе Laravel 12 с использованием Docker и PostgreSQL.

## Быстрый старт

### Клонирование репозитория

```bash
git clone https://github.com/Christianocka/Practice_2_course_php.git
cd Practice_2_course_php/ToDo
```

### Запуск через Docker

1. Убедитесь, что установлен и запущен Docker Desktop.
2. Соберите и запустите контейнеры:
   ```bash
   docker-compose up -d
   ```
3. Примените миграции:
   ```bash
   docker-compose exec app php artisan migrate
   ```
4. Откройте приложение в браузере:  
   [http://127.0.0.1:8000](http://127.0.0.1:8000)

### Доступ к базе данных

- **pgAdmin:** [http://localhost:5050](http://localhost:5050)
- **PostgreSQL:**  
  - Host: `localhost`  
  - Port: `5433`  
  - User: `user`  
  - Password: `password`  
  - Database: `tasksdb`

## Структура проекта

- `app/` — исходный код Laravel
- `routes/` — маршруты приложения
- `resources/views/` — шаблоны Blade
- `docker-compose.yml` — конфигурация Docker
- `dockerfile` — сборка контейнера приложения

## Основные команды

- Установка зависимостей:
  ```bash
  composer install
  ```
- Запуск тестов:
  ```bash
  docker-compose exec app php artisan test
  ```
- Остановка контейнеров:
  ```bash
  docker-compose down
  ```

## Автор

- [Christianocka](https://github.com/Christianocka)

---

Проект создан для учебных целей.
