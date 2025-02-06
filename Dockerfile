FROM php:7.4-apache

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Definir o nome do servidor
RUN echo "ServerName premium-portaldeloteriasmacpoint.onrender.com" >> /etc/apache2/apache2.conf

# Alterar a porta para 8080
RUN sed -i 's/80/8080/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Instalar extensões necessárias
RUN docker-php-ext-install mysqli

# Instalar o Composer diretamente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Definir diretório de trabalho
WORKDIR /var/www/html

# Copiar os arquivos do projeto
COPY . /var/www/html/

# Instalar dependências do Composer
RUN composer install --no-dev --optimize-autoloader

# Corrigir permissões dos arquivos
RUN chown -R www-data:www-data /var/www/html

# Expor a porta 8080
EXPOSE 8080

# Iniciar o Apache
CMD ["apache2-foreground"]

