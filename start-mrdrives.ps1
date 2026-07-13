$ErrorActionPreference = "Stop"
$ProjectRoot = Split-Path -Parent $MyInvocation.MyCommand.Path
$Port = 8032

Get-CimInstance Win32_Process -Filter "name = 'php.exe'" |
    Where-Object { $_.CommandLine -like "*$ProjectRoot*router.php*" -or $_.CommandLine -like "*-S 127.0.0.1:$Port router.php*" } |
    ForEach-Object { Stop-Process -Id $_.ProcessId -Force }

Start-Process -FilePath php -ArgumentList "-S 127.0.0.1:$Port router.php" -WorkingDirectory $ProjectRoot -WindowStyle Hidden
Start-Sleep -Milliseconds 700
Write-Host "MRDRIVES rodando isolado em http://127.0.0.1:$Port"
