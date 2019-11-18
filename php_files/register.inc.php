<?php
include_once('db_connect.php');
include_once('functions.php');
sec_session_start();

if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['p']))
{
    // Sanitize and validate the data passed in
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);               
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);               //filter_var uses a cached email address in a variable 
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        // Not a valid email
        header('Location: register.php?error=invalid email');
        exit();
    }
 
    
    if (strlen($_POST['p']) != 128)
    {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        header('Location: register.php?error=invalid password configuration');
        exit();
    }
 
    // Username validity and password validity have been checked client side.
    // This should should be adequate as nobody gains any advantage from
    // breaking these rules.
    //
 
    $stmt = $db->prepare("SELECT id FROM members WHERE email = ? LIMIT 1");
   // check existing email  
    if ($stmt)
    {
        $stmt->bindParam(1, $email);
        if($stmt->execute())
        {
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            $count=$stmt->rowCount();
     
            if ($count == 1)
            {
                // A user with this email address already exists
                header('Location: register.php?error=A user with this email already exist');
                exit();
            }
        }
    }
    else
    {
        header('Location: register.php?error=Database error');
        exit();
    }
 
    // check existing username
    $stmt = $db->prepare("SELECT id FROM members WHERE username = ? LIMIT 1");
    if ($stmt)
    {
        $stmt->bindParam(1, $username);
        if($stmt->execute())
        {
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            $count=$stmt->rowCount();
     
            if ($count == 1)
            {
                // A user with this username already exists
                header('Location: register.php?error=A user with this username already exists');
                exit();
            }
        }
    }
    else
    {
        header('Location: register.php?error=Database error line');
        exit();
    }
 
    // TODO: 
    // We'll also have to account for the situation where the user doesn't have
    // rights to do registration, by checking what type of user is attempting to
    // perform the operation.
 
    if (empty($error_msg))
    {
 
        // Create hashed password using the password_hash function.
        // This function salts it with a random salt and can be verified with
        // the password_verify function.
        $password = password_hash($password, PASSWORD_BCRYPT);
 
        // Insert the new user into the database 
        if ($insert_stmt = $db->prepare("INSERT INTO members (username, email, password) VALUES (?, ?, ?)"))
        {
            $insert_stmt->bindParam(1, $username);
            $insert_stmt->bindParam(2, $email);
            $insert_stmt->bindParam(3, $password);
            // Execute the prepared query.
            if (! $insert_stmt->execute())
            {
                header('Location: error.php?error=Registration failure: INSERT');
                exit();
            }
        }
        if($stmt=$db->prepare("insert into profile_members (oname,name) values(?,?)"))
        {
            $stmt->bindParam(1,$username);
            $stmt->bindParam(2,$username);
            $stmt->execute();
        }
        session_initialize($email,$db);
        header('Location: ../protected_page.php');
    }
}
?>