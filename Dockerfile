FROM php:8.2-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

# Instalar extensiones de PHP
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# Copiar el código fuente a la imagen Docker
COPY . /var/www

# Establecer el directorio de trabajo
WORKDIR /var/www

# Dar permisos de escritura
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

# Expone el puerto 9000 para PHP-FPM
EXPOSE 9000
