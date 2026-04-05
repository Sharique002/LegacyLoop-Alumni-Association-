$ErrorActionPreference = 'Stop'

Write-Host 'LegacyLoop Scalability Deployment'
Write-Host '================================='
Write-Host ''

try {
    docker info | Out-Null
} catch {
    Write-Error 'Docker is not running. Start Docker Desktop and try again.'
    exit 1
}

$composeCmd = @('docker', 'compose')
try {
    docker compose version | Out-Null
} catch {
    Write-Error 'Docker Compose is not available. Install Docker Desktop and try again.'
    exit 1
}

Write-Host 'Docker is running'
Write-Host ''
Write-Host 'Select deployment mode:'
Write-Host '1) Single instance (development)'
Write-Host '2) Multi-instance - 3 replicas (production)'
Write-Host '3) Custom scale'
$choice = Read-Host 'Enter choice [1-3]'

switch ($choice) {
    '1' { $scale = 1; $mode = 'development' }
    '2' { $scale = 3; $mode = 'production' }
    '3' {
        $scale = [int](Read-Host 'Enter number of backend instances (1-10)')
        $mode = 'custom'
    }
    default {
        $scale = 1
        $mode = 'development'
    }
}

Write-Host ''
Write-Host 'Deployment Configuration:'
Write-Host "  Mode: $mode"
Write-Host "  Backend instances: $scale"
Write-Host ''

$backendEnv = Join-Path $PSScriptRoot 'backend/.env'
$backendEnvExample = Join-Path $PSScriptRoot 'backend/.env.example'

if (-not (Test-Path $backendEnv)) {
    Write-Host 'No backend/.env found. Creating from backend/.env.example...'
    Copy-Item -Path $backendEnvExample -Destination $backendEnv -Force
    Write-Host 'Created backend/.env'
}

$envText = Get-Content -Path $backendEnv -Raw
if ($envText -notmatch '(?m)^APP_KEY=base64:') {
    Write-Host 'Generating APP_KEY in backend/.env...'
    $bytes = New-Object byte[] 32
    [System.Security.Cryptography.RandomNumberGenerator]::Create().GetBytes($bytes)
    $appKey = 'base64:' + [Convert]::ToBase64String($bytes)

    if ($envText -match '(?m)^APP_KEY=') {
        $envText = [Regex]::Replace($envText, '(?m)^APP_KEY=.*$', "APP_KEY=$appKey")
    } else {
        if ($envText.Length -gt 0 -and -not $envText.EndsWith("`n")) {
            $envText += "`r`n"
        }
        $envText += "APP_KEY=$appKey`r`n"
    }
    Set-Content -Path $backendEnv -Value $envText -NoNewline
    Write-Host 'APP_KEY generated'
}

Write-Host ''
Write-Host 'Building Docker images...'
& $composeCmd[0] $composeCmd[1] build

Write-Host ''
Write-Host "Starting services with $scale backend instance(s)..."
if ($scale -eq 1) {
    & $composeCmd[0] $composeCmd[1] up -d
} else {
    & $composeCmd[0] $composeCmd[1] up -d --scale "backend=$scale"
}

Write-Host ''
Write-Host 'Waiting for services to be healthy...'
Start-Sleep -Seconds 10

Write-Host 'Current service status:'
& $composeCmd[0] $composeCmd[1] ps

$runMigrations = Read-Host 'Run database migrations? [y/N]'
if ($runMigrations -match '^[Yy]$') {
    Write-Host 'Running database migrations...'
    & $composeCmd[0] $composeCmd[1] exec backend php artisan migrate --force
    Write-Host 'Migrations completed'
}

Write-Host ''
Write-Host 'Caching configuration...'
& $composeCmd[0] $composeCmd[1] exec backend php artisan config:cache
& $composeCmd[0] $composeCmd[1] exec backend php artisan route:cache
Write-Host 'Cache updated'

Write-Host ''
Write-Host 'Deployment completed successfully'
Write-Host ''
Write-Host 'Service URLs:'
Write-Host '  Application: http://localhost'
Write-Host '  Health Check: http://localhost/api/health'
Write-Host '  Ready Check: http://localhost/api/ready'
Write-Host '  Nginx Health: http://localhost:8080/nginx-health'
Write-Host ''
Write-Host 'Useful commands:'
Write-Host '  docker compose logs -f'
Write-Host '  docker compose logs -f backend'
Write-Host '  docker compose logs -f nginx'
Write-Host '  docker compose up -d --scale backend=5'
Write-Host '  docker compose down'
Write-Host '  docker compose ps'
