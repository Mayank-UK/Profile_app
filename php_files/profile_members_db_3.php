<?php
include_once('db_connect.php');

if($data=file_get_contents('php://input'))
{
    $data=json_decode($data);

    $name=htmlentities($data->name);
}
else
{
    header('Location: ../protected_page?error=an error has occured');
    exit();
}

if($stmt=$db->prepare("select * from profile_members where oname=? LIMIT 1"))
{
    $stmt->bindParam(1,$name);
    if($stmt->execute())
    {
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
    
        $encoded_json_array=json_encode($result);  
        echo $encoded_json_array;
    }
}
else
{
    header('Location: ../protected_page?error=database connection error');
}
?>