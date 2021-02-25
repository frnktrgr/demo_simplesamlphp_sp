<?php
require_once('../../simplesamlphp/lib/_autoload.php');
$as = new \SimpleSAML\Auth\Simple('default-sp');
$as->logout();
