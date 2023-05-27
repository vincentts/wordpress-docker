FROM node:20-slim

WORKDIR /var/www/html/wp-content/themes/my-wordpress-theme

ENTRYPOINT [ "npm" ]