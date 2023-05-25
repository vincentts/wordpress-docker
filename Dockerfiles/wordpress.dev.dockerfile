FROM wordpress:php8.2-apache

RUN cd /usr/src/wordpress/wp-content \
    && rm -r themes/twentytwentyone \
    && rm -r themes/twentytwentytwo \
    && rm -r themes/twentytwentythree \
    && rm -r plugins/akismet \
    && rm plugins/hello.php

COPY wp-config.php /var/www/html/wp-config.php

COPY wp-content/plugins /var/www/html/wp-content/plugins

COPY wp-content/themes /var/www/html/wp-content/themes

ENV WORDPRESS_DB_HOST=mysql

ENV WORDPRESS_DB_USER=user

ENV WORDPRESS_DB_PASSWORD=password

ENV WORDPRESS_DB_NAME=wordpress

ENV WORDPRESS_TABLE_PREFIX=wp_

EXPOSE 80