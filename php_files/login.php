<?php
include_once('db_connect.php');
include_once('functions.php');
include_once('gplus_1.php');
 
cookie_checker($db);

if (login_check($db) == true)
{
    $logged = 'in';
}
else
{
    $logged = 'out';
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Secure Login: Log In</title>
        <link rel="stylesheet" type="text/css" href="../css_files/Responsive.css" />
        <link rel="stylesheet" type="text/css" href="../css_files/login.css" />
    </head>
    <body>  
        <div class="div">
            <form action="process_login.php" method="post" name="login_form" 
                style="<?php if($logged=='in'){echo 'display: none';} else{echo 'display: block';} ?>"> 

                <div>
                    <?php if (isset($_GET['error'])){ echo '<p class="error">'.$_GET['error'].'</p>';} ?>
                </div>
                
                <div>
                  <p class="one"></p>
                  <label for="email"><b>Email</b></label>
                  <input type="text" placeholder="Enter email" name="email" class="input" required/>

                  <label for="password"><b>Password</b></label>
                  <input type="password" placeholder="Enter Password"  class="input" name="password" required/>

                  <button class="login"
                  onclick="return formhash(this.form,this.form.email,this.form.password);">Login</button>
                  <label class="input remember_me">
                  <input type="checkbox" name="remember"
                  <?php if(isset($_COOKIE['uid'])){echo 'checked="checked"';}else{echo '';} ?> /> Remember me
                  </label>
                  <p class="or">or</p>
                  <?php echo "<a href='$auth_url' class='gplus'>Login with google</a>"; ?>
                </div>

                <div>
                  <button >Cancel</button>
                  <span >Forgot <a href="#">password?</a></span>
                </div>
            </form>
            <div class="log_status">
                <?php
                if (login_check($db) == true)
                {
                    echo '<p>Currently logged ' . $logged . ' as ' . htmlentities($_SESSION['username']) . '</p>';
                    echo '<p>Do you want to change user? <a href="logout.php">Log out</a>.</p>';
                }
                else
                {
                    echo '<p>Currently logged ' . $logged . '.</p>';
                    echo "<p>If you don't have a login, please <a href='register.php'>Register</a></p>";
                }
                ?>   
            </div>
        </div>
   
        <script type="text/JavaScript" src="../javascript_files/sha512.js"></script> 
        <script type="text/JavaScript" src="../javascript_files/forms.js"></script>
    </body>
</html>