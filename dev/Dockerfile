# Use the official PHP image with Apache
FROM php:8.3-apache

# Set the working directory in the container
WORKDIR /var/www/html

# Install necessary PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Copy the application code to the container
# COPY /app/ssm /var/www/html

# Copy custom Apache configuration
COPY ./vhost.conf /etc/apache2/sites-available/000-default.conf

# Give necessary permissions to the web server
RUN chown -R www-data:www-data /var/www/html/
# Ensure proper file permissions
RUN chmod -R 755 /var/www/html

# Expose port 80
EXPOSE 80

# Enable Apache mod_rewrite module
RUN a2enmod rewrite

# Enable Apache mod_dir module
RUN a2enmod dir

# Start the Apache server
CMD ["apache2-foreground"]


# php artisan storage:link