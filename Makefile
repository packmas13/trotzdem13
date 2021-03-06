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

test: vendor node_modules public/mix-manifest.json
	$(artisan) test

vendor:
	composer install

public/mix-manifest.json:
	npm run prod

node_modules:
	npm ci

dev: node_modules
	npm run dev

dev-hot: node_modules
	npm run dev-hot

lint:
	npm run lint
