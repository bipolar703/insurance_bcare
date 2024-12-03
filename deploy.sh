#!/bin/bash

# Exit on error
set -e

echo "Starting deployment process..."

# Check if running in production
if [ ! -f .env.production ]; then
    echo "Error: .env.production file not found!"
    exit 1
fi

# Backup the current .env file
if [ -f .env ]; then
    cp .env .env.backup
fi

# Copy production environment
cp .env.production .env

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

# Build assets
echo "Building assets..."
if [ -f package.json ]; then
    npm ci
    npm run build
else
    echo "No package.json found, skipping asset build"
fi

# Set proper permissions
echo "Setting permissions..."
chmod -R 755 storage bootstrap/cache
find storage -type f -exec chmod 644 {} \;
find bootstrap/cache -type f -exec chmod 644 {} \;

# Deploy using PHP script
echo "Uploading files to server..."
php deploy.php

# Restore original .env if it existed
if [ -f .env.backup ]; then
    mv .env.backup .env
fi

echo "Deployment completed successfully!"
