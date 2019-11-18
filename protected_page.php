<?php 
include_once('php_files/db_connect.php');
include_once('php_files/functions.php');

sec_session_start();
cookie_checker($db);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profile_repository</title>
        <link rel="stylesheet" type="text/css" href="css_files/Responsive.css" />
        <link rel="stylesheet" type="text/css" href="css_files/profile_app.css" />
    </head>
    <body>
        <?php if (login_check($db) == true) : ?>
        
        <header>
            <?php
            if($stmt=$db->prepare("select * from profile_members where oname=? LIMIT 1"))
            {
                $stmt->bindValue(1,$_SESSION['username']);
                $stmt->execute();
                $result=$stmt->fetch(PDO::FETCH_ASSOC);
            }
            ?>
            <nav>
                <input class="header-nav-input" placeholder="  search profiles .." />
                <a href="php_files/logout.php">Logout</a>
            </nav>
            <div class="header-div-1">&quot <?php echo $result['quote']; ?> &quot</div>
            <div class="header-div-2">
                <img class="header-div-2-img" src="<?php if(empty($result['img'])){echo "img_files/Batman.jpg";}else{ echo $result['img'];} ?>" />
                <?php if(!empty($_GET['error'])){ echo "<div class='error'>".$_GET['error']."</div>";} ?>
                <form action="php_files/upload.php" method="post" class="header-div-2-form" enctype="multipart/form-data">
                    <input class="header-div-2-form-input-1" type="file" name="fileToUpload" onChange="previewImage()" />
                    <input class="header-div-2-form-input-2" type="text" name="oname" value="<?php echo $_SESSION['username']; ?>" value="Change" readonly onClick="document.getElementsByClassName('header-div-2-form-input-1')[0].click();" />
                </form>
            </div>
            <p class="header-p">Refresh to home</p>
        </header>
        
        <main>
            <div class="main-div">
                <button class="main-div-button-1" onClick="edit()">Edit</button>
                <button class="main-div-button-2" onClick="save()">Save</button>
                <div class="main-div-div">
                    <div class="main-div-div-div">
                        <p>Name</p>
                        <input class="main-div-div-div-input main-div-div-div-input-1" type="text" readonly value="<?php echo $result['name']; ?>" />
                    </div>
                    <div class="main-div-div-div">
                        <p>Public email</p>
                        <input class="main-div-div-div-input main-div-div-div-input-2" type="text" readonly value="<?php echo $result['email']; ?>" />
                    </div>
                    <div class="main-div-div-div">
                        <p>Education</p>
                        <textarea class="main-div-div-div-input main-div-div-div-input-3 main-div-div-div-textarea" type="text" readonly><?php echo $result['education']; ?></textarea>
                    </div>
                    <div class="main-div-div-div">
                        <p>Company</p>
                        <textarea class="main-div-div-div-input main-div-div-div-input-4 main-div-div-div-textarea" type="text" readonly><?php echo $result['company']; ?></textarea>
                    </div>
                    <div class="main-div-div-div">
                        <p>URL</p>
                        <input class="main-div-div-div-input main-div-div-div-input-5" type="text" readonly value="<?php echo $result['url']; ?>" />
                    </div>
                    <div class="main-div-div-div">
                        <p>Bio</p>
                        <textarea class="main-div-div-div-input main-div-div-div-input-6 main-div-div-div-textarea" type="text" readonly><?php echo $result['bio']; ?></textarea>
                    </div>
                    <div class="main-div-div-div">
                        <p>Favourite quote</p>
                        <textarea class="main-div-div-div-input main-div-div-div-input-7 main-div-div-div-textarea" type="text" readonly><?php echo $result['quote']; ?></textarea>
                    </div>
                    <div class="main-div-div-div">
                        <p>Location</p>
                        <input class="main-div-div-div-input main-div-div-div-input-8" type="text" readonly value="<?php echo $result['location']; ?>" />
                    </div>
                </div>
            </div>
        </main>
        
        <footer>
            <a href="html_files/about.html">About</a>
        </footer>
        
        <?php else : ?>
        <div class="else-div">
            <h1>Developer profiles</h1>
            <p>Search for the future employee or create a profile now to get hired.</p>
            <div>
                <a href="php_files/login.php" class="else-div-div-a-1">Login</a>                <!--overflow: auto is used on parent div-->
                <h2>or</h2>
                <a href="php_files/register.php" class="else-div-div-a-2">Register</a>
            </div>
        </div>
        <?php endif; ?>
        <script type="text/javascript">
                var oName="<?php echo $_SESSION['username']; ?>";
        </script>
        <script type="text/javascript" src="javascript_files/profile_app.js"></script>
    </body>
</html> 