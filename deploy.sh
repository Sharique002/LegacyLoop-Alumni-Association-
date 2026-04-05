#!/bin/bash

# LegacyLoop Scalability Deployment Script
# This script helps deploy the scalable LegacyLoop platform

set -e

COMPOSE_CMD=""

if command -v docker-compose > /dev/null 2>&1; then
    COMPOSE_CMD="docker-compose"
elif docker compose version > /dev/null 2>&1; then
    COMPOSE_CMD="docker compose"
else
    echo "docker compose is not available. Install Docker Compose and try again."
    exit 1
fi

echo "LegacyLoop Scalability Deployment"
echo "================================="
echo ""

# Check if Docker is running
if ! docker info > /dev/null 2>&1; then
    echo "Docker is not running. Please start Docker and try again."
    exit 1
fi

echo "Docker is running"
echo ""

# Ask for deployment mode
echo "Select deployment mode:"
echo "1) Single instance (development)"
echo "2) Multi-instance - 3 replicas (production)"
echo "3) Custom scale"
read -p "Enter choice [1-3]: " choice

case $choice in
    1)
        SCALE=1
        MODE="development"
        ;;
    2)
        SCALE=3
        MODE="production"
        ;;
    3)
        read -p "Enter number of backend instances (1-10): " SCALE
        MODE="custom"
        ;;
    *)
        echo "Invalid choice. Using single instance."
        SCALE=1
        MODE="development"
        ;;
esac

echo ""
echo "Deployment Configuration:"
echo "   Mode: $MODE"
echo "   Backend instances: $SCALE"
echo ""

# Check if .env exists
if [ ! -f "backend/.env" ]; then
    echo "No .env file found. Creating from .env.example..."
    cp backend/.env.example backend/.env
    echo "Created backend/.env"
fi

if ! grep -q '^APP_KEY=base64:' backend/.env; then
    echo "Generating APP_KEY in backend/.env..."
    APP_KEY="base64:$(openssl rand -base64 32)"
    if grep -q '^APP_KEY=' backend/.env; then
        sed -i "s|^APP_KEY=.*|APP_KEY=${APP_KEY}|" backend/.env
    else
        echo "APP_KEY=${APP_KEY}" >> backend/.env
    fi
    echo "APP_KEY generated"
fi

# Build and start services
echo "Building Docker images..."
$COMPOSE_CMD build

echo ""
echo "Starting services with $SCALE backend instance(s)..."
if [ $SCALE -eq 1 ]; then
    $COMPOSE_CMD up -d
else
    $COMPOSE_CMD up -d --scale backend=$SCALE
fi

echo ""
echo "Waiting for services to be healthy..."
sleep 10

# Check if services are running
if $COMPOSE_CMD ps | grep -q "Up"; then
    echo "Services are running"
else
    echo "Some services failed to start. Check logs with: $COMPOSE_CMD logs"
    exit 1
fi

# Run migrations
echo ""
read -p "Run database migrations? [y/N]: " run_migrations
if [[ $run_migrations =~ ^[Yy]$ ]]; then
    echo "Running database migrations..."
    $COMPOSE_CMD exec backend php artisan migrate --force
    echo "Migrations completed"
fi

# Clear cache
echo ""
echo "Caching configuration..."
$COMPOSE_CMD exec backend php artisan config:cache
$COMPOSE_CMD exec backend php artisan route:cache
echo "Cache updated"

echo ""
echo "Deployment completed successfully"
echo ""
echo "Service URLs:"
echo "   Application: http://localhost"
echo "   Health Check: http://localhost/api/health"
echo "   Ready Check: http://localhost/api/ready"
echo "   Nginx Health: http://localhost:8080/nginx-health"
echo ""
echo "Useful Commands:"
echo "   View logs: $COMPOSE_CMD logs -f"
echo "   View backend logs: $COMPOSE_CMD logs -f backend"
echo "   View Nginx logs: $COMPOSE_CMD logs -f nginx"
echo "   Scale backend: $COMPOSE_CMD up -d --scale backend=5"
echo "   Stop services: $COMPOSE_CMD down"
echo "   Check status: $COMPOSE_CMD ps"
echo ""
echo "Test the deployment:"
echo "   curl http://localhost/api/health"
echo ""
