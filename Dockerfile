FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Clear cache
RUN php artisan config:clear && php artisan route:clear

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Copy nginx template
RUN echo 'server {\n\
    listen ${PORT};\n\
    server_name _;\n\
    root /var/www/html/public;\n\
    index index.php index.html;\n\
    \n\
    access_log /dev/stdout;\n\
    error_log /dev/stderr;\n\
    \n\
    location / {\n\
        try_files $uri $uri/ /index.php?$query_string;\n\
    }\n\
    \n\
    location ~ \.php$ {\n\
        try_files $uri =404;\n\
        fastcgi_split_path_info ^(.+\.php)(/.+)$;\n\
        fastcgi_pass 127.0.0.1:9000;\n\
        fastcgi_index index.php;\n\
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;\n\
        include fastcgi_params;\n\
    }\n\
}' > /etc/nginx/nginx.template

# Start script that replaces PORT
RUN echo '#!/bin/bash\n\
export PORT=${PORT:-8080}\n\
envsubst '"'"'$PORT'"'"' < /etc/nginx/nginx.template > /etc/nginx/sites-available/default\n\
rm -f /etc/nginx/sites-enabled/default\n\
ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/\n\
echo "Starting PHP-FPM..."\n\
php-fpm -D\n\
echo "Starting Nginx on port $PORT..."\n\
nginx -g "daemon off;"' > /start.sh && chmod +x /start.sh

EXPOSE ${PORT}

CMD ["/start.sh"]