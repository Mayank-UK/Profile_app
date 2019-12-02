<?php 
include_once("db_connect.php");
include_once("functions.php");

sec_session_start();  //session start without paprameters
require ("google_dependencies/vendor/autoload.php");

//Step 1: Enter you google account credentials
$g_client = new Google_Client();
$g_client->setClientId("174567366257-fesr2h18i09f2rv0h2ilpgp20o0mgdff.apps.googleusercontent.com");
$g_client->setClientSecret("wOWxyzISmNBx2F0nDFgaE4QJ");
$g_client->setRedirectUri("https://makportfolio.000webhostapp.com/Profile_app/php_files/gplus_2.php");
$g_client->setScopes(array("https://www.googleapis.com/auth/userinfo.email","https://www.googleapis.com/auth/userinfo.profile",));

//Step 2 : Create the url
$auth_url = $g_client->createAuthUrl();
?>