FROM php:8.1-apache
COPY . /var/www/html/
RUN sed -i 's/80/$PORT/g' /etc/apache2/ports.conf
ENV PORT=80
EXPOSE 80
CMD ["apache2-foreground"]