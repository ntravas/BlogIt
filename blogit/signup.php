<?php

//session_start();

include_once( 'Database.php' );
include_once( 'userType.php' );
include_once( 'User.php' );

$db = new Database();
$conn = $db->connect();
$userType = new UserType();
$result = $userType->getAllRoles( $conn );
$user = new User( $conn );

include( 'header.php' )

?>

<main>
	<br><br>
	<div class="container-fluid">

		<?php 
	
			if (isset($_GET['status'])) {
				
				if ($_GET['status'] == 'registered') {
					?>

		<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Success!</strong> You have been registered successfully !
		</div>

		<?php
		}

		if ( $_GET[ 'status' ] == 'fail' ) {

			?>

		<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Fail!</strong> User registration failed, email or username already exists!
		</div>

		<?php
		}

		}

		?>

		<h1 class="display-4">Register New Account</h1>

		<form method="post" action="<?php echo($_SERVER['PHP_SELF']) ?>" enctype="multipart/form-data">
			<div class="col-sm-5">


				<div class="form-group">
					<label for="sel1">Enter Username:</label>
					<input type="text" name="username" placeholder="Username..." required class="form-control">
				</div>

				<div class="form-group">
					<label for="sel1">Enter Password:</label>
					<input type="password" name="password" placeholder="Password..." required class="form-control">
				</div>
				
				
				
				
				<div class="form-group">
					<label for="sel1">Enter Email:</label>
					<input type="email" name="email" placeholder="Email..." required class="form-control">
				</div>

			</div>


			<button type="submit" name="register" class="btn btn-primary btn-sm">Register</button>

	</form>
	</div>
	

</main>