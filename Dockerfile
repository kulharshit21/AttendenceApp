# Use the official PHP Apache image as the base image
FROM php:7.4-apache

# Install necessary PHP extensions (mysqli, pdo_mysql)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Install sendmail for email functionality
RUN apt-get update && apt-get install -y \
    sendmail \
    sendmail-bin \
    && rm -rf /var/lib/apt/lists/*

# Configure sendmail
RUN echo "sendmail_path=/usr/sbin/sendmail -t -i" > /usr/local/etc/php/conf.d/sendmail.ini

# Enable Apache mod_rewrite (optional, if needed)
RUN a2enmod rewrite

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy your application files into the container (optional)
# COPY ./htdocs /var/www/html

# Expose port 80 for Apache
EXPOSE 80