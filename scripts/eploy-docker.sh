#!/bin/bash

# Stop any running containers
docker-compose down

# Build the images
docker-compose build --no-cache

# Start the containers
docker-compose up -d

# Install dependencies and run migrations
docker-compose exec app composer install --no-dev --optimize-autoloader
docker-compose exec app php artisan migrate --force
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
docker-compose exec app php artisan storage:link

# Set proper permissions
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
docker-compose exec app chmod -R 775 storage bootstrap/cache
