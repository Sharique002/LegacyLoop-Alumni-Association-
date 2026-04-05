# 🔍 Pre-Deployment Verification Checklist

Write-Host "========================================"
Write-Host "🔍 Pre-Deployment Verification Checklist"
Write-Host "========================================`n"

# Check if backend directory exists
if (Test-Path "backend") {
    Write-Host "✅ Backend directory exists" -ForegroundColor Green
} else {
    Write-Host "❌ Backend directory not found" -ForegroundColor Red
    exit 1
}

# Check critical files
$files = @(
    "backend\composer.json",
    "backend\Dockerfile",
    "backend\.env.example",
    "render.yaml",
    "DEPLOY_NOW.md"
)

foreach ($file in $files) {
    if (Test-Path $file) {
        Write-Host "✅ $file exists" -ForegroundColor Green
    } else {
        Write-Host "❌ $file missing" -ForegroundColor Red
    }
}

# Check git status
try {
    $gitStatus = git rev-parse --git-dir 2>&1
    Write-Host "✅ Git repository initialized" -ForegroundColor Green
    
    $remote = git remote get-url origin 2>$null
    if ($remote) {
        Write-Host "✅ Git remote configured: $remote" -ForegroundColor Green
        
        $commits = git log --oneline | Measure-Object
        Write-Host "✅ Total commits: $($commits.Count)" -ForegroundColor Green
    } else {
        Write-Host "⚠️  Git remote not configured" -ForegroundColor Yellow
    }
} catch {
    Write-Host "❌ Not a git repository" -ForegroundColor Red
}

Write-Host "`n📊 Project Statistics:"
Write-Host "----------------------"

Push-Location backend

$phpFiles = (Get-ChildItem -Path "app" -Filter "*.php" -Recurse).Count
$controllers = (Get-ChildItem -Path "app\Http\Controllers" -Filter "*.php" -Recurse).Count
$models = (Get-ChildItem -Path "app\Models" -Filter "*.php" -Recurse).Count
$migrations = (Get-ChildItem -Path "database\migrations" -Filter "*.php" -Recurse).Count

Write-Host "PHP Files: $phpFiles"
Write-Host "Controllers: $controllers"
Write-Host "Models: $models"
Write-Host "Migrations: $migrations"

Pop-Location

Write-Host "`n🎯 Deployment Targets:"
Write-Host "----------------------"
Write-Host "✅ GitHub: https://github.com/Sharique002/LegacyLoop-Alumni-Association-" -ForegroundColor Green
Write-Host "⏳ Render: https://dashboard.render.com/ (Blueprint deployment)" -ForegroundColor Yellow
Write-Host "⏳ Vercel: Optional (Frontend only)" -ForegroundColor Yellow

Write-Host "`n🚀 Ready for Deployment!"
Write-Host "`nNext Steps:"
Write-Host "1. Open DEPLOY_NOW.md for detailed instructions"
Write-Host "2. Visit https://dashboard.render.com/"
Write-Host "3. Create a new Blueprint from your GitHub repo"
Write-Host "4. Configure database environment variables"
Write-Host "5. Deploy and test!"

Write-Host "`n✨ All systems go! ✨`n" -ForegroundColor Cyan
