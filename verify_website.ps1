# SSH Connection Details
$sshHost = "92.113.19.110"
$sshPort = "65002"
$sshUser = "u116650566"
$websitePath = "~/domains/taminattcom.pro/public_html"

Write-Host "Starting website verification..." -ForegroundColor Green

# Upload verification script
Write-Host "Uploading verification script..." -ForegroundColor Yellow
scp -P $sshPort verify_setup.sh "${sshUser}@${sshHost}:${websitePath}/verify_setup.sh"

# Run verification
Write-Host "Running verification..." -ForegroundColor Yellow
ssh -p $sshPort "${sshUser}@${sshHost}" @"
cd $websitePath
chmod +x verify_setup.sh
./verify_setup.sh
"@

# Check website accessibility
Write-Host "`nChecking website accessibility..." -ForegroundColor Yellow
try {
    $response = Invoke-WebRequest -Uri "https://taminattcom.pro" -Method Head
    Write-Host "Website is accessible! Status code: $($response.StatusCode)" -ForegroundColor Green
} catch {
    Write-Host "Website is not accessible. Error: $($_.Exception.Message)" -ForegroundColor Red

    # Additional checks
    Write-Host "`nPerforming additional checks..." -ForegroundColor Yellow
    ssh -p $sshPort "${sshUser}@${sshHost}" @"
    echo 'Checking error logs...'
    tail -n 50 $websitePath/storage/logs/laravel.log 2>/dev/null
    echo 'Checking PHP error log...'
    tail -n 50 $websitePath/storage/logs/php_errors.log 2>/dev/null
    echo 'Checking Apache error log...'
    tail -n 50 ~/logs/error.log 2>/dev/null
"@
}

# Provide troubleshooting steps
Write-Host "`nTroubleshooting steps:" -ForegroundColor Cyan
Write-Host "1. Check if https://taminattcom.pro/test.php shows PHP info"
Write-Host "2. Verify that index.php exists in the root directory"
Write-Host "3. Check .htaccess configuration"
Write-Host "4. Verify storage directory permissions"
Write-Host "5. Check Laravel logs for errors"
Write-Host "6. Verify database connection"
Write-Host "7. Check if all required PHP extensions are enabled"

# Display important paths
Write-Host "`nImportant paths:" -ForegroundColor Yellow
Write-Host "Document Root: $websitePath"
Write-Host "Storage Path: $websitePath/storage"
Write-Host "Public Path: $websitePath/public"

Write-Host "`nVerification completed!" -ForegroundColor Green
