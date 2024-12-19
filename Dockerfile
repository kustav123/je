# Use the official PHP image with Apache
FROM php:8.3-apache

# Install necessary PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install Supervisor
RUN apt-get update && apt-get install -y supervisor

# Set the working directory in the container
WORKDIR /var/www/html

# Copy the application code to the container
COPY /app/ssm /var/www/html

# Copy custom Apache configuration
COPY ./vhost.conf /etc/apache2/sites-available/000-default.conf

# Copy Supervisor configuration
COPY ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf

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

# Create a symbolic link for storage
RUN php artisan storage:link

# Start Supervisor
CMD ["/usr/bin/supervisord"]
