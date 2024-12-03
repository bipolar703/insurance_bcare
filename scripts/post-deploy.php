<?php
// Post-deployment tasks
shell_exec('php artisan optimize:clear');
shell_exec('php artisan config:cache');
shell_exec('php artisan route:cache');
shell_exec('php artisan view:cache');
shell_exec('php artisan migrate --force');
shell_exec('chmod -R 755 storage bootstrap/cache');
