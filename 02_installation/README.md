# Installation

## Links
* [SimpleSAMLphp Documentation > Installing SimpleSAMLphp > Download and install SimpleSAMLphp](https://simplesamlphp.org/docs/stable/simplesamlphp-install.html#download-and-install-simplesamlphp)
* [SimpleSAMLphp Documentation > Installing SimpleSAMLphp > Configuration](https://simplesamlphp.org/docs/stable/simplesamlphp-install.html#configuration)
* [SimpleSAMLphp Documentation > Installing SimpleSAMLphp > Configuring Apache](https://simplesamlphp.org/docs/stable/simplesamlphp-install.html#configuring-apache)

## Teilschritte
* Installation
* Konfiguration Apache
* Upgrade (siehe Link)
* Oberfläche

[//]: # (AUTOGENERATE START)
## Anpassungen
### Hinzugefügt
* [resources/var/simplesamlphp](../../../blob/main/02_installation/resources/var/simplesamlphp)

### Änderungen
* [compose.yaml](../../../blob/main/02_installation/compose.yaml):
```diff
@@ -6,9 +6,11 @@
       - "443:443"
     volumes:
       - var_log:/var/log
+      - var_simplesamlphp:/var/simplesamlphp
       - /opt/simplesamlphp_sp/sso-dev.fau.de.chained.crt:/etc/ssl/certs/sso-dev.fau.de.chained.crt
       - /opt/simplesamlphp_sp/sso-dev.fau.de.pem:/etc/ssl/private/sso-dev.fau.de.pem
       - ./resources/var/www/html:/var/www/html
     network_mode: bridge
 volumes:
   var_log:
+  var_simplesamlphp:
```
* [Dockerfile](../../../blob/main/02_installation/Dockerfile):
```diff
@@ -1,12 +1,20 @@
 ARG BBX_APACHE_VERSION=2.4.62*
 ARG BBX_PHP_VERSION=8.4
 
+ARG BBX_SSP_VERSION=2.3.5
+ARG BBX_SSP_FLAVOR=-full
+ARG BBX_SSP_CHECKSUM=97bc3b8220eb628fd5493e14187d756247462849ebf323ccf094b0cd2b505665
+
 FROM ubuntu:24.04 AS build
 MAINTAINER Frank Tröger <frank.troeger@fau.de>
 
 ARG BBX_APACHE_VERSION
 ARG BBX_PHP_VERSION
 
+ARG BBX_SSP_VERSION
+ARG BBX_SSP_FLAVOR
+ARG BBX_SSP_CHECKSUM
+
 # env vars
 ENV TERM xterm
 ENV BBX_PHP_VERSION=$BBX_PHP_VERSION
@@ -56,6 +64,19 @@
         supervisor \
         unzip
 
+# install SimpleSAMLphp
+WORKDIR /var
+RUN set -ex \
+    && wget https://github.com/simplesamlphp/simplesamlphp/releases/download/v${BBX_SSP_VERSION}/simplesamlphp-${BBX_SSP_VERSION}${BBX_SSP_FLAVOR}.tar.gz \
+    && echo "${BBX_SSP_CHECKSUM}  simplesamlphp-${BBX_SSP_VERSION}${BBX_SSP_FLAVOR}.tar.gz" | sha256sum -c \
+    && tar xzf simplesamlphp-${BBX_SSP_VERSION}${BBX_SSP_FLAVOR}.tar.gz \
+    && mv simplesamlphp-${BBX_SSP_VERSION} simplesamlphp \
+    && rm simplesamlphp-${BBX_SSP_VERSION}${BBX_SSP_FLAVOR}.tar.gz
+
+WORKDIR /var/simplesamlphp
+RUN set -ex \
+    && cp config/config.php.dist config/config.php
+
 COPY resources/ /
 
 RUN set -ex \
@@ -65,7 +86,7 @@
     && a2ensite sso-dev.fau.de sso-dev.fau.de-ssl \
     && rm /var/www/html/index.html
 
-WORKDIR /
+WORKDIR /var/simplesamlphp
 
 EXPOSE 80/tcp 443/tcp
 
```
* [resources/etc/apache2/sites-available/sso-dev.fau.de-ssl.conf](../../../blob/main/02_installation/resources/etc/apache2/sites-available/sso-dev.fau.de-ssl.conf):
```diff
@@ -35,6 +35,13 @@
 
         RewriteCond %{HTTP_HOST} !^sso-dev\.fau\.de [NC]
         RewriteRule ^/(.*) https://sso-dev.fau.de/$1  [R,L]
+
+        SetEnv SIMPLESAMLPHP_CONFIG_DIR /var/simplesamlphp/config
+
+        Alias /simplesaml /var/simplesamlphp/public
+        <Directory /var/simplesamlphp/public>
+            Require all granted
+        </Directory>
     </VirtualHost>
 </IfModule>
 
```
* [resources/var/www/html/index.php](../../../blob/main/02_installation/resources/var/www/html/index.php):
```diff
@@ -37,6 +37,7 @@
                 <ul class="navbar-nav">
                     <li class="nav-item"><a href="/" class="nav-link active">Home</a></li>
                     <li class="nav-item"><a href="/phpinfo.php" class="nav-link">PHP Info</a></li>
+                    <li class="nav-item"><a href="/simplesaml" class="nav-link">SimpleSAMLphp</a></li>
                     <li class="nav-item"><a href="?logout=true" class="nav-link"><i class="bi bi-box-arrow-right"></i>Abmelden</a></li>
                     <li class="nav-item"><a href="?destroy=true" class="nav-link"><i class="bi bi-box-arrow-right"></i>Destroy</a></li>
                 </ul>
```

[//]: # (AUTOGENERATE END)
