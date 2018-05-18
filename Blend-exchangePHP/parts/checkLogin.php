<?php

if (session_status() == PHP_SESSION_NONE && isset($_COOKIE["PHPSESSID"])) {
   session_set_cookie_params(86400 * 50);
   session_start();
   session_regenerate_id();
}
$loggedIn = false;
$admin = false;
if((isset($_SESSION["loggedIn"]) == true) && ($_SESSION["loggedIn"] == true)){
    $userId = $_SESSION["userId"] ;
    $loggedIn = $_SESSION["loggedIn"];
    $admin = $_SESSION["admin"];
}

?>
