FROM php:7.1-cli

RUN apt-get update && apt-get install -y \
      wget \
      git

# Install Postgre PDO
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# More PHP conf here

# Symfony tool
RUN wget https://get.symfony.com/cli/installer -O - | bash && \
  mv /root/.symfony/bin/symfony /usr/local/bin/symfony

WORKDIR /usr/src/app

EXPOSE 8000

CMD symfony serve --allow-http --no-tls --port=8000