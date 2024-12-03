#!/bin/bash

echo "Starting deployment process..."

# Install dependencies
echo "Installing composer dependencies..."
composer install --no-dev --optimize-autoloader

# Clear caches
echo "Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Optimize
echo "Optimizing..."
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations
echo "Running migrations..."
php artisan migrate --force

# Build assets
echo "Building assets..."
npm install
npm run build

# Deploy using PHP script
echo "Uploading files to server..."
php deploy.php

echo "Deployment completed!"
