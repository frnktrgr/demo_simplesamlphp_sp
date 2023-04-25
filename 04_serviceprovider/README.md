# Service Provider

## Links
* [SimpleSAMLphp Documentation > Service Provider Quickstart](https://simplesamlphp.org/docs/stable/simplesamlphp-sp)
* [SimpleSAMLphp Documentation > Hosted SP Configuration Reference](https://simplesamlphp.org/docs/stable/saml:sp)
* [IdP remote reference](https://simplesamlphp.org/docs/stable/simplesamlphp-reference-idp-remote)

## Teilschritte
* `config/authsources.php`
    * Zertifikat/Schlüssel
* `metadata/saml20-idp-remote.php`
    * IdPs
    * default IdP
* Metadaten austauschen
* Testen

[//]: # (AUTOGENERATE START)
## Anpassungen
### Änderungen
* [compose.yaml](../../../blob/simplesamlphp-2.0/04_serviceprovider/compose.yaml):
```diff
@@ -1,3 +1,4 @@
+version: '3'
 services:
   sp:
     build: .
@@ -9,6 +10,8 @@
       - var_simplesamlphp:/var/simplesamlphp
       - /opt/simplesamlphp_sp/sso-dev.fau.de.crt:/etc/ssl/certs/sso-dev.fau.de.crt
       - /opt/simplesamlphp_sp/sso-dev.fau.de.pem:/etc/ssl/private/sso-dev.fau.de.pem
+      - /opt/simplesamlphp_sp/sso-dev.fau.de.crt:/var/simplesamlphp/cert/sso-dev.fau.de.crt
+      - /opt/simplesamlphp_sp/sso-dev.fau.de.pem:/var/simplesamlphp/cert/sso-dev.fau.de.pem
       - ./resources/var/www/html:/var/www/html
     network_mode: bridge
 volumes:
```
* [Dockerfile](../../../blob/simplesamlphp-2.0/04_serviceprovider/Dockerfile):
```diff
@@ -72,7 +72,8 @@
 
 WORKDIR /var/simplesamlphp
 RUN set -ex \
-    && cp config/config.php.dist config/config.php
+    && cp config/config.php.dist config/config.php \
+    && cp config/authsources.php.dist config/authsources.php
 
 COPY resources/ /
 
```
* [resources/var/simplesamlphp/config/authsources.php](../../../blob/simplesamlphp-2.0/04_serviceprovider/resources/var/simplesamlphp/config/authsources.php):
```diff
@@ -27,7 +27,14 @@
         'saml:SP',
 
         // The entity ID of this SP.
-        'entityID' => 'https://myapp.example.org/',
+        'entityID' => 'https://sso-dev.fau.de/devssp/module.php/saml/sp/metadata.php/default-sp',
+
+        'privatekey' => 'sso-dev.fau.de.pem',
+        'certificate' => 'sso-dev.fau.de.crt',
+
+        'NameIDPolicy' => ['Format' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent', 'allowcreate' => true],
+
+        'sign.logout' => true,
 
         // The entity ID of the IdP this SP should contact.
         // Can be NULL/unset, in which case the user will be shown a list of available IdPs.
@@ -52,19 +59,43 @@
          * The metadata will then be created as follows:
          * <md:RequestedAttribute FriendlyName="friendlyName" Name="name" />
          */
-        /*
         'name' => [
-            'en' => 'A service',
-            'no' => 'En tjeneste',
+            'en' => 'My Awesome PHP App',
+            'de' => 'Meine tolle PHP Anwendung',
         ],
 
         'attributes' => [
-            'attrname' => 'urn:oid:x.x.x.x',
+            'eduPersonPrincipalName' => 'urn:oid:1.3.6.1.4.1.5923.1.1.1.6',
         ],
         'attributes.required' => [
-            'urn:oid:x.x.x.x',
+            'urn:oid:1.3.6.1.4.1.5923.1.1.1.6',
+        ],
+        'attributes.NameFormat' => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
+        'UIInfo' => [
+            'DisplayName' => [
+                'en' => 'Meine tolle PHP Anwendung',
+                'de' => 'Meine tolle PHP Anwendung',
+            ],
+            'Description' => [
+                'de' => 'Tolle Beschreibung',
+                'en' => 'Awesome description',
+            ],
+            'InformationURL' => [
+                'de' => 'https://sso-dev.fau.de',
+                'en' => 'https://sso-dev.fau.de',
+            ],
+            'PrivacyStatementURL' => [
+                'de' => 'https://sso-dev.fau.de/data-protection',
+                'en' => 'https://sso-dev.fau.de/en/data-protection',
+            ],
+            'Logo' => [
+                [
+                    'url'    => 'https://sso-dev.fau.de/logo.jpg',
+                    'height' => 236,
+                    'width'  => 50,
+                ]
+            ],
         ],
-        */
     ],
 
 
```
* [resources/var/simplesamlphp/metadata/saml20-idp-remote.php](../../../blob/simplesamlphp-2.0/04_serviceprovider/resources/var/simplesamlphp/metadata/saml20-idp-remote.php):
```diff
@@ -7,3 +7,42 @@
  *
  * See: https://simplesamlphp.org/docs/stable/simplesamlphp-reference-idp-remote
  */
+
+$metadata['https://www.sso.uni-erlangen.de/simplesaml/saml2/idp/metadata.php'] = [
+    'metadata-set' => 'saml20-idp-hosted',
+    'entityid' => 'https://www.sso.uni-erlangen.de/simplesaml/saml2/idp/metadata.php',
+    'SingleSignOnService' => [
+        [
+            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
+            'Location' => 'https://www.sso.uni-erlangen.de/simplesaml/saml2/idp/SSOService.php',
+        ],
+        [
+            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
+            'Location' => 'https://www.sso.uni-erlangen.de/simplesaml/saml2/idp/SSOService.php',
+        ],
+        [
+            'index' => 0,
+            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
+            'Location' => 'https://www.sso.uni-erlangen.de/simplesaml/saml2/idp/SSOService.php',
+        ],
+    ],
+    'SingleLogoutService' => [
+        [
+            'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
+            'Location' => 'https://www.sso.uni-erlangen.de/simplesaml/saml2/idp/SingleLogoutService.php',
+        ],
+    ],
+    'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
+    'scope' => [
+        'fau.de',
+        'uni-erlangen.de',
+    ],
+    'contacts' => [
+        [
+            'emailAddress' => 'sso-support@fau.de',
+            'contactType' => 'technical',
+            'givenName' => 'SSO-Admins RRZE FAU',
+        ],
+    ],
+    'certData' => 'MIIEFzCCAn+gAwIBAgIUZu6JGUynt+HmkDyTBVufV8brvfIwDQYJKoZIhvcNAQELBQAwIjEgMB4GA1UEAxMXd3d3LnNzby51bmktZXJsYW5nZW4uZGUwHhcNMjIxMDI1MTI0NDIzWhcNMjUxMTE5MTI0NDIzWjAiMSAwHgYDVQQDExd3d3cuc3NvLnVuaS1lcmxhbmdlbi5kZTCCAaIwDQYJKoZIhvcNAQEBBQADggGPADCCAYoCggGBAKV+3afbJg5B5r94ZuQMPRfFJdmixpAPiRqqif0hoXC4GAAd09txIWp2sMLWOEseiBYfSndBOz5OUHfyxvQ3IKubucP26leZxvyEDBymlaMw6ad2pi5JdCycJegGgkH2rThiNRK9rYLjyO5oUuCNumMBwqN1rCxaTsf6vC97cv5sEAoH551jNSPDYVvbn1/uUNw15GQuvvU43N3N3efiLnbRjUE8Ih/qDYp6v63/nxExINt7xgErgvD82k0gHrBJv7BIOMe7WmTQ2yQYC8FnzvCwHdHnZ8i1vRzPDYFTktxxn6Vsu1YMeNdd2K4Q+LLb/ljdoSxrNMKiwz9ls1Mj059hxlo3Q1g6JAYSZc9Lzqo26iTYLlq/LfF259OENIZX6FeQqDExK8BPLX6OXlneeksTxl9Bohsga3QPtRMRlGF415hmtpunW9LSiF1VewcKwpvjoEcDK+wutI/N7RNRhLNauUPQz16v1gZJDim4/zLB3Nfh19kLfJnlcRVnIkpKQQIDAQABo0UwQzAiBgNVHREEGzAZghd3d3cuc3NvLnVuaS1lcmxhbmdlbi5kZTAdBgNVHQ4EFgQUPB7olQAUEMwG9ImXfbDXtdLNPeUwDQYJKoZIhvcNAQELBQADggGBAEiIFXch6BzXOeU4S5/YgTQ/dHYpwHAc93YYP6WmlzEambSx+HGu4c6eav9zSrRhIVxwHkPE1nGJzBvtcM0FMML9/5U7keOtAcD7jkcHfnrC5cz9bWEbVpu4pSGVK1OWvC24gqwLn7++W3lx7prwpN7fO1uCSsudT3oOhSjy3oEJvtnBS26pqf/FFBUl6slZ4M3uVGUuf4q0PVXRIjK04oM8AwSO2Bb3tYU4u1lTBJkXJ+nFZGd8BcyYpFkQVY9/8iElY2qDWS6q1hNJ4c/phS7heJlk98MqtBeFw/Jo4juukdfIAtGmRpLg2xN3FzO2eoIzFgwQKrMrwMrTlovL71MEYkX/2NJ+TUCMcwseeAQaa8IgCXWfP7eD/RnS3DNj6su3Zes7W9HIpUJP33Ds3I+h0+QU9OYTnsjhxfOZOUm8BxNLvtBwVxKUmtJkh3zX/8F/exHXRaB2h0jx7iQ8bjpsGGnTE0izn0b/R3YuhH6yzt5nW8FaoHVQC/A7NVOfhg==',
+];
```

[//]: # (AUTOGENERATE END)
