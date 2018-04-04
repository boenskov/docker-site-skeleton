FROM php:7.0-fpm

#RUN apt-get update && apt-get install -y mc        

#RUN curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | bash 
RUN apt-get update && apt-get install -y \
	mc \
	git \
        libmcrypt-dev \        
        curl  \
        libpng-dev \
        libmagickwand-dev \
#        drush \
        mysql-client
        

COPY conf/ /usr/local/etc/php-fpm.d/


#RUN docker-php-ext-install pdo pdo_mysql mysqli mysqli gd iconv zip
#curl 
#RUN pecl install imagick

CMD ["php-fpm"]

#RUN docker-php-ext-install curl
#RUN docker-php-ext-install pdo pdo_mysql pdo_sqlite 
#RUN docker-php-ext-install fileinfo filter pcntl phar posix

#RUN apt-get install postfix -y

#RUN sed -i -e "s|^;date.timezone =.*$|date.timezone = Europe/Moscow|" /etc/php.ini

