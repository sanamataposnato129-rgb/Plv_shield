Railway automated deployment notes
================================

This project includes a Dockerfile and a GitHub Actions workflow that builds a Docker image, pushes it to GitHub Container Registry (GHCR), and attempts to deploy to Railway using the Railway CLI.

Required repository secrets (set in GitHub -> Settings -> Secrets):
- `RAILWAY_API_KEY` — API key from Railway (used by the workflow to authenticate)

Railway setup checklist:
1. Create a Railway project and connect your GitHub repo (optional). You can also deploy via the Railway CLI used in the workflow.
2. Add a MySQL plugin in Railway and copy DB credentials.
3. In Railway project variables, add the environment variables (required minimum):
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - `APP_URL=https://<your-railway-domain>`
   - `DB_CONNECTION=mysql`
   - `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
   - `APP_KEY` (generate with `php artisan key:generate --show` and paste value)
   - If you use the second DB connection (`duty`), add `DB_DUTY_*` values.
4. After the first deploy, run migrations from Railway console or via CLI:
   ````markdown
   Deployment notes (Railway references removed)
   ===========================================

   Railway-specific deployment notes were removed from this file. See `DEPLOY_RENDER.md` for instructions on deploying this project to Render (including connecting a MySQL database or other managed database provider).

   If you previously relied on Railway secrets or environment variables, remove them from your CI/CD secrets and replace with Render environment variables when you configure the Render service.

   ````
   # configure git user for this repo (sets name/email locally)
