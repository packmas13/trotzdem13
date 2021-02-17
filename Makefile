artisan=php artisan

install: install_dependencies .env

install_dependencies:# install dependencies
	composer install
	npm install

.env: # generate .env file
	cp -n .env.example .env
	$(artisan) key:generate
	touch database/database.sqlite
	$(artisan) migrate

test: vendor public/mix-manifest.json
	$(artisan) test

vendor:
	composer install

public/mix-manifest.json: node_modules
	npm run prod

node_modules:
	npm install

dev: node_modules
	npm run dev
