FROM php:7.4-apache

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Definir o nome do servidor
RUN echo "ServerName premium-portaldeloteriasmacpoint.onrender.com" >> /etc/apache2/apache2.conf

# Alterar a porta para 8080
RUN sed -i 's/80/8080/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Instalar a extensão mysqli
RUN docker-php-ext-install mysqli

# Copiar os arquivos do projeto para o diretório correto
COPY . /var/www/html/

# Expor a porta 8080
EXPOSE 8080

# Iniciar o Apache
CMD ["apache2-foreground"]
