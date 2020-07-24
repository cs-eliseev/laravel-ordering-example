[English](https://github.com/cs-eliseev/laravel-ordering-example/blob/master/README.md) | Русский

Пример формы заказа на laravel
=======

## Описание

Используемый стек: Nginx, PHP 7.4, MySQL 5.7.


## Информация

### Порты

* Приложение Laravel доступно: http://localhost:6002

|Сервис|Порт|
|:---|:---:|
|http|6002|
|mysql|6004|
|xdebug|9000|

### Docker контейнеры

|Сервис|Имя контейнера|
|:---|:---:|
|nginx|testing-nginx|
|php-fpm|testing-php-fpm|
|mysql|testing-mysql|
|aplication|testing-workspace|

### Путь к проекту

```
./src
```

### Путь к логам

```
./logs
```

### Путь к отчету к UnitTest

```
./src/coverage_report
```


## Использование

### Установка окружения для разработчиков

* Install [docker](https://docs.docker.com/engine/installation/)
* Install [docker-compose](https://docs.docker.com/compose/install/)

### Сборка проекта

1. Импорт зависимостей

    ```shell
    git clone https://github.com/laradock/laradock.git docker
    ```

1. Сборка Docker контейнеров

    ```shell
    docker-compose up -d --build
    ```

1. Сборка зависимостей

    ```shell
    docker exec testing-workspace bash -c 'npm i --no-bin-links && npm run dev && composer update'
    ```
 
 ### Создание базы данных
 
 1. Миграция таблиц
  
     ```shell
     docker exec testing-workspace php artisan migrate
     ```
 
 ### Генерация тестовых данных
 
 1. Запуск сидов
 
     ```shell
     docker exec testing-workspace php artisan db:seed
     ```    

### Использование UnitTest

UnitTest для сервиса `OrderServices`

1. Перейти в контейнер

    ```shell
    docker exec -it testing-workspace bash
    ```

1. Запустить UnitTest

    ```shell
    phpunit
    ```

1. Просмотр покрытия тестоми

    ```
   ./src/coverage_report/index.html
   ```


## Обновление данных контейнеров

1. Удаление данных MySQL

    ```shell
    rm -rf ~/.docker_testing/mysql
   ```


## Документация

[Пользовательская документация](https://github.com/cs-eliseev/laravel-testing-example/blob/master/src/README.ru_RU.md)
 
 
 ## Примеры SQL запросов 
 
 1. Подсчет количества заказов пользователей в зависимости от цены
 
     ```mysql
     SELECT client_id,
            SUM(IF (price < 1000, 1, 0)) AS count1,
            SUM(IF (price > 1000, 1, 0)) AS count2
     FROM orders
     GROUP BY client_id;
     ```
 
 1. Выбор заказа пользователя
     
    ```mysql
     SELECT id, client_id, price
     FROM (
         SELECT o.id, o.client_id, o.price, @row := IF(@grp = o.client_id, @row, 0) + 1 AS numGroup, @grp := o.client_id
         FROM (SELECT @row := 0, @grp := '') r, orders o
         ORDER BY o.client_id
     ) s
     WHERE numGroup = 3
     ORDER BY client_id;
     ```
 
 1. Выбор заказа пользователя в зависимости от предыдущей стоимости
     
    ```mysql
     SELECT id, client_id, price
     FROM (
              SELECT o.id, o.client_id, o.price, @row := IF(@grp = o.client_id AND o.id > s.minid, @row, 0) + 1 AS numGroup, @grp := o.client_id
              FROM (SELECT @row := 0, @grp := '') r, orders o
              LEFT JOIN (
                  SELECT MIN(id) as minid, client_id
                  FROM orders
                  WHERE price > 1000
                  GROUP BY client_id
                  ) s ON s.client_id = o.client_id
              ORDER BY o.client_id
          ) s
     WHERE numGroup = 3
     ORDER BY client_id;
     ```


***

> Елисеев АК