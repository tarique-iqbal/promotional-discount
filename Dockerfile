FROM ubuntu:20.04

# Install necessary packages and PHP
RUN apt-get update && \
    apt-get install -y software-properties-common curl && \
    add-apt-repository ppa:ondrej/php && \
    apt-get update && \
    apt-get install -y php8.4-cli php8.4-dom php8.4-mbstring php8.4-xml php8.4-xdebug unzip curl && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /home/app

# Copy composer.json, composer.lock and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist

# Copy rest of the application
COPY . .

# Set entrypoint to bash shell
ENTRYPOINT ["/bin/bash"]
