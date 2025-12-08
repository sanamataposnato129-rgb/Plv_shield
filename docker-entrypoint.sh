#!/usr/bin/env sh
# Entrypoint for the production container: substitute PORT into nginx config and start services
set -e

# Default port if not set by Render
: ${PORT:=80}

# Replace placeholder @@PORT@@ in nginx config if present
if [ -f /etc/nginx/conf.d/default.conf ]; then
  if grep -q "@@PORT@@" /etc/nginx/conf.d/default.conf; then
    echo "Substituting PORT=$PORT into nginx config"
    sed -i "s/@@PORT@@/${PORT}/g" /etc/nginx/conf.d/default.conf
  fi
fi

# Ensure permissions for storage and cache
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

# Optionally run migrations at container start. This is useful when you do not
# have an interactive shell on the host (e.g., Render free tier). Set
# `RUN_MIGRATIONS=true` in the Render environment to enable this step.
if [ "${RUN_MIGRATIONS}" = "true" ]; then
  echo "RUN_MIGRATIONS=true — attempting to run migrations and storage:link"
  MAX_TRIES=${MIGRATION_MAX_TRIES:-30}
  DELAY=${MIGRATION_RETRY_DELAY:-2}
  i=0
  until php artisan migrate --force; do
    i=$((i+1))
    echo "Migration attempt $i failed — retrying in ${DELAY}s..."
    sleep ${DELAY}
    if [ "$i" -ge "$MAX_TRIES" ]; then
      echo "Migrations failed after $i attempts — continuing startup"
      break
    fi
  done
  php artisan storage:link || true
fi

# Start php-fpm and nginx
php-fpm -D
nginx -g 'daemon off;'
