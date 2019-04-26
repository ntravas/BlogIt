<?php


include_once( 'Database.php' );


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Blog Application</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link type="text/css" rel="stylesheet" href="res/project.css">
	<script src="res/sitescript.js"></script>
</head>

<body>
	<div id="nav" class="navigation">

		<a href="index.php"><i class="fa fa-globe"></i> Life Blog</a>
		<a href="posts.php">Blog</a>
		<a href="about.php">About the author</a>
		<?php if (isset($_SESSION['user_id'])){
					echo '<a href="myaccount.php">My Account</a>';
					echo '<a href="logout.php">Logout</a>';}
		else{
			echo '<a href="login.php">Login</a>';
			echo '<a href="signup.php">Register</a>';
			}
		?>

		<a onClick="openNavigation()" class="icon" href="javascript:void(0)"><i class="fa fa-bars"></i></a>

	</div>

