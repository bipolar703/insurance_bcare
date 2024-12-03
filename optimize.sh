#!/bin/bash

# Check and create directories if they don't exist
echo "Setting up directory structure..."
cd ~
mkdir -p domains/taminattcom.pro/public_html
cd domains/taminattcom.pro/public_html

# Fix permissions
echo "Fixing permissions..."
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;

# Create and set permissions for essential directories
echo "Creating essential directories..."
mkdir -p storage/app/public
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set proper permissions for storage and cache
chmod -R 777 storage
chmod -R 777 bootstrap/cache

# Clear all caches
echo "Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize the application
echo "Optimizing application..."
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage link if not exists
echo "Creating storage link..."
php artisan storage:link --force

# Update composer dependencies
echo "Updating composer dependencies..."
composer install --optimize-autoloader --no-dev

# Run migrations
echo "Running database migrations..."
php artisan migrate --force

# Clear OPcache
echo "Clearing OPcache..."
php -r "opcache_reset();"

# Fix common Laravel issues
echo "Fixing common Laravel issues..."
php artisan key:generate --force
php artisan package:discover --ansi

# Set proper ownership
echo "Setting proper ownership..."
chown -R u116650566:u116650566 .

# Create or update PHP configuration
echo "Updating PHP configuration..."
cat > php.ini << 'EOL'
max_execution_time = 300
max_input_time = 300
memory_limit = 256M
post_max_size = 64M
upload_max_filesize = 64M
display_errors = Off
log_errors = On
error_log = ${PWD}/storage/logs/php_errors.log
date.timezone = UTC
EOL

# Verify the setup
echo "Verifying setup..."
echo "PHP Version:"
php -v
echo "Directory Structure:"
ls -la
echo "Storage Permissions:"
ls -la storage/

echo "Optimization completed!"
