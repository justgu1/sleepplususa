FROM wordpress:5.8.3-php7.4-apache

COPY php.ini /usr/local/etc/php/conf.d/zz-sleepplususa.ini
COPY . /usr/src/wordpress/