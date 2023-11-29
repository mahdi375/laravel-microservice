FROM composer:latest AS composer
FROM php:8.2-fpm

# Arguments defined in docker-compose.yml
ARG xdebug_enabled
ARG DOCKER_USER=laravel
ARG DOCKER_UID=1000

# Install composer binary from composer:latest
COPY --from=composer /usr/bin/composer /usr/local/bin/composer

# Install packages
RUN apt-get update \
    && apt-get upgrade -y \
    && apt-get install -y --no-install-recommends \
    build-essential \
    curl \
    git \
    gifsicle \
    jpegoptim \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    libonig-dev \
    libzip-dev \
    optipng \
    zip \
    unzip \
    pgpgpg \
    pngquant \
    procps \
    supervisor \
    default-mysql-client\
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install \
    bcmath \
    exif \
    gd \
    mbstring \
    opcache \
    pcntl \
    pdo_mysql \
    zip

RUN if [ "$xdebug_enabled" = "true" ] ; then pecl install xdebug && docker-php-ext-enable xdebug ; fi

RUN useradd -G www-data -u ${DOCKER_UID} -d /home/${DOCKER_USER} ${DOCKER_USER}
RUN mkdir -p /home/${DOCKER_USER}/.composer && \
    chown -R ${DOCKER_USER}:${DOCKER_USER} /home/${DOCKER_USER}

COPY start-container /usr/local/bin/start-container
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY php.ini /etc/php/8.2/cli/conf.d/99-app.ini
COPY xdebug.ini /etc/php/8.2/cli/conf.d/99-xdebug.ini
COPY fpm.conf /usr/local/etc/php-fpm.d/zz-docker.conf
RUN chmod +x /usr/local/bin/start-container
RUN sed -i 's/127.0.0.1:9000/0.0.0.0:9000/g' /usr/local/etc/php-fpm.d/www.conf

RUN touch /var/log/supervisor/supervisord.log
RUN chown ${DOCKER_USER} /var/log/supervisor/supervisord.log
USER ${DOCKER_USER}

EXPOSE 9000

ENTRYPOINT ["start-container"]
