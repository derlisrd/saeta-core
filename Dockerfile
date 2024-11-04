# Usa una imagen base de PHP con extensiones necesarias para Laravel
FROM php:8.2-fpm

# Instala dependencias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

# Instala extensiones PHP
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configura el directorio de trabajo
WORKDIR /var/www/html/saeta-core/

# Copia el código de la aplicación
COPY . .

# Da permisos a las carpetas de almacenamiento y cache
RUN chown -R www-data:www-data /var/www/html/saeta-core/storage /var/www/html/bootstrap/cache

# Expone el puerto
EXPOSE 9000

CMD ["php-fpm"]
