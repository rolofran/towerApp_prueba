# 1. Base PHP con extensiones
FROM php:8.5-fpm

# Instalar deps
RUN apt-get update && apt-get install -y \
    nginx \
    libpq-dev \
    zip unzip \
    curl \
    git \
    && docker-php-ext-install pdo pdo_pgsql

# Crear directorio de trabajo
WORKDIR /var/www/html

# Copiar aplicación
COPY . .

# Instalar composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Instalar dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Crear directorios necesarios y establecer permisos
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Configurar PHP-FPM para escuchar en 0.0.0.0:9000
RUN sed -i 's/listen = .*/listen = 0.0.0.0:9000/' /usr/local/etc/php-fpm.d/www.conf

# Configurar PHP-FPM para escuchar en socket Unix
# RUN sed -i 's|listen = .*|listen = /var/run/php/php-fpm.sock|' /usr/local/etc/php-fpm.d/www.conf


# Limpiar todas las configuraciones de Nginx por defecto
RUN rm -rf /etc/nginx/conf.d/* && \
    rm -rf /etc/nginx/sites-enabled/* && \
    rm -rf /etc/nginx/sites-available/*

# Copiar configuración nginx (DESPUÉS de limpiar)
COPY conf/nginx/nginx-site.conf /etc/nginx/conf.d/site.conf

# Crear directorios de logs para Nginx
RUN mkdir -p /var/log/nginx && chown -R www-data:www-data /var/log/nginx

# Eliminar configuración por defecto de Nginx para evitar conflictos
RUN rm -f /etc/nginx/conf.d/default.conf

# Copiar script de entrada
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Exponer puerto 80
EXPOSE 80

# Start NGINX + PHP-FPM usando el script
CMD ["/usr/local/bin/docker-entrypoint.sh"]
