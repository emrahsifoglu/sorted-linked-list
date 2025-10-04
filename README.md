# SortedLinkedList implementation in PHP

This is a library that provides SortedLinkedList. 
It should be able to hold string or int values, but not both.

## Table of Contents

* [Prerequisites](#prerequisites)
* [Project Setup](#project-setup)
  * [Install Dependencies](#install-dependencies)
  * [Run Tests](#run-tests)
  * [Code Quality Checks](#code-quality-checks)
* [Resources](#resources)  

## Prerequisites

* Container Runtime
  * [Docker](https://docs.docker.com/engine/install/)
  * [Podman](https://podman.io/docs/installation)

---

## Project Setup

The tools used during development are:

- **PHPUnit** for testing
- **PHPStan** (with strict rules) for static analysis
- **PHP-CS-Fixer** for code style
- **Infection** for mutation testing

##### Install Dependencies

```bash
docker compose run --rm php composer install
```

##### Run Tests

```bash
docker compose run --rm php composer test
```

##### Code Quality Checks

```bash
# Static analysis
docker compose run --rm php composer phpstan

# Check code style
docker compose run --rm php composer cs-check

# Fix code style
docker compose run --rm php composer cs-fix

# Run all QA checks
docker compose run --rm php composer qa
```
---

## Resources

- [Streamlined Laravel Development: A Complete Guide to Code Quality](https://abdullahalhabal.medium.com/streamlined-laravel-development-a-complete-guide-to-code-quality-with-phpstan-php-cs-fixer-717733005b44)
- [How to add PHP CS Fixer to your project?](https://dev.to/dobron/how-to-add-php-cs-fixer-to-your-project-5486)
- [Create a PHP composer package](https://dev.to/joemoses33/create-a-composer-package-how-to-29kn)
- [The first time you run Infection for your project...](https://infection.github.io/guide/usage.html)
- [Extra strict and opinionated rules for PHPStan](https://github.com/phpstan/phpstan-strict-rules)
- [PHP Coding Standards Fixer](https://cs.symfony.com/doc/config.html)
- [Setup PHP in GitHub Actions](https://github.com/shivammathur/setup-php)
