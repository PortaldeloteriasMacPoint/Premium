# Use uma imagem base do PHP
FROM php:8.1-cli

# Instalar dependências necessárias para o PHP
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Instalar o Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Definir o diretório de trabalho dentro do contêiner
WORKDIR /var/www/html

# Copiar o arquivo composer.json para o diretório de trabalho
COPY composer.json .

# Instalar as dependências do Composer
RUN composer install --no-interaction

# Copiar todos os arquivos do projeto para o diretório de trabalho
COPY . .

# Expor a porta 80 (se necessário)
EXPOSE 80

# Comando para iniciar o servidor PHP
CMD ["php", "-S", "0.0.0.0:80", "-t", "public"]
