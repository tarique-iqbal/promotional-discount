# Promotional Campaigns
A small command-line utility to apply certain promotional campaigns to give discounts. The system needs to be flexible regarding the promotional rules.

| Product code | Name          | Price   |
|--------------|---------------|---------|
| 001          | Curry Sauce   | 1.95 €  |
| 002          | Pizza         | 5.99 €  |
| 003          | Men’s T-Shirt | 25.00 € |
- If you spend over €30, you get 10% off your purchase.
- If you buy 2 or more pizzas, the price for each drops to €3.99.

| Items in basket      | Total price |
|----------------------|-------------|
| 002,001,002,003      |   31.44 €   |

| How it works?        |             |
|----------------------|-------------|
| 5.99+1.95+5.99+25.00 | = 38.93     |
| 38.93−(5.99−3.99)×2  | = 34.93     |
| 34.93−(34.93×10)÷100 | = 31.437    |
| round(31.437, 2)     | = 31.44     |

## Test Cases
| Items in basket | Total price |
|-----------------|-------------|
| 001,002,003     | 29.65 €     |
| 002,001,002     | 9.93 €      |
| 002,001,002,003 | 31.44 €     |

## Prerequisites
```
composer
php (>=8.4)
Docker (Optional for Containerized Development)
```

## Installation and Run the script
- All the `code` required to get started
- Need write permission to following `directory`

`./var/logs`

- Install the script
```shell
$ cd /path/to/base/directory
$ composer install --no-dev
```

- Run the script and sample output

```shell
$ php index.php
€31.44
```

## Running the tests

- Follow Install instructions.
Adapt `phpunit.xml.dist` PHP Constant according to your setup environment.

```shell
$ cd /path/to/base/directory
$ composer update
$ ./vendor/bin/phpunit tests
```

Test-cases, test unit and integration tests.

## Run the script in a Docker container
- Build the Docker Image
```shell
$ docker build --no-cache -t promotional_discount .
```

- Run the Container and script
```shell
$ docker run -it --rm promotional_discount
$ php index.php
€31.44
$ ./vendor/bin/phpunit tests
```
