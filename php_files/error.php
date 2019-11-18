<?php
$error=filter_input(INPUT_GET, 'error', $filter = FILTER_SANITIZE_STRING);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Secure Login: Error</title>
    </head>
    <body>
        <h2 class="error"><?php echo $error; ?></h2>  
    </body>
</html>