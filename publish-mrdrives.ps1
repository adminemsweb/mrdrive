param(
    [string]$Message = "Atualiza MRDRIVES",
    [string]$VpsHost = "89.116.74.235",
    [string]$VpsUser = "root",
    [string]$RemoteDir = "/root/mrdrives"
)

$ErrorActionPreference = "Stop"
$ProjectRoot = Split-Path -Parent $MyInvocation.MyCommand.Path
$ArchivePath = Join-Path $ProjectRoot "mrdrives-deploy.zip"

function Run-Step {
    param(
        [string]$Title,
        [scriptblock]$Command
    )

    Write-Host ""
    Write-Host "==> $Title" -ForegroundColor Cyan
    & $Command
}

Run-Step "Verificando Git" {
    git -C $ProjectRoot status --short
}

Run-Step "Adicionando alteracoes" {
    git -C $ProjectRoot add -A
}

$pending = git -C $ProjectRoot status --short
if ($pending) {
    Run-Step "Commit local" {
        git -C $ProjectRoot commit -m $Message
    }
}
else {
    Write-Host "Sem alteracoes para commit." -ForegroundColor Yellow
}

Run-Step "Subindo para GitHub" {
    git -C $ProjectRoot push
}

Run-Step "Gerando ZIP limpo pelo Git" {
    if (Test-Path $ArchivePath) {
        Remove-Item -LiteralPath $ArchivePath -Force
    }
    git -C $ProjectRoot archive --format zip --output $ArchivePath HEAD
}

Run-Step "Enviando pacote para VPS" {
    scp $ArchivePath "${VpsUser}@${VpsHost}:/tmp/mrdrives-deploy.zip"
}

$remoteCommand = @"
set -e
rm -rf '$RemoteDir'
mkdir -p '$RemoteDir'
unzip -oq /tmp/mrdrives-deploy.zip -d '$RemoteDir'
find '$RemoteDir' -type f -name '*.sh' -exec sed -i 's/\r$//' {} +
chmod +x '$RemoteDir/scripts/deploy-prod.sh'
bash '$RemoteDir/scripts/deploy-prod.sh' '$RemoteDir'
"@

Run-Step "Publicando na producao" {
    $remoteCommand | ssh "${VpsUser}@${VpsHost}" "bash -s"
}

Run-Step "Teste publico" {
    curl.exe -I https://mrdrives.com.br/
}

Write-Host ""
Write-Host "Pronto: GitHub atualizado e deploy MRDRIVES concluido." -ForegroundColor Green
