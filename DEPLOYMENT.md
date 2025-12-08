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
   - `php artisan migrate --force`
   - `php artisan storage:link`

   Quick local Git / GitHub steps
   --------------------------------

   If you haven't created a GitHub repo yet, pick a repo name (suggestion: `plv_shield`) and run these commands locally in PowerShell to push this project:

   ```powershell
   # configure git user for this repo (sets name/email locally)
   git config user.name "andesjhomel1-crypto"
   git config user.email "andesjhomel1@gmail.com"

   # Option A: run the helper script included in `scripts/push_to_github.ps1`
   # This will initialize the repo if needed and push to your premade repo `shield_website`.
   .
   \scripts\push_to_github.ps1

   # Option B: run the git commands manually (use this if you prefer):
   git init
   git add --all
   git commit -m "chore: prepare repo for Railway deployment"
   git branch -M main
   git remote add origin https://github.com/andesjhomel1-crypto/shield_website.git
   git push -u origin main
   ```

   Notes:
   - If you prefer a different repo name, replace `plv_shield` in the `git remote add` URL.
   - If you use HTTPS remotes you'll need to authenticate with GitHub (use a PAT if required); you can also set up SSH keys and use an SSH remote.
   Notes:
   - The included `scripts/push_to_github.ps1` is preconfigured to push to `https://github.com/andesjhomel1-crypto/shield_website.git`.
   - Run the script from the project root in PowerShell; ensure `git` is installed and you can authenticate with GitHub (PAT or SSH).

   Railway checklist (final)
   -------------------------

   - Ensure Railway project has a MySQL plugin (or other DB) and copy the credentials.
   - In Railway Variables, set at minimum:
      - `APP_ENV=production`
      - `APP_DEBUG=false`
      - `APP_URL=https://<your-railway-domain>`
      - `DB_CONNECTION=mysql`
      - `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
      - `APP_KEY` (generate locally with `php artisan key:generate --show` and paste value)
      - `FILESYSTEM_DISK=s3` + AWS_* env if you need persistent file storage (recommended for uploads)
      - `DB_DUTY_*` variables if you use the secondary duty DB connection

   - Deploy via Railway by connecting the GitHub repo or running `railway up` from your machine (requires Railway CLI and login).
   - After deploy, run migrations and link storage:
      - `php artisan migrate --force`
      - `php artisan storage:link`

Notes & troubleshooting
- The Dockerfile installs PHP extensions and runs `php-fpm` + `nginx` in the container. If Railway uses a different runtime, you may prefer to use Railway's default PHP buildpack instead of this Dockerfile.
- If the Railway CLI `railway up` step fails in the workflow, check the Actions logs and consider running Railway deployment manually from your machine to debug.
- For file uploads, consider using S3 (set `FILESYSTEM_DISK=s3` and add AWS_* env vars) — Railway's ephemeral filesystems may not persist uploads across redeploys.
