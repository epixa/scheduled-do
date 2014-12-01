# Scheduled Actions on Digital Ocean

[![Build Status](https://travis-ci.org/epixa/scheduled-do.svg?branch=master)](https://travis-ci.org/epixa/scheduled-do)

Very much a work in progress

### Setup

Install the package dependencies for development:

```
composer install
```

Run migrations:

```
vendor/bin/phinx migrate
```

Run a local web server (on port 8000):

```
php -S localhost:8000 -t public/
```

### Tests

Tests are written with PHPUnit and located in `tests/`. Run with:

```
vendor/bin/phpunit
```

### Contributing

To contribute code, issue pull requests at https://github.com/epixa/scheduled-do/pulls

### Requirements

```
PHP      ~5.6
Composer ~1.0
MySQL    ~5.6
```
