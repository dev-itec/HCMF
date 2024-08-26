# Usar una imagen base oficial de PHP
FROM php:8.2-fpm

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    libonig-dev \
    npm \
    nodejs

# Limpiar el cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones de PHP
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar el código de la aplicación
COPY . .

# Establecer los permisos correctos para la carpeta storage y bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Instalar dependencias de Node.js
RUN npm install

# Exponer el puerto 9000 y configurar el proceso principal de la imagen
EXPOSE 9000
CMD ["php-fpm"]
