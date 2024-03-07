FROM dunglas/frankenphp:1.1-builder-php8.2.16

# Set Caddy server name to "http://" to serve on 80 and not 443
# Read more: https://frankenphp.dev/docs/config/#environment-variables
ENV SERVER_NAME="http://"

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
    git \
    unzip \
    supervisor

RUN install-php-extensions \
    pdo_pgsql \
    pcntl


COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy the Laravel application files into the container.
COPY . .

COPY ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Install Laravel dependencies using Composer.
RUN composer install

# Set permissions for Laravel.
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80 443


# Start Supervisor.
CMD ["supervisord","-c", "/etc/supervisor/conf.d/supervisord.conf"]
