.DEFAULT_GOAL := help

# -----------------------------------
# Variables
# -----------------------------------
is_docker := $(shell docker info > /dev/null 2>&1 && echo 1)
user := $(shell id -u)
group := $(shell id -g)

ifeq ($(is_docker), 1)
	php := USER_ID=$(user) GROUP_ID=$(group) docker-compose run --rm --no-deps php
	composer := $(php) composer
else
	php := php
	composer := composer
endif

# -----------------------------------
# Recipes
# -----------------------------------
.PHONY: help
help: ## affiche cet aide
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: lint
lint: vendor/autoload.php ## affiche les erreurs de formatage de code
	$(php) vendor/bin/ecs
	$(php) vendor/bin/phpstan

.PHONY: test
test: vendor/autoload.php ## lance les tests
	$(php) vendor/bin/phpunit

.PHONY: lint-fix
lint-fix: vendor/autoload.php ## corrige les erreurs de formatage de code
	$(php) vendor/bin/ecs --fix

vendor/autoload.php: composer.lock # installe les dépendances PHP
	$(composer) update
	$(composer) dump-autoload
