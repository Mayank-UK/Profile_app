<?php
include_once('db_connect.php');

if($data=file_get_contents('php://input'))
{
    $data=json_decode($data);

    $oname=htmlentities($data->oname);
    $name=htmlentities($data->name);
    $email=htmlentities($data->email);
    $education=htmlentities($data->education);
    $company=htmlentities($data->company);
    $url=htmlentities($data->url);
    $bio=htmlentities($data->bio);
    $quote=htmlentities($data->quote);
    $location=htmlentities($data->location);
}
else
{
    header('Location: ../index?error=database connection error');
    die();
}

if($stmt=$db->prepare("UPDATE  profile_members SET name=?,email=?,education=?,company=?,url=?,bio=?,quote=?,location=? WHERE oname=?"))
{
    $stmt->bindParam(1,$name);
    $stmt->bindParam(2,$email);
    $stmt->bindParam(3,$education);
    $stmt->bindParam(4,$company);
    $stmt->bindParam(5,$url);
    $stmt->bindParam(6,$bio);
    $stmt->bindParam(7,$quote);
    $stmt->bindParam(8,$location);
    $stmt->bindParam(9,$oname);
    
    $stmt->execute();
}
else
{
    header('Location: ../index?error=database connection error');
}
?>