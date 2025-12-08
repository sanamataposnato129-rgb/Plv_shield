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

# Start php-fpm and nginx
php-fpm -D
nginx -g 'daemon off;'
