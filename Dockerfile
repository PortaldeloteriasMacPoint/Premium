FROM php:7.4-apache

RUN a2enmod rewrite

RUN echo "ServerName premium-portaldeloteriasmacpoint.onrender.com" >> /etc/apache2/apache2.conf

RUN sed -i 's/80/8080/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

COPY . /var/www/html/

EXPOSE 8080

CMD ["apache2-foreground"]

