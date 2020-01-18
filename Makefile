.DEFAULT_GOAL := help

ifndef TAG
	TAG=alpine
endif

PORT ?= 8080
PHP := $(shell sh -c 'which php')

ifdef NO_DOCKER
	PHP = php
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
	docker run \
		--rm \
		--volume $(shell pwd):/var/www/FreshRSS:z \
		--publish $(PORT):80 \
		--env FRESHRSS_ENV=development \
		--name freshrss-dev \
		freshrss/freshrss:$(TAG)

.PHONY: stop
stop: ## Stop FreshRSS container if any
	docker stop freshrss-dev

###########
## Tests ##
###########
bin/phpunit: ## Install PHPUnit for test purposes
	mkdir -p bin/
	wget -O bin/phpunit https://phar.phpunit.de/phpunit-7.5.9.phar
	echo '5404288061420c3921e53dd3a756bf044be546c825c5e3556dea4c51aa330f69 bin/phpunit' | sha256sum -c - || rm bin/phpunit

.PHONY: test
test: bin/phpunit ## Run the test suite
	$(PHP) ./bin/phpunit --bootstrap ./tests/bootstrap.php ./tests

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
	@echo To add a new language, you need to provide one in the "lang" variable.
	@exit 10
endif
	@$(PHP) ./cli/manipulate.translation.php -a add -l $(lang)
	@echo Language added.

.PHONY: i18n-add-key
i18n-add-key: ## Add a translation key to all supported languages
ifndef key
	@echo To add a key, you need to provide one in the "key" variable.
	@exit 10
endif
ifndef value
	@echo To add a key, you need to provide its value in the "value" variable.
	@exit 10
endif
	@$(PHP) ./cli/manipulate.translation.php -a add -k $(key) -v "$(value)"
	@echo Key added.

.PHONY: i18n-remove-key
i18n-remove-key: ## Remove a translation key from all supported languages
ifndef key
	@echo To remove a key, you need to provide one in the "key" variable.
	@exit 10
endif
	@$(PHP) ./cli/manipulate.translation.php -a delete -k $(key)
	@echo Key removed.

.PHONY: i18n-ignore-key
i18n-ignore-key: ## Ignore a translation key for the selected language
ifndef lang
	@echo To ignore a key, you need to provide a language in the "lang" variable.
	@exit 10
endif
ifndef key
	@echo To ignore a key, you need to provide one in the "key" variable.
	@exit 10
endif
	@$(PHP) ./cli/manipulate.translation.php -a ignore -k $(key) -l $(lang)
	@echo Key ignored.

.PHONY: rtl
rtl: ## Generate RTL CSS files
	rtlcss -d p/themes

##########
## HELP ##
##########
.PHONY: help
help:
	@grep --extended-regexp '^[a-zA-Z0-9_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
