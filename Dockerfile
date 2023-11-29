# Use an official PHP runtime as a parent image
FROM php:8.1



# Install dependencies
RUN apt-get update -y && apt-get install -y libzip-dev zip unzip git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo pdo_mysql zip

# Install Composer

# Set the working directory to /app
WORKDIR /app

# Copy the current directory contents into the container at .
COPY . .

# Install Laravel dependencies
RUN composer install

# Start Apache
CMD php artisan serve --host=0.0.0.0
# Expose port 80
EXPOSE 8000
