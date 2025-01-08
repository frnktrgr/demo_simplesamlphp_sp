ARG BBX_APACHE_VERSION=2.4.62*
ARG BBX_PHP_VERSION=8.4

FROM ubuntu:24.04 AS build
MAINTAINER Frank Tröger <frank.troeger@fau.de>

ARG BBX_APACHE_VERSION
ARG BBX_PHP_VERSION

# env vars
ENV TERM xterm
ENV BBX_PHP_VERSION=$BBX_PHP_VERSION

# set local mirror - can be skipped, of course
RUN set -ex \
    && sed "s/archive\.ubuntu\.com/ftp.uni-erlangen.de\/pub\/mirrors/" -i /etc/apt/sources.list.d/ubuntu.sources

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
    && LC_ALL=C.UTF-8 add-apt-repository -y ppa:ondrej/apache2 \
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
        php${BBX_PHP_VERSION}-xml \
        rsyslog \
        supervisor \
        unzip

COPY resources/ /

RUN set -ex \
    && a2enmod headers rewrite ssl \
    && a2enconf ssl-stapling \
    && a2dissite 000-default \
    && a2ensite sso-dev.fau.de sso-dev.fau.de-ssl \
    && rm /var/www/html/index.html

WORKDIR /

EXPOSE 80/tcp 443/tcp

CMD ["/startup.sh"]
