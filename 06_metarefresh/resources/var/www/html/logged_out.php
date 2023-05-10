<?php
require_once('../../simplesamlphp/src/_autoload.php');
$state = \SimpleSAML\Auth\State::loadState((string)$_REQUEST['LogoutState'], 'MyLogoutState');
$ls = $state['saml:sp:LogoutStatus']; /* Only works for SAML SP */
if ($ls['Code'] === 'urn:oasis:names:tc:SAML:2.0:status:Success' && !isset($ls['SubCode'])) {
    /* Successful logout. */
    echo("You have been logged out.");
} else {
    /* Logout failed. Tell the user to close the browser. */
    echo("We were unable to log you out of all your sessions. To be completely sure that you are logged out, you need to close your web browser.");
}
