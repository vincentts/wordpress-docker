FROM composer

WORKDIR /var/www/html/wp-content/themes/my-wordpress-theme

ENTRYPOINT [ "composer" ]