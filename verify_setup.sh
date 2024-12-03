#!/bin/bash

# Navigate to the website root
cd ~/domains/taminattcom.pro/public_html

echo "=== Checking Website Setup ==="

# Check index.php exists
echo "Checking index.php..."
if [ -f "index.php" ]; then
    echo "✓ index.php exists"
else
    echo "✗ index.php not found!"
fi

# Check .htaccess exists
echo "Checking .htaccess..."
if [ -f ".htaccess" ]; then
    echo "✓ .htaccess exists"
else
    echo "✗ .htaccess not found! Creating default Laravel .htaccess..."
    cat > .htaccess << 'EOL'
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
EOL
fi

# Check .env exists
echo "Checking .env..."
if [ -f ".env" ]; then
    echo "✓ .env exists"
else
    echo "✗ .env not found! Creating from .env.production..."
    cp .env.production .env
fi

# Fix permissions
echo "Setting correct permissions..."
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod -R 777 storage
chmod -R 777 bootstrap/cache

# Create storage link
echo "Creating storage link..."
php artisan storage:link --force

# Clear all caches
echo "Clearing all caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize
echo "Optimizing Laravel..."
php artisan optimize

# Check storage structure
echo "Checking storage structure..."
mkdir -p storage/app/public
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs

# Check vendor directory
echo "Checking vendor directory..."
if [ ! -d "vendor" ]; then
    echo "Installing dependencies..."
    composer install --no-dev --optimize-autoloader
fi

# Check public directory
echo "Checking public directory structure..."
if [ ! -d "public" ]; then
    mkdir -p public
    echo "Moving assets to public directory..."
    mv css public/ 2>/dev/null || true
    mv js public/ 2>/dev/null || true
    mv images public/ 2>/dev/null || true
fi

# Create test PHP file
echo "Creating test PHP file..."
cat > test.php << 'EOL'
<?php
phpinfo();
EOL

# Check PHP configuration
echo "Checking PHP configuration..."
php -v
php -m | grep -E 'pdo|mbstring|xml|curl|json'

# Check Laravel requirements
echo "Checking Laravel requirements..."
php artisan --version
php artisan env

# Check database connection
echo "Testing database connection..."
php artisan migrate:status

# Display important paths
echo "Important paths:"
echo "Document Root: $(pwd)"
echo "Storage Path: $(pwd)/storage"
echo "Public Path: $(pwd)/public"

# Create symbolic links if needed
echo "Creating symbolic links..."
ln -sf public/* . 2>/dev/null || true

echo "=== Setup verification completed ==="
echo "Please check https://taminattcom.pro/test.php to verify PHP is working"
echo "Then check https://taminattcom.pro to verify Laravel is working"
