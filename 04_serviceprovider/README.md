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
@@ -9,6 +9,8 @@
       - var_simplesamlphp:/var/simplesamlphp
       - /opt/simplesamlphp_sp/sso-dev.fau.de.chained.crt:/etc/ssl/certs/sso-dev.fau.de.chained.crt
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
@@ -7,3 +7,242 @@
  *
  * See: https://simplesamlphp.org/docs/stable/simplesamlphp-reference-idp-remote
  */
+
+$metadata['https://testidp2.aai.dfn.de/idp/shibboleth'] = [
+    'entityid' => 'https://testidp2.aai.dfn.de/idp/shibboleth',
+    'entityDescriptor' => 'PG1kOkVudGl0eURlc2NyaXB0b3IgeG1sbnM6bWQ9InVybjpvYXNpczpuYW1lczp0YzpTQU1MOjIuMDptZXRhZGF0YSIgZW50aXR5SUQ9Imh0dHBzOi8vdGVzdGlkcDIuYWFpLmRmbi5kZS9pZHAvc2hpYmJvbGV0aCI+PG1kOkV4dGVuc2lvbnM+PG1kcnBpOlJlZ2lzdHJhdGlvbkluZm8geG1sbnM6bWRycGk9InVybjpvYXNpczpuYW1lczp0YzpTQU1MOm1ldGFkYXRhOnJwaSIgcmVnaXN0cmF0aW9uQXV0aG9yaXR5PSJodHRwczovL3d3dy5hYWkuZGZuLmRlIiByZWdpc3RyYXRpb25JbnN0YW50PSIyMDA5LTA1LTI2VDA4OjM1OjAyWiI+PG1kcnBpOlJlZ2lzdHJhdGlvblBvbGljeSB4bWw6bGFuZz0iZGUiPmh0dHBzOi8vd3d3LmFhaS5kZm4uZGUvdGVpbG5haG1lLzwvbWRycGk6UmVnaXN0cmF0aW9uUG9saWN5PjxtZHJwaTpSZWdpc3RyYXRpb25Qb2xpY3kgeG1sOmxhbmc9ImVuIj5odHRwczovL3d3dy5hYWkuZGZuLmRlL2VuL2pvaW4vPC9tZHJwaTpSZWdpc3RyYXRpb25Qb2xpY3k+PC9tZHJwaTpSZWdpc3RyYXRpb25JbmZvPjwvbWQ6RXh0ZW5zaW9ucz48bWQ6SURQU1NPRGVzY3JpcHRvciBwcm90b2NvbFN1cHBvcnRFbnVtZXJhdGlvbj0idXJuOm9hc2lzOm5hbWVzOnRjOlNBTUw6Mi4wOnByb3RvY29sIj48bWQ6RXh0ZW5zaW9ucz48c2hpYm1kOlNjb3BlIHhtbG5zOnNoaWJtZD0idXJuOm1hY2U6c2hpYmJvbGV0aDptZXRhZGF0YToxLjAiIHJlZ2V4cD0iZmFsc2UiPnRlc3RzY29wZS5hYWkuZGZuLmRlPC9zaGlibWQ6U2NvcGU+PG1kdWk6VUlJbmZvIHhtbG5zOm1kdWk9InVybjpvYXNpczpuYW1lczp0YzpTQU1MOm1ldGFkYXRhOnVpIj48bWR1aTpEaXNwbGF5TmFtZSB4bWw6bGFuZz0iZGUiPkRGTjogT2ZmaXppZWxsZXIgw7ZmZmVudGxpY2hlciBUZXN0LUlkUDwvbWR1aTpEaXNwbGF5TmFtZT48bWR1aTpEaXNwbGF5TmFtZSB4bWw6bGFuZz0iZW4iPkRGTjogT2ZmaWNpYWwgcHVibGljIHRlc3QgSWRQPC9tZHVpOkRpc3BsYXlOYW1lPjxtZHVpOkRlc2NyaXB0aW9uIHhtbDpsYW5nPSJkZSI+SWRQIGRlciBERk4tQUFJLVRlc3R1bWdlYnVuZyAoU0FNTDIgV2ViLVNTTyk8L21kdWk6RGVzY3JpcHRpb24+PG1kdWk6RGVzY3JpcHRpb24geG1sOmxhbmc9ImVuIj5JZFAgb2YgdGhlIERGTi1BQUkgdGVzdCBlbnZpcm9ubWVudCAoU0FNTDIgV2ViLVNTTyk8L21kdWk6RGVzY3JpcHRpb24+PG1kdWk6SW5mb3JtYXRpb25VUkwgeG1sOmxhbmc9ImRlIj5odHRwczovL3d3dy5kZm4uZGU8L21kdWk6SW5mb3JtYXRpb25VUkw+PG1kdWk6SW5mb3JtYXRpb25VUkwgeG1sOmxhbmc9ImVuIj5odHRwczovL3d3dy5kZm4uZGU8L21kdWk6SW5mb3JtYXRpb25VUkw+PG1kdWk6UHJpdmFjeVN0YXRlbWVudFVSTCB4bWw6bGFuZz0iZGUiPmh0dHBzOi8vd3d3LmFhaS5kZm4uZGUvZmlsZWFkbWluL2RvY3VtZW50cy9kYXRlbnNjaHV0ei90ZXN0LWlkcC5odG1sPC9tZHVpOlByaXZhY3lTdGF0ZW1lbnRVUkw+PG1kdWk6TG9nbyB3aWR0aD0iMjM2IiBoZWlnaHQ9IjEzMSI+aHR0cHM6Ly90ZXN0aWRwMi5hYWkuZGZuLmRlL2lkcC9pbWFnZXMvbG9nby5wbmc8L21kdWk6TG9nbz48bWR1aTpMb2dvIHdpZHRoPSIxNiIgaGVpZ2h0PSIxNiI+aHR0cHM6Ly90ZXN0aWRwMi5hYWkuZGZuLmRlL2lkcC9pbWFnZXMvZmF2aWNvbi5pY288L21kdWk6TG9nbz48L21kdWk6VUlJbmZvPjwvbWQ6RXh0ZW5zaW9ucz48bWQ6S2V5RGVzY3JpcHRvcj48ZHM6S2V5SW5mbyB4bWxuczpkcz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC8wOS94bWxkc2lnIyI+PGRzOktleU5hbWU+dGVzdGlkcDIuYWFpLmRmbi5kZTwvZHM6S2V5TmFtZT48ZHM6WDUwOURhdGE+PGRzOlg1MDlTdWJqZWN0TmFtZSB4bWxuczpzYW1sMW1kPSJ1cm46bWFjZTpzaGliYm9sZXRoOm1ldGFkYXRhOjEuMCIgeG1sbnM6c2FtbD0idXJuOm9hc2lzOm5hbWVzOnRjOlNBTUw6Mi4wOmFzc2VydGlvbiIgeG1sbnM6cmVtZD0iaHR0cDovL3JlZmVkcy5vcmcvbWV0YWRhdGEiIHhtbG5zOm1kdWk9InVybjpvYXNpczpuYW1lczp0YzpTQU1MOm1ldGFkYXRhOnVpIiB4bWxuczptZHJwaT0idXJuOm9hc2lzOm5hbWVzOnRjOlNBTUw6bWV0YWRhdGE6cnBpIiB4bWxuczptZGF0dHI9InVybjpvYXNpczpuYW1lczp0YzpTQU1MOm1ldGFkYXRhOmF0dHJpYnV0ZSIgeG1sbnM6aW5pdD0idXJuOm9hc2lzOm5hbWVzOnRjOlNBTUw6cHJvZmlsZXM6U1NPOnJlcXVlc3QtaW5pdCIgeG1sbnM6aWRwZGlzYz0idXJuOm9hc2lzOm5hbWVzOnRjOlNBTUw6cHJvZmlsZXM6U1NPOmlkcC1kaXNjb3ZlcnktcHJvdG9jb2wiPmVtYWlsQWRkcmVzcz1ob3RsaW5lQGFhaS5kZm4uZGUsQ049dGVzdGlkcDIuYWFpLmRmbi5kZSxPPVZlcmVpbiB6dXIgRm9lcmRlcnVuZyBlaW5lcyBEZXV0c2NoZW4gRm9yc2NodW5nc25ldHplcyBlLiBWLixMPUJlcmxpbixTVD1CZXJsaW4sQz1ERTwvZHM6WDUwOVN1YmplY3ROYW1lPjxkczpYNTA5Q2VydGlmaWNhdGU+TUlJRjl6Q0NBOThDRkdIS21aUFJiRVRhQm5xK28rb2hsMkxPQU9VME1BMEdDU3FHU0liM0RRRUJDd1VBTUlHM01Rc3dDUVlEVlFRR0V3SkVSVEVQTUEwR0ExVUVDQXdHUW1WeWJHbHVNUTh3RFFZRFZRUUhEQVpDWlhKc2FXNHhSVEJEQmdOVkJBb01QRlpsY21WcGJpQjZkWElnUm05bGNtUmxjblZ1WnlCbGFXNWxjeUJFWlhWMGMyTm9aVzRnUm05eWMyTm9kVzVuYzI1bGRIcGxjeUJsTGlCV0xqRWNNQm9HQTFVRUF3d1RkR1Z6ZEdsa2NESXVZV0ZwTG1SbWJpNWtaVEVoTUI4R0NTcUdTSWIzRFFFSkFSWVNhRzkwYkdsdVpVQmhZV2t1WkdadUxtUmxNQjRYRFRJeU1EZ3hPREV6TlRReU1Wb1hEVEkxTURneE56RXpOVFF5TVZvd2diY3hDekFKQmdOVkJBWVRBa1JGTVE4d0RRWURWUVFJREFaQ1pYSnNhVzR4RHpBTkJnTlZCQWNNQmtKbGNteHBiakZGTUVNR0ExVUVDZ3c4Vm1WeVpXbHVJSHAxY2lCR2IyVnlaR1Z5ZFc1bklHVnBibVZ6SUVSbGRYUnpZMmhsYmlCR2IzSnpZMmgxYm1kemJtVjBlbVZ6SUdVdUlGWXVNUnd3R2dZRFZRUUREQk4wWlhOMGFXUndNaTVoWVdrdVpHWnVMbVJsTVNFd0h3WUpLb1pJaHZjTkFRa0JGaEpvYjNSc2FXNWxRR0ZoYVM1a1ptNHVaR1V3Z2dJaU1BMEdDU3FHU0liM0RRRUJBUVVBQTRJQ0R3QXdnZ0lLQW9JQ0FRQzh4YzlDbHdmbnVENGptb3VaSWRPNFo3QXBxcUQvRWRLUVROcnMvZDBCV0Rpd2V5VUYyMDgzbWVDZ0RZUGJIbi9QUFR2d0d6TnpOaEo1V1ZjZmttUHljbmtSZDZ3UjBGT1ZaT1RWNnJpMWJMVmZaOVlKd0F0dXpwRzhKVUNiQjViSjgwd1lGTU4yVHhNYjllZm53Zk5jdUFPV2tGeWcyWWlKV0MxaERYUHU5bkpPUldITHNPR1k0c01kblFFaUZZbWVYZkN5WUZNdkNRQWJqVy9PVmFvRC9UZEhuUk54TnpWQW9YVkszbGhmc0FpTnF1NWxtellFNU1weENHVDMrK3FpZ1B4cGRuUTdiNFVDMkpDSzl2R1YxbFM1UzY1NmZIWjNDVXhqWVhFSkpQQVFWM0pieXdCcWtYNzFpR3RFck1VUzF5S0VCbkV0SDZDQ29seUh4bUtBQUxVai9HNFVmZ3BSYzY0NTBNWGlaRlV4RTBOakRiVHVIYXphNnYyRUZMRG5KR0JBYitoQlU3cEFXdngzcTFwL1hoQU54VVhka0x6UEZpekhRRFA4ZDFGZzhGWGE2dEt5VDZXZmUrRHNjNHdXMVM0QUFKVFI2TjVpdUl5a09BYk5ZU09MZ3JlYjBKb1dRUXhQaU9qck5HUTU0cGVrMmRteGRQeTFEV0c2K1EwYmlXbzBkVVlzM2swamUxZzh4S1JHRjBqNjBlQkZ4Z1NmNkNkR2hNZCtoSWtDeG0vOVI0c2ZTQmtzb01FTUdhOTBJQU0vWWppNHM0UmlxcUhrd08wZzVqbis4RTNjSVBEakFNN2VVTE1YcGlGWW1IZmZvQlBsdHBXYWxtK1ZoN2ZuRHk1OTBCdWx3ck82NEgxUnk5ZzZ4aFFvTUhENFc1d3dPVzIwVzBEbVhRSURBUUFCTUEwR0NTcUdTSWIzRFFFQkN3VUFBNElDQVFDY3ZBaCs1WFhJQTZ4bnNROVg4cmtaeW9jcEtZNUZ2NzcwQW1mZXI5WkFsa0NjSlZGYWtGeGRzNzRPWXV4V2oxb3hsbEQwNlBDcEpTakhWeDM5SzJoUnMrMjQyelNQdWxLRndHQjFxbis0NC9YdXFadmtEWnI5cURpaTdaaWNIYy94empmQ3Q5dVFvaExzNTB4OGJCN0IxNTgxU2sxd0lUc05Da3FEV3psVTBSUkF5SFZtOVdidVZ2c2Y0aU1hbGNVeUpjYUN1SnNCSkdjMkdlNWZZWGNnL2FTTUcvN3QwM0NtdStNSEdNSnIwWk14TGgyRk1WaS9zaklYYzMvL1p0ZDN5Y2UxOThDSi9FOC9iVU9LekcwL1lha3V4bG5xcTZmbmpYUGlXc2tVT1NPa05saUVYcjcwenFyQ0VCaEkxT1pSTllMRE1VZDF4VUVwZW9lakJHazVwWFFYSHNBa1p3OFRoelVHSzNDWE9pYWRUWFN2MWNCZWZTUVJUUnFCVzZXalUrWW5pckYzc3ZGTUNJeGpTcFVPVER2a005NHJBL1YxZEFZcjFBdUViWnVKKzZ4elF5cm5PL1AwNU1CY2NPR0t6Zk9MQUVOV2paaUxiMHlzamFMNDZqMHVPZDQyamNiY081QlMxTVhOK1JVVXdQODFQWVZvdDFMZnZvOGIvaU1SYVA2dGxDK2hzaWx5RDlDa3d3TWxoWGowM1crVE41SVloVzlseW9haG5lMnY4WCtzMWsvWkliSWdKZHNUMzhnUkh3a2svVDk3NGtIYzBJUUF4TEk2OUswSXZWYlZEOUw4blFWd2RrZlp1ZVZESGNHVkEyeTRvNXhTMEJkajNFcytiZjBSL0phRjVOZVdUQzhUR2ExOWRUSGFzVkNXc3FUVTg2TGpVazVqN1E9PTwvZHM6WDUwOUNlcnRpZmljYXRlPjwvZHM6WDUwOURhdGE+PC9kczpLZXlJbmZvPjwvbWQ6S2V5RGVzY3JpcHRvcj48bWQ6QXJ0aWZhY3RSZXNvbHV0aW9uU2VydmljZSBCaW5kaW5nPSJ1cm46b2FzaXM6bmFtZXM6dGM6U0FNTDoyLjA6YmluZGluZ3M6U09BUCIgTG9jYXRpb249Imh0dHBzOi8vdGVzdGlkcDIuYWFpLmRmbi5kZTo4NDQzL2lkcC9wcm9maWxlL1NBTUwyL1NPQVAvQXJ0aWZhY3RSZXNvbHV0aW9uIiBpbmRleD0iMiIvPjxtZDpTaW5nbGVMb2dvdXRTZXJ2aWNlIEJpbmRpbmc9InVybjpvYXNpczpuYW1lczp0YzpTQU1MOjIuMDpiaW5kaW5nczpIVFRQLVBPU1QiIExvY2F0aW9uPSJodHRwczovL3Rlc3RpZHAyLmFhaS5kZm4uZGUvaWRwL3Byb2ZpbGUvU0FNTDIvUE9TVC9TTE8iLz48bWQ6U2luZ2xlTG9nb3V0U2VydmljZSBCaW5kaW5nPSJ1cm46b2FzaXM6bmFtZXM6dGM6U0FNTDoyLjA6YmluZGluZ3M6SFRUUC1QT1NULVNpbXBsZVNpZ24iIExvY2F0aW9uPSJodHRwczovL3Rlc3RpZHAyLmFhaS5kZm4uZGUvaWRwL3Byb2ZpbGUvU0FNTDIvUE9TVC1TaW1wbGVTaWduL1NMTyIvPjxtZDpTaW5nbGVMb2dvdXRTZXJ2aWNlIEJpbmRpbmc9InVybjpvYXNpczpuYW1lczp0YzpTQU1MOjIuMDpiaW5kaW5nczpIVFRQLVJlZGlyZWN0IiBMb2NhdGlvbj0iaHR0cHM6Ly90ZXN0aWRwMi5hYWkuZGZuLmRlL2lkcC9wcm9maWxlL1NBTUwyL1JlZGlyZWN0L1NMTyIvPjxtZDpTaW5nbGVMb2dvdXRTZXJ2aWNlIEJpbmRpbmc9InVybjpvYXNpczpuYW1lczp0YzpTQU1MOjIuMDpiaW5kaW5nczpTT0FQIiBMb2NhdGlvbj0iaHR0cHM6Ly90ZXN0aWRwMi5hYWkuZGZuLmRlOjg0NDMvaWRwL3Byb2ZpbGUvU0FNTDIvU09BUC9TTE8iLz48bWQ6TmFtZUlERm9ybWF0PnVybjpvYXNpczpuYW1lczp0YzpTQU1MOjIuMDpuYW1laWQtZm9ybWF0OnBlcnNpc3RlbnQ8L21kOk5hbWVJREZvcm1hdD48bWQ6TmFtZUlERm9ybWF0PnVybjpvYXNpczpuYW1lczp0YzpTQU1MOjIuMDpuYW1laWQtZm9ybWF0OnRyYW5zaWVudDwvbWQ6TmFtZUlERm9ybWF0PjxtZDpTaW5nbGVTaWduT25TZXJ2aWNlIEJpbmRpbmc9InVybjpvYXNpczpuYW1lczp0YzpTQU1MOjIuMDpiaW5kaW5nczpIVFRQLVBPU1QiIExvY2F0aW9uPSJodHRwczovL3Rlc3RpZHAyLmFhaS5kZm4uZGUvaWRwL3Byb2ZpbGUvU0FNTDIvUE9TVC9TU08iLz48bWQ6U2luZ2xlU2lnbk9uU2VydmljZSBCaW5kaW5nPSJ1cm46b2FzaXM6bmFtZXM6dGM6U0FNTDoyLjA6YmluZGluZ3M6SFRUUC1QT1NULVNpbXBsZVNpZ24iIExvY2F0aW9uPSJodHRwczovL3Rlc3RpZHAyLmFhaS5kZm4uZGUvaWRwL3Byb2ZpbGUvU0FNTDIvUE9TVC1TaW1wbGVTaWduL1NTTyIvPjxtZDpTaW5nbGVTaWduT25TZXJ2aWNlIEJpbmRpbmc9InVybjpvYXNpczpuYW1lczp0YzpTQU1MOjIuMDpiaW5kaW5nczpIVFRQLVJlZGlyZWN0IiBMb2NhdGlvbj0iaHR0cHM6Ly90ZXN0aWRwMi5hYWkuZGZuLmRlL2lkcC9wcm9maWxlL1NBTUwyL1JlZGlyZWN0L1NTTyIvPjxtZDpTaW5nbGVTaWduT25TZXJ2aWNlIEJpbmRpbmc9InVybjpvYXNpczpuYW1lczp0YzpTQU1MOjIuMDpiaW5kaW5nczpTT0FQIiBMb2NhdGlvbj0iaHR0cHM6Ly90ZXN0aWRwMi5hYWkuZGZuLmRlL2lkcC9wcm9maWxlL1NBTUwyL1NPQVAvRUNQIi8+PC9tZDpJRFBTU09EZXNjcmlwdG9yPjxtZDpBdHRyaWJ1dGVBdXRob3JpdHlEZXNjcmlwdG9yIHByb3RvY29sU3VwcG9ydEVudW1lcmF0aW9uPSJ1cm46b2FzaXM6bmFtZXM6dGM6U0FNTDoyLjA6cHJvdG9jb2wiPjxtZDpFeHRlbnNpb25zPjxzaGlibWQ6U2NvcGUgeG1sbnM6c2hpYm1kPSJ1cm46bWFjZTpzaGliYm9sZXRoOm1ldGFkYXRhOjEuMCIgcmVnZXhwPSJmYWxzZSI+dGVzdHNjb3BlLmFhaS5kZm4uZGU8L3NoaWJtZDpTY29wZT48L21kOkV4dGVuc2lvbnM+PG1kOktleURlc2NyaXB0b3I+PGRzOktleUluZm8geG1sbnM6ZHM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvMDkveG1sZHNpZyMiPjxkczpLZXlOYW1lPnRlc3RpZHAyLmFhaS5kZm4uZGU8L2RzOktleU5hbWU+PGRzOlg1MDlEYXRhPjxkczpYNTA5U3ViamVjdE5hbWUgeG1sbnM6c2FtbDFtZD0idXJuOm1hY2U6c2hpYmJvbGV0aDptZXRhZGF0YToxLjAiIHhtbG5zOnNhbWw9InVybjpvYXNpczpuYW1lczp0YzpTQU1MOjIuMDphc3NlcnRpb24iIHhtbG5zOnJlbWQ9Imh0dHA6Ly9yZWZlZHMub3JnL21ldGFkYXRhIiB4bWxuczptZHVpPSJ1cm46b2FzaXM6bmFtZXM6dGM6U0FNTDptZXRhZGF0YTp1aSIgeG1sbnM6bWRycGk9InVybjpvYXNpczpuYW1lczp0YzpTQU1MOm1ldGFkYXRhOnJwaSIgeG1sbnM6bWRhdHRyPSJ1cm46b2FzaXM6bmFtZXM6dGM6U0FNTDptZXRhZGF0YTphdHRyaWJ1dGUiIHhtbG5zOmluaXQ9InVybjpvYXNpczpuYW1lczp0YzpTQU1MOnByb2ZpbGVzOlNTTzpyZXF1ZXN0LWluaXQiIHhtbG5zOmlkcGRpc2M9InVybjpvYXNpczpuYW1lczp0YzpTQU1MOnByb2ZpbGVzOlNTTzppZHAtZGlzY292ZXJ5LXByb3RvY29sIj5lbWFpbEFkZHJlc3M9aG90bGluZUBhYWkuZGZuLmRlLENOPXRlc3RpZHAyLmFhaS5kZm4uZGUsTz1WZXJlaW4genVyIEZvZXJkZXJ1bmcgZWluZXMgRGV1dHNjaGVuIEZvcnNjaHVuZ3NuZXR6ZXMgZS4gVi4sTD1CZXJsaW4sU1Q9QmVybGluLEM9REU8L2RzOlg1MDlTdWJqZWN0TmFtZT48ZHM6WDUwOUNlcnRpZmljYXRlPk1JSUY5ekNDQTk4Q0ZHSEttWlBSYkVUYUJucStvK29obDJMT0FPVTBNQTBHQ1NxR1NJYjNEUUVCQ3dVQU1JRzNNUXN3Q1FZRFZRUUdFd0pFUlRFUE1BMEdBMVVFQ0F3R1FtVnliR2x1TVE4d0RRWURWUVFIREFaQ1pYSnNhVzR4UlRCREJnTlZCQW9NUEZabGNtVnBiaUI2ZFhJZ1JtOWxjbVJsY25WdVp5QmxhVzVsY3lCRVpYVjBjMk5vWlc0Z1JtOXljMk5vZFc1bmMyNWxkSHBsY3lCbExpQldMakVjTUJvR0ExVUVBd3dUZEdWemRHbGtjREl1WVdGcExtUm1iaTVrWlRFaE1COEdDU3FHU0liM0RRRUpBUllTYUc5MGJHbHVaVUJoWVdrdVpHWnVMbVJsTUI0WERUSXlNRGd4T0RFek5UUXlNVm9YRFRJMU1EZ3hOekV6TlRReU1Wb3dnYmN4Q3pBSkJnTlZCQVlUQWtSRk1ROHdEUVlEVlFRSURBWkNaWEpzYVc0eER6QU5CZ05WQkFjTUJrSmxjbXhwYmpGRk1FTUdBMVVFQ2d3OFZtVnlaV2x1SUhwMWNpQkdiMlZ5WkdWeWRXNW5JR1ZwYm1WeklFUmxkWFJ6WTJobGJpQkdiM0p6WTJoMWJtZHpibVYwZW1WeklHVXVJRll1TVJ3d0dnWURWUVFEREJOMFpYTjBhV1J3TWk1aFlXa3VaR1p1TG1SbE1TRXdId1lKS29aSWh2Y05BUWtCRmhKb2IzUnNhVzVsUUdGaGFTNWtabTR1WkdVd2dnSWlNQTBHQ1NxR1NJYjNEUUVCQVFVQUE0SUNEd0F3Z2dJS0FvSUNBUUM4eGM5Q2x3Zm51RDRqbW91WklkTzRaN0FwcXFEL0VkS1FUTnJzL2QwQldEaXdleVVGMjA4M21lQ2dEWVBiSG4vUFBUdndHek56TmhKNVdWY2ZrbVB5Y25rUmQ2d1IwRk9WWk9UVjZyaTFiTFZmWjlZSndBdHV6cEc4SlVDYkI1Yko4MHdZRk1OMlR4TWI5ZWZud2ZOY3VBT1drRnlnMllpSldDMWhEWFB1OW5KT1JXSExzT0dZNHNNZG5RRWlGWW1lWGZDeVlGTXZDUUFialcvT1Zhb0QvVGRIblJOeE56VkFvWFZLM2xoZnNBaU5xdTVsbXpZRTVNcHhDR1QzKytxaWdQeHBkblE3YjRVQzJKQ0s5dkdWMWxTNVM2NTZmSFozQ1V4allYRUpKUEFRVjNKYnl3QnFrWDcxaUd0RXJNVVMxeUtFQm5FdEg2Q0NvbHlIeG1LQUFMVWovRzRVZmdwUmM2NDUwTVhpWkZVeEUwTmpEYlR1SGF6YTZ2MkVGTERuSkdCQWIraEJVN3BBV3Z4M3ExcC9YaEFOeFVYZGtMelBGaXpIUURQOGQxRmc4RlhhNnRLeVQ2V2ZlK0RzYzR3VzFTNEFBSlRSNk41aXVJeWtPQWJOWVNPTGdyZWIwSm9XUVF4UGlPanJOR1E1NHBlazJkbXhkUHkxRFdHNitRMGJpV28wZFVZczNrMGplMWc4eEtSR0YwajYwZUJGeGdTZjZDZEdoTWQraElrQ3htLzlSNHNmU0Jrc29NRU1HYTkwSUFNL1lqaTRzNFJpcXFIa3dPMGc1am4rOEUzY0lQRGpBTTdlVUxNWHBpRlltSGZmb0JQbHRwV2FsbStWaDdmbkR5NTkwQnVsd3JPNjRIMVJ5OWc2eGhRb01IRDRXNXd3T1cyMFcwRG1YUUlEQVFBQk1BMEdDU3FHU0liM0RRRUJDd1VBQTRJQ0FRQ2N2QWgrNVhYSUE2eG5zUTlYOHJrWnlvY3BLWTVGdjc3MEFtZmVyOVpBbGtDY0pWRmFrRnhkczc0T1l1eFdqMW94bGxEMDZQQ3BKU2pIVngzOUsyaFJzKzI0MnpTUHVsS0Z3R0IxcW4rNDQvWHVxWnZrRFpyOXFEaWk3WmljSGMveHpqZkN0OXVRb2hMczUweDhiQjdCMTU4MVNrMXdJVHNOQ2txRFd6bFUwUlJBeUhWbTlXYnVWdnNmNGlNYWxjVXlKY2FDdUpzQkpHYzJHZTVmWVhjZy9hU01HLzd0MDNDbXUrTUhHTUpyMFpNeExoMkZNVmkvc2pJWGMzLy9adGQzeWNlMTk4Q0ovRTgvYlVPS3pHMC9ZYWt1eGxucXE2Zm5qWFBpV3NrVU9TT2tObGlFWHI3MHpxckNFQmhJMU9aUk5ZTERNVWQxeFVFcGVvZWpCR2s1cFhRWEhzQWtadzhUaHpVR0szQ1hPaWFkVFhTdjFjQmVmU1FSVFJxQlc2V2pVK1luaXJGM3N2Rk1DSXhqU3BVT1REdmtNOTRyQS9WMWRBWXIxQXVFYlp1Sis2eHpReXJuTy9QMDVNQmNjT0dLemZPTEFFTldqWmlMYjB5c2phTDQ2ajB1T2Q0MmpjYmNPNUJTMU1YTitSVVV3UDgxUFlWb3QxTGZ2bzhiL2lNUmFQNnRsQytoc2lseUQ5Q2t3d01saFhqMDNXK1RONUlZaFc5bHlvYWhuZTJ2OFgrczFrL1pJYklnSmRzVDM4Z1JId2trL1Q5NzRrSGMwSVFBeExJNjlLMEl2VmJWRDlMOG5RVndka2ZadWVWREhjR1ZBMnk0bzV4UzBCZGozRXMrYmYwUi9KYUY1TmVXVEM4VEdhMTlkVEhhc1ZDV3NxVFU4NkxqVWs1ajdRPT08L2RzOlg1MDlDZXJ0aWZpY2F0ZT48L2RzOlg1MDlEYXRhPjwvZHM6S2V5SW5mbz48L21kOktleURlc2NyaXB0b3I+PG1kOkF0dHJpYnV0ZVNlcnZpY2UgQmluZGluZz0idXJuOm9hc2lzOm5hbWVzOnRjOlNBTUw6Mi4wOmJpbmRpbmdzOlNPQVAiIExvY2F0aW9uPSJodHRwczovL3Rlc3RpZHAyLmFhaS5kZm4uZGU6ODQ0My9pZHAvcHJvZmlsZS9TQU1MMi9TT0FQL0F0dHJpYnV0ZVF1ZXJ5Ii8+PG1kOk5hbWVJREZvcm1hdD51cm46b2FzaXM6bmFtZXM6dGM6U0FNTDoyLjA6bmFtZWlkLWZvcm1hdDpwZXJzaXN0ZW50PC9tZDpOYW1lSURGb3JtYXQ+PG1kOk5hbWVJREZvcm1hdD51cm46b2FzaXM6bmFtZXM6dGM6U0FNTDoyLjA6bmFtZWlkLWZvcm1hdDp0cmFuc2llbnQ8L21kOk5hbWVJREZvcm1hdD48L21kOkF0dHJpYnV0ZUF1dGhvcml0eURlc2NyaXB0b3I+PG1kOk9yZ2FuaXphdGlvbj48bWQ6T3JnYW5pemF0aW9uTmFtZSB4bWw6bGFuZz0iZGUiPmUxNTwvbWQ6T3JnYW5pemF0aW9uTmFtZT48bWQ6T3JnYW5pemF0aW9uTmFtZSB4bWw6bGFuZz0iZW4iPmUxNTwvbWQ6T3JnYW5pemF0aW9uTmFtZT48bWQ6T3JnYW5pemF0aW9uRGlzcGxheU5hbWUgeG1sOmxhbmc9ImRlIj5ERk4tVmVyZWluIC0gRGV1dHNjaGVzIEZvcnNjaHVuZ3NuZXR6PC9tZDpPcmdhbml6YXRpb25EaXNwbGF5TmFtZT48bWQ6T3JnYW5pemF0aW9uRGlzcGxheU5hbWUgeG1sOmxhbmc9ImVuIj5HZXJtYW4gTmF0aW9uYWwgUmVzZWFyY2ggYW5kIEVkdWNhdGlvbiBOZXR3b3JrLCBERk48L21kOk9yZ2FuaXphdGlvbkRpc3BsYXlOYW1lPjxtZDpPcmdhbml6YXRpb25VUkwgeG1sOmxhbmc9ImRlIj5odHRwOi8vd3d3LmRmbi5kZTwvbWQ6T3JnYW5pemF0aW9uVVJMPjxtZDpPcmdhbml6YXRpb25VUkwgeG1sOmxhbmc9ImVuIj5odHRwOi8vd3d3LmRmbi5kZS9lbi88L21kOk9yZ2FuaXphdGlvblVSTD48L21kOk9yZ2FuaXphdGlvbj48bWQ6Q29udGFjdFBlcnNvbiBjb250YWN0VHlwZT0iYWRtaW5pc3RyYXRpdmUiPjxtZDpHaXZlbk5hbWU+REZOLUFBSTwvbWQ6R2l2ZW5OYW1lPjxtZDpTdXJOYW1lPkhvdGxpbmU8L21kOlN1ck5hbWU+PG1kOkVtYWlsQWRkcmVzcz5tYWlsdG86aG90bGluZUBhYWkuZGZuLmRlPC9tZDpFbWFpbEFkZHJlc3M+PC9tZDpDb250YWN0UGVyc29uPjxtZDpDb250YWN0UGVyc29uIGNvbnRhY3RUeXBlPSJvdGhlciIgcmVtZDpjb250YWN0VHlwZT0iaHR0cDovL3JlZmVkcy5vcmcvbWV0YWRhdGEvY29udGFjdFR5cGUvc2VjdXJpdHkiPjxtZDpHaXZlbk5hbWU+REZOLUFBSSBUZWFtPC9tZDpHaXZlbk5hbWU+PG1kOkVtYWlsQWRkcmVzcz5tYWlsdG86aG90bGluZUBhYWkuZGZuLmRlPC9tZDpFbWFpbEFkZHJlc3M+PC9tZDpDb250YWN0UGVyc29uPjxtZDpDb250YWN0UGVyc29uIGNvbnRhY3RUeXBlPSJzdXBwb3J0Ij48bWQ6R2l2ZW5OYW1lPkRGTiBBQUk8L21kOkdpdmVuTmFtZT48bWQ6U3VyTmFtZT5Ib3RsaW5lPC9tZDpTdXJOYW1lPjxtZDpFbWFpbEFkZHJlc3M+bWFpbHRvOmhvdGxpbmVAYWFpLmRmbi5kZTwvbWQ6RW1haWxBZGRyZXNzPjwvbWQ6Q29udGFjdFBlcnNvbj48bWQ6Q29udGFjdFBlcnNvbiBjb250YWN0VHlwZT0idGVjaG5pY2FsIj48bWQ6R2l2ZW5OYW1lPkRGTi1BQUk8L21kOkdpdmVuTmFtZT48bWQ6U3VyTmFtZT5Ib3RsaW5lPC9tZDpTdXJOYW1lPjxtZDpFbWFpbEFkZHJlc3M+bWFpbHRvOmhvdGxpbmVAYWFpLmRmbi5kZTwvbWQ6RW1haWxBZGRyZXNzPjwvbWQ6Q29udGFjdFBlcnNvbj48L21kOkVudGl0eURlc2NyaXB0b3I+',
+    'description' =>
+        [
+            'de' => 'e15',
+            'en' => 'e15',
+        ],
+    'OrganizationName' =>
+        [
+            'de' => 'e15',
+            'en' => 'e15',
+        ],
+    'name' =>
+        [
+            'de' => 'DFN: Offizieller öffentlicher Test-IdP',
+            'en' => 'DFN: Official public test IdP',
+        ],
+    'OrganizationDisplayName' =>
+        [
+            'de' => 'DFN-Verein - Deutsches Forschungsnetz',
+            'en' => 'German National Research and Education Network, DFN',
+        ],
+    'url' =>
+        [
+            'de' => 'http://www.dfn.de',
+            'en' => 'http://www.dfn.de/en/',
+        ],
+    'OrganizationURL' =>
+        [
+            'de' => 'http://www.dfn.de',
+            'en' => 'http://www.dfn.de/en/',
+        ],
+    'contacts' =>
+        [
+            0 =>
+                [
+                    'contactType' => 'administrative',
+                    'givenName' => 'DFN-AAI',
+                    'surName' => 'Hotline',
+                    'emailAddress' =>
+                        [
+                            0 => 'hotline@aai.dfn.de',
+                        ],
+                ],
+            1 =>
+                [
+                    'contactType' => 'other',
+                    'givenName' => 'DFN-AAI Team',
+                    'emailAddress' =>
+                        [
+                            0 => 'hotline@aai.dfn.de',
+                        ],
+                ],
+            2 =>
+                [
+                    'contactType' => 'support',
+                    'givenName' => 'DFN AAI',
+                    'surName' => 'Hotline',
+                    'emailAddress' =>
+                        [
+                            0 => 'hotline@aai.dfn.de',
+                        ],
+                ],
+            3 =>
+                [
+                    'contactType' => 'technical',
+                    'givenName' => 'DFN-AAI',
+                    'surName' => 'Hotline',
+                    'emailAddress' =>
+                        [
+                            0 => 'hotline@aai.dfn.de',
+                        ],
+                ],
+        ],
+    'metadata-set' => 'saml20-idp-remote',
+    'SingleSignOnService' =>
+        [
+            0 =>
+                [
+                    'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
+                    'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/POST/SSO',
+                ],
+            1 =>
+                [
+                    'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST-SimpleSign',
+                    'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/POST-SimpleSign/SSO',
+                ],
+            2 =>
+                [
+                    'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
+                    'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/Redirect/SSO',
+                ],
+            3 =>
+                [
+                    'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
+                    'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/SOAP/ECP',
+                ],
+        ],
+    'SingleLogoutService' =>
+        [
+            0 =>
+                [
+                    'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
+                    'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/POST/SLO',
+                ],
+            1 =>
+                [
+                    'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST-SimpleSign',
+                    'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/POST-SimpleSign/SLO',
+                ],
+            2 =>
+                [
+                    'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
+                    'Location' => 'https://testidp2.aai.dfn.de/idp/profile/SAML2/Redirect/SLO',
+                ],
+            3 =>
+                [
+                    'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
+                    'Location' => 'https://testidp2.aai.dfn.de:8443/idp/profile/SAML2/SOAP/SLO',
+                ],
+        ],
+    'ArtifactResolutionService' =>
+        [
+            0 =>
+                [
+                    'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP',
+                    'Location' => 'https://testidp2.aai.dfn.de:8443/idp/profile/SAML2/SOAP/ArtifactResolution',
+                    'index' => 2,
+                ],
+        ],
+    'NameIDFormats' =>
+        [
+            0 => 'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent',
+            1 => 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient',
+        ],
+    'keys' =>
+        [
+            0 =>
+                [
+                    'encryption' => true,
+                    'signing' => true,
+                    'type' => 'X509Certificate',
+                    'X509Certificate' => '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',
+                ],
+        ],
+    'scope' =>
+        [
+            0 => 'testscope.aai.dfn.de',
+        ],
+    'RegistrationInfo' =>
+        [
+            'registrationAuthority' => 'https://www.aai.dfn.de',
+        ],
+    'UIInfo' =>
+        [
+            'DisplayName' =>
+                [
+                    'de' => 'DFN: Offizieller öffentlicher Test-IdP',
+                    'en' => 'DFN: Official public test IdP',
+                ],
+            'Description' =>
+                [
+                    'de' => 'IdP der DFN-AAI-Testumgebung (SAML2 Web-SSO)',
+                    'en' => 'IdP of the DFN-AAI test environment (SAML2 Web-SSO)',
+                ],
+            'InformationURL' =>
+                [
+                    'de' => 'https://www.dfn.de',
+                    'en' => 'https://www.dfn.de',
+                ],
+            'PrivacyStatementURL' =>
+                [
+                    'de' => 'https://www.aai.dfn.de/fileadmin/documents/datenschutz/test-idp.html',
+                ],
+            'Logo' =>
+                [
+                    0 =>
+                        [
+                            'url' => 'https://testidp2.aai.dfn.de/idp/images/logo.png',
+                            'height' => 131,
+                            'width' => 236,
+                        ],
+                    1 =>
+                        [
+                            'url' => 'https://testidp2.aai.dfn.de/idp/images/favicon.ico',
+                            'height' => 16,
+                            'width' => 16,
+                        ],
+                ],
+        ],
+    'tags' =>
+        [
+            0 => 'dfntest',
+        ],
+    'authproc' =>
+        [
+        ],
+];
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
