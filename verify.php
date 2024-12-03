<?php
// Save as verify.php and upload to check installation
echo "Checking Laravel installation...\n";

// Check PHP version
echo "PHP Version: " . PHP_VERSION . "\n";

// Check extensions
$required = ['mbstring', 'xml', 'ctype', 'iconv', 'intl', 'pdo_mysql', 'bcmath', 'zip'];
foreach ($required as $ext) {
    echo extension_loaded($ext)
        ? "✅ {$ext} extension loaded\n"
        : "❌ {$ext} extension missing\n";
}

// Check storage permissions
$storage = is_writable('storage');
echo $storage
    ? "✅ Storage is writable\n"
    : "❌ Storage is not writable\n";

// Check database connection
try {
    require 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    DB::connection()->getPdo();
    echo "✅ Database connection successful\n";
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
}
