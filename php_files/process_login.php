<?php
include_once('db_connect.php');
include_once('functions.php');
sec_session_start();

if (!empty($_POST['email']) && !empty($_POST['p']))
{
    $email=filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email=filter_var($email, FILTER_VALIDATE_EMAIL);
    $password=filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        header('Location: login.php?error=Login failed');
    }
    
    if (login($email, $password, $db) == true)
    {
        // Login success 
        if(isset($_POST['remember']))
        {
            $stmt=$db->prepare('select id,email from members where email=? LIMIT 1');
            $stmt->bindParam(1,$email);
            if($stmt->execute())
            {
                $count=$stmt->rowCount();
                $result=$stmt->fetch(PDO::FETCH_ASSOC);
                if($count==1)
                {
                    $uid=$result['id']+99;
                    $uemail=$result['email'].'this is to make it more secure!';
                    $uemail=hash('sha512',$uemail,false);
                    $year = time() + 31536000;
                    setcookie('uid',$uid,$year,'/');     //the fourth parameter is to specify the accesibility domain of the cookie
                    setcookie('uemail',$uemail,$year,'/');
                }
                else
                {
                    header('Location: register.php?error=unable to set cookie');    
                }
            }
        }
        elseif(!isset($_POST['remember'])) 
        {
            if(isset($_COOKIE['uid'],$_COOKIE['uemail'])) 
            {
                $past = time() - 100;
                setcookie('uid', $uid, $year);
                setcookie('uemail',$uemail,$year);
            }
        }
        header('Location: ../protected_page.php');
    }
    else
    {
        // Login failed 
        header('Location: login.php?error=Login failed');
    }
}
else
{
    header('Location: login.php?error=Login failed');
}
?>