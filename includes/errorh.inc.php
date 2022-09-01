<?php

/** checks if there's any empty fields in the sign up form */
function emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat){
    $result;
    if(empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdRepeat)){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}

/** Makes sure it is proper username */
function invalidUid($username){
    $result;
    if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}

/** Checks if email is valid */
function invalidEmail($email){
    $result;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ //built in inside php
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}

/** Checks if passwords are matching */
function pwdMatch($pwd, $pwdRepeat){
    $result;
    if($pwd !== $pwdRepeat){ 
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}

/** Checks if user is already taken and returns the query result*/
function uidExists($conn, $username, $email){
    //can login using userid or email
    $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;"; //? is a placeholder which will be replaced later
    $stmt = mysqli_stmt_init($conn); //prepared statement

    //binding
    if(!mysqli_stmt_prepare($stmt, $sql)){ //checking if the sql is right
        header("location: ../signup.php?error=stmtfailed"); //error = ... is a get method
        exist();
    }
    //binding parameters
    mysqli_stmt_bind_param($stmt, "ss", $username, $email); //'ss' because it is taking in two strings (username and email)
    //executing statement
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    //fetching data returned by the sql
    if($row = mysqli_fetch_assoc($resultData)){ //associative array uses names instead of index
        return $row; //returning all the row
    }else{
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

/** updates pfp table with new user info*/
function createPfp($conn, $uid){
    $sql = "SELECT * FROM users WHERE usersUid = '$uid'"; //selects the user
    $result = mysqli_query($conn, $sql);
    if($row = mysqli_fetch_assoc($result)){
        $sql = "INSERT INTO pfpimg (uid, status) VALUES ('$uid',0);";
        mysqli_query($conn, $sql);
    }else{
        header("location: ../signup.php?error=stmtfailed");
    }
}

/** Creates user by inserting data into the database*/
function createUser($conn, $name, $email, $username, $pwd){
    $sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd) VALUES(?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn); //prepared statement

    //binding checking if the sql is right
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../signup.php?error=stmtfailed");
        exist();
    }

    //hash the password
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT); //built in PHP hashing algorithm

    //binding parameters into the statement
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPwd); 
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    createPfp($conn, $username);

    header("location: ../signup.php?error=none");
    exist();
}

/** checks if there's any empty fields in the login form */
function emptyInputLogin($username, $pwd){
    $result;
    if(empty($username) || empty($pwd)){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}

function loginUser($conn, $username, $pwd){
    $uidExists = uidExists($conn, $username, $username); //returns matching row
    
    if($uidExists == false){
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExists["usersPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed); //built in

    if($checkPwd === false){
        header("location: ../login.php?error=wronglogin");
        exit();
    }
    //logged in using the userid
    else if($checkPwd === true){
        session_start(); 
        //session is a global variable
        $_SESSION["userid"] = $uidExists["usersId"];
        $_SESSION["useruid"] = $uidExists["usersUid"];
        $_SESSION["name"] = $uidExists["usersName"];
        header("location: ../index.php");
        exit();
    }
}
