# Konfiguration

## Links
* [SimpleSAMLphp Documentation > Installing SimpleSAMLphp > SimpleSAMLphp configuration: config.php](https://simplesamlphp.org/docs/stable/simplesamlphp-install#section_7)

## Teilschritte
* `baseurlpath`
* `config/config.php`
* PHP Konfiguration - Versenden von E-Mails (siehe Link)
* Module (de)aktivieren (siehe Link)
* npm (siehe Link)
* Oberfläche

[//]: # (AUTOGENERATE START)
## Anpassungen
### Hinzugefügt
* [resources/etc/rsyslog.d](../blob/main/03_konfiguration/resources/etc/rsyslog.d)
* [resources/var/simplesamlphp/config/authsources.php](../blob/main/03_konfiguration/resources/var/simplesamlphp/config/authsources.php)
* [resources/var/simplesamlphp/metadata](../blob/main/03_konfiguration/resources/var/simplesamlphp/metadata)

### Änderungen
* [resources/etc/apache2/sites-available/sso-dev.fau.de-ssl.conf](../blob/main/03_konfiguration/resources/etc/apache2/sites-available/sso-dev.fau.de-ssl.conf):
```diff
@@ -39,7 +39,7 @@
 
         SetEnv SIMPLESAMLPHP_CONFIG_DIR /var/simplesamlphp/config
 
-        Alias /simplesaml /var/simplesamlphp/www
+        Alias /devssp /var/simplesamlphp/www
 
         <Directory /var/simplesamlphp/www>
             Require all granted
```
* [resources/var/simplesamlphp/config/config.php](../blob/main/03_konfiguration/resources/var/simplesamlphp/config/config.php):
```diff
@@ -27,7 +27,7 @@
      * external url, no matter where you come from (direct access or via the
      * reverse proxy).
      */
-    'baseurlpath' => 'simplesaml/',
+    'baseurlpath' => 'https://sso-dev.fau.de/devssp/',
 
     /*
      * The 'application' configuration array groups a set configuration options
@@ -73,7 +73,7 @@
      * also as the technical contact in generated metadata.
      */
     'technicalcontact_name' => 'Administrator',
-    'technicalcontact_email' => 'na@example.org',
+    'technicalcontact_email' => 'sso@fau.de',
 
     /*
      * (Optional) The method by which email is delivered.  Defaults to mail which utilizes the
@@ -114,7 +114,7 @@
      *
      * See this page for a list of valid timezones: http://php.net/manual/en/timezones.php
      */
-    'timezone' => null,
+    'timezone' => 'Europe/Berlin',
 
 
 
@@ -130,7 +130,7 @@
      * A possible way to generate a random salt is by running the following command from a unix shell:
      * LC_CTYPE=C tr -c -d '0123456789abcdefghijklmnopqrstuvwxyz' </dev/urandom | dd bs=32 count=1 2>/dev/null;echo
      */
-    'secretsalt' => 'defaultsecretsalt',
+    'secretsalt' => 'l3vjii2o5rd9le057prijyjg9ddrwur4',
 
     /*
      * This password must be kept secret, and modified from the default value 123.
@@ -138,7 +138,7 @@
      * metadata listing and diagnostics pages.
      * You can also put a hash here; run "bin/pwgen.php" to generate one.
      */
-    'auth.adminpassword' => '123',
+    'auth.adminpassword' => 'admin1234',
 
     /*
      * Set this options to true if you want to require administrator password to access the web interface
@@ -249,7 +249,7 @@
      * empty array.
      */
     'debug' => [
-        'saml' => false,
+        'saml' => true,
         'backtraces' => true,
         'validatexml' => false,
     ],
@@ -291,7 +291,7 @@
      * Options: [syslog,file,errorlog,stderr]
      *
      */
-    'logging.level' => SimpleSAML\Logger::NOTICE,
+    'logging.level' => SimpleSAML\Logger::DEBUG,
     'logging.handler' => 'syslog',
 
     /*
@@ -566,7 +566,7 @@
      * through https. If the user can access the service through
      * both http and https, this must be set to FALSE.
      */
-    'session.cookie.secure' => false,
+    'session.cookie.secure' => true,
 
     /*
      * Set the SameSite attribute in the cookie.
@@ -789,7 +789,7 @@
         'et', 'he', 'id', 'sr', 'lv', 'ro', 'eu', 'el', 'af', 'zu', 'xh', 'st',
     ],
     'language.rtl' => ['ar', 'dv', 'fa', 'ur', 'he'],
-    'language.default' => 'en',
+    'language.default' => 'de',
 
     /*
      * Options to override the default settings for the language parameter
@@ -803,7 +803,7 @@
     'language.cookie.name' => 'language',
     'language.cookie.domain' => null,
     'language.cookie.path' => '/',
-    'language.cookie.secure' => false,
+    'language.cookie.secure' => true,
     'language.cookie.httponly' => false,
     'language.cookie.lifetime' => (60 * 60 * 24 * 900),
     'language.cookie.samesite' => \SimpleSAML\Utils\HTTP::canSetSameSiteNone() ? 'None' : null,
```
* [resources/var/www/html/index.php](../blob/main/03_konfiguration/resources/var/www/html/index.php):
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
