FROM php:8.4-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
	libfreetype-dev \
	libjpeg62-turbo-dev \
	libpng-dev \
	libzip-dev \
	unzip \
	curl \
	git \
	libonig-dev \
	libxml2-dev \
	libpq-dev \
	libssl-dev \
	libsqlite3-dev \
	zip \
    libcurl4-openssl-dev \
    pkg-config \
    nodejs \
    npm \
    chromium \
    fonts-liberation \
    libasound2 \
    libatk-bridge2.0-0 \
    libatk1.0-0 \
    libatspi2.0-0 \
    libcups2 \
    libdbus-1-3 \
    libdrm2 \
    libgtk-3-0 \
    libnspr4 \
    libnss3 \
    libxcomposite1 \
    libxdamage1 \
    libxfixes3 \
    libxrandr2 \
    libxss1 \
    libxtst6 \
    xdg-utils

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd \
	&& docker-php-ext-install bcmath \
	&& docker-php-ext-install pdo_mysql pdo_sqlite mbstring exif pcntl zip
	
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Add PHP configuration
RUN echo "memory_limit=1G" > /usr/local/etc/php/conf.d/memory-limit.ini
RUN echo "max_execution_time=300" > /usr/local/etc/php/conf.d/max-execution-time.ini

WORKDIR /var/www

# Copy and set permissions for entrypoint script
COPY docker-compose/entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

USER $user

ENTRYPOINT ["entrypoint.sh"]