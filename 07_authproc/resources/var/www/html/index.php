<?php
require_once('mapa_init.php');
require_once('mapa_sso.php');
require_once('mapa_authn.php');

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

    <title>Welcome</title>
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
    <nav class="navbar fixed-top navbar-expand-xxl navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">My Awesome PHP App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="/" class="nav-link active">Home</a></li>
                    <li class="nav-item"><a href="/phpinfo.php" class="nav-link">PHP Info</a></li>
                    <li class="nav-item"><a href="/devssp" class="nav-link">SimpleSAMLphp</a></li>
                    <li class="nav-item"><a href="?ssoLogin=true" class="nav-link"><i class="bi bi-box-arrow-in-right"></i> Anmelden</a></li>
                    <li class="nav-item"><a href="?ssoLoginFau=true" class="nav-link"><i class="bi bi-box-arrow-in-right"></i> Anmelden FAU</a></li>
                    <li class="nav-item"><a href="?ssoLoginDfn=true" class="nav-link"><i class="bi bi-box-arrow-in-right"></i> Anmelden DFN</a></li>
                    <li class="nav-item"><a href="?ssoLogout=true" class="nav-link"><i class="bi bi-box-arrow-right"></i>SLO</a></li>
                    <li class="nav-item"><a href="?logout=true" class="nav-link"><i class="bi bi-box-arrow-right"></i>Abmelden</a></li>
                    <li class="nav-item"><a href="?destroy=true" class="nav-link"><i class="bi bi-box-arrow-right"></i>Destroy</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-3 order-lg-1">
                <div class="shadow-sm p-3 mb-5 bg-body rounded">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Nutzerkennung</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="beliebig">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Passwort</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="gleich Nutzerkennung">
                        </div>
                        <div class="form-group mt-1">
                            <input type="submit" class="btn btn-primary" value="Lokale Anmeldung">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12 col-lg-9">
                <h1>Anwendung mit lokaler Anmeldung und SimpleSAMLphp</h1>
                <ul class="list-group">
                    <li class="list-group-item <?php echo isAuthenticated() ? "text-success" : "text-danger"; ?>"><?php echo isAuthenticated() ? "" : "nicht "; ?>angemeldet</li>
                    <li class="list-group-item <?php echo isSsoAuthenticated() ? "text-success" : "text-danger"; ?>">SSO <?php echo isSsoAuthenticated() ? "" : "nicht "; ?>angemeldet</li>
                    <li class="list-group-item"><a href="/protectme.php" class="btn btn-secondary btn-sm">Demo: Einfache Absicherung (protectme.php)</a></li>
                    <li class="list-group-item"><a href="/protectmeopt.php" class="btn btn-secondary btn-sm">Demo: Einfache Absicherung optional (protectmeopt.php)</a></li>
                    <li class="list-group-item"><a href="/protectmeoptsession.php" class="btn btn-secondary btn-sm">Demo: Einfache Absicherung optional mit eigener Session (protectmeoptsession.php)</a></li>
                </ul>
            </div>
        </div>
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
                    <pre><code class="language-php">require_once('mapa_init.php');
require_once('mapa_sso.php');
require_once('mapa_authn.php');</code></pre>
                    <span class="font-monospace">mapa_init.php</span>
                    <pre><code class="language-php"><?php echo htmlspecialchars(file_get_contents('mapa_init.php')); ?></code></pre>
                    <span class="font-monospace">mapa_sso.php</span>
                    <pre><code class="language-php"><?php echo htmlspecialchars(file_get_contents('mapa_sso.php')); ?></code></pre>
                    <span class="font-monospace">mapa_authn.php</span>
                    <pre><code class="language-php"><?php echo htmlspecialchars(file_get_contents('mapa_authn.php')); ?></code></pre>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<script src="js/prism.js"></script>
</body>
</html>
