$ProjectRoot = Split-Path -Parent $MyInvocation.MyCommand.Path
$Port = 8032

Get-CimInstance Win32_Process -Filter "name = 'php.exe'" |
    Where-Object { $_.CommandLine -like "*$ProjectRoot*router.php*" -or $_.CommandLine -like "*-S 127.0.0.1:$Port router.php*" } |
    ForEach-Object {
        Stop-Process -Id $_.ProcessId -Force
        Write-Host "MRDRIVES parado: PID $($_.ProcessId)"
    }
