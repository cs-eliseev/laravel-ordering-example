English | [Русский](https://github.com/cs-eliseev/laravel-ordering-example/blob/master/README.ru_RU.md)

Example ordering for Laravel
=======

## Description

Uses stack: Nginx, PHP 7.4, MySQL 5.7.


## Info

### Project link

* Laravel application HTTP: http://localhost:6002

|Service|Port|
|:---|:---:|
|http|6002|
|mysql|6004|
|xdebug|9000|

### Docker containers

|Service|Container name|
|:---|:---:|
|nginx|testing-nginx|
|php-fpm|testing-php-fpm|
|mysql|testing-mysql|
|aplication|testing-workspace|

### Laravel project path

```
./src
```

### Logs path

```
./logs
```

### UnitTest report path

```
./src/coverage_report
```


## Usage

### Install developments tools

* Install [docker](https://docs.docker.com/engine/installation/)
* Install [docker-compose](https://docs.docker.com/compose/install/)

### Build application

1. Import dependency

    ```shell
    git clone https://github.com/laradock/laradock.git docker
    ```

1. Build Docker containers

    ```shell
    docker-compose up -d --build
    ```

1. Build dependency

    ```shell
    docker exec testing-workspace bash -c 'npm i --no-bin-links && npm run dev && composer update'
    ```


### Create db

1. Migrate table
 
    ```shell
    docker exec testing-workspace php artisan migrate
    ```

### Generate test data

1. Run seeding

    ```shell
    docker exec testing-workspace php artisan db:seed
    ```    
 
### Use UnitTest

UNIT test service `OrderServices`

1. Go to container

    ```shell
    docker exec -it testing-workspace bash
    ```

1. Run UnitTest

    ```shell
    phpunit
    ```

1. View code coverage

    ```
   ./src/coverage_report/index.html
   ```


## Update container data

1. Удаление данных MySQL

    ```shell
    rm -rf ~/.docker_testing/mysql
   ```


## Documentation

[User documentation](https://github.com/cs-eliseev/laravel-testing-example/blob/master/src/README.md)


## SQL example

1. Choose for each client the number of orders with a price less than 1000 and more than 1000

    ```mysql
    SELECT client_id,
           SUM(IF (price < 1000, 1, 0)) AS count1,
           SUM(IF (price > 1000, 1, 0)) AS count2
    FROM orders
    GROUP BY client_id;
    ```

1. Select a third order for each customer
    
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

1. Choose for each client the third order placed after an order worth more than 1000
    
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

> Eliseev AK