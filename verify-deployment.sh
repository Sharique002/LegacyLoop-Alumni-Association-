#!/bin/bash

echo "🔍 Pre-Deployment Verification Checklist"
echo "========================================"
echo ""

# Check if backend directory exists
if [ -d "backend" ]; then
    echo "✅ Backend directory exists"
else
    echo "❌ Backend directory not found"
    exit 1
fi

# Check critical files
FILES=("backend/composer.json" "backend/Dockerfile" "backend/.env.example" "render.yaml")
for file in "${FILES[@]}"; do
    if [ -f "$file" ]; then
        echo "✅ $file exists"
    else
        echo "❌ $file missing"
    fi
done

# Check git status
if git rev-parse --git-dir > /dev/null 2>&1; then
    echo "✅ Git repository initialized"
    REMOTE=$(git remote get-url origin 2>/dev/null)
    if [ -n "$REMOTE" ]; then
        echo "✅ Git remote configured: $REMOTE"
    else
        echo "⚠️  Git remote not configured"
    fi
else
    echo "❌ Not a git repository"
fi

echo ""
echo "📊 Project Statistics:"
echo "----------------------"
cd backend
echo "PHP Files: $(find app -name '*.php' | wc -l)"
echo "Controllers: $(find app/Http/Controllers -name '*.php' | wc -l)"
echo "Models: $(find app/Models -name '*.php' | wc -l)"
echo "Migrations: $(find database/migrations -name '*.php' | wc -l)"
echo "Routes: $(wc -l < routes/api.php) lines in API routes"
cd ..

echo ""
echo "🚀 Ready for Deployment!"
echo "Next: Visit https://dashboard.render.com/ and create a Blueprint"
