FROM php:7.3-fpm

#set our application folder as an environment variable
ENV APP_HOME /var/www/html

COPY .docker $APP_HOME/.docker

ARG INSTALL_NODE=false

ARG INSTALL_XDEBUG=false

ARG INSTALL_OPCACHE=true

ENV COMPOSER_ALLOW_SUPERUSER=1
ers
RUN apt-get update -y && \
    pecl channel-update pecl.php.net && \
    apt-get install -y --no-install-recommends \
        ca-certificates \
        lsb-release \
        gnupg2 \
        nano \
        apt-utils \
        openssh-server \
        curl \
        libmemcached-dev \
        libz-dev \
        libpq-dev \
        libjpeg-dev \
        libpng-dev \
        libfreetype6-dev \
        libssl-dev \
        libzip-dev \
        libmcrypt-dev \
        zip \
        unzip \
        supervisor \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure gd \
               --with-jpeg-dir=/usr/lib \
               --with-png-dir=/usr/lib \
               --with-freetype-dir=/usr/include/freetype2 \
    && docker-php-ext-install \
        pdo_mysql \
        zip \
        pcntl \
        bcmath \
        gd \
    && php -m | grep -q 'zip'

###########################################################################
# Nginx:
###########################################################################

RUN echo "deb http://nginx.org/packages/debian `lsb_release -cs` nginx" \
        | tee /etc/apt/sources.list.d/nginx.list

RUN curl -fsSL https://nginx.org/keys/nginx_signing.key | apt-key add -
RUN apt-key fingerprint ABF5BD827BD9BF62
RUN apt-get update -y && apt-get install -y nginx


###########################################################################
# NodeJs:
###########################################################################
RUN if [ ${INSTALL_NODE} = true ]; then \
  curl -sL https://deb.nodesource.com/setup_14.x | bash - && \
  apt-get install -y nodejs \
;fi


###########################################################################
# xDebug:
###########################################################################
RUN if [ ${INSTALL_XDEBUG} = true ]; then \
  pecl install xdebug && \
  docker-php-ext-enable xdebug && \
  cp ${APP_HOME}/.docker/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini \
;fi


###########################################################################
# OPCACHE:
###########################################################################

RUN if [ ${INSTALL_OPCACHE} = true ]; then \
  docker-php-ext-install opcache && \
  cp ${APP_HOME}/.docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini \
;fi

###########################################################################
# Composer:
###########################################################################

# Install composer and add its bin to the PATH.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer


###########################################################################
# SSH:
###########################################################################

# SSH login fix. Otherwise user is kicked off after login
RUN mkdir /var/run/sshd
RUN sed -i 's/PermitRootLogin without-password/PermitRootLogin yes/' /etc/ssh/sshd_config

RUN sed 's@session\s*required\s*pam_loginuid.so@session optional pam_loginuid.so@g' -i /etc/pam.d/sshd

ENV NOTVISIBLE "in users profile"
RUN echo "export VISIBLE=now" >> /etc/profile


#
#--------------------------------------------------------------------------
# Final Touch
#--------------------------------------------------------------------------
#

# Configure PHP & PHP-FPM
COPY .docker/php/laravel.ini /usr/local/etc/php/conf.d/
RUN rm /usr/local/etc/php-fpm.d/*
COPY .docker/php/fpm.pool.conf /usr/local/etc/php-fpm.d/

# Configure NGINX
COPY .docker/nginx/nginx.conf /etc/nginx/nginx.conf
RUN rm /etc/nginx/conf.d/default.conf

# Configure supervisord
COPY .docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

#change uid and gid of apache to docker user uid/gid
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# Copy source files
COPY --chown=www-data:www-data . $APP_HOME

RUN composer install --no-interaction --optimize-autoloader

WORKDIR /var/www/html

EXPOSE 80

ENTRYPOINT ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]


