FROM php:8.2-cli

ARG APP_ROOT=/home/app

# Install dependencies
RUN apt-get update && apt-get install -y git zip unzip libzip-dev libpng-dev

RUN docker-php-ext-configure gd

# Install PHP extensions
RUN docker-php-ext-install zip

# Install Composer
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"

# Set up working directory
RUN mkdir -p $APP_ROOT
WORKDIR ${APP_ROOT}

# RUN composer global require statamic/cli
# COMPOSER_PROCESS_TIMEOUT=2000 ~/.composer/vendor/bin/statamic new darul-jidaal

# Copy composer files and install PHP dependencies
COPY composer.* .
RUN composer install --download-only

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install

EXPOSE 8000

ENTRYPOINT ["./entrypoint.sh"]
