FROM php:latest
MAINTAINER Tijmen Wierenga <tijmen@devmob.com>

ARG username=tijmen
ARG user_id=501

#ENV HOME /home/${USERNAME}

# Create new user
RUN useradd -ms /bin/zsh -u ${user_id} ${username} && \
# Change permissions
    usermod -d /var/www -s /bin/zsh -u ${user_id} ${username}

# Install base packages
RUN apt-get update && \
    apt-get -yq install --no-install-recommends \
    ca-certificates bzip2 git curl zip unzip acl zsh openssh-server libssl-dev

# Install Mongo extension
RUN pecl install mongodb-1.1.8 \
    && docker-php-ext-enable mongodb

# Install Oh-My-ZSH
ADD .zshrc var/www/
RUN git clone https://github.com/robbyrussell/oh-my-zsh.git var/www/.oh-my-zsh && \
    chsh -s /bin/zsh

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
# Install CodeSniffer
    pear install PHP_CodeSniffer-3.0.0RC3

WORKDIR /var/www/project