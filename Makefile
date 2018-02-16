CONSOLE=php bin/console
COMPOSER=composer
PHPUNIT=php bin/phpunit

default:
	echo "Use make YOUR_COMMAND to execute"

### CONSOLE ###
cache-clear:
	$(CONSOLE) cache:clear

### COMPOSER ###
composer-install:
	$(COMPOSER) install

composer-update:
	$(COMPOSER) update

### FIXTURES ###
fixtures:
	$(CONSOLE) doctrine:database:drop --force
	$(CONSOLE) doctrine:database:create
	$(CONSOLE) doctrine:schema:create
	$(CONSOLE) doctrine:fixtures:load -n
