default: help

help:
	@ echo "Makefile for the Heartbreaker application"
	@ echo "Usage: make <target>"
	@ echo "Available targets:"
	@ awk '/^##/ {c=$$0}; /^[a-zA-Z_-]+:/ {gsub(":$$", "", $$1); gsub(/^#+/, "", c); printf "\033[36m%-30s\033[0m %s\n", $$1, c}; /^([^#]|$$)/ {c=""}' $(MAKEFILE_LIST)

build:
	@docker-compose build

start:
	@docker-compose up

ssh:
	@docker exec -ti hearts /bin/bash