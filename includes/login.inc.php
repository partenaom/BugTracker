<?php
//prevents SQL injection
if(isset($_POST["submit"])){
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];
    
    require_once 'dbh.inc.php';
    require_once 'errorh.inc.php';

    //Error handling
    if(emptyInputLogin($username, $pwd) !== false){
        header("location: ../login.php?error=emptyinput");
        exist();
    }

    loginUser($conn, $username, $pwd);
}
//sends user back to signup
else{
    header("location: ../login.php");
    exist();
}
