<?php
include_once('psl-config.php');   // As functions.php is not included

try
{
    $db=new PDO($HOST,$USER,$PASSWORD);
}
catch(exception $e)
{
    echo $e;
    //header('Location: error.php?error=Database error');
}