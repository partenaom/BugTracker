<?php
session_start();
include_once 'dbh.inc.php';
$uid = $_SESSION["useruid"];

if(isset($_POST['submit'])){
    $file = $_FILES['file'];

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array("jpg", "jpeg", "png");
    
    if(in_array($fileActualExt, $allowed)){
        if($fileError === 0){
            if($fileSize < 5000000){
                
                $fileNameNew = $uid."_pfp.".$fileActualExt;
                $fileDestination = '../uploads/' . $fileNameNew;
                
                
                if(move_uploaded_file($fileTmpName, $fileDestination)){
                    $sql = "UPDATE pfpimg SET status=1 WHERE uid='$uid';";
                    $result = mysqli_query($conn, $sql);
                    header("Location: ../uploadpfp.php?uploadsuccess");
                }else{
                    header("Location: ../uploadpfp.php?error=uploadfailed");
                }
                
                // if(isset($_POST['remove'])){
                //     if(!unlink($fileDestination)){
                //         header("Location: ../uploadpfp.php?error=removefailed");
                //     }else{
                //         header("Location: ../uploadpfp.php?error=removesuccess");
                //     }
                // }     
                
            }else{
                echo "Your file is too big!";
            }
        }else{
            echo "Error uploading file.";
        }
       
    }else{
        echo "Invalid file type! Type: ".$fileActulExt;
    }
}else{
    header("location: ../uploadpfp.php");
}