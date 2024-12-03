# Deployment script for Windows PowerShell

Write-Host "Starting deployment process..." -ForegroundColor Green

try {
    # Install dependencies
    Write-Host "Installing composer dependencies..." -ForegroundColor Yellow
    composer install --no-dev --optimize-autoloader
    if ($LASTEXITCODE -ne 0) { throw "Composer install failed" }

    # Clear caches
    Write-Host "Clearing caches..." -ForegroundColor Yellow
    php artisan config:clear
    php artisan cache:clear
    php artisan view:clear
    php artisan route:clear

    # Optimize
    Write-Host "Optimizing..." -ForegroundColor Yellow
    php artisan optimize
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache

    # Run database migrations
    Write-Host "Running migrations..." -ForegroundColor Yellow
    php artisan migrate --force

    # Build assets
    Write-Host "Building assets..." -ForegroundColor Yellow
    npm install
    if ($LASTEXITCODE -ne 0) { throw "NPM install failed" }
    npm run build
    if ($LASTEXITCODE -ne 0) { throw "NPM build failed" }

    # Deploy using PHP script
    Write-Host "Uploading files to server..." -ForegroundColor Yellow
    php deploy.php
    if ($LASTEXITCODE -ne 0) { throw "File upload failed" }

    Write-Host "Deployment completed successfully!" -ForegroundColor Green
}
catch {
    Write-Host "Deployment failed: $_" -ForegroundColor Red
    exit 1
}
