ARG BBX_APACHE_VERSION=2.4.41*
ARG BBX_PHP_VERSION=7.4

FROM ubuntu:20.04 AS build
MAINTAINER Frank Tröger <frank.troeger@fau.de>

ARG BBX_APACHE_VERSION
ARG BBX_PHP_VERSION

ENV TERM xterm
ENV BBX_PHP_VERSION=$BBX_PHP_VERSION

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
        php${BBX_PHP_VERSION}-xml \
        rsyslog \
        supervisor \
        unzip

# get dfn ca cert chain
WORKDIR /usr/local/share/ca-certificates
RUN set -ex \
    && wget -O dfnchain-g2.crt https://pki.pca.dfn.de/dfn-ca-global-g2/pub/cacert/chain.txt \
    && update-ca-certificates

COPY resources/ /

RUN set -ex \
    && chmod 644 /etc/logrotate.d/apache2 \
    && chmod 644 /etc/logrotate.d/rsyslog

RUN set -ex \
    && a2enmod headers rewrite ssl \
    && a2enconf ssl-stapling \
    && a2dissite 000-default \
    && a2ensite sso-dev.fau.de sso-dev.fau.de-ssl \
    && rm /var/www/html/index.html

WORKDIR /

EXPOSE 80/tcp 443/tcp

CMD ["/startup.sh"]
