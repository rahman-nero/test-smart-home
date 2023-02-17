### Запуск проекта

Запуск проекта не сложен, так как окружение настроено докером. Нужно выполнить несколько команд:
```
docker-compose up -d --build
make composer-dev-install
```

Дальше следует взять `.env.example` и просто переименовать в `.env`, затем выполняем эти команды:

```
make laravel-key-generate
make laravel-migrate
```

Затем настраиваем front-end:

```
make npm-install
make build-production
```

Сайт будет доступен на http://localhost:8080, а api на http://localhost:8081

---

Также нужно будет в таблицу `equipment_type`, добавить записи, чтобы была возможность добавления оборудования.

Пример записи:
```
id = 1
title = TP-Link
mask = NNAAAaZ
created_at = null
```

Затем уже можем добавлять оборудования.




