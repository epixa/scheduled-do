.PHONY all clean test deps db start

all:
	make deps
	make db

clean:
	rm -rf vendor
	rm composer.lock

deps:
	composer install

db:
	vendor/bin/phinx migrate

start:
	php -S localhost:8000 -t public/

test:
	vendor/bin/phpunit
