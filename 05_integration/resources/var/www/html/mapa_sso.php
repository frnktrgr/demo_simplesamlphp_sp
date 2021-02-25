<?php
// init local
require_once('mapa_init.php');

function isSsoAuthenticated() {
    return isset($_SESSION["ssp"]) && $_SESSION["ssp"] === true;
}

require_once('../../simplesamlphp/lib/_autoload.php');

$as = new \SimpleSAML\Auth\Simple('default-sp');

if ($_GET["ssoLogout"]) {
    if ($as->isAuthenticated()) {
        $as->logout();
    }
} else {
    if ($_GET["ssoLogoutReturnTo"]) {
        if ($as->isAuthenticated()) {
            $as->logout(['ReturnTo' => $full_url]);
        }
    } else {
        if ($_GET["ssoLogin"]) {
            $as->requireAuth();
        } else {
            if ($_GET["ssoLoginFau"]) {
                $as->requireAuth(['saml:idp' => 'https://www.sso.uni-erlangen.de/simplesaml/saml2/idp/metadata.php']);
            } else {
                if ($_GET["ssoLoginDfn"]) {
                    $as->login([
                        'saml:idp' => 'https://testidp2.aai.dfn.de/idp/shibboleth',
                        'ReturnTo' => $full_url
                    ]);
                }
            }
        }
    }
}
$attributes = $as->getAttributes();
SimpleSAML_Session::getSessionFromRequest()->cleanup();

if ($as->isAuthenticated()) {
    if ($_SESSION['ssp']) {
        // check if remote user changed
        if (isset($attributes['urn:oid:1.3.6.1.4.1.5923.1.1.1.6'])) {
            if ($_SESSION['ssp_username'] != $attributes['urn:oid:1.3.6.1.4.1.5923.1.1.1.6'][0]) {
                // logout user? switch to new user? ...
                $_SESSION['ssp_username'] = $attributes['urn:oid:1.3.6.1.4.1.5923.1.1.1.6'][0];
            }
        }
    } else {
        // init app session
        $_SESSION['ssp'] = true;
        if (isset($attributes['urn:oid:1.3.6.1.4.1.5923.1.1.1.6'])) {
            $_SESSION['ssp_username'] = $attributes['urn:oid:1.3.6.1.4.1.5923.1.1.1.6'][0];
            $_SESSION["mapa_authn"] = true;
            $_SESSION["mapa_authn_sso"] = true;
            $_SESSION["mapa_authn_timestamp"] = date(DATE_RFC822);
            $_SESSION["mapa_authn_username"] = $_SESSION['ssp_username'];
        }
    }
} else {
    if ($_SESSION['ssp']) {
        unset($_SESSION['ssp']);
        unset($_SESSION['ssp_username']);
        if ($_SESSION["mapa_authn_sso"]) {
            unset($_SESSION["mapa_authn"]);
            unset($_SESSION["mapa_authn_sso"]);
            unset($_SESSION["mapa_authn_timestamp"]);
            unset($_SESSION["mapa_authn_username"]);
        }
//        // Unset all of the session variables
//        $_SESSION = array();
//        // Destroy the session.
//        session_destroy();
    }
}

