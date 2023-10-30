.DEFAULT_GOAL := help

ifndef TAG
	TAG=alpine
endif

PORT ?= 8080
NETWORK ?= freshrss-network

ifdef NO_DOCKER
	PHP = $(shell which php)
else
	PHP = docker run \
		--rm \
		--volume $(shell pwd):/var/www/FreshRSS:z \
		--env FRESHRSS_ENV=development \
		--name freshrss-php-cli \
		freshrss/freshrss:$(TAG) \
		php
endif

ifeq ($(findstring alpine,$(TAG)),alpine)
	DOCKERFILE=Dockerfile-Alpine
else ifeq ($(findstring arm,$(TAG)),arm)
	DOCKERFILE=Dockerfile-QEMU-ARM
else
	DOCKERFILE=Dockerfile
endif

############
## Docker ##
############
.PHONY: build
build: ## Build a Docker image
	docker build \
		--pull \
		--tag freshrss/freshrss:$(TAG) \
		--file Docker/$(DOCKERFILE) .

.PHONY: start
start: ## Start the development environment (use Docker)
	docker network create --driver bridge $(NETWORK) || true
	$(foreach extension,$(extensions),$(eval volumes=$(volumes) --volume $(extension):/var/www/FreshRSS/extensions/$(notdir $(extension)):z))
	docker run \
		--rm \
		--volume $(shell pwd):/var/www/FreshRSS:z \
		$(volumes) \
		--publish $(PORT):80 \
		--env FRESHRSS_ENV=development \
		--name freshrss-dev \
		--network $(NETWORK) \
		freshrss/freshrss:$(TAG)

.PHONY: stop
stop: ## Stop FreshRSS container if any
	docker stop freshrss-dev || true
	docker network rm $(NETWORK) || true

######################
## Tests and linter ##
######################
.PHONY: test
test: vendor/bin/phpunit ## Run the test suite
	$(PHP) vendor/bin/phpunit --bootstrap ./tests/bootstrap.php ./tests

.PHONY: lint
lint: vendor/bin/phpcs ## Run the linter on the PHP files
	$(PHP) vendor/bin/phpcs . -p -s

.PHONY: lint-fix
lint-fix: vendor/bin/phpcbf ## Fix the errors detected by the linter
	$(PHP) vendor/bin/phpcbf . -p -s

bin/composer:
	mkdir -p bin/
	wget 'https://raw.githubusercontent.com/composer/getcomposer.org/a19025d6c0a1ff9fc1fac341128b2823193be462/web/installer' -O - -q | php -- --quiet --install-dir='./bin/' --filename='composer'

vendor/bin/phpunit: bin/composer
	bin/composer install --prefer-dist --no-progress
	ln -s ../vendor/bin/phpunit bin/phpunit

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

##########
## I18N ##
##########
.PHONY: i18n-format
i18n-format: ## Format I18N files
	@$(PHP) ./cli/manipulate.translation.php -a format
	@echo Files formatted.

.PHONY: i18n-add-language
i18n-add-language: ## Add a new supported language
ifndef lang
	$(error To add a new language, you need to provide one in the "lang" variable)
endif
	$(PHP) ./cli/manipulate.translation.php -a add -l $(lang) -o $(ref)
	@echo Language added.

.PHONY: i18n-add-key
i18n-add-key: ## Add a translation key to all supported languages
ifndef key
	$(error To add a key, you need to provide one in the "key" variable)
endif
ifndef value
	$(error To add a key, you need to provide its value in the "value" variable)
endif
	@$(PHP) ./cli/manipulate.translation.php -a add -k $(key) -v "$(value)"
	@echo Key added.

.PHONY: i18n-remove-key
i18n-remove-key: ## Remove a translation key from all supported languages
ifndef key
	$(error To remove a key, you need to provide one in the "key" variable)
endif
	@$(PHP) ./cli/manipulate.translation.php -a delete -k $(key)
	@echo Key removed.

.PHONY: i18n-update-key
i18n-update-key: ## Update a translation key in all supported languages
ifndef key
	$(error To update a key, you need to provide one in the "key" variable)
endif
ifndef value
	$(error To update a key, you need to provide its value in the "value" variable)
endif
	@$(PHP) ./cli/manipulate.translation.php -a add -k $(key) -v "$(value)" -l en
	@echo Key updated.

.PHONY: i18n-ignore-key
i18n-ignore-key: ## Ignore a translation key for the selected language
ifndef lang
	$(error To ignore a key, you need to provide a language in the "lang" variable)
endif
ifndef key
	$(error To ignore a key, you need to provide one in the "key" variable)
endif
	@$(PHP) ./cli/manipulate.translation.php -a ignore -k $(key) -l $(lang)
	@echo Key ignored.

.PHONY: i18n-ignore-unmodified-keys
i18n-ignore-unmodified-keys: ## Ignore all unmodified translation keys for the selected language
ifndef lang
	$(error To ignore unmodified keys, you need to provide a language in the "lang" variable)
endif
	@$(PHP) ./cli/manipulate.translation.php -a ignore_unmodified -l $(lang)
	@echo Unmodified keys ignored.

.PHONY: i18n-key-exists
i18n-key-exists: ## Check if a translation key exists
ifndef key
	$(error To check if a key exists, you need to provide one in the "key" variable)
endif
	@$(PHP) ./cli/manipulate.translation.php -a exist -k $(key)

###########
## TOOLS ##
###########
.PHONY: rtl
rtl: node_modules/.bin/rtlcss ## Generate RTL CSS files
	npm run-script rtlcss

.PHONY: pot
pot: ## Generate POT templates for docs
	cd docs && ../cli/translation-update.sh

.PHONY: refresh
refresh: ## Refresh feeds by fetching new messages
	@$(PHP) ./app/actualize_script.php

###############################
## New commands aligned on CI #
##     Work in progress       #
###############################

# TODO: Add composer install
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


##########
## HELP ##
##########
.PHONY: help
help:
	@grep --extended-regexp '^[a-zA-Z0-9_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
