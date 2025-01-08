# Usa a imagem oficial do PHP com Apache
FROM php:7.4-apache

# Habilita o módulo mod_rewrite do Apache
RUN a2enmod rewrite

# Copia o código do seu projeto para dentro do container
COPY . /var/www/html/

# Ajusta o Apache para escutar na porta 8080
RUN sed -i 's/80/8080/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Expõe a porta 8080 para Render
EXPOSE 8080

# Comando para iniciar o Apache
CMD ["apache2-foreground"]

