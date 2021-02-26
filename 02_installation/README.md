# Installation

## Links
* [SimpleSAMLphp Documentation > Installing SimpleSAMLphp > Download and install SimpleSAMLphp](https://simplesamlphp.org/docs/stable/simplesamlphp-install#section_2)

## Teilschritte
* Installation
* Konfiguration Apache
* Upgrade (siehe Link)
* Oberfläche

[//]: # (AUTOGENERATE START)
## Anpassungen
### Hinzugefügt
* [resources/var/simplesamlphp](../blob/main/02_installation/resources/var/simplesamlphp)

### Änderungen
* [docker-compose.yml](../blob/main/02_installation/docker-compose.yml):
```diff
@@ -7,9 +7,11 @@
       - "443:443"
     volumes:
       - var_log:/var/log
+      - var_simplesamlphp:/var/simplesamlphp
       - /opt/simplesamlphp_sp/sso-dev.fau.de.crt:/etc/ssl/certs/sso-dev.fau.de.crt
       - /opt/simplesamlphp_sp/sso-dev.fau.de.pem:/etc/ssl/private/sso-dev.fau.de.pem
       - ./resources/var/www/html:/var/www/html
     network_mode: bridge
 volumes:
   var_log:
+  var_simplesamlphp:
```
* [Dockerfile](../blob/main/02_installation/Dockerfile):
```diff
@@ -1,11 +1,15 @@
 ARG BBX_APACHE_VERSION=2.4.41*
 ARG BBX_PHP_VERSION=7.4
+ARG BBX_SSP_VERSION=1.19.0
+ARG BBX_SSP_CHECKSUM=2111129787a4baf27a51e52bda660c56d069f167354800bffc72440dcacb3a6f
 
 FROM ubuntu:20.04 AS build
 MAINTAINER Frank Tröger <frank.troeger@fau.de>
 
 ARG BBX_APACHE_VERSION
 ARG BBX_PHP_VERSION
+ARG BBX_SSP_VERSION
+ARG BBX_SSP_CHECKSUM
 
 ENV TERM xterm
 ENV BBX_PHP_VERSION=$BBX_PHP_VERSION
@@ -56,6 +60,15 @@
     && wget -O dfnchain-g2.crt https://pki.pca.dfn.de/dfn-ca-global-g2/pub/cacert/chain.txt \
     && update-ca-certificates
 
+# install SimpleSAMLphp
+WORKDIR /var
+RUN set -ex \
+    && wget https://github.com/simplesamlphp/simplesamlphp/releases/download/v${BBX_SSP_VERSION}/simplesamlphp-${BBX_SSP_VERSION}.tar.gz \
+    && echo "${BBX_SSP_CHECKSUM}  simplesamlphp-${BBX_SSP_VERSION}.tar.gz" | sha256sum -c \
+    && tar xzf simplesamlphp-${BBX_SSP_VERSION}.tar.gz \
+    && mv simplesamlphp-${BBX_SSP_VERSION} simplesamlphp \
+    && rm simplesamlphp-${BBX_SSP_VERSION}.tar.gz
+
 COPY resources/ /
 
 RUN set -ex \
@@ -69,7 +82,7 @@
     && a2ensite sso-dev.fau.de sso-dev.fau.de-ssl \
     && rm /var/www/html/index.html
 
-WORKDIR /
+WORKDIR /var/simplesamlphp
 
 EXPOSE 80/tcp 443/tcp
 
```
* [resources/etc/apache2/sites-available/sso-dev.fau.de-ssl.conf](../blob/main/02_installation/resources/etc/apache2/sites-available/sso-dev.fau.de-ssl.conf):
```diff
@@ -36,6 +36,14 @@
 
         RewriteCond %{HTTP_HOST} !^sso-dev\.fau\.de [NC]
         RewriteRule ^/(.*) https://sso-dev.fau.de/$1  [R,L]
+
+        SetEnv SIMPLESAMLPHP_CONFIG_DIR /var/simplesamlphp/config
+
+        Alias /simplesaml /var/simplesamlphp/www
+
+        <Directory /var/simplesamlphp/www>
+            Require all granted
+        </Directory>
     </VirtualHost>
 </IfModule>
 
```
* [resources/var/www/html/index.php](../blob/main/02_installation/resources/var/www/html/index.php):
```diff
@@ -36,7 +36,8 @@
             <div class="collapse navbar-collapse" id="navbarNav">
                 <ul class="navbar-nav">
                     <li class="nav-item"><a href="/" class="nav-link active">Home</a></li>
-                    <li class="nav-item"><a href="phpinfo.php" class="nav-link">PHP Info</a></li>
+                    <li class="nav-item"><a href="/phpinfo.php" class="nav-link">PHP Info</a></li>
+                    <li class="nav-item"><a href="/simplesaml" class="nav-link">SimpleSAMLphp</a></li>
                     <li class="nav-item"><a href="?logout=true" class="nav-link"><i class="bi bi-box-arrow-right"></i>Abmelden</a></li>
                     <li class="nav-item"><a href="?destroy=true" class="nav-link"><i class="bi bi-box-arrow-right"></i>Destroy</a></li>
                 </ul>
```

[//]: # (AUTOGENERATE END)
