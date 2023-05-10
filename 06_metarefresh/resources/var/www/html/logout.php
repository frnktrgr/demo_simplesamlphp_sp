<?php
require_once('../../simplesamlphp/src/_autoload.php');
$as = new \SimpleSAML\Auth\Simple('default-sp');
//$as->logout('/');
$as->logout([
    'ReturnTo' => '/logged_out.php',
    'ReturnStateParam' => 'LogoutState',
    'ReturnStateStage' => 'MyLogoutState',
]);
\SimpleSAML\Session::getSessionFromRequest()->cleanup();
