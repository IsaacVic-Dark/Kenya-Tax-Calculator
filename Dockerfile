# Use official PHP image with Apache
FROM php:8.2-apache

# Copy project files to the Apache document root
COPY . /var/www/html/

# Enable Apache mod_rewrite (if needed)
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Expose port 10000 (Render default)
EXPOSE 10000

# Start Apache in the foreground binding to 0.0.0.0:10000
CMD ["apache2-foreground"]
