#!/bin/sh
# Exit on error
set -e

echo "-------------------------------------"
echo "Starting Docker Entrypoint for Laravel"
echo "-------------------------------------"

# Limpiar caches de Laravel (opcional, pero recomendable)
echo "Clearing caches..."
php artisan config:clear
php artisan route:clear
php artisan cache:clear

# Arrancar PHP-FPM en background
echo "Starting PHP-FPM..."
php-fpm -D

# Esperar unos segundos para que PHP-FPM esté listo
sleep 2

# Arrancar Nginx en foreground
echo "Starting Nginx..."
nginx -g 'daemon off;'
