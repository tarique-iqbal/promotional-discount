FROM ubuntu:20.04

# Install necessary packages and PHP
RUN apt-get update && \
    apt-get install -y software-properties-common curl && \
    add-apt-repository ppa:ondrej/php && \
    apt-get update && \
    apt-get install -y php8.4-cli php8.4-dom php8.4-mbstring php8.4-xml php8.4-xdebug unzip curl && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Configure xdebug (Optional: customize according to needs)
RUN echo "zend_extension=xdebug.so" >> /etc/php/8.4/cli/conf.d/20-xdebug.ini && \
    echo "xdebug.mode=debug" >> /etc/php/8.4/cli/conf.d/20-xdebug.ini && \
    echo "xdebug.start_with_request=yes" >> /etc/php/8.4/cli/conf.d/20-xdebug.ini

# Set working directory
WORKDIR /var/www/promotional-discount

# Copy composer.json and install dependencies
COPY ./composer.json composer.json
RUN composer install

# Copy rest of the application
COPY . .

# Set entrypoint to bash shell
ENTRYPOINT ["/bin/bash"]
