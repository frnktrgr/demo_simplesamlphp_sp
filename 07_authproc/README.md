# Grundlagen der Authentication Processing Filters

## Links
* [SimpleSAMLphp Documentation > Authentication Processing Filters](https://simplesamlphp.org/docs/stable/simplesamlphp-authproc)

## Teilschritte
* `config/config.php`
* `config/authsources.php`
* `metadata/saml20-idp-remote.php`

[//]: # (AUTOGENERATE START)
## Anpassungen
### Änderungen
* [resources/var/simplesamlphp/config/config-metarefresh.php](../../../blob/main/07_authproc/resources/var/simplesamlphp/config/config-metarefresh.php):
```diff
@@ -11,6 +11,15 @@
                     //'validateFingerprint' => 'cbf57ce9e8b1bf2abd0605bd943a0ce505829325',
                     'template' => [
                         'tags' => ['dfntest'],
+                        'authproc'  => [
+                            50 => array(
+                                'class' => 'core:GenerateGroups',
+                                'eduPersonScopedAffiliation',
+                            ),
+                            90 => [
+                                'class' => 'saml:FilterScopes',
+                            ],
+                        ],
                     ],
                 ],
             ],
@@ -27,6 +36,15 @@
 					//'validateFingerprint' => 'cbf57ce9e8b1bf2abd0605bd943a0ce505829325',
 					'template' => [
 						'tags'	    => ['dfn'],
+                        'authproc'  => [
+                            50 => array(
+                                'class' => 'core:GenerateGroups',
+                                'eduPersonScopedAffiliation',
+                            ),
+                            90 => [
+                                'class' => 'saml:FilterScopes',
+                            ],
+                        ],
 					],
 				],
 			],
```
* [resources/var/simplesamlphp/config/config.php](../../../blob/main/07_authproc/resources/var/simplesamlphp/config/config.php):
```diff
@@ -1026,6 +1026,9 @@
      * Both Shibboleth and SAML 2.0
      */
     'authproc.sp' => [
+        10 => [
+            'class' => 'core:AttributeMap', 'oid2name'
+        ],
         /*
         10 => [
             'class' => 'core:AttributeMap', 'removeurnprefix'
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
