FROM php:latest
MAINTAINER Tijmen Wierenga <tijmen@devmob.com>

ARG username=tijmen
ARG user_id=501

# Create new user
RUN useradd -ms /bin/bash -u ${user_id} ${username} && \
# Change permissions
    usermod -d /var/www -s /bin/bash -u ${user_id} ${username}

# Install base packages
RUN apt-get update && \
    apt-get -yq install --no-install-recommends \
    ca-certificates bzip2 git curl zip unzip acl zsh openssh-server libssl-dev

# Install Mongo extension
RUN pecl install mongodb-1.2.9 \
    && docker-php-ext-enable mongodb

# Install CodeSniffer
RUN pear install PHP_CodeSniffer-3.0.0RC3

WORKDIR /var/www/project
HEALTHCHECK --interval=10s CMD curl -sSf localhost:1337/healthcheck > /dev/null

EXPOSE 1337