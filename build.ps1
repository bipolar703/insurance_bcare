# Build Script for Windows
Write-Host "Starting build process..." -ForegroundColor Green

# Create build directory if it doesn't exist
if (!(Test-Path -Path "build")) {
    New-Item -ItemType Directory -Path "build"
}

# Clean previous build
if (Test-Path -Path "build/*") {
    Remove-Item -Path "build/*" -Recurse -Force
}

# Install PHP dependencies
Write-Host "Installing PHP dependencies..." -ForegroundColor Yellow
composer install --optimize-autoloader --no-dev

# Install NPM dependencies and build assets
Write-Host "Installing NPM dependencies..." -ForegroundColor Yellow
npm install
Write-Host "Building frontend assets..." -ForegroundColor Yellow
npm run build

# Optimize Laravel
Write-Host "Optimizing Laravel..." -ForegroundColor Yellow
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Copy necessary files to build directory
Write-Host "Copying files to build directory..." -ForegroundColor Yellow
$directories = @(
    "app",
    "bootstrap",
    "config",
    "database",
    "lang",
    "public",
    "resources",
    "routes",
    "storage",
    "vendor"
)

foreach ($dir in $directories) {
    Copy-Item -Path $dir -Destination "build/$dir" -Recurse -Force
}

# Copy individual files
$files = @(
    "artisan",
    "composer.json",
    "composer.lock",
    "package.json",
    "package-lock.json",
    "vite.config.js"
)

foreach ($file in $files) {
    Copy-Item -Path $file -Destination "build/$file" -Force
}

# Copy and rename environment file
Copy-Item -Path ".env.hostinger" -Destination "build/.env" -Force

# Create storage symlink in public directory
Set-Location build
php artisan storage:link
Set-Location ..

Write-Host "Build completed successfully!" -ForegroundColor Green
Write-Host "The build files are ready in the 'build' directory." -ForegroundColor Green
Write-Host "Now you can use SmartFTP to upload the contents of the 'build' directory to your Hostinger public_html folder." -ForegroundColor Yellow
