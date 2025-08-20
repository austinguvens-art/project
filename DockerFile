# Use official PHP with Apache
FROM php:8.2-apache

# Enable Apache mod_rewrite (useful for frameworks like Laravel or clean URLs)
RUN a2enmod rewrite

# Copy project files into Apache server root
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Expose port 80 for web traffic
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
