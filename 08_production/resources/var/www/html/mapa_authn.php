<?php
require_once('mapa_init.php');

// Define variables and initialize with empty values
$username = $password = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Validate credentials
    if ($username == $password) {
        // Password is correct, so start a new session
        session_start();
        // Store data in session variables
        $_SESSION["mapa_authn"] = true;
        $_SESSION["mapa_authn_timestamp"] = date(DATE_RFC822);
        $_SESSION["mapa_authn_username"] = $username;
    } else {
        // TODO handle invalid credentials
    }
}

if ($_GET["logout"]) {
    // Unset all of the session variables
    unset($_SESSION["mapa_authn"]);
    unset($_SESSION["mapa_authn_timestamp"]);
    unset($_SESSION["mapa_authn_username"]);
}

if ($_GET["destroy"]) {
    // Unset all of the session variables
    $_SESSION = array();
    // Destroy the session.
    session_destroy();
}
