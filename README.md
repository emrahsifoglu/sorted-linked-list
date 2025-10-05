# SortedLinkedList implementation in PHP

This is a library that provides SortedLinkedList. 
It should be able to hold string or int values, but not both.

## Table of Contents

* [Prerequisites](#prerequisites)
* [Project Setup](#project-setup)
  * [Install Dependencies](#install-dependencies)
  * [Run Tests](#run-tests)
  * [Code Quality Checks](#code-quality-checks)
* [Usage](#usage)
* [Resources](#resources)  
* [License](#license)

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

## Usage

Here are some examples of how to use the `SortedLinkedList` class:

##### Insert Elements

```php
<?php

use Sif\SortedLinkedList\SortedLinkedList;

$list = new SortedLinkedList();

// Inserting integers
$list->insert(5)->insert(3)->insert(8)->insert(1);
// The list now contains: 1, 3, 5, 8

// Inserting strings (must be of the same type)
$stringList = new SortedLinkedList();
$stringList->insert('C')->insert('A')->insert('B');
// The list now contains: A, B, C
```

##### Search for an Element

```php
<?php

use Sif\SortedLinkedList\SortedLinkedList;

$list = new SortedLinkedList();
$list->insert(1)->insert(3)->insert(5)->insert(8);

// Search for an existing value
$found = $list->search(5); // true

// Search for a non-existing value
$notFound = $list->search(4); // false
```

##### Delete an Element

```php
<?php

use Sif\SortedLinkedList\SortedLinkedList;

$list = new SortedLinkedList();
$list->insert(1)->insert(3)->insert(5)->insert(8);

// Delete an existing value
$deleted = $list->delete(5); // true
// The list is now: 1, 3, 8

// Delete a non-existing value
$notDeleted = $list->delete(4); // false
```

##### Use `fromArray` and `toArray`

```php
<?php

use Sif\SortedLinkedList\SortedLinkedList;

// Create a list from an array
$arr = [5, 2, 9, 1];
$list = SortedLinkedList::fromArray($arr);
// The list is now: 1, 2, 5, 9

// Convert the list back to an array
$newArr = $list->toArray(); // [1, 2, 5, 9]
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
- [A type-safe, automatically-sorted linked list data structure for PHP](https://github.com/uniacid/sortedlinkedlist)
- [A PHP library providing a sorted linked list for int or string values](https://github.com/davidvarney/SortedLinkedList)
- [Ignoring Errors](https://phpstan.org/user-guide/ignoring-errors)
- [Difference between gettype() and get_debug_type() in PHP8.1?](https://stackoverflow.com/questions/71508548/difference-between-gettype-and-get-debug-type-in-php8-1)
- [Passing null to non-nullable internal function parameters is deprecated](https://php.watch/versions/8.1/internal-func-non-nullable-null-deprecation)
- [Remove duplicates from a sorted Linked List](https://www.youtube.com/watch?v=0nSjucAVsIU)
- [Solving PHPStan error “No value type specified in iterable type”](https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type)
- [PHP interfaces IteratorAggregate vs Iterator?](https://stackoverflow.com/questions/13624639/php-interfaces-iteratoraggregate-vs-iterator)

## License

[MIT](https://choosealicense.com/licenses/mit/)
