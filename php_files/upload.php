<?php
include_once("db_connect.php");

$oname=$_POST['oname'];
$path=basename($_FILES["fileToUpload"]["name"]);
$temp=explode('.',$path);
$new_path="../uploads/".round(microtime(true)).$oname.'.'.$temp[1];
$uploadOk=1;
$imageFileType=strtolower($temp[1]);

// Check if image file is a actual image or fake image
if(!@is_array(getimagesize($_FILES["fileToUpload"]["tmp_name"])))
{
    header("Location: ../index.php?error=file is not an image");
    exit();
}

// Check if file already exists
/*if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}*/

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" )
{
    header("Location: ../index.php?error=Sorry, only JPG, JPEG, PNG & GIF files are allowed");
    exit();
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 1024*200)
{
    header("Location: ../index.php?error=file size should be less than 200kb");
    exit();
}

// Check if $uploadOk is set to 0 by an error

if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$new_path))
{
    if($stmt=$db->prepare("select img from profile_members where oname=? LIMIT 1"))
    {
        $stmt->bindParam(1,$oname);
        if($stmt->execute())
        {
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            $target_file=$result['img'];
                
            if(file_exists($target_file))
            {
                unlink($target_file);
            } 
        }
    }
    else
    {
        header("Location: ../index.php?error=Database error");
        exit();
    }
        
    if($stmt=$db->prepare("UPDATE profile_members SET img=? WHERE oname=?"))
    {
        $new_path_db="uploads/".round(microtime(true)).$oname.'.'.$temp[1];
        $stmt->bindParam(1,$new_path_db);
        $stmt->bindParam(2,$oname);
        $stmt->execute();
    }
    else
    {
        header("Location: ../index.php?error=Database error");
        die();
    }
    
    header("Location: ../index.php");
}
else
{
    header("Location: ../index.php?error=Sorry, there was an error uploading your file");
}
?>
