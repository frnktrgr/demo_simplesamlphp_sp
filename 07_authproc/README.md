# Grundlagen der Authentication Processing Filters

## Links
* [SimpleSAMLphp Documentation > Authentication Processing Filters](https://simplesamlphp.org/docs/stable/simplesamlphp-authproc.html)

## Teilschritte
* `config/config.php`
* `config/authsources.php`
* `metadata/saml20-idp-remote.php`

[//]: # (AUTOGENERATE START)
## Anpassungen
### Änderungen
* [resources/var/simplesamlphp/config/config.php](../../../blob/main/07_authproc/resources/var/simplesamlphp/config/config.php):
```diff
@@ -1036,6 +1036,9 @@
      * Authentication processing filters that will be executed for all SPs
      */
     'authproc.sp' => [
+        10 => [
+            'class' => 'core:AttributeMap', 'oid2name'
+        ],
         /*
         10 => [
             'class' => 'core:AttributeMap', 'removeurnprefix'
```
* [resources/var/simplesamlphp/config/module_metarefresh.php](../../../blob/main/07_authproc/resources/var/simplesamlphp/config/module_metarefresh.php):
```diff
@@ -42,6 +42,10 @@
                     'certificates' => ['dfn-aai.pem'],
                     'template' => [
                         'tags' => ['dfntest'],
+                        'authproc' => [
+                            40 => ['class' => 'saml:FilterScopes'],
+                            50 => ['class' => 'core:GenerateGroups', 'eduPersonScopedAffiliation'],
+                        ],
                     ],
                 ],
             ],
@@ -59,6 +63,10 @@
                     'certificates' => ['dfn-aai.pem'],
                     'template' => [
                         'tags' => ['dfn'],
+                        'authproc' => [
+                            40 => ['class' => 'saml:FilterScopes'],
+                            50 => ['class' => 'core:GenerateGroups', 'eduPersonScopedAffiliation'],
+                        ],
                     ],
                 ],
             ],
```
* [resources/var/www/html/mapa_sso.php](../../../blob/main/07_authproc/resources/var/www/html/mapa_sso.php):
```diff
@@ -42,17 +42,17 @@
 if ($as->isAuthenticated()) {
     if ($_SESSION['ssp']) {
         // check if remote user changed
-        if (isset($attributes['urn:oid:1.3.6.1.4.1.5923.1.1.1.6'])) {
-            if ($_SESSION['ssp_username'] != $attributes['urn:oid:1.3.6.1.4.1.5923.1.1.1.6'][0]) {
+        if (isset($attributes['eduPersonPrincipalName'])) {
+            if ($_SESSION['ssp_username'] != $attributes['eduPersonPrincipalName'][0]) {
                 // logout user? switch to new user? ...
-                $_SESSION['ssp_username'] = $attributes['urn:oid:1.3.6.1.4.1.5923.1.1.1.6'][0];
+                $_SESSION['ssp_username'] = $attributes['eduPersonPrincipalName'][0];
             }
         }
     } else {
         // init app session
         $_SESSION['ssp'] = true;
-        if (isset($attributes['urn:oid:1.3.6.1.4.1.5923.1.1.1.6'])) {
-            $_SESSION['ssp_username'] = $attributes['urn:oid:1.3.6.1.4.1.5923.1.1.1.6'][0];
+        if (isset($attributes['eduPersonPrincipalName'])) {
+            $_SESSION['ssp_username'] = $attributes['eduPersonPrincipalName'][0];
             $_SESSION["mapa_authn"] = true;
             $_SESSION["mapa_authn_sso"] = true;
             $_SESSION["mapa_authn_timestamp"] = date(DATE_RFC822);
```

[//]: # (AUTOGENERATE END)
