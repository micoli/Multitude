test-unit:
	vendor/bin/phpunit --testdox
test-static:
	vendor/bin/psalm
test-coding-standard:
	vendor/bin/php-cs-fixer fix --verbose

tests-all: test-coding-standard test-static test-unit
