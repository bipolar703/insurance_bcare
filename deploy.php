<?php
/**
 * Hostinger Deployment Script
 */

// Configuration
$config = [
    'ftp_host' => 'taminattcom.pro',
    'ftp_user' => 'u116650566.taminattcom.pro',
    'ftp_password' => 'Reeree12.R.',
    'ftp_port' => 21,
    'remote_path' => '/public_html',
    'exclude' => [
        '.git',
        '.env',
        '.env.example',
        '.env.hostinger',
        '.env.production',
        'node_modules',
        'storage/framework/cache/*',
        'storage/framework/sessions/*',
        'storage/framework/views/*',
        'storage/logs/*',
        'tests',
        '.gitignore',
        '.gitattributes',
        'README.md',
        'deploy.php',
        'deploy.sh',
        'deploy.ps1',
        'docker-compose.yml',
        'Dockerfile',
        'phpunit.xml',
        'composer.lock',
        '.git*',
        '.env*',
        'storage/*.key',
        'vendor',
        '.idea',
        '.vscode',
        'build',
        'dist'
    ],
    'critical_directories' => [
        'storage/app',
        'storage/framework',
        'storage/logs',
        'bootstrap/cache'
    ]
];

// Start deployment
echo "Starting deployment to " . $config['ftp_host'] . "...\n";

// Connect to FTP
echo "Connecting to FTP server...\n";
$conn = ftp_connect($config['ftp_host'], $config['ftp_port']);
if (!$conn) {
    // Try alternative hostname
    echo "Trying alternative connection method...\n";
    $conn = ftp_connect('92.113.19.110', $config['ftp_port']);
    if (!$conn) {
        die("Could not connect to FTP server\n");
    }
}

// Login
echo "Logging in as " . $config['ftp_user'] . "...\n";
if (!ftp_login($conn, $config['ftp_user'], $config['ftp_password'])) {
    die("Could not login to FTP server\n");
}

// Enable passive mode
echo "Enabling passive mode...\n";
ftp_pasv($conn, true);

// Create directories if they don't exist
function createRemoteDir($conn, $dir) {
    $parts = explode('/', $dir);
    $path = '';
    foreach ($parts as $part) {
        if (!$part) continue;
        $path .= '/' . $part;
        if (@ftp_mkdir($conn, $path)) {
            echo "Created directory: $path\n";
            // Set directory permissions to 755
            @ftp_chmod($conn, 0755, $path);
        }
    }
}

// Upload directory recursively
function uploadDirectory($conn, $local_path, $remote_path, $exclude) {
    $dir = opendir($local_path);
    while ($file = readdir($dir)) {
        if ($file == '.' || $file == '..') continue;

        $local_file = $local_path . '/' . $file;
        $remote_file = $remote_path . '/' . $file;

        // Check if file/directory should be excluded
        $relative_path = str_replace('./', '', $local_file);
        if (in_array($relative_path, $exclude)) {
            echo "Skipping excluded path: $relative_path\n";
            continue;
        }

        // Check for wildcard exclusions
        foreach ($exclude as $pattern) {
            if (strpos($pattern, '*') !== false) {
                $regex = '#^' . str_replace('*', '.*', $pattern) . '$#';
                if (preg_match($regex, $relative_path)) {
                    echo "Skipping excluded pattern: $relative_path\n";
                    continue 2;
                }
            }
        }

        if (is_dir($local_file)) {
            createRemoteDir($conn, $remote_file);
            uploadDirectory($conn, $local_file, $remote_file, $exclude);
        } else {
            echo "Uploading: $local_file -> $remote_file\n";
            $retry = 3;
            while ($retry > 0) {
                if (ftp_put($conn, $remote_file, $local_file, FTP_BINARY)) {
                    // Set file permissions to 644
                    @ftp_chmod($conn, 0644, $remote_file);
                    echo "Successfully uploaded: $remote_file\n";
                    break;
                } else {
                    $retry--;
                    if ($retry > 0) {
                        echo "Retrying upload for: $remote_file\n";
                        sleep(1);
                    } else {
                        echo "Failed to upload: $remote_file after 3 attempts\n";
                    }
                }
            }
        }
    }
    closedir($dir);
}

// Create necessary directories
echo "Creating remote directories...\n";
createRemoteDir($conn, $config['remote_path']);

// Set storage directory permissions
echo "Setting up storage directory...\n";
$storage_paths = [
    $config['remote_path'] . '/storage',
    $config['remote_path'] . '/storage/app',
    $config['remote_path'] . '/storage/app/public',
    $config['remote_path'] . '/storage/framework',
    $config['remote_path'] . '/storage/framework/cache',
    $config['remote_path'] . '/storage/framework/sessions',
    $config['remote_path'] . '/storage/framework/views',
    $config['remote_path'] . '/storage/logs',
    $config['remote_path'] . '/bootstrap/cache'
];

foreach ($storage_paths as $path) {
    createRemoteDir($conn, $path);
    @ftp_chmod($conn, 0777, $path);
    echo "Set permissions for: $path\n";
}

// Upload files
echo "Uploading project files...\n";
uploadDirectory($conn, '.', $config['remote_path'], $config['exclude']);

// Create .env file from production
echo "Setting up production environment...\n";
if (file_exists('.env.production')) {
    $env_contents = file_get_contents('.env.production');
    $temp_env = tempnam(sys_get_temp_dir(), 'env');
    file_put_contents($temp_env, $env_contents);

    if (ftp_put($conn, $config['remote_path'] . '/.env', $temp_env, FTP_ASCII)) {
        echo "Successfully uploaded .env file\n";
        @ftp_chmod($conn, 0644, $config['remote_path'] . '/.env');
    } else {
        echo "Failed to upload .env file\n";
    }
    unlink($temp_env);
}

// Close connection
ftp_close($conn);

echo "Deployment completed successfully!\n";
