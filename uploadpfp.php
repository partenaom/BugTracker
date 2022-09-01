<?php
    session_start();
    require_once 'includes/dbh.inc.php';
    $uid = $_SESSION["useruid"];

    if(isset($uid)){
            $sqlImg = "SELECT * FROM pfpimg WHERE uid = '$uid'";
            $resultImg = mysqli_query($conn, $sqlImg);
            //checking if user has uploaded an image
            if($rowImg = mysqli_fetch_assoc($resultImg)){
                echo "<div>";
                    if($rowImg['status'] == 1){
                        echo "<img src='uploads/".$uid."_pfp.jpg'>";
                    }else {
                        //default pfp
                        echo "<img src='uploads/defaultpfp.jpg'>";
                    }
                echo "</div>";
            }else{
                echo "An error occured while fetching profile data.";
            }

        echo "
        <form action='includes/uploadpfp.inc.php' method='post' enctype='multipart/form-data'>
            <input type='file' name='file'>
            <button type='submit' name='submit'>Upload</button>
        </form>
        "; 
        // echo "
        // <form action='includes/uploadpfp.inc.php' method='post' enctype='multipart/form-data'>
        //     <input type='file' name='file'>
        //     <input type='submit' class='btn' name='upload' value='Upload' />
        //     <input type='submit' class='btn' name='remove' value='Remove' />
        // </form>";
        if(isset($_GET["error"])){
            if($_GET["error"] == "uploadfailed"){
                echo "<p>File upload failed!</p>";
            }
        }
    }else{
        header("location: index.php");
    }       
    