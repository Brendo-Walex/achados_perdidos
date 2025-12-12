FROM php:8.1-apache

# 1. Instala dependências do Sistema e Extensões PHP
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libwebp-dev \
    libxpm-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
        --with-xpm \
    && docker-php-ext-install mysqli gd pdo pdo_mysql

# 2. Configura o Apache para apontar para a pasta /public (Padrão MVC)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 3. Habilita o mod_rewrite (Necessário para rotas amigáveis)
RUN a2enmod rewrite

# 4. Define permissões corretas (Usuário www-data)
WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www/html