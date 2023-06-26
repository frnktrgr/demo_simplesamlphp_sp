# Extras

## Links
* [SimpleSAMLphp Documentation](https://simplesamlphp.org/docs/stable/)
* [SimpleSAMLphp Documentation > Key rollover](https://simplesamlphp.org/docs/stable/saml:keyrollover)
* [SimpleSAMLphp Documentation > Maintenance and configuration](https://simplesamlphp.org/docs/stable/simplesamlphp-maintenance)
* [Composer](https://getcomposer.org/)
* [Roadmap](https://simplesamlphp.org/releaseplan)

## Teilschritte
* Konfigurationsdateien sind PHP-Skripte
* Key Rollover
* Maintenance
  * Session Management
  * Metadata Storage
* Modules
* Bridging
* Composer
* Theming, Übersetzung, ...
* ...

[//]: # (AUTOGENERATE START)
## Anpassungen
### Änderungen
* [Dockerfile](../../../blob/main/09_extras/Dockerfile):
```diff
@@ -64,6 +64,7 @@
         php${BBX_PHP_VERSION}-curl \
         php${BBX_PHP_VERSION}-intl \
         php${BBX_PHP_VERSION}-sqlite3 \
+        php${BBX_PHP_VERSION}-xdebug \
         php${BBX_PHP_VERSION}-xml \
         rsyslog \
         supervisor \
```
* [resources/startup.sh](../../../blob/main/09_extras/resources/startup.sh):
```diff
@@ -25,6 +25,12 @@
 echogood "Setting PHP max execution time to ${PHPMAXEXECUTIONTIME}"
 sed "s/^max_execution_time = .*$/max_execution_time = $PHPMAXEXECUTIONTIME/" -i /etc/php/${BBX_PHP_VERSION}/apache2/php.ini
 
+echogood "Enable xdebug ..."
+#Set up debugger
+echo "xdebug.mode=debug" >> /etc/php/${BBX_PHP_VERSION}/apache2/php.ini
+#Please provide your host (local machine IP) instead of 169.254.254.1
+echo "xdebug.client_host=169.254.254.1" >> /etc/php/${BBX_PHP_VERSION}/apache2/php.ini
+
 echogood "Starting Supervisor"
 exec /usr/bin/supervisord > /dev/null 2>&1 &
 child=$!
```

[//]: # (AUTOGENERATE END)
