FROM composer

COPY wp-content/plugins /var/www/html/wp-content/plugins

COPY wp-content/themes/my-wordpress-theme /var/www/html/wp-content/themes/my-wordpress-theme

WORKDIR /var/www/html/wp-content/themes/my-wordpress-theme

ENTRYPOINT [ "composer" ]