FROM ubuntu:20.04

ARG APIURL

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update \
    && apt-get install -y apache2 \
    && apt-get install -y php \
    && apt-get install -y php-curl \
    && rm -rf /var/www/html/*

COPY ./ /var/www/html/

# Enable Apache rewrite module
RUN a2enmod rewrite

# Modify php.ini to change session.auto_start
RUN sed -i 's/^\(session\.auto_start\s*=\s*\)0/\11/' /etc/php/7.4/apache2/php.ini

# Modify Apache configuration to allow .htaccess overrides
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride all/' /etc/apache2/apache2.conf

# Set $my_api value to "https://seulchuksaeng.store/"
RUN sed -i 's/$my_api = "";/\$my_api = "${APIURL}";/' /var/www/html/config/config.php

ENTRYPOINT ["apachectl", "-D", "FOREGROUND"]
EXPOSE 80/tcp
