FROM php:8.1-fpm

RUN apt update && apt install -y \
      apt-utils \
      libpq-dev \
      libpng-dev \
      libzip-dev \
      zip unzip \
      git && \
      docker-php-ext-install pdo_pgsql && \
      docker-php-ext-install bcmath && \
      docker-php-ext-install gd && \
      docker-php-ext-install zip && \
      pecl install xdebug && \
      docker-php-ext-enable xdebug && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY ./_docker/php/php.ini /usr/local/etc/php/conf.d/php.ini
COPY ./_docker/php/fpm-pool.conf /usr/local/etc/php-fpm.d/www.conf

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

# Установка php-xdebug
RUN if [ "$ENV" = "development" ]; \
	then pecl install xdebug && docker-php-ext-enable xdebug;  \
	else echo "$ENV"; \
	fi

RUN adduser -G root -u 1000 -h /home/1000 -S 1000

USER 1000

WORKDIR /var/www/html/web/
