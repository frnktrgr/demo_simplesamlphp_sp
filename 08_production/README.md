# Vorbereitungen für den produktiven Betrieb

## Links
* [SimpleSAMLphp Documentation > Maintenance and configuration > Getting ready for production](https://simplesamlphp.org/docs/stable/simplesamlphp-maintenance.html#getting-ready-for-production)

## Teilschritte
* `config/config.php`
* `config/authsources.php`
* ...

[//]: # (AUTOGENERATE START)
## Anpassungen
### Änderungen
* [resources/var/simplesamlphp/config/authsources.php](../../../blob/main/08_production/resources/var/simplesamlphp/config/authsources.php):
```diff
@@ -44,7 +44,7 @@
 
         // The URL to the discovery service.
         // Can be NULL/unset, in which case a builtin discovery service will be used.
-        'discoURL' => 'https://wayf.aai.dfn.de/DFN-AAI-Test/wayf',
+        'discoURL' => null,
 
         /*
          * If SP behind the SimpleSAMLphp in IdP/SP proxy mode requests
@@ -100,281 +100,4 @@
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
-        'users' => [
-            'student:studentpass' => [
-                'uid' => ['test'],
-                'eduPersonAffiliation' => ['member', 'student'],
-            ],
-            'employee:employeepass' => [
-                'uid' => ['employee'],
-                'eduPersonAffiliation' => ['member', 'employee'],
-            ],
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
-    // Twitter OAuth Authentication API.
-    // Register your application to get an API key here:
-    //  http://twitter.com/oauth_clients
-    'twitter' => [
-        'authtwitter:Twitter',
-        'key' => 'xxxxxxxxxxxxxxxx',
-        'secret' => 'xxxxxxxxxxxxxxxx',
-        // Forces the user to enter their credentials to ensure the correct users account is authorized.
-        // Details: https://dev.twitter.com/docs/api/1/get/oauth/authenticate
-        'force_login' => false,
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
-        'ldap:Ldap',
-
-        // The connection string for the LDAP-server.
-        // You can add multiple by separating them with a space.
-        'connection_string' => 'ldap.example.org',
-
-        // Whether SSL/TLS should be used when contacting the LDAP server.
-        // Possible values are 'ssl', 'tls' or 'none'
-        'encryption' => 'ssl',
-
-        // The LDAP version to use when interfacing the LDAP-server.
-        // Defaults to 3
-        'version' => 3,
-
-        // Set to TRUE to enable LDAP debug level. Passed to the LDAP connector class.
-        //
-        // Default: FALSE
-        // Required: No
-        'ldap.debug' => false,
-
-        // The LDAP-options to pass when setting up a connection
-        // See [Symfony documentation][1]
-        'options' => [
-
-            // Set whether to follow referrals.
-            // AD Controllers may require 0x00 to function.
-            // Possible values are 0x00 (NEVER), 0x01 (SEARCHING),
-            //   0x02 (FINDING) or 0x03 (ALWAYS).
-            'referrals' => 0x00,
-
-            'network_timeout' => 3,
-        ],
-
-        // The connector to use.
-        // Defaults to '\SimpleSAML\Module\ldap\Connector\Ldap', but can be set
-        // to '\SimpleSAML\Module\ldap\Connector\ActiveDirectory' when
-        // authenticating against Microsoft Active Directory. This will
-        // provide you with more specific error messages.
-        'connector' => '\SimpleSAML\Module\ldap\Connector\Ldap',
-
-        // Which attributes should be retrieved from the LDAP server.
-        // This can be an array of attribute names, or NULL, in which case
-        // all attributes are fetched.
-        'attributes' => null,
-
-         // Which attributes should be base64 encoded after retrieval from
-         // the LDAP server.
-        'attributes.binary' => [
-            'jpegPhoto',
-            'objectGUID',
-            'objectSid',
-            'mS-DS-ConsistencyGuid'
-        ],
-
-        // The pattern which should be used to create the user's DN given
-        // the username. %username% in this pattern will be replaced with
-        // the user's username.
-        //
-        // This option is not used if the search.enable option is set to TRUE.
-        'dnpattern' => 'uid=%username%,ou=people,dc=example,dc=org',
-
-        // As an alternative to specifying a pattern for the users DN, it is
-        // possible to search for the username in a set of attributes. This is
-        // enabled by this option.
-        'search.enable' => false,
-
-        // An array on DNs which will be used as a base for the search. In
-        // case of multiple strings, they will be searched in the order given.
-        'search.base' => [
-            'ou=people,dc=example,dc=org',
-        ],
-
-        // The scope of the search. Valid values are 'sub' and 'one' and
-        // 'base', first one being the default if no value is set.
-        'search.scope' => 'sub',
-
-        // The attribute(s) the username should match against.
-        //
-        // This is an array with one or more attribute names. Any of the
-        // attributes in the array may match the value the username.
-        'search.attributes' => ['uid', 'mail'],
-
-        // Additional filters that must match for the entire LDAP search to
-        // be true.
-        //
-        // This should be a single string conforming to [RFC 1960][2]
-        // and [RFC 2544][3]. The string is appended to the search attributes
-        'search.filter' => '(&(objectClass=Person)(|(sn=Doe)(cn=John *)))',
-
-        // The username & password where SimpleSAMLphp should bind to before
-        // searching. If this is left NULL, no bind will be performed before
-        // searching.
-        'search.username' => null,
-        'search.password' => null,
-    ],
-    */
-
-    /*
-    // Example of an LDAPMulti authentication source.
-    'example-ldapmulti' => [
-        'ldap:LdapMulti',
-
-         // The way the organization as part of the username should be handled.
-         // Three possible values:
-         // - 'none':   No handling of the organization. Allows '@' to be part
-         //             of the username.
-         // - 'allow':  Will allow users to type 'username@organization'.
-         // - 'force':  Force users to type 'username@organization'. The dropdown
-         //             list will be hidden.
-         //
-         // The default is 'none'.
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
-        'mapping' => [
-            'employees' => [
-                // A short name/description for this group. Will be shown in a
-                // dropdown list when the user logs on.
-                //
-                // This option can be a string or an array with
-                // language => text mappings.
-                'description' => 'Employees',
-                'authsource' => 'example-ldap',
-            ],
-
-            'students' => [
-                'description' => 'Students',
-                'authsource' => 'example-ldap-2',
-            ],
-        ],
-    ],
-    */
 ];
```
* [resources/var/simplesamlphp/config/config.php](../../../blob/main/08_production/resources/var/simplesamlphp/config/config.php):
```diff
@@ -325,7 +325,7 @@
      * empty array.
      */
     'debug' => [
-        'saml' => true,
+        'saml' => false,
         'backtraces' => true,
         'validatexml' => false,
     ],
@@ -337,7 +337,7 @@
      * When 'errorreporting' is enabled, a form will be presented for the user to report
      * the error to 'technicalcontact_email'.
      */
-    'showerrors' => true,
+    'showerrors' => false,
     'errorreporting' => true,
 
     /*
@@ -369,7 +369,7 @@
      * must exist and be writable for SimpleSAMLphp. If set to something else, set
      * loggingdir above to 'null'.
      */
-    'logging.level' => SimpleSAML\Logger::DEBUG,
+    'logging.level' => SimpleSAML\Logger::NOTICE,
     'logging.handler' => 'file',
 
     /*
@@ -825,11 +825,12 @@
     /*
      * Languages available, RTL languages, and what language is the default.
      */
-    'language.available' => [
-        'en', 'no', 'nn', 'se', 'da', 'de', 'sv', 'fi', 'es', 'ca', 'fr', 'it', 'nl', 'lb',
-        'cs', 'sk', 'sl', 'lt', 'hr', 'hu', 'pl', 'pt', 'pt_BR', 'tr', 'ja', 'zh', 'zh_TW',
-        'ru', 'et', 'he', 'id', 'sr', 'lv', 'ro', 'eu', 'el', 'af', 'zu', 'xh', 'st'
-    ],
+//    'language.available' => [
+//        'en', 'no', 'nn', 'se', 'da', 'de', 'sv', 'fi', 'es', 'ca', 'fr', 'it', 'nl', 'lb',
+//        'cs', 'sk', 'sl', 'lt', 'hr', 'hu', 'pl', 'pt', 'pt_BR', 'tr', 'ja', 'zh', 'zh_TW',
+//        'ru', 'et', 'he', 'id', 'sr', 'lv', 'ro', 'eu', 'el', 'af', 'zu', 'xh', 'st'
+//    ],
+    'language.available' => ['en', 'de'],
     'language.rtl' => ['ar', 'dv', 'fa', 'ur', 'he'],
     'language.default' => 'de',
 
@@ -975,7 +976,7 @@
      *
      * Options: [links,dropdown]
      */
-    'idpdisco.layout' => 'dropdown',
+    'idpdisco.layout' => 'links',
 
 
 
```
* [resources/var/simplesamlphp/config/module_metarefresh.php](../../../blob/main/08_production/resources/var/simplesamlphp/config/module_metarefresh.php):
```diff
@@ -32,10 +32,9 @@
                     /*
                      * Whitelist: only keep these EntityIDs.
                      */
-                    #'whitelist' => array(
-                    #    'http://some.uni/idp',
-                    #    'http://some.other.uni/idp',
-                    #),
+                    'whitelist' => array(
+                        'https://testidp2.aai.dfn.de/idp/shibboleth',
+                    ),
 
                     #'conditionalGET' => true,
                     'src' => 'http://www.aai.dfn.de/fileadmin/metadata/dfn-aai-test-metadata.xml',
@@ -59,6 +58,9 @@
             'cron' => ['hourly'],
             'sources' => [
                 [
+                    'whitelist' => array(
+                        'https://www.sso.uni-erlangen.de/simplesaml/saml2/idp/metadata.php',
+                    ),
                     'src' => 'http://www.aai.dfn.de/metadata/dfn-aai-idp-metadata.xml',
                     'certificates' => ['dfn-aai.pem'],
                     'template' => [
```

[//]: # (AUTOGENERATE END)
