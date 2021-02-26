# Vorbereitungen für den produktiven Betrieb

## Links
* [SimpleSAMLphp Documentation > Maintenance and configuration > 7 Getting ready for production](https://simplesamlphp.org/docs/stable/simplesamlphp-maintenance#section_7)

## Teilschritte
* `config/config.php`
* `config/authsources.php`
* ...

[//]: # (AUTOGENERATE START)
## Anpassungen
### Änderungen
* [Dockerfile](../blob/main/08_production/Dockerfile):
```diff
@@ -82,7 +82,11 @@
     && a2dissite 000-default \
     && a2ensite sso-dev.fau.de sso-dev.fau.de-ssl \
     && rm /var/www/html/index.html \
-    && chown www-data /var/simplesamlphp/metadata
+    && chown www-data /var/simplesamlphp/metadata \
+    && rm -fR /var/simplesamlphp/metadata/adfs*.php \
+    && rm -fR /var/simplesamlphp/metadata/saml20-sp-remote.php \
+    && rm -fR /var/simplesamlphp/metadata/shib13*.php \
+    && rm -fR /var/simplesamlphp/metadata/wsfed*.php
 
 WORKDIR /var/simplesamlphp
 
```
* [resources/var/simplesamlphp/config/authsources.php](../blob/main/08_production/resources/var/simplesamlphp/config/authsources.php):
```diff
@@ -91,272 +91,4 @@
             ],
         ],
     ],
-
-
-    /*
-    'example-sql' => [
-        'sqlauth:SQL',
-        'dsn' => 'pgsql:host=sql.example.org;port=5432;dbname=simplesaml',
-        'username' => 'simplesaml',
-        'password' => 'secretpassword',
-        'query' => 'SELECT uid, givenName, email, eduPersonPrincipalName FROM users WHERE uid = :username ' .
-            'AND password = SHA2(CONCAT((SELECT salt FROM users WHERE uid = :username), :password), 256);',
-    ],
-    */
-
-    /*
-    'example-static' => [
-        'exampleauth:StaticSource',
-        'uid' => ['testuser'],
-        'eduPersonAffiliation' => ['member', 'employee'],
-        'cn' => ['Test User'],
-    ],
-    */
-
-    /*
-    'example-userpass' => [
-        'exampleauth:UserPass',
-
-        // Give the user an option to save their username for future login attempts
-        // And when enabled, what should the default be, to save the username or not
-        //'remember.username.enabled' => false,
-        //'remember.username.checked' => false,
-
-        'student:studentpass' => [
-            'uid' => ['test'],
-            'eduPersonAffiliation' => ['member', 'student'],
-        ],
-        'employee:employeepass' => [
-            'uid' => ['employee'],
-            'eduPersonAffiliation' => ['member', 'employee'],
-        ],
-    ],
-    */
-
-    /*
-    'crypto-hash' => [
-        'authcrypt:Hash',
-        // hashed version of 'verysecret', made with bin/pwgen.php
-        'professor:{SSHA256}P6FDTEEIY2EnER9a6P2GwHhI5JDrwBgjQ913oVQjBngmCtrNBUMowA==' => [
-            'uid' => ['prof_a'],
-            'eduPersonAffiliation' => ['member', 'employee', 'board'],
-        ],
-    ],
-    */
-
-    /*
-    'htpasswd' => [
-        'authcrypt:Htpasswd',
-        'htpasswd_file' => '/var/www/foo.edu/legacy_app/.htpasswd',
-        'static_attributes' => [
-            'eduPersonAffiliation' => ['member', 'employee'],
-            'Organization' => ['University of Foo'],
-        ],
-    ],
-    */
-
-    /*
-    // This authentication source serves as an example of integration with an
-    // external authentication engine. Take a look at the comment in the beginning
-    // of modules/exampleauth/lib/Auth/Source/External.php for a description of
-    // how to adjust it to your own site.
-    'example-external' => [
-        'exampleauth:External',
-    ],
-    */
-
-    /*
-    'yubikey' => [
-        'authYubiKey:YubiKey',
-         'id' => '000',
-        // 'key' => '012345678',
-    ],
-    */
-
-    /*
-    'facebook' => [
-        'authfacebook:Facebook',
-        // Register your Facebook application on http://www.facebook.com/developers
-        // App ID or API key (requests with App ID should be faster; https://github.com/facebook/php-sdk/issues/214)
-        'api_key' => 'xxxxxxxxxxxxxxxx',
-        // App Secret
-        'secret' => 'xxxxxxxxxxxxxxxx',
-        // which additional data permissions to request from user
-        // see http://developers.facebook.com/docs/authentication/permissions/ for the full list
-        // 'req_perms' => 'email,user_birthday',
-        // Which additional user profile fields to request.
-        // When empty, only the app-specific user id and name will be returned
-        // See https://developers.facebook.com/docs/graph-api/reference/v2.6/user for the full list
-        // 'user_fields' => 'email,birthday,third_party_id,name,first_name,last_name',
-    ],
-    */
-
-    /*
-    // LinkedIn OAuth Authentication API.
-    // Register your application to get an API key here:
-    //  https://www.linkedin.com/secure/developer
-    // Attributes definition:
-    //  https://developer.linkedin.com/docs/fields
-    'linkedin' => [
-        'authlinkedin:LinkedIn',
-        'key' => 'xxxxxxxxxxxxxxxx',
-        'secret' => 'xxxxxxxxxxxxxxxx',
-        'attributes' => 'id,first-name,last-name,headline,summary,specialties,picture-url,email-address',
-    ],
-    */
-
-    /*
-    // Microsoft Account (Windows Live ID) Authentication API.
-    // Register your application to get an API key here:
-    //  https://apps.dev.microsoft.com/
-    'windowslive' => [
-        'authwindowslive:LiveID',
-        'key' => 'xxxxxxxxxxxxxxxx',
-        'secret' => 'xxxxxxxxxxxxxxxx',
-    ],
-    */
-
-    /*
-    // Example of a LDAP authentication source.
-    'example-ldap' => [
-        'ldap:LDAP',
-
-        // Give the user an option to save their username for future login attempts
-        // And when enabled, what should the default be, to save the username or not
-        //'remember.username.enabled' => false,
-        //'remember.username.checked' => false,
-
-        // The hostname of the LDAP server.
-        'hostname' => 'ldap.example.org',
-
-        // Whether SSL/TLS should be used when contacting the LDAP server.
-        'enable_tls' => true,
-
-        // Whether debug output from the LDAP library should be enabled.
-        // Default is FALSE.
-        'debug' => false,
-
-        // The timeout for accessing the LDAP server, in seconds.
-        // The default is 0, which means no timeout.
-        'timeout' => 0,
-
-        // The port used when accessing the LDAP server.
-        // The default is 389.
-        'port' => 389,
-
-        // Set whether to follow referrals. AD Controllers may require FALSE to function.
-        'referrals' => true,
-
-        // Which attributes should be retrieved from the LDAP server.
-        // This can be an array of attribute names, or NULL, in which case
-        // all attributes are fetched.
-        'attributes' => null,
-
-        // The pattern which should be used to create the users DN given the username.
-        // %username% in this pattern will be replaced with the users username.
-        //
-        // This option is not used if the search.enable option is set to TRUE.
-        'dnpattern' => 'uid=%username%,ou=people,dc=example,dc=org',
-
-        // As an alternative to specifying a pattern for the users DN, it is possible to
-        // search for the username in a set of attributes. This is enabled by this option.
-        'search.enable' => false,
-
-        // The DN which will be used as a base for the search.
-        // This can be a single string, in which case only that DN is searched, or an
-        // array of strings, in which case they will be searched in the order given.
-        'search.base' => 'ou=people,dc=example,dc=org',
-
-        // The attribute(s) the username should match against.
-        //
-        // This is an array with one or more attribute names. Any of the attributes in
-        // the array may match the value the username.
-        'search.attributes' => ['uid', 'mail'],
-
-        // Additional LDAP filters appended to the search attributes
-        //'search.filter' => '(objectclass=inetorgperson)',
-
-        // The username & password the SimpleSAMLphp should bind to before searching. If
-        // this is left as NULL, no bind will be performed before searching.
-        'search.username' => null,
-        'search.password' => null,
-
-        // If the directory uses privilege separation,
-        // the authenticated user may not be able to retrieve
-        // all required attribures, a privileged entity is required
-        // to get them. This is enabled with this option.
-        'priv.read' => false,
-
-        // The DN & password the SimpleSAMLphp should bind to before
-        // retrieving attributes. These options are required if
-        // 'priv.read' is set to TRUE.
-        'priv.username' => null,
-        'priv.password' => null,
-
-    ],
-    */
-
-    /*
-    // Example of an LDAPMulti authentication source.
-    'example-ldapmulti' => [
-        'ldap:LDAPMulti',
-
-        // Give the user an option to save their username for future login attempts
-        // And when enabled, what should the default be, to save the username or not
-        //'remember.username.enabled' => false,
-        //'remember.username.checked' => false,
-
-        // Give the user an option to save their organization choice for future login
-        // attempts. And when enabled, what should the default be, checked or not.
-        //'remember.organization.enabled' => false,
-        //'remember.organization.checked' => false,
-
-        // The way the organization as part of the username should be handled.
-        // Three possible values:
-        // - 'none':   No handling of the organization. Allows '@' to be part
-        //             of the username.
-        // - 'allow':  Will allow users to type 'username@organization'.
-        // - 'force':  Force users to type 'username@organization'. The dropdown
-        //             list will be hidden.
-        //
-        // The default is 'none'.
-        'username_organization_method' => 'none',
-
-        // Whether the organization should be included as part of the username
-        // when authenticating. If this is set to TRUE, the username will be on
-        // the form <username>@<organization identifier>. If this is FALSE, the
-        // username will be used as the user enters it.
-        //
-        // The default is FALSE.
-        'include_organization_in_username' => false,
-
-        // A list of available LDAP servers.
-        //
-        // The index is an identifier for the organization/group. When
-        // 'username_organization_method' is set to something other than 'none',
-        // the organization-part of the username is matched against the index.
-        //
-        // The value of each element is an array in the same format as an LDAP
-        // authentication source.
-        'employees' => [
-            // A short name/description for this group. Will be shown in a dropdown list
-            // when the user logs on.
-            //
-            // This option can be a string or an array with language => text mappings.
-            'description' => 'Employees',
-
-            // The rest of the options are the same as those available for
-            // the LDAP authentication source.
-            'hostname' => 'ldap.employees.example.org',
-            'dnpattern' => 'uid=%username%,ou=employees,dc=example,dc=org',
-        ],
-
-        'students' => [
-            'description' => 'Students',
-
-            'hostname' => 'ldap.students.example.org',
-            'dnpattern' => 'uid=%username%,ou=students,dc=example,dc=org',
-        ],
-    ],
-    */
 ];
```
* [resources/var/simplesamlphp/config/config-metarefresh.php](../blob/main/08_production/resources/var/simplesamlphp/config/config-metarefresh.php):
```diff
@@ -6,6 +6,11 @@
             'cron'		=> ['hourly'],
             'sources'	=> [
                 [
+                    'whitelist'     => [
+                        'https://testidp.aai.dfn.de/idp/shibboleth',
+                        'https://testidp2-dev.aai.dfn.de/idp/shibboleth',
+                        'https://testidp3-dev.aai.dfn.de/idp/shibboleth',
+                    ],
                     'src' => 'http://www.aai.dfn.de/fileadmin/metadata/dfn-aai-test-metadata.xml',
                     'certificates' => ['dfn-aai.pem'],
                     //'validateFingerprint' => 'cbf57ce9e8b1bf2abd0605bd943a0ce505829325',
@@ -23,6 +28,7 @@
                     ],
                 ],
             ],
+            'types'         => ['saml20-idp-remote'],
             'expireAfter'   => 60*60*24*4, // Maximum 4 days cache time.
             'outputDir' 	=> 'metadata/dfntest/',
             'outputFormat'  => 'flatfile',
@@ -31,6 +37,9 @@
 			'cron'		=> ['hourly'],
 			'sources'	=> [
                 [
+                    'whitelist'     => [
+                        'https://www.sso.uni-erlangen.de/simplesaml/saml2/idp/metadata.php',
+                    ],
 					'src' => 'http://www.aai.dfn.de/fileadmin/metadata/dfn-aai-basic-metadata.xml',
                     'certificates' => ['dfn-aai.pem'],
 					//'validateFingerprint' => 'cbf57ce9e8b1bf2abd0605bd943a0ce505829325',
@@ -48,6 +57,7 @@
 					],
 				],
 			],
+            'types'         => ['saml20-idp-remote'],
 			'expireAfter' 	=> 60*60*24*4, // Maximum 4 days cache time.
 			'outputDir' 	=> 'metadata/dfn/',
 			'outputFormat'  => 'flatfile',
```
* [resources/var/simplesamlphp/config/config.php](../blob/main/08_production/resources/var/simplesamlphp/config/config.php):
```diff
@@ -144,7 +144,7 @@
      * Set this options to true if you want to require administrator password to access the web interface
      * or the metadata pages, respectively.
      */
-    'admin.protectindexpage' => false,
+    'admin.protectindexpage' => true,
     'admin.protectmetadata' => false,
 
     /*
@@ -249,7 +249,7 @@
      * empty array.
      */
     'debug' => [
-        'saml' => true,
+        'saml' => false,
         'backtraces' => true,
         'validatexml' => false,
     ],
@@ -261,7 +261,7 @@
      * When 'errorreporting' is enabled, a form will be presented for the user to report
      * the error to 'technicalcontact_email'.
      */
-    'showerrors' => true,
+    'showerrors' => false,
     'errorreporting' => true,
 
     /*
@@ -291,7 +291,7 @@
      * Options: [syslog,file,errorlog,stderr]
      *
      */
-    'logging.level' => SimpleSAML\Logger::DEBUG,
+    'logging.level' => SimpleSAML\Logger::NOTICE,
     'logging.handler' => 'syslog',
 
     /*
@@ -785,11 +785,12 @@
     /*
      * Languages available, RTL languages, and what language is the default.
      */
-    'language.available' => [
-        'en', 'no', 'nn', 'se', 'da', 'de', 'sv', 'fi', 'es', 'ca', 'fr', 'it', 'nl', 'lb',
-        'cs', 'sl', 'lt', 'hr', 'hu', 'pl', 'pt', 'pt-br', 'tr', 'ja', 'zh', 'zh-tw', 'ru',
-        'et', 'he', 'id', 'sr', 'lv', 'ro', 'eu', 'el', 'af', 'zu', 'xh', 'st',
-    ],
+//    'language.available' => [
+//        'en', 'no', 'nn', 'se', 'da', 'de', 'sv', 'fi', 'es', 'ca', 'fr', 'it', 'nl', 'lb',
+//        'cs', 'sl', 'lt', 'hr', 'hu', 'pl', 'pt', 'pt-br', 'tr', 'ja', 'zh', 'zh-tw', 'ru',
+//        'et', 'he', 'id', 'sr', 'lv', 'ro', 'eu', 'el', 'af', 'zu', 'xh', 'st',
+//    ],
+    'language.available' => ['en', 'de'],
     'language.rtl' => ['ar', 'dv', 'fa', 'ur', 'he'],
     'language.default' => 'de',
 
@@ -957,7 +958,7 @@
      *
      * Options: [links,dropdown]
      */
-    'idpdisco.layout' => 'dropdown',
+    'idpdisco.layout' => 'links',
 
 
 
```

[//]: # (AUTOGENERATE END)
