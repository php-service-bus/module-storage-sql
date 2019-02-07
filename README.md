[![Build Status](https://travis-ci.org/php-service-bus/module-storage-sql.svg?branch=v3.0)](https://travis-ci.org/php-service-bus/module-storage-sql)
[![Code Coverage](https://scrutinizer-ci.com/g/php-service-bus/module-storage-sql/badges/coverage.png?b=v3.0)](https://scrutinizer-ci.com/g/php-service-bus/module-storage-sql/?branch=v3.0)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/php-service-bus/module-storage-sql/badges/quality-score.png?b=v3.0)](https://scrutinizer-ci.com/g/php-service-bus/module-storage-sql/?branch=v3.0)

## What is it?

Module for working with relational databases

Contains packages:
* [php-service-bus/storage-sql](https://github.com/php-service-bus/storage-sql): PostgreSQL\SQLite support
* [php-service-bus/active-record](https://github.com/php-service-bus/active-record): Active record implementation

## Installation

```bash
composer req php-service-bus/module-storage-sql
```

Example of module creation

```php
$module = SqlStorageModule::postgreSQL('pgsql://postgres:123456789@localhost:5432/test')
   ->enableLogger(); // Enable logging of SQL queries

```

Enable module:

```php
$bootstrap->applyModules($module);
```