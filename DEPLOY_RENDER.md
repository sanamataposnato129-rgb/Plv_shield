# Deploying `plv_shield` to Render

This guide explains how to deploy this Laravel project to Render and connect it to a MySQL database (either Render Managed MySQL if available in your account, or an external managed MySQL like PlanetScale/Amazon RDS). The repository already contains a `Dockerfile`—recommended for a predictable production environment.

## Overview
- Preferred: Deploy as a Render **Service** using the included `Dockerfile`.
- Create a Managed Database (MySQL) on Render if offered; otherwise create an external MySQL instance and copy credentials.
- Set environment variables on Render from the Render dashboard.
- Run migrations and link storage after the first deploy.

## Steps

1) Push your repository to GitHub (or connect your Git provider)

   - Create a GitHub repo (or use an existing one) and push the project.
   - You can use the included helper script `\scripts\push_to_github.ps1` or run Git commands manually.

2) Create a new Web Service on Render (Docker)

   - In Render dashboard, click **New** → **Web Service**.
   - Connect your Git provider and select the repository.
   - Choose **Docker** as the environment and set the `Dockerfile` path to the project root `./Dockerfile`.
   - Set the instance plan according to your needs (free/small/standard).
   - (Optional) Set a health check if you have an endpoint like `/health`.

3) Create or connect a MySQL database

   - Option A: Create a Managed MySQL on Render (if available for your account).
     - In Render dashboard, **New** → **Database** → select **MySQL** (if present) and create it.
     - After it's ready, note the connection info: host, port (3306), database, user, password.

   - Option B: Use an external Managed MySQL (PlanetScale, AWS RDS, Azure MySQL, Google Cloud SQL).
     - Create the database in that provider and note the connection info.

4) Set environment variables in Render for the Web Service

   Minimum required env vars for this project:
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - `APP_KEY` — generate locally with `php artisan key:generate --show` and paste the value
   - `APP_URL` — the public URL Render gives you (or your custom domain)
   - `DB_CONNECTION=mysql`
   - `DB_HOST` — database host
   - `DB_PORT` — usually `3306`
   - `DB_DATABASE` — database name
   - `DB_USERNAME` — database user
   - `DB_PASSWORD` — database password

   Additional recommended env vars:
   - `FILESYSTEM_DISK=s3` (recommended for persistent uploads) and the AWS_* keys if using S3
   - Email config (`MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_FROM_ADDRESS`)
   - Any custom keys used by your app (e.g., `PUSHER`, `STRIPE`, etc.)

   Add these variables in the Render service's **Environment** settings.

5) Deploy & run migrations

   - Trigger a deploy in Render (it will build the Docker image). If the build fails, inspect build logs.
   - After the deploy succeeds, run migrations. Options:
     - Use Render's **Shell** (one-off shell) to run:
       ```bash
       php artisan migrate --force
       php artisan storage:link
       ```
     - Or run a one-off job (Render supports Jobs/One-off commands) that runs the above commands.

6) Files and persistent storage

   - Render containers have ephemeral disks — uploaded files will not persist across deploys. Use S3 (or another cloud storage) for `FILESYSTEM_DISK`.
   - Ensure `FILESYSTEM_DISK` and AWS env vars are set if you rely on file uploads.

7) (Optional) Scheduled tasks & background workers

   - If you need queue workers, create a separate **Background Worker** service on Render that runs `php artisan queue:work --sleep=3 --tries=3` (or use Horizon if configured).
   - For scheduled tasks, use Render cron jobs (scheduled jobs) to run `php artisan schedule:run` every minute.

8) Custom domains & TLS

   - In Render, add a custom domain to the service and configure DNS records as instructed.
   - Render will provision TLS certificates automatically for supported domains.

## Notes & troubleshooting
- If your Dockerfile builds but the container doesn't start, check the `CMD` / `ENTRYPOINT` in the Dockerfile and the Render start command; ensure `php-fpm`/`nginx` are started correctly by the container.
- If you see database connection errors, double-check env vars and ensure the DB accepts connections from Render (some providers require allowed IPs).
- Prefer S3 for file storage — Render filesystem is ephemeral.

## Quick local commands (useful before deploy)

```powershell
# Install deps
composer install --no-dev --optimize-autoloader
npm ci
npm run build

# Generate APP_KEY
php artisan key:generate --show

# Run migrations locally against your local or staging DB
php artisan migrate
php artisan storage:link
```

If you want, I can now:
- Commit the Railway-removal changes for you (I will run `git add`/`git commit`).
- Create a Render `render.yaml` manifest (optional) to make the deployment reproducible.

