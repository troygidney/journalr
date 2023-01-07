    FROM php:7.0-fpm
    RUN docker-php-ext-install pdo pdo_mysql
    RUN apt update
    RUN apt upgrade -y
    RUN apt install unzip -y
    RUN curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
    RUN HASH=`curl -sS https://composer.github.io/installer.sig`
    RUN php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
    RUN php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer
    RUN ln -fs /usr/share/zoneinfo/America/Edmonton /etc/localtime && dpkg-reconfigure -f noninteractive tzdata
    CMD ["sh", "../docker-entrypoint.sh"]