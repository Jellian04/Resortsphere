# Use official PHP image with Apache
FROM php:8.2-apache
 
# Install necessary dependencies
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git unzip
 
# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd pdo pdo_mysql
 
# Enable Apache mod_rewrite
RUN a2enmod rewrite
 
# Copy the custom Apache config file
COPY laravel-site.conf /etc/apache2/sites-available/000-default.conf
 
# Set the permissions for the Laravel app
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
 
# Enable site configuration
RUN a2ensite 000-default.conf
 
# Expose port 80
EXPOSE 80
