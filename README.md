# Scheduled Actions on Digital Ocean

[![Build Status](https://travis-ci.org/epixa/scheduled-do.svg?branch=master)](https://travis-ci.org/epixa/scheduled-do)

Very much a work in progress

### Setup

To set up the dependencies and database, run:

```
make
```

**or**

Install the package dependencies for development:

```
make deps
```

and run migrations:

```
make db
```

### Running the app

Run a local web server (on port 8000):

```
make start
```

### Tests

Tests are written with PHPUnit and located in `tests/`. Run with:

```
make test
```

### Contributing

To contribute code, issue pull requests at https://github.com/epixa/scheduled-do/pulls

### Requirements

```
PHP      ~5.6
Composer ~1.0
MySQL    ~5.6
```
