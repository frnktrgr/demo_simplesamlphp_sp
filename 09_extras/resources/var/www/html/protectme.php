<?php
require_once('../../simplesamlphp/src/_autoload.php');
$as = new \SimpleSAML\Auth\Simple('default-sp');
$as->requireAuth();
$attributes = $as->getAttributes();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="css/prism.css" rel="stylesheet"/>

    <title>protect me</title>
    <style type="text/css">
        .text-large {
            font-size: 120%;
        }
        body {
            padding-top: 60px;
        }
    </style>
</head>
<body>
<div class="m-5">
    <h1>Einfache Absicherung (keine eigene Session)</h1>
    <a href="/logout.php" class="btn btn-danger mb-2">Abmelden via API</a>
    <a href="<?php echo $as->getLogoutURL('https://sso-dev.fau.de')?>" class="btn btn-danger mb-2">Abmelden via Logout URL</a>
    <div>
        <a href="/" class="btn btn-secondary btn-sm mb-2">Home</a>
        <a href="/protectme.php" class="btn btn-secondary btn-sm mb-2">Demo: Einfache Absicherung (protectme.php)</a>
        <a href="/protectmeopt.php" class="btn btn-secondary btn-sm mb-2">Demo: Einfache Absicherung optional (protectmeopt.php)</a>
        <a href="/protectmeoptsession.php" class="btn btn-secondary btn-sm mb-2">Demo: Einfache Absicherung optional mit eigener Session (protectmeoptsession.php)</a>
    </div>
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <span class="font-monospace"><i class="bi bi-code-square"></i> $_SESSION</span>
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <pre><code class="language-php"><?php var_dump($_SESSION); ?></code></pre>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <span class="font-monospace"><i class="bi bi-code-square"></i> SimpleSAMLphp</span>
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                 data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <span class="font-monospace text-muted">// requireAuth(), login(), logout()</span>
                    <span class="font-monospace">isAuthenticated():</span>
                    <pre><code class="language-php"><?php var_dump($as->isAuthenticated()); ?></code></pre>
                    <span class="font-monospace">$attributes:</span>
                    <pre><code class="language-php"><?php var_dump($attributes); ?></code></pre>
                    <span class="font-monospace">getLoginURL(string $returnTo = NULL):</span>
                    <pre><code class="language-php"><?php var_dump($as->getLoginURL()); ?></code></pre>
                    <span class="font-monospace">getLogoutURL(string $returnTo = NULL):</span>
                    <pre><code class="language-php"><?php var_dump($as->getLogoutURL()); ?></code></pre>
                    <span class="font-monospace">getAuthData('saml:sp:IdP'):</span>
                    <pre><code class="language-php"><?php var_dump($as->getAuthData('saml:sp:IdP')); ?></code></pre>
                    <span class="font-monospace">getAuthData('saml:sp:NameID'):</span>
                    <pre><code class="language-php"><?php var_dump($as->getAuthData('saml:sp:NameID')); ?></code></pre>
                    <span class="font-monospace">getAuthData('saml:sp:SessionIndex'):</span>
                    <pre><code class="language-php"><?php var_dump($as->getAuthData('saml:sp:SessionIndex')); ?></code></pre>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    <span class="font-monospace"><i class="bi bi-code-square"></i> PHP Code</span>
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <span class="font-monospace">index.php</span>
                    <pre><code class="language-php">require_once('../../simplesamlphp/src/_autoload.php');
$as = new \SimpleSAML\Auth\Simple('default-sp');
$as->requireAuth();
$attributes = $as->getAttributes();</code></pre>
                    <span class="font-monospace">logout.php</span>
                    <pre><code class="language-php"><?php echo htmlspecialchars(file_get_contents('logout.php')); ?></code></pre>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<script src="js/prism.js"></script>
</body>
</html>
