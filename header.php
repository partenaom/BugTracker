<?php
	session_start();
?>
<!doctype html>
<html lang="en" dir="ltr">
    <head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="UTF-8">
		<title>DashBoard | Bug Tracker</title>
		<meta name="description" content="See all your tickets here!">
		<meta name="lastmodified" content="Updated on 28 Jun 2022">
		<meta name="copyright" content="copyright Naomi Parte 2022">
		<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<!--BootStrap-->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous"> 
		<link rel="icon" href="images/icon.png"> <!--todo-->
	</head>
    <body>
		<header>
            <nav>
				<?php
					//if the user logged in
					if(isset($_SESSION["useruid"])){
						echo "<li><a accesskey='h' href='index.php'>DashBoard</a></li>";
						echo "<li><a accesskey='p' href='projects.php'>Projects</a></li>";
						echo "<li><a accesskey='t' href='tickets.php'>Tickets</a></li>";
						echo "<li><a href='profile.php'>Profile</a></li>";
						echo "<li><a href='includes/logout.inc.php'>Logout</a></li>";
					}else{
						echo "<li><a href='signup.php'>Sign Up</a></li>";
						echo "<li><a href='login.php'>Log In</a></li>";
					}
				?>
            </nav>
        </header>