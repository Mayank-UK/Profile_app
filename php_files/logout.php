<?php
include_once('db_connect.php');
include_once('functions.php');
sec_session_start();

//destroy the login cookie
if(isset($_COOKIE['uid'],$_COOKIE['uemail'])) 
{
    $past = time() - 100;
    $uid='';
    $uemail='';
    setcookie('uid', $uid, $past,'/');
    setcookie('uemail', $uemail, $past,'/');
}

//delete unwanted invalid password records
if($stmt=$db->prepare("delete from login_attempts where time<?"))
{
    $time=time()-2*60;
    $stmt->bindParam(1,$time);
    $stmt->execute();
}

// Unset all session values 
$_SESSION = array();
 
// get session parameters 
$params = session_get_cookie_params();
 
// Delete the actual cookie. 
setcookie(session_name(),'', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
 
// Destroy session 
session_destroy();
header('Location: login.php');