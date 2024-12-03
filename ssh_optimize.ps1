# SSH Connection Details
$sshHost = "92.113.19.110"
$sshPort = "65002"
$sshUser = "u116650566"
$remotePath = "~/domains/taminattcom.pro/public_html"

Write-Host "Connecting to server..." -ForegroundColor Green

# First, ensure the directory exists
Write-Host "Creating directory structure..." -ForegroundColor Yellow
ssh -p $sshPort "${sshUser}@${sshHost}" "mkdir -p ~/domains/taminattcom.pro/public_html"

# Upload the optimization script
Write-Host "Uploading optimization script..." -ForegroundColor Yellow
scp -P $sshPort optimize.sh "${sshUser}@${sshHost}:~/domains/taminattcom.pro/public_html/optimize.sh"

# Connect via SSH and run optimization
Write-Host "Running optimization script..." -ForegroundColor Yellow
ssh -p $sshPort "${sshUser}@${sshHost}" @"
cd ~/domains/taminattcom.pro/public_html
chmod +x optimize.sh
./optimize.sh
"@

Write-Host "Optimization process completed!" -ForegroundColor Green

# Additional checks
Write-Host "`nPerforming additional checks..." -ForegroundColor Yellow

# Check directory structure
Write-Host "`nChecking directory structure..." -ForegroundColor Yellow
ssh -p $sshPort "${sshUser}@${sshHost}" @"
echo 'Directory Structure:'
ls -la ~/domains/taminattcom.pro/public_html
echo 'Storage Directory:'
ls -la ~/domains/taminattcom.pro/public_html/storage
"@

# Check Laravel logs
Write-Host "`nChecking Laravel logs..." -ForegroundColor Yellow
ssh -p $sshPort "${sshUser}@${sshHost}" @"
if [ -f ~/domains/taminattcom.pro/public_html/storage/logs/laravel.log ]; then
    tail -n 50 ~/domains/taminattcom.pro/public_html/storage/logs/laravel.log
else
    echo 'Laravel log file not found'
fi
"@

# Check PHP version and modules
Write-Host "`nChecking PHP configuration..." -ForegroundColor Yellow
ssh -p $sshPort "${sshUser}@${sshHost}" @"
echo 'PHP Version:'
php -v
echo 'PHP Modules:'
php -m
echo 'PHP Configuration:'
php -i | grep 'memory_limit\|max_execution_time\|upload_max_filesize'
"@

# Check storage permissions
Write-Host "`nVerifying storage permissions..." -ForegroundColor Yellow
ssh -p $sshPort "${sshUser}@${sshHost}" @"
echo 'Storage Permissions:'
ls -la ~/domains/taminattcom.pro/public_html/storage
echo 'Cache Permissions:'
ls -la ~/domains/taminattcom.pro/public_html/bootstrap/cache
"@

# Check server status
Write-Host "`nChecking server status..." -ForegroundColor Yellow
ssh -p $sshPort "${sshUser}@${sshHost}" @"
echo 'Memory Usage:'
free -m
echo 'Disk Usage:'
df -h
echo 'PHP Process:'
ps aux | grep php
"@

Write-Host "`nAll tasks completed!" -ForegroundColor Green

# Provide next steps
Write-Host "`nNext steps:" -ForegroundColor Cyan
Write-Host "1. Visit https://taminattcom.pro to verify the website is working"
Write-Host "2. Check the Laravel logs if you encounter any issues"
Write-Host "3. Run 'php artisan migrate:status' to verify database setup"
Write-Host "4. Test file uploads and storage functionality"
