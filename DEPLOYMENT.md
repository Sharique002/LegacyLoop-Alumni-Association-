# Deployment Guide (GitHub + Render + Vercel)

## What is configured in this repository

- Backend deployment for Render using [render.yaml](render.yaml)
- Dockerized Laravel backend in [backend/Dockerfile](backend/Dockerfile)
- Dockerized queue worker in [backend/Dockerfile.worker](backend/Dockerfile.worker)
- Git ignore rules to keep unwanted generated files out of commits in [.gitignore](.gitignore)

## Render (Laravel API)

1. Push this repository to GitHub.
2. In Render, create a new Blueprint and connect the GitHub repo.
3. Render will detect [render.yaml](render.yaml) and create:
   - A web service (backend API)
   - A worker service (queue worker)
4. Set the required database env vars in Render:
   - DB_HOST
   - DB_DATABASE
   - DB_USERNAME
   - DB_PASSWORD
5. Run migrations once after first deploy:
   - php artisan migrate --force

## Deployment Phase Checklist (Do This Now)

1. Initialize git locally (currently this folder is not a git repo):
   - git init
   - git branch -M main
2. Commit project files:
   - git add .
   - git commit -m "prepare deployment for render"
3. Create/connect GitHub repo:
   - git remote add origin https://github.com/Sharique002/LegacyLoop-Alumni-Association-.git
   - git push -u origin main
4. In Render, create Blueprint from this GitHub repo.
5. In Render web service and worker, set env vars from [backend/.env.render.example](backend/.env.render.example).
6. After first successful deploy, run in Render shell:
   - php artisan migrate --force
   - php artisan config:cache
   - php artisan route:cache

## Local Pre-Deploy Test

Before pushing changes, run local checks:

1. From [backend](backend):
   - composer install
   - php artisan route:list
   - php artisan about
2. If testing containers locally, start Docker Desktop first.

Health endpoint:
- /api/health

## Vercel (Frontend)

This workspace currently contains only the Laravel backend.
There is no frontend project (no package.json / Next.js / React app) to deploy on Vercel yet.

If your frontend is in another repo, deploy that repo to Vercel and set its API base URL to your Render backend URL.

If you want, add your frontend folder here and Vercel config can be added next.
