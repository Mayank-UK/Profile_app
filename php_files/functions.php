<?php
 
function sec_session_start()                 //equally important as session_initialize()
{
    // httponly provides protection against javascript
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE)           
    {
        header("Location: error.php?error=Could not initiate a safe session");
        exit();
    }
    
    $cookieParams = session_get_cookie_params();                    // Gets current cookies params.
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $cookieParams["secure"], $cookieParams["httponly"]);
    
    session_name('sec_session_id');  // Sets the session name to the one set above.
    session_start();             // Start the PHP session 
    session_regenerate_id();    // regenerated the session, delete the old one. 
}



function login($email, $password, $db)
{
    // Using prepared statements means that SQL injection is not possible. 
    if ($stmt = $db->prepare("SELECT id, username, password FROM members WHERE email = ? LIMIT 1"))
    {
        $stmt->bindParam(1, $email); 
        if($stmt->execute())
        {
            $count=$stmt->rowCount();
            // get variables from result.
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            $user_id=$result['id'];
            $username=$result['username'];
            $db_password=$result['password'];
     
            if ($count == 1)
            {
                // If the user exists we check if the account is locked
                // from too many login attempts 
     
                if (checkbrute($user_id, $db) == true)
                {
                    // Account is locked 
                    // Send an email to user saying their account is locked
                    return false;
                }
                else
                {
                    // Check if the password in the database matches
                    // the password the user submitted. We are using
                    // the password_verify function to avoid timing attacks.
                    if (password_verify($password,$db_password))
                    {
                        session_initialize($email,$db);
                        return true;
                    }
                    else
                    {
                        // Password is not correct
                        // We record this attempt in the database
                        $now = time();
                        if($stmt=$db->prepare("INSERT INTO login_attempts(user_id, time) VALUES (?,?)"))
                        {
                            $stmt->bindParam(1,$user_id);
                            $stmt->bindParam(2,$now);
                            $stmt->execute();
                            return false;
                        }
                    }
                }
            }
            else
            {
                // No user exists.
                return false;
            }
        }
           
      
    }
}


function checkbrute($user_id, $db)
{
    // Get timestamp of current time 
    $now = time();
 
    // All login attempts are counted from the past 2 hours. 
    $valid_attempts = $now - (3 * 30);
 
    if ($stmt = $db->prepare("SELECT time FROM login_attempts WHERE user_id = ? AND time > ?"))
    {
        $stmt->bindParam(1, $user_id);
        $stmt->bindParam(2, $valid_attempts);
 
        // Execute the prepared query. 
        if($stmt->execute())
        {
            $count=$stmt->rowCount();
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            
            // If there have been more than 5 failed logins 
            if ($count > 3)
            {
                header('Location: login.php?error=Account locked for 90 seconds');
                exit();
            }
            else
            {
                return false;
            }
        }
    }
}


function login_check($db)
{
    // Check if all session variables are set 
    if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string']))
    {
 
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
 
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
        if ($stmt = $db->prepare("SELECT password FROM members WHERE id = ? LIMIT 1"))
        {
            // Bind "$user_id" to parameter. 
            $stmt->bindParam(1, $user_id);
            if($stmt->execute())
            {
                $count=$stmt->rowCount();
                $result=$stmt->fetch(PDO::FETCH_ASSOC);
     
                if ($count == 1)
                {
                    // If the user exists get variables from result.
                    $password=$result['password'];
                    $login_check = hash('sha512', $password , $user_browser);
     
                    if (hash_equals($login_check, $login_string))
                    {
                        // Logged In!!!! 
                        return true;
                    }
                    else
                    {
                        // Not logged in 
                        return false;
                    }
                }
                else
                {
                    // Not logged in 
                    return false;
                }
            }
        }
        else
        {
            // Not logged in 
            return false;
        }
    }
    else
    {
        // Not logged in 
        return false;
    }
}


function esc_url($url)
{
 
    if ('' == $url)
    {
        return $url;
    }
 
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
 
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
 
    $count = 1;
    while ($count)
    {
        $url = str_replace($strip, '', $url, $count);
    }
 
    $url = str_replace(';//', '://', $url);
 
    $url = htmlentities($url);
 
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
 
    if ($url[0] !== '/')
    {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    }
    else
    {
        return $url;
    }
}

function session_initialize($email,$db)
{
    // httponly provides protection against javascript
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE)           
    {
        header("Location: error.php?error=Could not initiate a safe session");
        exit();
    }
    
    if ($stmt = $db->prepare("SELECT id, username, password FROM members WHERE email = ? LIMIT 1"))
    {
        $stmt->bindParam(1, $email); 
        if($stmt->execute())
        {
            $count=$stmt->rowCount();
 
            // get variables from result.
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            $user_id=$result['id'];
            $username=$result['username'];
            $db_password=$result['password'];
     
            if ($count == 1)
            {
                // Get the user-agent string of the user.
                $user_browser = $_SERVER['HTTP_USER_AGENT'];
                // XSS protection as we might print this value
                $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                $_SESSION['user_id'] = $user_id;
                // XSS protection as we might print this value
                $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
                $_SESSION['username'] = $username;
                $_SESSION['login_string'] = hash('sha512', $db_password , $user_browser);
            }
        }
    }
}

function cookie_checker($db)
{
    if(isset($_COOKIE['uid'],$_COOKIE['uemail']))
    {
        $uid=$_COOKIE['uid']-99;
        $uemail=$_COOKIE['uemail'];

        if ($stmt = $db->prepare("SELECT id,username,email,password FROM members WHERE id = ? LIMIT 1"))
        {
            $stmt->bindParam(1, $uid);
            if($stmt->execute())
            {
                $count=$stmt->rowCount();
                $result=$stmt->fetch(PDO::FETCH_ASSOC);
    
                if ($count == 1)
                {
                    $user_id=$result['id'];
                    $username=$result['username'];
                    $email=$result['email'].'this is to make it more secure!';
                    $db_password=$result['password'];
    
                    $email=hash('sha512',$email,false);
                    if(hash_equals($email, $uemail))
                    {
                        $user_browser = $_SERVER['HTTP_USER_AGENT'];
                        // XSS protection as we might print this value
                        $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                        $_SESSION['user_id'] = $user_id;
                        // XSS protection as we might print this value
                        $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
                        $_SESSION['username'] = $username;
                        $_SESSION['login_string'] = hash('sha512', $db_password , $user_browser);
                    }
                }
            }
        }
    }
}