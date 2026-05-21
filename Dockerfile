FROM dunglas/frankenphp:php8.3-bookworm

# PHP extensions requises par Laravel + Filament
RUN MAKEFLAGS="-j1" install-php-extensions intl zip pdo_mysql bcmath gd pcntl opcache

# Node.js 22 pour Vite / npm
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction \
    && npm ci \
    && npm run build

RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 8000

CMD ["sh", "-c", "php artisan package:discover --ansi && php artisan optimize && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}"]
