FROM node:20-slim

COPY wp-content/themes/my-wordpress-theme /var/www/html/wp-content/themes/my-wordpress-theme

WORKDIR /var/www/html/wp-content/themes/my-wordpress-theme

ENTRYPOINT [ "npm" ]