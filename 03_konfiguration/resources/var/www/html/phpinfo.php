<?php
require_once('mapa_init.php');

// Check if the user is logged in, if not then redirect him to login page
if(!isAuthenticated()){
    header("location: /");
    exit;
}

phpinfo();
