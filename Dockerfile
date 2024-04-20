FROM docker.arvancloud.ir/composer as builder
WORKDIR /app/
COPY ./composer.* ./
RUN composer install --prefer-dist && composer dump-autoload

FROM docker.arvancloud.ir/php:8.2.18-fpm-bullseye

RUN apt-get update -y && apt-get upgrade -y && apt-get install git libssl-dev -y
# Install unzip utility and
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip
RUN docker-php-ext-install zip
WORKDIR /var/www/html

COPY --from=builder /app/ ./
COPY . ./

CMD php ./src/config-bot.php