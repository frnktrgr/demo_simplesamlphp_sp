ARG BBX_APACHE_VERSION=2.4.52*
ARG BBX_PHP_VERSION=8.1

ARG BBX_SSP_VERSION=2.0.3
ARG BBX_SSP_CHECKSUM=ca06d22d265fb75ee0f91d1e013db167dcc33ee449d03a81bd20160f899273cf

ARG BBX_COMPOSER_VERSION=2.5.8
ARG BBX_COMPOSER_CHECKSUM=f07934fad44f9048c0dc875a506cca31cc2794d6aebfc1867f3b1fbf48dce2c5

FROM ubuntu:22.04 AS build
MAINTAINER Frank Tröger <frank.troeger@fau.de>

ARG BBX_APACHE_VERSION
ARG BBX_PHP_VERSION

ARG BBX_SSP_VERSION
ARG BBX_SSP_CHECKSUM

ARG BBX_COMPOSER_VERSION
ARG BBX_COMPOSER_CHECKSUM

# env vars
ENV TERM xterm
ENV BBX_PHP_VERSION=$BBX_PHP_VERSION

# set local mirror - can be skipped, of course
RUN set -ex \
    && sed "s/archive\.ubuntu\.com/ftp.uni-erlangen.de\/pub\/mirrors/" -i /etc/apt/sources.list

RUN set -ex \
    && export DEBIAN_FRONTEND=noninteractive \
    && apt-get -qq update && apt-get -qqy upgrade \
    && apt-get -qqy install \
        apt-transport-https \
        curl \
        iputils-ping \
        less \
        multitail \
        net-tools \
        software-properties-common \
        tzdata \
        vim \
        wget \
    && LC_ALL=C.UTF-8 add-apt-repository -y ppa:ondrej/php \
    && apt-get -qq update \
    && apt-get -qqy upgrade

# set timezone
RUN set -ex \
    && ln -fs /usr/share/zoneinfo/Europe/Berlin /etc/localtime \
    && dpkg-reconfigure -f noninteractive tzdata

# install packages
RUN set -ex \
    && export DEBIAN_FRONTEND=noninteractive \
    && apt-get -qq update \
    && apt-get -qqy install \
        apache2=${BBX_APACHE_VERSION} \
        cron \
        libapache2-mod-php${BBX_PHP_VERSION} \
        logrotate \
        patch \
        php${BBX_PHP_VERSION} \
        php${BBX_PHP_VERSION}-curl \
        php${BBX_PHP_VERSION}-intl \
        php${BBX_PHP_VERSION}-sqlite3 \
        php${BBX_PHP_VERSION}-xdebug \
        php${BBX_PHP_VERSION}-xml \
        rsyslog \
        supervisor \
        unzip

# install composer
WORKDIR /usr/local/bin
RUN set -ex \
    && wget https://getcomposer.org/download/${BBX_COMPOSER_VERSION}/composer.phar \
    && echo "${BBX_COMPOSER_CHECKSUM}  composer.phar" | sha256sum -c \
    && mv /usr/local/bin/composer.phar /usr/local/bin/composer \
    && chmod a+x /usr/local/bin/composer

# install SimpleSAMLphp
WORKDIR /var
RUN set -ex \
    && wget https://github.com/simplesamlphp/simplesamlphp/releases/download/v${BBX_SSP_VERSION}/simplesamlphp-${BBX_SSP_VERSION}.tar.gz \
    && echo "${BBX_SSP_CHECKSUM}  simplesamlphp-${BBX_SSP_VERSION}.tar.gz" | sha256sum -c \
    && tar xzf simplesamlphp-${BBX_SSP_VERSION}.tar.gz \
    && mv simplesamlphp-${BBX_SSP_VERSION} simplesamlphp \
    && rm simplesamlphp-${BBX_SSP_VERSION}.tar.gz

WORKDIR /var/simplesamlphp
RUN set -ex \
    && COMPOSER_ALLOW_SUPERUSER=1 composer require -n --ignore-platform-reqs --update-no-dev simplesamlphp/simplesamlphp-module-metarefresh

WORKDIR /var/simplesamlphp
RUN set -ex \
    && cp config/config.php.dist config/config.php \
    && cp config/authsources.php.dist config/authsources.php \
    && cp modules/cron/config/module_cron.php.dist config/module_cron.php \
    && cp modules/metarefresh/config-templates/module_metarefresh.php config/module_metarefresh.php

COPY resources/ /

RUN set -ex \
    && a2enmod headers rewrite ssl \
    && a2enconf ssl-stapling \
    && a2dissite 000-default \
    && a2ensite sso-dev.fau.de sso-dev.fau.de-ssl \
    && rm /var/www/html/index.html \
    && chown www-data /var/simplesamlphp/metadata

WORKDIR /var/simplesamlphp

EXPOSE 80/tcp 443/tcp

CMD ["/startup.sh"]
