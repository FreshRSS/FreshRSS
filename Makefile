.DEFAULT_GOAL := help

ifndef TAG
	TAG=dev-alpine
endif

PORT ?= 8080

ifeq ($(findstring alpine,$(TAG)),alpine)
	DOCKERFILE=Dockerfile-Alpine
else ifeq ($(findstring arm,$(TAG)),arm)
	DOCKERFILE=Dockerfile-QEMU-ARM
else
	DOCKERFILE=Dockerfile
endif

.PHONY: build
build: ## Build a Docker image
	docker build \
		--pull \
		--tag freshrss/freshrss:$(TAG) \
		-f Docker/$(DOCKERFILE) .

.PHONY: start
start: ## Start the development environment (use Docker)
	docker run \
		--rm \
		-v $(shell pwd):/var/www/FreshRSS:z \
		-p $(PORT):80 \
		-e FRESHRSS_ENV=development \
		--name freshrss-dev \
		freshrss/freshrss:$(TAG)

.PHONY: stop
stop: ## Stop FreshRSS container if any
	docker stop freshrss-dev

.PHONY: help
help:
	@grep -h -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
