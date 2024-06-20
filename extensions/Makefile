.DEFAULT_GOAL := help

ifdef NO_DOCKER
	PHP = $(shell which php)
else
	PHP = docker run \
		--interactive \
		--tty \
		--rm \
		--volume $(shell pwd):/usr/src/app:z \
		--workdir /usr/src/app \
		--name freshrss-extension-php-cli \
		freshrss-extension-php-cli \
		php
endif

############
## Docker ##
############
.PHONY: build
build: ## Build a Docker image
	docker build \
		--pull \
		--tag freshrss-extension-php-cli \
		--file Docker/Dockerfile .

###########
## TOOLS ##
###########
.PHONY: generate
generate: ## Generate the extensions.json file
	@$(PHP) ./generate.php

##########
## HELP ##
##########
.PHONY: help
help:
	@grep --extended-regexp '^[a-zA-Z0-9_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

######################
## Tests and linter ##
######################
.PHONY: lint
lint: vendor/bin/phpcs ## Run the linter on the PHP files
	$(PHP) vendor/bin/phpcs . -p -s

.PHONY: lint-fix
lint-fix: vendor/bin/phpcbf ## Fix the errors detected by the linter
	$(PHP) vendor/bin/phpcbf . -p -s

bin/composer:
	mkdir -p bin/
	wget 'https://raw.githubusercontent.com/composer/getcomposer.org/a19025d6c0a1ff9fc1fac341128b2823193be462/web/installer' -O - -q | php -- --quiet --install-dir='./bin/' --filename='composer'

vendor/bin/phpcs: bin/composer
	bin/composer install --prefer-dist --no-progress
	ln -s ../vendor/bin/phpcs bin/phpcs

vendor/bin/phpcbf: bin/composer
	bin/composer install --prefer-dist --no-progress
	ln -s ../vendor/bin/phpcbf bin/phpcbf

bin/typos:
	mkdir -p bin/
	cd bin ; \
	wget -q 'https://github.com/crate-ci/typos/releases/download/v1.16.21/typos-v1.16.21-x86_64-unknown-linux-musl.tar.gz' && \
	tar -xvf *.tar.gz './typos' && \
	chmod +x typos && \
	rm *.tar.gz ; \
	cd ..

node_modules/.bin/eslint:
	npm install

node_modules/.bin/rtlcss:
	npm install

vendor/bin/phpstan: bin/composer
	bin/composer install --prefer-dist --no-progress

.PHONY: composer-test
composer-test: vendor/bin/phpstan
	bin/composer run-script test

.PHONY: composer-fix
composer-fix:
	bin/composer run-script fix

.PHONY: npm-test
npm-test: node_modules/.bin/eslint
	npm test

.PHONY: npm-fix
npm-fix: node_modules/.bin/eslint
	npm run fix

.PHONY: typos-test
typos-test: bin/typos
	bin/typos

# TODO: Add shellcheck, shfmt, hadolint
.PHONY: test-all
test-all: composer-test npm-test typos-test

.PHONY: fix-all
fix-all: composer-fix npm-fix
