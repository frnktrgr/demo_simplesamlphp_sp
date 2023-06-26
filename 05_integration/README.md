# Einbindung in eine eigene PHP-Anwendung

## Links
* [SimpleSAMLphp Documentation > Service Provider Quickstart > 6 Integrating authentication with your own application](https://simplesamlphp.org/docs/stable/simplesamlphp-sp#section_6)
* [SP API reference](https://simplesamlphp.org/docs/stable/simplesamlphp-sp-api)

## Teilschritte
* siehe Beispielanwendung

[//]: # (AUTOGENERATE START)
## Anpassungen
### Hinzugefügt
* [resources/var/www/html/logged_out.php](../../../blob/main/05_integration/resources/var/www/html/logged_out.php)
* [resources/var/www/html/logout.php](../../../blob/main/05_integration/resources/var/www/html/logout.php)
* [resources/var/www/html/mapa_sso.php](../../../blob/main/05_integration/resources/var/www/html/mapa_sso.php)
* [resources/var/www/html/protectmeopt.php](../../../blob/main/05_integration/resources/var/www/html/protectmeopt.php)
* [resources/var/www/html/protectmeoptsession.php](../../../blob/main/05_integration/resources/var/www/html/protectmeoptsession.php)
* [resources/var/www/html/protectme.php](../../../blob/main/05_integration/resources/var/www/html/protectme.php)

### Änderungen
* [resources/var/www/html/index.php](../../../blob/main/05_integration/resources/var/www/html/index.php):
```diff
@@ -1,5 +1,6 @@
 <?php
 require_once('mapa_init.php');
+require_once('mapa_sso.php');
 require_once('mapa_authn.php');
 
 ?>
@@ -38,6 +39,10 @@
                     <li class="nav-item"><a href="/" class="nav-link active">Home</a></li>
                     <li class="nav-item"><a href="/phpinfo.php" class="nav-link">PHP Info</a></li>
                     <li class="nav-item"><a href="/devssp" class="nav-link">SimpleSAMLphp</a></li>
+                    <li class="nav-item"><a href="?ssoLogin=true" class="nav-link"><i class="bi bi-box-arrow-in-right"></i> Anmelden</a></li>
+                    <li class="nav-item"><a href="?ssoLoginFau=true" class="nav-link"><i class="bi bi-box-arrow-in-right"></i> Anmelden FAU</a></li>
+                    <li class="nav-item"><a href="?ssoLoginDfn=true" class="nav-link"><i class="bi bi-box-arrow-in-right"></i> Anmelden DFN</a></li>
+                    <li class="nav-item"><a href="?ssoLogout=true" class="nav-link"><i class="bi bi-box-arrow-right"></i>SLO</a></li>
                     <li class="nav-item"><a href="?logout=true" class="nav-link"><i class="bi bi-box-arrow-right"></i>Abmelden</a></li>
                     <li class="nav-item"><a href="?destroy=true" class="nav-link"><i class="bi bi-box-arrow-right"></i>Destroy</a></li>
                 </ul>
@@ -67,6 +72,10 @@
                 <h1>Anwendung mit lokaler Anmeldung und SimpleSAMLphp</h1>
                 <ul class="list-group">
                     <li class="list-group-item <?php echo isAuthenticated() ? "text-success" : "text-danger"; ?>"><?php echo isAuthenticated() ? "" : "nicht "; ?>angemeldet</li>
+                    <li class="list-group-item <?php echo isSsoAuthenticated() ? "text-success" : "text-danger"; ?>">SSO <?php echo isSsoAuthenticated() ? "" : "nicht "; ?>angemeldet</li>
+                    <li class="list-group-item"><a href="/protectme.php" class="btn btn-secondary btn-sm">Demo: Einfache Absicherung (protectme.php)</a></li>
+                    <li class="list-group-item"><a href="/protectmeopt.php" class="btn btn-secondary btn-sm">Demo: Einfache Absicherung optional (protectmeopt.php)</a></li>
+                    <li class="list-group-item"><a href="/protectmeoptsession.php" class="btn btn-secondary btn-sm">Demo: Einfache Absicherung optional mit eigener Session (protectmeoptsession.php)</a></li>
                 </ul>
             </div>
         </div>
@@ -85,6 +94,34 @@
             </div>
         </div>
         <div class="accordion-item">
+            <h2 class="accordion-header" id="headingTwo">
+                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
+                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
+                    <span class="font-monospace"><i class="bi bi-code-square"></i> SimpleSAMLphp</span>
+                </button>
+            </h2>
+            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
+                 data-bs-parent="#accordionExample">
+                <div class="accordion-body">
+                    <span class="font-monospace text-muted">// requireAuth(), login(), logout()</span>
+                    <span class="font-monospace">isAuthenticated():</span>
+                    <pre><code class="language-php"><?php var_dump($as->isAuthenticated()); ?></code></pre>
+                    <span class="font-monospace">$attributes:</span>
+                    <pre><code class="language-php"><?php var_dump($attributes); ?></code></pre>
+                    <span class="font-monospace">getLoginURL(string $returnTo = NULL):</span>
+                    <pre><code class="language-php"><?php var_dump($as->getLoginURL()); ?></code></pre>
+                    <span class="font-monospace">getLogoutURL(string $returnTo = NULL):</span>
+                    <pre><code class="language-php"><?php var_dump($as->getLogoutURL()); ?></code></pre>
+                    <span class="font-monospace">getAuthData('saml:sp:IdP'):</span>
+                    <pre><code class="language-php"><?php var_dump($as->getAuthData('saml:sp:IdP')); ?></code></pre>
+                    <span class="font-monospace">getAuthData('saml:sp:NameID'):</span>
+                    <pre><code class="language-php"><?php var_dump($as->getAuthData('saml:sp:NameID')); ?></code></pre>
+                    <span class="font-monospace">getAuthData('saml:sp:SessionIndex'):</span>
+                    <pre><code class="language-php"><?php var_dump($as->getAuthData('saml:sp:SessionIndex')); ?></code></pre>
+                </div>
+            </div>
+        </div>
+        <div class="accordion-item">
             <h2 class="accordion-header" id="headingThree">
                 <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                     <span class="font-monospace"><i class="bi bi-code-square"></i> PHP Code</span>
@@ -94,9 +131,12 @@
                 <div class="accordion-body">
                     <span class="font-monospace">index.php</span>
                     <pre><code class="language-php">require_once('mapa_init.php');
+require_once('mapa_sso.php');
 require_once('mapa_authn.php');</code></pre>
                     <span class="font-monospace">mapa_init.php</span>
                     <pre><code class="language-php"><?php echo htmlspecialchars(file_get_contents('mapa_init.php')); ?></code></pre>
+                    <span class="font-monospace">mapa_sso.php</span>
+                    <pre><code class="language-php"><?php echo htmlspecialchars(file_get_contents('mapa_sso.php')); ?></code></pre>
                     <span class="font-monospace">mapa_authn.php</span>
                     <pre><code class="language-php"><?php echo htmlspecialchars(file_get_contents('mapa_authn.php')); ?></code></pre>
                 </div>
```
* [resources/var/www/html/mapa_authn.php](../../../blob/main/05_integration/resources/var/www/html/mapa_authn.php):
```diff
@@ -24,7 +24,9 @@
 
 if ($_GET["logout"]) {
     // Unset all of the session variables
-    $_SESSION = array();
+    unset($_SESSION["mapa_authn"]);
+    unset($_SESSION["mapa_authn_timestamp"]);
+    unset($_SESSION["mapa_authn_username"]);
 }
 
 if ($_GET["destroy"]) {
```

[//]: # (AUTOGENERATE END)
