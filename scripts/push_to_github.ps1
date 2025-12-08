param(
    [string]$RepoUrl = "https://github.com/andesjhomel1-crypto/shield_website.git",
    [switch]$Force
)

Write-Output "Preparing to push repository to: $RepoUrl"

# Configure git user for this repo (local config)
git config user.name "andesjhomel1-crypto"
git config user.email "andesjhomel1@gmail.com"

if (!(Test-Path -Path .git)) {
    Write-Output "Initializing git repository..."
    git init
}

Write-Output "Adding files to commit..."
git add --all

Write-Output "Creating commit (if there are changes)..."
git commit -m "chore: prepare repo for Railway deployment" 2>$null
if ($LASTEXITCODE -ne 0) {
    Write-Output "No commit created (no changes) or commit failed. Continuing to push.";
}

Write-Output "Ensuring branch is 'main'..."
git branch -M main 2>$null

if ($Force) {
    Write-Output "Removing existing 'origin' remote (force)..."
    git remote remove origin -ErrorAction SilentlyContinue
}

# Add remote if it does not exist
$existing = git remote get-url origin 2>$null
if (-not $existing) {
    Write-Output "Adding remote origin: $RepoUrl"
    git remote add origin $RepoUrl
} else {
    Write-Output "Remote origin already exists: $existing"
}

Write-Output "Pushing to origin/main..."
git push -u origin main

Write-Output "Done. If push failed, ensure 'git' is installed and you are authenticated with GitHub (PAT or SSH)."
