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

# Ejecutar migraciones automáticamente
echo "Running Laravel migrations..."
if php artisan migrate --force; then
    echo "✅ Migrations applied successfully."
else
    echo "⚠️ Migrations failed!"
fi

echo "Running composer install..."
if composer install; then
    echo "✅ composer install successfully."
else
    echo "⚠️ composer failed!"
fi

echo "Running faker install..."
if composer require fakerphp/faker --dev; then
    echo "✅ Faker install successfully."
else
    echo "⚠️ Faker install failed!"
fi

echo "Running Laravel seed..."
if php artisan db:seed --force; then
    echo "✅ Seeders applied successfully."
else
    echo "⚠️ Seeders failed!"
fi

# Arrancar Nginx en foreground
echo "Starting Nginx..."
nginx -g 'daemon off;'
