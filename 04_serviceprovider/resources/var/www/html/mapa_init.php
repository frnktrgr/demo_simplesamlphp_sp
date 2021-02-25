<?php
// Initialize the session
session_start();

// Include config file
//require_once "config.php";

$full_url_with_params = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$full_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]";

function isAuthenticated() {
    return isset($_SESSION["mapa_authn"]) && $_SESSION["mapa_authn"] === true;
}
