# Makefile for Laravel + Docker + Node (Vite)

# Default target
.DEFAULT_GOAL := help

# Variables
DC = docker compose
APP = $(DC) exec app
NPM = $(DC) exec npm

# ----------------------------
# Common tasks
# ----------------------------

help: ## Show available commands
	@echo "Usage: make [target]"
	@echo ""
	@echo "Targets:"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2}'

up: ## Start all containers in background
	$(DC) up -d

down: ## Stop all containers
	$(DC) down

build: ## Build/rebuild containers
	$(DC) up -d --build

restart: ## Restart all containers
	$(DC) restart

logs: ## Tail logs from all containers
	$(DC) logs -f

# ----------------------------
# Laravel / PHP
# ----------------------------

migrate: ## Run Laravel migrations
	$(APP) php artisan migrate

tinker: ## Open Laravel Tinker
	$(APP) php artisan tinker

artisan: ## Run arbitrary artisan command, e.g. make artisan cmd="cache:clear"
	$(APP) php artisan $(cmd)

composer: ## Run Composer command, e.g. make composer cmd="install"
	$(APP) composer $(cmd)

# ----------------------------
# Node / Vite
# ----------------------------

npm-install: ## Install Node dependencies (clean)
	$(NPM) npm ci

npm-dev: ## Run Vite dev server (hot reload)
	$(NPM) npm run dev -- --host 0.0.0.0 --port 5173

npm-build: ## Build assets for production
	$(NPM) npm run build

# ----------------------------
# Database
# ----------------------------

db: ## Connect to MySQL CLI
	$(DC) exec mysql mysql -ularavel -psecret personalblog
