<?php
include_once('db_connect.php');

if($data=file_get_contents('php://input'))
{
    $data=json_decode($data);
    $name=htmlentities($data->name);
    if($stmt=$db->prepare("select name,email,location,img from profile_members where oname like ? '%' "))
    {
        $stmt->bindParam(1,$name);
        if($stmt->execute())
        {
            $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
            $encoded_json_array=json_encode($result);  
            echo $encoded_json_array;
        }
    }
    else
    {
        header('Location: ../index?error=database connection error');
        exit();
    }
}
else
{
    header('Location: ../index?error=an error has occured');
}