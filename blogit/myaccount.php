<?php
session_start();

if ( !isset( $_GET[ 'userid' ] ) || $_GET[ 'userid' ] = '' ) {
	header( 'location: myaccount.php?userid=' . $_SESSION[ 'user_id' ] . '' );
}


include_once( "Database.php" );
include_once( "User.php" );


$db = new Database;
$conn = $db->connect();
$user = new User( $conn );


$userData = $user->fetchData( $_SESSION[ 'user_id' ], $conn );

if ( $userData->num_rows == 0 ) {
	header( "location: 404.php" );

}

$row = $userData->fetch_assoc();

include( "header.php" );

?>

<div class="container-fluid">

	<?php if(isset($_GET['status']) && $_GET['status'] == 100) {
	
	?>
	<div class="alert alert-success alert-dismissible fade show">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Success:</strong> Data updated successfully!
	</div>
	<?php
	}

	if ( isset( $_GET[ 'status' ] ) && $_GET[ 'status' ] == 101 ) {

		?>
	<div class="alert alert-success alert-dismissible fade show">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Success:</strong> Password is successfully updated.
	</div>
	<?php
	}
	?>



	<br><br>
	<div class="row">
		<div class="col-sm-3"></div>
		<div class="col-sm-6">
			<h1 class="display-3">My Account</h1>
		
			<p align="center">My Personal Data</p>


			<form method="post" action="<?php echo($_SERVER['PHP_SELF']) ?>?id=<?php echo($_GET['userid']) ?>" enctype="multipart/form-data">
				<div class="form-group">
					<label for="usr">Username:</label>
					<input name="username" type="text" required value="<?php echo($row['username']) ?>" class="form-control" id="user">
				</div>
				<div class="form-group">
					<label for="usr">Email:</label>
					<input name="email" type="email" required value="<?php echo($row['email']) ?>" class="form-control" id="user">
				</div>
				<button name="update_data" class="btn btn-primary btn-block" type="submit">Update Data</button>


			</form>


			<form method="post" action="<?php echo($_SERVER['PHP_SELF'].'?userid='.$_GET['userid']) ?>" enctype="multipart/form-data">

				<div class="form-group">
					<label for="pwd">Change password</label>
					<input type="password" name="password" class="form-control" id="txtNewPassword" placeholder="New password">
				</div>

				<div class="form-group">
					<label for="pwd">Confirm password</label>
					<input type="password" name="confirm_password" class="form-control" id="txtConfirmPassword" onChange="checkPasswordMatch()" placeholder="Confirm password">
					<div id="divCheckPasswordMatch"></div>
				</div>

				<div class="form-group">
					<button id="sender" type="submit" name="update_password" class="btn btn-primary btn-block">Update Password</button>
				</div>
			</form>
			<?php if ($_SESSION['user_type'] == 1 || $row['ID'] == $_SESSION['user_id']) { ?>
			<a role="button" href="removeaccount.php?userid=<?php echo($_SESSION['user_id']) ?>" class="btn btn-danger"> Remove Account</a>
			<?php } ?>
		</div>
		<div class="col-sm-3"></div>
	</div>
	<br>


</div>
<footer>Life Blog 2018</footer>
</body>
</html>