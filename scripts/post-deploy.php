<?php

// Post-deployment script for Hostinger

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Change to the project root directory
    chdir(__DIR__ . '/..');

    // Run artisan commands
    $commands = [
        'php artisan migrate --force',
        'php artisan config:cache',
        'php artisan route:cache',
        'php artisan view:cache',
        'php artisan storage:link',
        'php artisan queue:restart'
    ];

    foreach ($commands as $command) {
        echo "Running: $command\n";
        $output = [];
        $return_var = 0;
        exec($command, $output, $return_var);

        if ($return_var !== 0) {
            throw new Exception("Command failed: $command\nOutput: " . implode("\n", $output));
        }

        echo implode("\n", $output) . "\n";
    }

    // Set directory permissions
    $directories = [
        'storage',
        'storage/app',
        'storage/app/public',
        'storage/framework',
        'storage/framework/cache',
        'storage/framework/sessions',
        'storage/framework/views',
        'storage/logs',
        'bootstrap/cache'
    ];

    foreach ($directories as $dir) {
        if (is_dir($dir)) {
            chmod($dir, 0755);
            echo "Set permissions for directory: $dir\n";
        }
    }

    echo "Post-deployment tasks completed successfully!\n";

} catch (Exception $e) {
    echo "Error during post-deployment: " . $e->getMessage() . "\n";
    exit(1);
}
