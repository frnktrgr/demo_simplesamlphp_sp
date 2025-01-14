# Metadaten aus der DFN-AAI-Föderation

## Links
* [SimpleSAMLphp Documentation > Automated Metadata Management](https://simplesamlphp.org/docs/contrib_modules/metarefresh/simplesamlphp-automated_metadata.html)
* [Cron](https://simplesamlphp.org/docs/stable/cron:cron)

## Teilschritte
* Module:
    * cron
    * metarefresh

[//]: # (AUTOGENERATE START)
## Anpassungen
### Hinzugefügt
* [resources/etc/cron.d](../../../blob/main/06_metarefresh/resources/etc/cron.d)
* [resources/var/simplesamlphp/config/module_cron.php](../../../blob/main/06_metarefresh/resources/var/simplesamlphp/config/module_cron.php)
* [resources/var/simplesamlphp/config/module_metarefresh.php](../../../blob/main/06_metarefresh/resources/var/simplesamlphp/config/module_metarefresh.php)

### Änderungen
* [compose.yaml](../../../blob/main/06_metarefresh/compose.yaml):
```diff
@@ -11,6 +11,7 @@
       - /opt/simplesamlphp_sp/sso-dev.fau.de.pem:/etc/ssl/private/sso-dev.fau.de.pem
       - /opt/simplesamlphp_sp/sso-dev.fau.de.crt:/var/simplesamlphp/cert/sso-dev.fau.de.crt
       - /opt/simplesamlphp_sp/sso-dev.fau.de.pem:/var/simplesamlphp/cert/sso-dev.fau.de.pem
+      - /opt/simplesamlphp_sp/dfn-aai.pem:/var/simplesamlphp/cert/dfn-aai.pem
       - ./resources/var/www/html:/var/www/html
     network_mode: bridge
 volumes:
```
* [Dockerfile](../../../blob/main/06_metarefresh/Dockerfile):
```diff
@@ -5,6 +5,9 @@
 ARG BBX_SSP_FLAVOR=-full
 ARG BBX_SSP_CHECKSUM=97bc3b8220eb628fd5493e14187d756247462849ebf323ccf094b0cd2b505665
 
+ARG BBX_COMPOSER_VERSION=2.8.3
+ARG BBX_COMPOSER_CHECKSUM=8323b4105c6e166d47c9db93209370083f9e421743636e108c37d8c1126386ef
+
 FROM ubuntu:24.04 AS build
 MAINTAINER Frank Tröger <frank.troeger@fau.de>
 
@@ -15,6 +18,9 @@
 ARG BBX_SSP_FLAVOR
 ARG BBX_SSP_CHECKSUM
 
+ARG BBX_COMPOSER_VERSION
+ARG BBX_COMPOSER_CHECKSUM
+
 # env vars
 ENV TERM xterm
 ENV BBX_PHP_VERSION=$BBX_PHP_VERSION
@@ -59,11 +65,21 @@
         patch \
         php${BBX_PHP_VERSION} \
         php${BBX_PHP_VERSION}-curl \
+        php${BBX_PHP_VERSION}-intl \
+        php${BBX_PHP_VERSION}-sqlite3 \
         php${BBX_PHP_VERSION}-xml \
         rsyslog \
         supervisor \
         unzip
 
+# install composer
+WORKDIR /usr/local/bin
+RUN set -ex \
+    && wget https://getcomposer.org/download/${BBX_COMPOSER_VERSION}/composer.phar \
+    && echo "${BBX_COMPOSER_CHECKSUM}  composer.phar" | sha256sum -c \
+    && mv /usr/local/bin/composer.phar /usr/local/bin/composer \
+    && chmod a+x /usr/local/bin/composer
+
 # install SimpleSAMLphp
 WORKDIR /var
 RUN set -ex \
@@ -73,10 +89,16 @@
     && mv simplesamlphp-${BBX_SSP_VERSION} simplesamlphp \
     && rm simplesamlphp-${BBX_SSP_VERSION}${BBX_SSP_FLAVOR}.tar.gz
 
+#WORKDIR /var/simplesamlphp
+#RUN set -ex \
+#    && COMPOSER_ALLOW_SUPERUSER=1 composer require -n --ignore-platform-reqs --update-no-dev simplesamlphp/simplesamlphp-module-metarefresh
+
 WORKDIR /var/simplesamlphp
 RUN set -ex \
     && cp config/config.php.dist config/config.php \
-    && cp config/authsources.php.dist config/authsources.php
+    && cp config/authsources.php.dist config/authsources.php \
+    && cp modules/cron/config/module_cron.php.dist config/module_cron.php \
+    && cp modules/metarefresh/config-templates/module_metarefresh.php config/module_metarefresh.php
 
 COPY resources/ /
 
@@ -91,7 +113,8 @@
     && mkdir -p /var/cache/simplesamlphp \
     && chown -R www-data /var/cache/simplesamlphp \
     && mkdir -p /var/log/simplesamlphp \
-    && chown -R www-data /var/log/simplesamlphp
+    && chown -R www-data /var/log/simplesamlphp \
+    && chown www-data /var/simplesamlphp/metadata
 
 WORKDIR /var/simplesamlphp
 
```
* [resources/startup.sh](../../../blob/main/06_metarefresh/resources/startup.sh):
```diff
@@ -16,6 +16,15 @@
 
 trap _term 15
 
+PHPMEMORYLIMIT="256M"
+PHPMAXEXECUTIONTIME="30"
+
+echogood "Setting PHP memory limit to ${PHPMEMORYLIMIT}"
+sed "s/^memory_limit = .*$/memory_limit = $PHPMEMORYLIMIT/" -i /etc/php/${BBX_PHP_VERSION}/apache2/php.ini
+
+echogood "Setting PHP max execution time to ${PHPMAXEXECUTIONTIME}"
+sed "s/^max_execution_time = .*$/max_execution_time = $PHPMAXEXECUTIONTIME/" -i /etc/php/${BBX_PHP_VERSION}/apache2/php.ini
+
 echogood "Starting Supervisor"
 exec /usr/bin/supervisord > /dev/null 2>&1 &
 child=$!
```
* [resources/var/simplesamlphp/config/authsources.php](../../../blob/main/06_metarefresh/resources/var/simplesamlphp/config/authsources.php):
```diff
@@ -44,7 +44,7 @@
 
         // The URL to the discovery service.
         // Can be NULL/unset, in which case a builtin discovery service will be used.
-        'discoURL' => null,
+        'discoURL' => 'https://wayf.aai.dfn.de/DFN-AAI-Test/wayf',
 
         /*
          * If SP behind the SimpleSAMLphp in IdP/SP proxy mode requests
```
* [resources/var/simplesamlphp/config/config.php](../../../blob/main/06_metarefresh/resources/var/simplesamlphp/config/config.php):
```diff
@@ -564,7 +564,9 @@
         'exampleauth' => false,
         'core' => true,
         'admin' => true,
-        'saml' => true
+        'saml' => true,
+        'cron' => true,
+        'metarefresh' => true,
     ],
 
 
@@ -1157,6 +1159,8 @@
      */
     'metadata.sources' => [
         ['type' => 'flatfile'],
+        ['type' => 'flatfile', 'directory' => 'metadata/dfntest'],
+        ['type' => 'flatfile', 'directory' => 'metadata/dfn'],
     ],
 
     /*
```
* [resources/var/simplesamlphp/metadata/saml20-idp-remote.php](../../../blob/main/06_metarefresh/resources/var/simplesamlphp/metadata/saml20-idp-remote.php):
```diff
@@ -8,309 +8,309 @@
  * See: https://simplesamlphp.org/docs/stable/simplesamlphp-reference-idp-remote
  */
 
-$metadata['https://testidp2.aai.dfn.de/idp/shibboleth'] = [
-    'entityid' => 'https://testidp2.aai.dfn.de/idp/shibboleth',
-    'description' => [
-        'de' => 'e15',
-        'en' => 'e15',
-    ],
-    'OrganizationName' => [
-        'de' => 'e15',
-        'en' => 'e15',
-    ],
-    'name' => [
-        'de' => 'DFN: Offizieller öffentlicher Test-IdP',
-        'en' => 'DFN: Official public test IdP',
-    ],
-    'OrganizationDisplayName' => [
-        'de' => 'DFN-Verein - Deutsches Forschungsnetz',
-        'en' => 'German National Research and Education Network, DFN',
-    ],
-    'url' => [
-        'de' => 'http://www.dfn.de',
-        'en' => 'http://www.dfn.de/en/',
-    ],
-    'OrganizationURL' => [
-        'de' => 'http://www.dfn.de',
-        'en' => 'http://www.dfn.de/en/',
-    ],
-    'contacts' => [
-        [
-            'contactType' => 'administrative',
-            'givenName' => 'DFN-AAI',
-            'surName' => 'Hotline',
-            'emailAddress' => [
-                'hotline@aai.dfn.de',
-            ],
-        ],
-        [
-            'contactType' => 'other',
-            'givenName' => 'DFN-AAI Team',
-            'emailAddress' => [
-                'hotline@aai.dfn.de',
-            ],
-        ],
-        [
-            'contactType' => 'support',
-            'givenName' => 'DFN AAI',
-            'surName' => 'Hotline',
-            'emailAddress' => [
-                'hotline@aai.dfn.de',
-            ],
-        ],
-        [
-            'contactType' => 'technical',
-            'givenName' => 'DFN-AAI',
-            'surName' => 'Hotline',
-            'emailAddress' => [
-                'hotline@aai.dfn.de',
-            ],
-        ],
-    ],
-    'metadata-set' => 'saml20-idp-remote',
-    'SingleSignOnService' => [
-        [
-            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
-            'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/POST/SSO',
-        ],
-        [
-            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST-SimpleSign',
-            'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/POST-SimpleSign/SSO',
-        ],
-        [
-            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
-            'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/Redirect/SSO',
-        ],
-        [
-            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
-            'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/SOAP/ECP',
-        ],
-    ],
-    'SingleLogoutService' => [
-        [
-            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
-            'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/POST/SLO',
-        ],
-        [
-            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST-SimpleSign',
-            'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/POST-SimpleSign/SLO',
-        ],
-        [
-            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
-            'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/Redirect/SLO',
-        ],
-        [
-            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
-            'Location' => 'https://testidp2.aai.dfn.de:8443/idp/profile/SAML2/SOAP/SLO',
-        ],
-    ],
-    'ArtifactResolutionService' => [
-        [
-            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
-            'Location' => 'https://testidp2.aai.dfn.de:8443/idp/profile/SAML2/SOAP/ArtifactResolution',
-            'index' => 2,
-        ],
-    ],
-    'NameIDFormats' => [
-        'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent',
-        'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
-    ],
-    'keys' => [
-        [
-            'encryption' => true,
-            'signing' => true,
-            'type' => 'X509Certificate',
-            'X509Certificate' => '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',
-        ],
-    ],
-    'scope' => [
-        'test.dfn.de',
-        'testscope.aai.dfn.de',
-    ],
-    'RegistrationInfo' => [
-        'authority' => 'https://www.aai.dfn.de',
-        'instant' => 1243326902,
-        'policies' => [
-            'de' => 'https://www.aai.dfn.de/teilnahme/',
-            'en' => 'https://www.aai.dfn.de/en/join/',
-        ],
-    ],
-    'UIInfo' => [
-        'DisplayName' => [
-            'de' => 'DFN: Offizieller öffentlicher Test-IdP',
-            'en' => 'DFN: Official public test IdP',
-        ],
-        'Description' => [
-            'de' => 'IdP der DFN-AAI-Testumgebung (SAML2 Web-SSO)',
-            'en' => 'IdP of the DFN-AAI test environment (SAML2 Web-SSO)',
-        ],
-        'InformationURL' => [
-            'de' => 'https://www.dfn.de',
-            'en' => 'https://www.dfn.de',
-        ],
-        'PrivacyStatementURL' => [
-            'de' => 'https://www.aai.dfn.de/fileadmin/documents/datenschutz/test-idp.html',
-        ],
-        'Logo' => [
-            [
-                'url' => 'https://testidp2.aai.dfn.de/idp/images/logo.png',
-                'height' => 131,
-                'width' => 236,
-            ],
-            [
-                'url' => 'https://testidp2.aai.dfn.de/idp/images/favicon.ico',
-                'height' => 16,
-                'width' => 16,
-            ],
-        ],
-    ],
-];
-
-$metadata['https://www.sso.uni-erlangen.de/simplesaml/saml2/idp/metadata.php'] = [
-    'entityid' => 'https://www.sso.uni-erlangen.de/simplesaml/saml2/idp/metadata.php',
-    'contacts' => [
-        [
-            'contactType' => 'other',
-            'givenName' => 'Security Response',
-            'surName' => 'Team',
-            'emailAddress' => [
-                'abuse@fau.de',
-            ],
-        ],
-        [
-            'contactType' => 'support',
-            'givenName' => 'WebSSO-Support',
-            'surName' => 'Team',
-            'emailAddress' => [
-                'sso@fau.de',
-            ],
-        ],
-        [
-            'contactType' => 'administrative',
-            'givenName' => 'WebSSO-Admins',
-            'surName' => 'Team',
-            'emailAddress' => [
-                'sso-admins@fau.de',
-            ],
-        ],
-        [
-            'contactType' => 'technical',
-            'givenName' => 'WebSSO-Admins',
-            'surName' => 'Team',
-            'emailAddress' => [
-                'sso-admins@fau.de',
-            ],
-        ],
-        [
-            'contactType' => 'technical',
-            'givenName' => 'WebSSO-Admins RRZE FAU',
-            'emailAddress' => [
-                'sso-support@fau.de',
-            ],
-        ],
-    ],
-    'metadata-set' => 'saml20-idp-remote',
-    'SingleSignOnService' => [
-        [
-            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
-            'Location' => 'https://www.sso.uni-erlangen.de/simplesaml/module.php/saml/idp/singleSignOnService',
-        ],
-        [
-            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
-            'Location' => 'https://www.sso.uni-erlangen.de/simplesaml/module.php/saml/idp/singleSignOnService',
-        ],
-        [
-            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
-            'Location' => 'https://www.sso.uni-erlangen.de/simplesaml/module.php/saml/idp/singleSignOnService',
-        ],
-    ],
-    'SingleLogoutService' => [
-        [
-            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
-            'Location' => 'https://www.sso.uni-erlangen.de/simplesaml/module.php/saml/idp/singleLogout',
-        ],
-    ],
-    'ArtifactResolutionService' => [],
-    'NameIDFormats' => [
-        'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
-        'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent',
-    ],
-    'keys' => [
-        [
-            'encryption' => false,
-            'signing' => true,
-            'type' => 'X509Certificate',
-            'X509Certificate' => 'MIIEFzCCAn+gAwIBAgIUZu6JGUynt+HmkDyTBVufV8brvfIwDQYJKoZIhvcNAQELBQAwIjEgMB4GA1UEAxMXd3d3LnNzby51bmktZXJsYW5nZW4uZGUwHhcNMjIxMDI1MTI0NDIzWhcNMjUxMTE5MTI0NDIzWjAiMSAwHgYDVQQDExd3d3cuc3NvLnVuaS1lcmxhbmdlbi5kZTCCAaIwDQYJKoZIhvcNAQEBBQADggGPADCCAYoCggGBAKV+3afbJg5B5r94ZuQMPRfFJdmixpAPiRqqif0hoXC4GAAd09txIWp2sMLWOEseiBYfSndBOz5OUHfyxvQ3IKubucP26leZxvyEDBymlaMw6ad2pi5JdCycJegGgkH2rThiNRK9rYLjyO5oUuCNumMBwqN1rCxaTsf6vC97cv5sEAoH551jNSPDYVvbn1/uUNw15GQuvvU43N3N3efiLnbRjUE8Ih/qDYp6v63/nxExINt7xgErgvD82k0gHrBJv7BIOMe7WmTQ2yQYC8FnzvCwHdHnZ8i1vRzPDYFTktxxn6Vsu1YMeNdd2K4Q+LLb/ljdoSxrNMKiwz9ls1Mj059hxlo3Q1g6JAYSZc9Lzqo26iTYLlq/LfF259OENIZX6FeQqDExK8BPLX6OXlneeksTxl9Bohsga3QPtRMRlGF415hmtpunW9LSiF1VewcKwpvjoEcDK+wutI/N7RNRhLNauUPQz16v1gZJDim4/zLB3Nfh19kLfJnlcRVnIkpKQQIDAQABo0UwQzAiBgNVHREEGzAZghd3d3cuc3NvLnVuaS1lcmxhbmdlbi5kZTAdBgNVHQ4EFgQUPB7olQAUEMwG9ImXfbDXtdLNPeUwDQYJKoZIhvcNAQELBQADggGBAEiIFXch6BzXOeU4S5/YgTQ/dHYpwHAc93YYP6WmlzEambSx+HGu4c6eav9zSrRhIVxwHkPE1nGJzBvtcM0FMML9/5U7keOtAcD7jkcHfnrC5cz9bWEbVpu4pSGVK1OWvC24gqwLn7++W3lx7prwpN7fO1uCSsudT3oOhSjy3oEJvtnBS26pqf/FFBUl6slZ4M3uVGUuf4q0PVXRIjK04oM8AwSO2Bb3tYU4u1lTBJkXJ+nFZGd8BcyYpFkQVY9/8iElY2qDWS6q1hNJ4c/phS7heJlk98MqtBeFw/Jo4juukdfIAtGmRpLg2xN3FzO2eoIzFgwQKrMrwMrTlovL71MEYkX/2NJ+TUCMcwseeAQaa8IgCXWfP7eD/RnS3DNj6su3Zes7W9HIpUJP33Ds3I+h0+QU9OYTnsjhxfOZOUm8BxNLvtBwVxKUmtJkh3zX/8F/exHXRaB2h0jx7iQ8bjpsGGnTE0izn0b/R3YuhH6yzt5nW8FaoHVQC/A7NVOfhg==',
-        ],
-        [
-            'encryption' => true,
-            'signing' => false,
-            'type' => 'X509Certificate',
-            'X509Certificate' => 'MIIEFzCCAn+gAwIBAgIUZu6JGUynt+HmkDyTBVufV8brvfIwDQYJKoZIhvcNAQELBQAwIjEgMB4GA1UEAxMXd3d3LnNzby51bmktZXJsYW5nZW4uZGUwHhcNMjIxMDI1MTI0NDIzWhcNMjUxMTE5MTI0NDIzWjAiMSAwHgYDVQQDExd3d3cuc3NvLnVuaS1lcmxhbmdlbi5kZTCCAaIwDQYJKoZIhvcNAQEBBQADggGPADCCAYoCggGBAKV+3afbJg5B5r94ZuQMPRfFJdmixpAPiRqqif0hoXC4GAAd09txIWp2sMLWOEseiBYfSndBOz5OUHfyxvQ3IKubucP26leZxvyEDBymlaMw6ad2pi5JdCycJegGgkH2rThiNRK9rYLjyO5oUuCNumMBwqN1rCxaTsf6vC97cv5sEAoH551jNSPDYVvbn1/uUNw15GQuvvU43N3N3efiLnbRjUE8Ih/qDYp6v63/nxExINt7xgErgvD82k0gHrBJv7BIOMe7WmTQ2yQYC8FnzvCwHdHnZ8i1vRzPDYFTktxxn6Vsu1YMeNdd2K4Q+LLb/ljdoSxrNMKiwz9ls1Mj059hxlo3Q1g6JAYSZc9Lzqo26iTYLlq/LfF259OENIZX6FeQqDExK8BPLX6OXlneeksTxl9Bohsga3QPtRMRlGF415hmtpunW9LSiF1VewcKwpvjoEcDK+wutI/N7RNRhLNauUPQz16v1gZJDim4/zLB3Nfh19kLfJnlcRVnIkpKQQIDAQABo0UwQzAiBgNVHREEGzAZghd3d3cuc3NvLnVuaS1lcmxhbmdlbi5kZTAdBgNVHQ4EFgQUPB7olQAUEMwG9ImXfbDXtdLNPeUwDQYJKoZIhvcNAQELBQADggGBAEiIFXch6BzXOeU4S5/YgTQ/dHYpwHAc93YYP6WmlzEambSx+HGu4c6eav9zSrRhIVxwHkPE1nGJzBvtcM0FMML9/5U7keOtAcD7jkcHfnrC5cz9bWEbVpu4pSGVK1OWvC24gqwLn7++W3lx7prwpN7fO1uCSsudT3oOhSjy3oEJvtnBS26pqf/FFBUl6slZ4M3uVGUuf4q0PVXRIjK04oM8AwSO2Bb3tYU4u1lTBJkXJ+nFZGd8BcyYpFkQVY9/8iElY2qDWS6q1hNJ4c/phS7heJlk98MqtBeFw/Jo4juukdfIAtGmRpLg2xN3FzO2eoIzFgwQKrMrwMrTlovL71MEYkX/2NJ+TUCMcwseeAQaa8IgCXWfP7eD/RnS3DNj6su3Zes7W9HIpUJP33Ds3I+h0+QU9OYTnsjhxfOZOUm8BxNLvtBwVxKUmtJkh3zX/8F/exHXRaB2h0jx7iQ8bjpsGGnTE0izn0b/R3YuhH6yzt5nW8FaoHVQC/A7NVOfhg==',
-        ],
-    ],
-    'scope' => [
-        'fau.de',
-        'uni-erlangen.de',
-    ],
-    'UIInfo' => [
-        'DisplayName' => [
-            'en' => 'Friedrich-Alexander-Universität Erlangen-Nürnberg (FAU)',
-            'de' => 'Friedrich-Alexander-Universität Erlangen-Nürnberg (FAU)',
-        ],
-        'Description' => [
-            'en' => 'Identity Provider of Friedrich-Alexander-Universität Erlangen-Nürnberg (FAU)',
-            'de' => 'Identity Provider der Friedrich-Alexander-Universität Erlangen-Nürnberg (FAU)',
-        ],
-        'InformationURL' => [
-            'en' => 'https://www.sso.fau.de/imprint',
-            'de' => 'https://www.sso.fau.de/impressum',
-        ],
-        'PrivacyStatementURL' => [
-            'en' => 'https://www.sso.fau.de/privacy',
-            'de' => 'https://www.sso.fau.de/datenschutz',
-        ],
-        'Keywords' => [
-            'en' => [
-                'university',
-                'friedrich-alexander',
-                'erlangen',
-                'nuremberg',
-                'fau',
-            ],
-            'de' => [
-                'universität',
-                'friedrich-alexander',
-                'erlangen',
-                'nürnberg',
-                'fau',
-            ],
-        ],
-        'Logo' => [
-            [
-                'url' => 'https://idm.fau.de/static/images/logos/fau_kernmarke_q_rgb_blue.svg',
-                'height' => 32,
-                'width' => 32,
-            ],
-            [
-                'url' => 'https://idm.fau.de/static/images/logos/fau_kernmarke_q_rgb_blue.svg',
-                'height' => 192,
-                'width' => 192,
-            ],
-        ],
-    ],
-    'DiscoHints' => [
-        'IPHint' => [],
-        'DomainHint' => [
-            'fau.de',
-            'www.fau.de',
-        ],
-        'GeolocationHint' => [
-            'geo:49.59793616990235,11.004654332497283',
-        ],
-    ],
-    'name' => [
-        'en' => 'Friedrich-Alexander-Universität Erlangen-Nürnberg (FAU)',
-        'de' => 'Friedrich-Alexander-Universität Erlangen-Nürnberg (FAU)',
-    ],
-];
+//$metadata['https://testidp2.aai.dfn.de/idp/shibboleth'] = [
+//    'entityid' => 'https://testidp2.aai.dfn.de/idp/shibboleth',
+//    'description' => [
+//        'de' => 'e15',
+//        'en' => 'e15',
+//    ],
+//    'OrganizationName' => [
+//        'de' => 'e15',
+//        'en' => 'e15',
+//    ],
+//    'name' => [
+//        'de' => 'DFN: Offizieller öffentlicher Test-IdP',
+//        'en' => 'DFN: Official public test IdP',
+//    ],
+//    'OrganizationDisplayName' => [
+//        'de' => 'DFN-Verein - Deutsches Forschungsnetz',
+//        'en' => 'German National Research and Education Network, DFN',
+//    ],
+//    'url' => [
+//        'de' => 'http://www.dfn.de',
+//        'en' => 'http://www.dfn.de/en/',
+//    ],
+//    'OrganizationURL' => [
+//        'de' => 'http://www.dfn.de',
+//        'en' => 'http://www.dfn.de/en/',
+//    ],
+//    'contacts' => [
+//        [
+//            'contactType' => 'administrative',
+//            'givenName' => 'DFN-AAI',
+//            'surName' => 'Hotline',
+//            'emailAddress' => [
+//                'hotline@aai.dfn.de',
+//            ],
+//        ],
+//        [
+//            'contactType' => 'other',
+//            'givenName' => 'DFN-AAI Team',
+//            'emailAddress' => [
+//                'hotline@aai.dfn.de',
+//            ],
+//        ],
+//        [
+//            'contactType' => 'support',
+//            'givenName' => 'DFN AAI',
+//            'surName' => 'Hotline',
+//            'emailAddress' => [
+//                'hotline@aai.dfn.de',
+//            ],
+//        ],
+//        [
+//            'contactType' => 'technical',
+//            'givenName' => 'DFN-AAI',
+//            'surName' => 'Hotline',
+//            'emailAddress' => [
+//                'hotline@aai.dfn.de',
+//            ],
+//        ],
+//    ],
+//    'metadata-set' => 'saml20-idp-remote',
+//    'SingleSignOnService' => [
+//        [
+//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
+//            'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/POST/SSO',
+//        ],
+//        [
+//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST-SimpleSign',
+//            'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/POST-SimpleSign/SSO',
+//        ],
+//        [
+//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
+//            'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/Redirect/SSO',
+//        ],
+//        [
+//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
+//            'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/SOAP/ECP',
+//        ],
+//    ],
+//    'SingleLogoutService' => [
+//        [
+//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
+//            'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/POST/SLO',
+//        ],
+//        [
+//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST-SimpleSign',
+//            'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/POST-SimpleSign/SLO',
+//        ],
+//        [
+//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
+//            'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/Redirect/SLO',
+//        ],
+//        [
+//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
+//            'Location' => 'https://testidp2.aai.dfn.de:8443/idp/profile/SAML2/SOAP/SLO',
+//        ],
+//    ],
+//    'ArtifactResolutionService' => [
+//        [
+//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
+//            'Location' => 'https://testidp2.aai.dfn.de:8443/idp/profile/SAML2/SOAP/ArtifactResolution',
+//            'index' => 2,
+//        ],
+//    ],
+//    'NameIDFormats' => [
+//        'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent',
+//        'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
+//    ],
+//    'keys' => [
+//        [
+//            'encryption' => true,
+//            'signing' => true,
+//            'type' => 'X509Certificate',
+//            'X509Certificate' => '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',
+//        ],
+//    ],
+//    'scope' => [
+//        'test.dfn.de',
+//        'testscope.aai.dfn.de',
+//    ],
+//    'RegistrationInfo' => [
+//        'authority' => 'https://www.aai.dfn.de',
+//        'instant' => 1243326902,
+//        'policies' => [
+//            'de' => 'https://www.aai.dfn.de/teilnahme/',
+//            'en' => 'https://www.aai.dfn.de/en/join/',
+//        ],
+//    ],
+//    'UIInfo' => [
+//        'DisplayName' => [
+//            'de' => 'DFN: Offizieller öffentlicher Test-IdP',
+//            'en' => 'DFN: Official public test IdP',
+//        ],
+//        'Description' => [
+//            'de' => 'IdP der DFN-AAI-Testumgebung (SAML2 Web-SSO)',
+//            'en' => 'IdP of the DFN-AAI test environment (SAML2 Web-SSO)',
+//        ],
+//        'InformationURL' => [
+//            'de' => 'https://www.dfn.de',
+//            'en' => 'https://www.dfn.de',
+//        ],
+//        'PrivacyStatementURL' => [
+//            'de' => 'https://www.aai.dfn.de/fileadmin/documents/datenschutz/test-idp.html',
+//        ],
+//        'Logo' => [
+//            [
+//                'url' => 'https://testidp2.aai.dfn.de/idp/images/logo.png',
+//                'height' => 131,
+//                'width' => 236,
+//            ],
+//            [
+//                'url' => 'https://testidp2.aai.dfn.de/idp/images/favicon.ico',
+//                'height' => 16,
+//                'width' => 16,
+//            ],
+//        ],
+//    ],
+//];
+//
+//$metadata['https://www.sso.uni-erlangen.de/simplesaml/saml2/idp/metadata.php'] = [
+//    'entityid' => 'https://www.sso.uni-erlangen.de/simplesaml/saml2/idp/metadata.php',
+//    'contacts' => [
+//        [
+//            'contactType' => 'other',
+//            'givenName' => 'Security Response',
+//            'surName' => 'Team',
+//            'emailAddress' => [
+//                'abuse@fau.de',
+//            ],
+//        ],
+//        [
+//            'contactType' => 'support',
+//            'givenName' => 'WebSSO-Support',
+//            'surName' => 'Team',
+//            'emailAddress' => [
+//                'sso@fau.de',
+//            ],
+//        ],
+//        [
+//            'contactType' => 'administrative',
+//            'givenName' => 'WebSSO-Admins',
+//            'surName' => 'Team',
+//            'emailAddress' => [
+//                'sso-admins@fau.de',
+//            ],
+//        ],
+//        [
+//            'contactType' => 'technical',
+//            'givenName' => 'WebSSO-Admins',
+//            'surName' => 'Team',
+//            'emailAddress' => [
+//                'sso-admins@fau.de',
+//            ],
+//        ],
+//        [
+//            'contactType' => 'technical',
+//            'givenName' => 'WebSSO-Admins RRZE FAU',
+//            'emailAddress' => [
+//                'sso-support@fau.de',
+//            ],
+//        ],
+//    ],
+//    'metadata-set' => 'saml20-idp-remote',
+//    'SingleSignOnService' => [
+//        [
+//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
+//            'Location' => 'https://www.sso.uni-erlangen.de/simplesaml/module.php/saml/idp/singleSignOnService',
+//        ],
+//        [
+//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
+//            'Location' => 'https://www.sso.uni-erlangen.de/simplesaml/module.php/saml/idp/singleSignOnService',
+//        ],
+//        [
+//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
+//            'Location' => 'https://www.sso.uni-erlangen.de/simplesaml/module.php/saml/idp/singleSignOnService',
+//        ],
+//    ],
+//    'SingleLogoutService' => [
+//        [
+//            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
+//            'Location' => 'https://www.sso.uni-erlangen.de/simplesaml/module.php/saml/idp/singleLogout',
+//        ],
+//    ],
+//    'ArtifactResolutionService' => [],
+//    'NameIDFormats' => [
+//        'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
+//        'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent',
+//    ],
+//    'keys' => [
+//        [
+//            'encryption' => false,
+//            'signing' => true,
+//            'type' => 'X509Certificate',
+//            'X509Certificate' => 'MIIEFzCCAn+gAwIBAgIUZu6JGUynt+HmkDyTBVufV8brvfIwDQYJKoZIhvcNAQELBQAwIjEgMB4GA1UEAxMXd3d3LnNzby51bmktZXJsYW5nZW4uZGUwHhcNMjIxMDI1MTI0NDIzWhcNMjUxMTE5MTI0NDIzWjAiMSAwHgYDVQQDExd3d3cuc3NvLnVuaS1lcmxhbmdlbi5kZTCCAaIwDQYJKoZIhvcNAQEBBQADggGPADCCAYoCggGBAKV+3afbJg5B5r94ZuQMPRfFJdmixpAPiRqqif0hoXC4GAAd09txIWp2sMLWOEseiBYfSndBOz5OUHfyxvQ3IKubucP26leZxvyEDBymlaMw6ad2pi5JdCycJegGgkH2rThiNRK9rYLjyO5oUuCNumMBwqN1rCxaTsf6vC97cv5sEAoH551jNSPDYVvbn1/uUNw15GQuvvU43N3N3efiLnbRjUE8Ih/qDYp6v63/nxExINt7xgErgvD82k0gHrBJv7BIOMe7WmTQ2yQYC8FnzvCwHdHnZ8i1vRzPDYFTktxxn6Vsu1YMeNdd2K4Q+LLb/ljdoSxrNMKiwz9ls1Mj059hxlo3Q1g6JAYSZc9Lzqo26iTYLlq/LfF259OENIZX6FeQqDExK8BPLX6OXlneeksTxl9Bohsga3QPtRMRlGF415hmtpunW9LSiF1VewcKwpvjoEcDK+wutI/N7RNRhLNauUPQz16v1gZJDim4/zLB3Nfh19kLfJnlcRVnIkpKQQIDAQABo0UwQzAiBgNVHREEGzAZghd3d3cuc3NvLnVuaS1lcmxhbmdlbi5kZTAdBgNVHQ4EFgQUPB7olQAUEMwG9ImXfbDXtdLNPeUwDQYJKoZIhvcNAQELBQADggGBAEiIFXch6BzXOeU4S5/YgTQ/dHYpwHAc93YYP6WmlzEambSx+HGu4c6eav9zSrRhIVxwHkPE1nGJzBvtcM0FMML9/5U7keOtAcD7jkcHfnrC5cz9bWEbVpu4pSGVK1OWvC24gqwLn7++W3lx7prwpN7fO1uCSsudT3oOhSjy3oEJvtnBS26pqf/FFBUl6slZ4M3uVGUuf4q0PVXRIjK04oM8AwSO2Bb3tYU4u1lTBJkXJ+nFZGd8BcyYpFkQVY9/8iElY2qDWS6q1hNJ4c/phS7heJlk98MqtBeFw/Jo4juukdfIAtGmRpLg2xN3FzO2eoIzFgwQKrMrwMrTlovL71MEYkX/2NJ+TUCMcwseeAQaa8IgCXWfP7eD/RnS3DNj6su3Zes7W9HIpUJP33Ds3I+h0+QU9OYTnsjhxfOZOUm8BxNLvtBwVxKUmtJkh3zX/8F/exHXRaB2h0jx7iQ8bjpsGGnTE0izn0b/R3YuhH6yzt5nW8FaoHVQC/A7NVOfhg==',
+//        ],
+//        [
+//            'encryption' => true,
+//            'signing' => false,
+//            'type' => 'X509Certificate',
+//            'X509Certificate' => 'MIIEFzCCAn+gAwIBAgIUZu6JGUynt+HmkDyTBVufV8brvfIwDQYJKoZIhvcNAQELBQAwIjEgMB4GA1UEAxMXd3d3LnNzby51bmktZXJsYW5nZW4uZGUwHhcNMjIxMDI1MTI0NDIzWhcNMjUxMTE5MTI0NDIzWjAiMSAwHgYDVQQDExd3d3cuc3NvLnVuaS1lcmxhbmdlbi5kZTCCAaIwDQYJKoZIhvcNAQEBBQADggGPADCCAYoCggGBAKV+3afbJg5B5r94ZuQMPRfFJdmixpAPiRqqif0hoXC4GAAd09txIWp2sMLWOEseiBYfSndBOz5OUHfyxvQ3IKubucP26leZxvyEDBymlaMw6ad2pi5JdCycJegGgkH2rThiNRK9rYLjyO5oUuCNumMBwqN1rCxaTsf6vC97cv5sEAoH551jNSPDYVvbn1/uUNw15GQuvvU43N3N3efiLnbRjUE8Ih/qDYp6v63/nxExINt7xgErgvD82k0gHrBJv7BIOMe7WmTQ2yQYC8FnzvCwHdHnZ8i1vRzPDYFTktxxn6Vsu1YMeNdd2K4Q+LLb/ljdoSxrNMKiwz9ls1Mj059hxlo3Q1g6JAYSZc9Lzqo26iTYLlq/LfF259OENIZX6FeQqDExK8BPLX6OXlneeksTxl9Bohsga3QPtRMRlGF415hmtpunW9LSiF1VewcKwpvjoEcDK+wutI/N7RNRhLNauUPQz16v1gZJDim4/zLB3Nfh19kLfJnlcRVnIkpKQQIDAQABo0UwQzAiBgNVHREEGzAZghd3d3cuc3NvLnVuaS1lcmxhbmdlbi5kZTAdBgNVHQ4EFgQUPB7olQAUEMwG9ImXfbDXtdLNPeUwDQYJKoZIhvcNAQELBQADggGBAEiIFXch6BzXOeU4S5/YgTQ/dHYpwHAc93YYP6WmlzEambSx+HGu4c6eav9zSrRhIVxwHkPE1nGJzBvtcM0FMML9/5U7keOtAcD7jkcHfnrC5cz9bWEbVpu4pSGVK1OWvC24gqwLn7++W3lx7prwpN7fO1uCSsudT3oOhSjy3oEJvtnBS26pqf/FFBUl6slZ4M3uVGUuf4q0PVXRIjK04oM8AwSO2Bb3tYU4u1lTBJkXJ+nFZGd8BcyYpFkQVY9/8iElY2qDWS6q1hNJ4c/phS7heJlk98MqtBeFw/Jo4juukdfIAtGmRpLg2xN3FzO2eoIzFgwQKrMrwMrTlovL71MEYkX/2NJ+TUCMcwseeAQaa8IgCXWfP7eD/RnS3DNj6su3Zes7W9HIpUJP33Ds3I+h0+QU9OYTnsjhxfOZOUm8BxNLvtBwVxKUmtJkh3zX/8F/exHXRaB2h0jx7iQ8bjpsGGnTE0izn0b/R3YuhH6yzt5nW8FaoHVQC/A7NVOfhg==',
+//        ],
+//    ],
+//    'scope' => [
+//        'fau.de',
+//        'uni-erlangen.de',
+//    ],
+//    'UIInfo' => [
+//        'DisplayName' => [
+//            'en' => 'Friedrich-Alexander-Universität Erlangen-Nürnberg (FAU)',
+//            'de' => 'Friedrich-Alexander-Universität Erlangen-Nürnberg (FAU)',
+//        ],
+//        'Description' => [
+//            'en' => 'Identity Provider of Friedrich-Alexander-Universität Erlangen-Nürnberg (FAU)',
+//            'de' => 'Identity Provider der Friedrich-Alexander-Universität Erlangen-Nürnberg (FAU)',
+//        ],
+//        'InformationURL' => [
+//            'en' => 'https://www.sso.fau.de/imprint',
+//            'de' => 'https://www.sso.fau.de/impressum',
+//        ],
+//        'PrivacyStatementURL' => [
+//            'en' => 'https://www.sso.fau.de/privacy',
+//            'de' => 'https://www.sso.fau.de/datenschutz',
+//        ],
+//        'Keywords' => [
+//            'en' => [
+//                'university',
+//                'friedrich-alexander',
+//                'erlangen',
+//                'nuremberg',
+//                'fau',
+//            ],
+//            'de' => [
+//                'universität',
+//                'friedrich-alexander',
+//                'erlangen',
+//                'nürnberg',
+//                'fau',
+//            ],
+//        ],
+//        'Logo' => [
+//            [
+//                'url' => 'https://idm.fau.de/static/images/logos/fau_kernmarke_q_rgb_blue.svg',
+//                'height' => 32,
+//                'width' => 32,
+//            ],
+//            [
+//                'url' => 'https://idm.fau.de/static/images/logos/fau_kernmarke_q_rgb_blue.svg',
+//                'height' => 192,
+//                'width' => 192,
+//            ],
+//        ],
+//    ],
+//    'DiscoHints' => [
+//        'IPHint' => [],
+//        'DomainHint' => [
+//            'fau.de',
+//            'www.fau.de',
+//        ],
+//        'GeolocationHint' => [
+//            'geo:49.59793616990235,11.004654332497283',
+//        ],
+//    ],
+//    'name' => [
+//        'en' => 'Friedrich-Alexander-Universität Erlangen-Nürnberg (FAU)',
+//        'de' => 'Friedrich-Alexander-Universität Erlangen-Nürnberg (FAU)',
+//    ],
+//];
```

[//]: # (AUTOGENERATE END)
