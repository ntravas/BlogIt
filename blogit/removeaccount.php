<?php
session_start();

if ( !isset( $_GET[ 'userid' ] ) || $_GET[ 'userid' ] == "" ) {
	header( "location: 404.php" );
}


if ($_SESSION['user_type'] != 1 && $_SESSION['user_id'] != $_GET['userid'] ) {
	header( "location: 404.php" );
	
}

include( "Database.php" );
include( "User.php" );

$db = new Database();
$conn = $db->connect();
$user = new User($conn);
$user->removeAccount($_GET['userid'], $conn);
header("location: logout.php");
?>