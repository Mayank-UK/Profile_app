<?php
include_once('register.inc.php');
include_once('functions.php');

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
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Secure Login: Registration Form</title>
        <link rel="stylesheet" type="text/css" href="../css_files/Responsive.css" />
        <link rel="stylesheet" type="text/css" href="../css_files/register.css" />
    </head>
    <body>
        <div>
            <form class="modal-content" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="POST" style="<?php if($logged=='in'){echo 'display: none';} else{echo 'display: block';} ?>">
                <?php if(isset($_GET['error'])){echo '<p class="error">'.$_GET['error'].'</p>';} ?>
                <h1>Sign Up</h1>
                <p>Please fill in this form to create an account.</p>
                <hr>
                    
                <label for="username"><b>Username</b></label>
                <input type="text" placeholder="Enter username" name="username" />
                    
                <label for="email"><b>Email</b></label>
                <input type="text" placeholder="Existing Email" name="email" />

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" />

                <label for="psw-repeat"><b>Repeat Password</b></label>
                <input type="password" placeholder="Repeat Password" name="confirmpwd" />

                <label>
                <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px" /> Remember me
                </label>

                <div class="clearfix">
                    <button type="reset" class="cancelbtn">Cancel</button>
                    <button type="submit" class="signupbtn" value="Register" 
                    onclick="return regformhash(this.form,this.form.username,this.form.email,this.form.password,this.form.confirmpwd);">Sign Up</button>
                </div>
            </form>
            <p class="return_login">Return to the <a href="login.php">login page</a>.</p>
        </div>
        <script type="text/JavaScript" src="../javascript_files/sha512.js"></script> 
        <script type="text/JavaScript" src="../javascript_files/forms.js"></script>
    </body>
</html>