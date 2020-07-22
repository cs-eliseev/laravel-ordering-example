Example ordering for Laravel
=======

## Description

Uses a persistant database store and stack Nginx, PHP 7.4, MySQL 5.7.


## Info

### Project link

* Laravel application HTTP: http://localhost:6002
* MySQL: http://localhost:6004

### Laravel project path

```
src
```

### Logs path

```
logs
```


## Usage

### Install developments tools

* Install [docker](https://docs.docker.com/engine/installation/)
* Install [docker-compose](https://docs.docker.com/compose/install/)

### Build application

1. Clone laradock

    ```shell
    git clone https://github.com/laradock/laradock.git docker
    ```

1. Build all Docker containers

    ```shell
    docker-compose up -d --build
    ```

1. Go to project

    ```shell
    cd src
    ```

1. Install composer dependency

    Run in OS (php 7.4)
    ```shell
    composer update
    ```

1. Install NPM dependency

    Run in OS (node 13.11.00 npm 6.13.7)
    ```shell
    npm i
    ```

1. Build frontend

    Run in OS (node 13.11.00 npm 6.13.7)
    ```shell
    npm run dev
    ```


### Create db

1. Migrate table
 
    ```shell
    docker exec testing-php-fpm php artisan migrate
    ```

### Generate test data

1. Run seeding

    ```shell
    docker exec testing-php-fpm php artisan db:seed
    ```    
 
### Use UnitTest

UNIT test service `OrderServicesTest`

1. To run the PHPUnit unit tests

    ```shell
    docker exec testing-php-fpm ./vendor/bin/phpunit
    ```

### SQL example

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