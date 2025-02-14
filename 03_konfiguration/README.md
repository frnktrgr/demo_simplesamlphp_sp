# Konfiguration

## Links
* [SimpleSAMLphp Documentation > Installing SimpleSAMLphp > Configuration](https://simplesamlphp.org/docs/stable/simplesamlphp-install.html#configuration)
* [SimpleSAMLphp Documentation > Installing SimpleSAMLphp > Configuring Apache](https://simplesamlphp.org/docs/stable/simplesamlphp-install.html#configuring-apache)
* [SimpleSAMLphp Documentation > Installing SimpleSAMLphp > SimpleSAMLphp configuration: config.php](https://simplesamlphp.org/docs/stable/simplesamlphp-install.html#simplesamlphp-configuration-configphp)
* [SimpleSAMLphp Documentation > Installing SimpleSAMLphp > Configuring PHP](https://simplesamlphp.org/docs/stable/simplesamlphp-install.html#configuring-php)
* [SimpleSAMLphp Documentation > Installing SimpleSAMLphp > Enabling and disabling modules](https://simplesamlphp.org/docs/stable/simplesamlphp-install.html#enabling-and-disabling-modules)
* [SimpleSAMLphp Documentation > Installing SimpleSAMLphp > The SimpleSAMLphp admin interface](https://simplesamlphp.org/docs/stable/simplesamlphp-install.html#the-simplesamlphp-admin-interface)

## Teilschritte
* `baseurlpath`
* `config/config.php`
* PHP Konfiguration - Versenden von E-Mails (siehe Link)
* Module (de)aktivieren (siehe Link)
* Oberfläche

[//]: # (AUTOGENERATE START)
## Anpassungen
### Hinzugefügt
* [resources/etc/logrotate.d](../../../blob/main/03_konfiguration/resources/etc/logrotate.d)
* [resources/var/simplesamlphp/config/authsources.php](../../../blob/main/03_konfiguration/resources/var/simplesamlphp/config/authsources.php)
* [resources/var/simplesamlphp/metadata](../../../blob/main/03_konfiguration/resources/var/simplesamlphp/metadata)

### Änderungen
* [Dockerfile](../../../blob/main/03_konfiguration/Dockerfile):
```diff
@@ -86,6 +86,12 @@
     && a2ensite sso-dev.fau.de sso-dev.fau.de-ssl \
     && rm /var/www/html/index.html
 
+RUN set -ex \
+    && mkdir -p /var/cache/simplesamlphp \
+    && chown -R www-data /var/cache/simplesamlphp \
+    && mkdir -p /var/log/simplesamlphp \
+    && chown -R www-data /var/log/simplesamlphp
+
 WORKDIR /var/simplesamlphp
 
 EXPOSE 80/tcp 443/tcp
```
* [resources/etc/apache2/sites-available/sso-dev.fau.de-ssl.conf](../../../blob/main/03_konfiguration/resources/etc/apache2/sites-available/sso-dev.fau.de-ssl.conf):
```diff
@@ -38,7 +38,7 @@
 
         SetEnv SIMPLESAMLPHP_CONFIG_DIR /var/simplesamlphp/config
 
-        Alias /simplesaml /var/simplesamlphp/public
+        Alias /devssp /var/simplesamlphp/public
         <Directory /var/simplesamlphp/public>
             Require all granted
         </Directory>
```
* [resources/var/simplesamlphp/config/config.php](../../../blob/main/03_konfiguration/resources/var/simplesamlphp/config/config.php):
```diff
@@ -31,7 +31,7 @@
      * external url, no matter where you come from (direct access or via the
      * reverse proxy).
      */
-    'baseurlpath' => 'simplesaml/',
+    'baseurlpath' => 'https://sso-dev.fau.de/devssp/',
 
     /*
      * The 'application' configuration array groups a set configuration options
@@ -58,7 +58,7 @@
     /*
      * The following settings are *filesystem paths* which define where
      * SimpleSAMLphp can find or write the following things:
-     * - 'cachedir': Where SimpleSAMLphp can write its cache. 
+     * - 'cachedir': Where SimpleSAMLphp can write its cache.
      * - 'loggingdir': Where to write logs. MUST be set to NULL when using a logging
      *                 handler other than `file`.
      * - 'datadir': Storage of general data.
@@ -68,7 +68,7 @@
      * root directory.
      */
     'cachedir' => '/var/cache/simplesamlphp',
-    //'loggingdir' => '/var/log/',
+    'loggingdir' => '/var/log/simplesamlphp/',
     //'datadir' => '/var/data/',
     //'tempdir' => '/tmp/simplesamlphp',
 
@@ -128,7 +128,7 @@
      * also as the technical contact in generated metadata.
      */
     'technicalcontact_name' => 'Administrator',
-    'technicalcontact_email' => 'na@example.org',
+    'technicalcontact_email' => 'sso@fau.de',
 
     /*
      * (Optional) The method by which email is delivered.  Defaults to mail which utilizes the
@@ -173,7 +173,7 @@
      *
      * See this page for a list of valid timezones: http://php.net/manual/en/timezones.php
      */
-    'timezone' => null,
+    'timezone' => 'Europe/Berlin',
 
 
 
@@ -189,7 +189,7 @@
      * A possible way to generate a random salt is by running the following command from a unix shell:
      * LC_ALL=C tr -c -d '0123456789abcdefghijklmnopqrstuvwxyz' </dev/urandom | dd bs=32 count=1 2>/dev/null;echo
      */
-    'secretsalt' => 'defaultsecretsalt',
+    'secretsalt' => 'l3vjii2o5rd9le057prijyjg9ddrwur4',
 
     /*
      * This password must be kept secret, and modified from the default value 123.
@@ -201,7 +201,7 @@
      * ansible.builtin.password_hash(hashtype='blowfish', ident='2y', rounds=13)
      * to generate this hashed value.
      */
-    'auth.adminpassword' => '123',
+    'auth.adminpassword' => '$argon2id$v=19$m=64,t=4,p=1$NkF5QTREL1F0SVc4N053aw$mqz6SogI5i4O/4pBHBKXrV70RaKOKnvRcGfwfXlxF14',
 
     /*
      * Set this option to true if you want to require administrator password to access the metadata.
@@ -325,7 +325,7 @@
      * empty array.
      */
     'debug' => [
-        'saml' => false,
+        'saml' => true,
         'backtraces' => true,
         'validatexml' => false,
     ],
@@ -369,8 +369,8 @@
      * must exist and be writable for SimpleSAMLphp. If set to something else, set
      * loggingdir above to 'null'.
      */
-    'logging.level' => SimpleSAML\Logger::NOTICE,
-    'logging.handler' => 'syslog',
+    'logging.level' => SimpleSAML\Logger::DEBUG,
+    'logging.handler' => 'file',
 
     /*
      * Specify the format of the logs. Its use varies depending on the log handler used (for instance, you cannot
@@ -829,7 +829,7 @@
         'ru', 'et', 'he', 'id', 'sr', 'lv', 'ro', 'eu', 'el', 'af', 'zu', 'xh', 'st'
     ],
     'language.rtl' => ['ar', 'dv', 'fa', 'ur', 'he'],
-    'language.default' => 'en',
+    'language.default' => 'de',
 
     /*
      * Options to override the default settings for the language parameter
```
* [resources/var/www/html/index.php](../../../blob/main/03_konfiguration/resources/var/www/html/index.php):
```diff
@@ -37,7 +37,7 @@
                 <ul class="navbar-nav">
                     <li class="nav-item"><a href="/" class="nav-link active">Home</a></li>
                     <li class="nav-item"><a href="/phpinfo.php" class="nav-link">PHP Info</a></li>
-                    <li class="nav-item"><a href="/simplesaml" class="nav-link">SimpleSAMLphp</a></li>
+                    <li class="nav-item"><a href="/devssp" class="nav-link">SimpleSAMLphp</a></li>
                     <li class="nav-item"><a href="?logout=true" class="nav-link"><i class="bi bi-box-arrow-right"></i>Abmelden</a></li>
                     <li class="nav-item"><a href="?destroy=true" class="nav-link"><i class="bi bi-box-arrow-right"></i>Destroy</a></li>
                 </ul>
```

[//]: # (AUTOGENERATE END)
