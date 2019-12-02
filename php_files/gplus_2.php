<?php
include_once("gplus_1.php");

//Step 3 : Get the authorization  code
$code = isset($_GET['code']) ? $_GET['code'] : NULL;

//Step 4: Get access token
if(isset($code))
{
    try
    {
        $token = $g_client->fetchAccessTokenWithAuthCode($code);
        $g_client->setAccessToken($token);
    }
    catch (Exception $e)
    {
        header('Location: login.php?error=Login failed');
    }
    try 
    {
        $pay_load = $g_client->verifyIdToken();
    }
    catch (Exception $e)
    {
        header('Location: index.php?error=Login failed');
    }
}
else
{
    $pay_load=null;
}




if(isset($pay_load))
{   
    $username=$pay_load['given_name'];
    $email=$pay_load['email'];
    $password=password_hash('this@is@random',PASSWORD_BCRYPT);
    
    if($stmt=$db->prepare("select id from members where email=? LIMIT 1"))
    {
        $stmt->bindParam(1,$email);
        if($stmt->execute())
        {
            $count=$stmt->rowCount();
            if($count==1)
            {           
                session_initialize($email,$db);
                header("Location: ../index.php");
            }
            else
            {
                if($stmt=$db->prepare("insert into members(username, email, password) values(?,?,?)"))
                {
                    $stmt->bindParam(1,$username);
                    $stmt->bindParam(2,$email);
                    $stmt->bindParam(3,$password);
                    $stmt->execute();
                    
                    if($stmt1=$db->prepare("insert into profile_members (oname,name) values(?,?)"))
                    {
                        $stmt1->bindParam(1,$username);
                        $stmt1->bindParam(2,$username);
                        $stmt1->execute();
                    }
                }
                
                session_initialize($email,$db);
                header("Location: ../index.php");
            }
        }
        
       
    }
}
?>